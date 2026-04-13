<?php

namespace App\Services;

use App\Models\FeeStructure;
use App\Models\User;
use App\Models\Commission;
use Illuminate\Support\Collection;

class FeeCalculatorService
{
    protected $user;
    protected $paymentMethodsManager;

    public function __construct(User $user = null)
    {
        $this->user = $user;
        $this->paymentMethodsManager = new PaymentMethodsManager($user);
    }

    /**
     * Calcula todas as taxas aplicáveis a uma transação
     */
    public function calculateTransactionFees(array $transactionData): array
    {
        $amount = $transactionData['amount'];
        $paymentMethod = $transactionData['payment_method'];
        $installments = $transactionData['installments'] ?? 1;
        $conditions = $transactionData['conditions'] ?? [];

        // Busca a estrutura de taxa aplicável
        $feeStructure = FeeStructure::findApplicableFee(
            $paymentMethod,
            $amount,
            $installments,
            $this->user?->id,
            $conditions
        );

        $platformFee = 0;
        $gatewayFee = 0;
        $installmentFee = 0;
        $additionalFees = [];

        // Taxa da plataforma (nossa taxa)
        if ($feeStructure) {
            $platformFee = $feeStructure->calculateFee($amount, $installments);
        }

        // Taxa do gateway de pagamento
        $gatewayFee = $this->calculateGatewayFee($paymentMethod, $amount, $installments);

        // Taxa de parcelamento (para cartão de crédito)
        if ($paymentMethod === 'credit_card' && $installments > 1) {
            $installmentFee = $this->calculateInstallmentFee($amount, $installments);
        }

        // Taxas adicionais (antifraude, etc.)
        $additionalFees = $this->calculateAdditionalFees($transactionData);

        $totalFees = $platformFee + $gatewayFee + $installmentFee + array_sum($additionalFees);
        $netAmount = $amount - $totalFees;

        return [
            'gross_amount' => $amount,
            'platform_fee' => $platformFee,
            'gateway_fee' => $gatewayFee,
            'installment_fee' => $installmentFee,
            'additional_fees' => $additionalFees,
            'total_fees' => $totalFees,
            'net_amount' => $netAmount,
            'fee_percentage' => $amount > 0 ? ($totalFees / $amount) * 100 : 0,
            'fee_structure_used' => $feeStructure?->id,
            'breakdown' => [
                'platform' => [
                    'amount' => $platformFee,
                    'percentage' => $amount > 0 ? ($platformFee / $amount) * 100 : 0,
                    'description' => 'Taxa da plataforma'
                ],
                'gateway' => [
                    'amount' => $gatewayFee,
                    'percentage' => $amount > 0 ? ($gatewayFee / $amount) * 100 : 0,
                    'description' => 'Taxa do gateway'
                ],
                'installment' => [
                    'amount' => $installmentFee,
                    'percentage' => $amount > 0 ? ($installmentFee / $amount) * 100 : 0,
                    'description' => 'Taxa de parcelamento'
                ]
            ]
        ];
    }

    /**
     * Calcula comissões aplicáveis
     */
    public function calculateCommissions(array $transactionData): array
    {
        $commissions = [];
        $amount = $transactionData['amount'];
        $userId = $transactionData['user_id'] ?? $this->user?->id;

        if (!$userId) {
            return $commissions;
        }

        $user = User::find($userId);
        if (!$user) {
            return $commissions;
        }

        // Comissão do afiliado (se houver)
        if ($affiliateId = $this->getAffiliateId($user, $transactionData)) {
            $affiliateCommission = $this->calculateAffiliateCommission($amount, $affiliateId, $transactionData);
            if ($affiliateCommission) {
                $commissions[] = $affiliateCommission;
            }
        }

        // Comissões de níveis (multinível)
        $multilevelCommissions = $this->calculateMultilevelCommissions($amount, $user, $transactionData);
        $commissions = array_merge($commissions, $multilevelCommissions);

        // Comissão de produto específico
        if (isset($transactionData['product_id'])) {
            $productCommission = $this->calculateProductCommission($amount, $transactionData['product_id'], $transactionData);
            if ($productCommission) {
                $commissions[] = $productCommission;
            }
        }

        return $commissions;
    }

    /**
     * Calcula split de pagamento
     */
    public function calculatePaymentSplit(array $transactionData): array
    {
        $splits = [];
        $amount = $transactionData['amount'];
        $splitRules = $transactionData['split_rules'] ?? [];

        if (empty($splitRules)) {
            return $splits;
        }

        $remainingAmount = $amount;

        foreach ($splitRules as $rule) {
            $splitAmount = 0;

            if ($rule['type'] === 'percentage') {
                $splitAmount = ($amount * $rule['value']) / 100;
            } elseif ($rule['type'] === 'fixed') {
                $splitAmount = $rule['value'];
            }

            // Aplica taxa no split se configurado
            $feeAmount = 0;
            if ($rule['charge_fee'] ?? false) {
                $fees = $this->calculateTransactionFees([
                    'amount' => $splitAmount,
                    'payment_method' => $transactionData['payment_method'],
                    'installments' => $transactionData['installments'] ?? 1
                ]);
                $feeAmount = $fees['total_fees'];
            }

            $netAmount = $splitAmount - $feeAmount;
            $remainingAmount -= $splitAmount;

            $splits[] = [
                'recipient_id' => $rule['recipient_id'],
                'recipient_type' => $rule['recipient_type'] ?? 'user',
                'split_amount' => $splitAmount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'percentage' => ($splitAmount / $amount) * 100,
                'rule' => $rule
            ];
        }

        // Split principal (restante para o vendedor)
        if ($remainingAmount > 0) {
            $mainFees = $this->calculateTransactionFees([
                'amount' => $remainingAmount,
                'payment_method' => $transactionData['payment_method'],
                'installments' => $transactionData['installments'] ?? 1
            ]);

            $splits[] = [
                'recipient_id' => $transactionData['user_id'] ?? $this->user?->id,
                'recipient_type' => 'user',
                'split_amount' => $remainingAmount,
                'fee_amount' => $mainFees['total_fees'],
                'net_amount' => $remainingAmount - $mainFees['total_fees'],
                'percentage' => ($remainingAmount / $amount) * 100,
                'rule' => ['type' => 'remainder', 'description' => 'Valor principal']
            ];
        }

        return $splits;
    }

    /**
     * Calcula valor líquido após todas as deduções
     */
    public function calculateNetAmount(array $transactionData): array
    {
        $fees = $this->calculateTransactionFees($transactionData);
        $commissions = $this->calculateCommissions($transactionData);
        $splits = $this->calculatePaymentSplit($transactionData);

        $totalCommissions = array_sum(array_column($commissions, 'commission_amount'));
        $totalSplits = array_sum(array_column($splits, 'split_amount'));

        $grossAmount = $transactionData['amount'];
        $totalDeductions = $fees['total_fees'] + $totalCommissions + $totalSplits;
        $netAmount = $grossAmount - $totalDeductions;

        return [
            'gross_amount' => $grossAmount,
            'fees' => $fees,
            'commissions' => $commissions,
            'splits' => $splits,
            'total_fees' => $fees['total_fees'],
            'total_commissions' => $totalCommissions,
            'total_splits' => $totalSplits,
            'total_deductions' => $totalDeductions,
            'net_amount' => $netAmount,
            'net_percentage' => $grossAmount > 0 ? ($netAmount / $grossAmount) * 100 : 0
        ];
    }

    /**
     * Simula cenários de preços
     */
    public function simulatePricing(float $baseAmount, array $scenarios = []): array
    {
        $results = [];

        $defaultScenarios = [
            'pix_vista' => ['payment_method' => 'pix', 'installments' => 1],
            'cartao_vista' => ['payment_method' => 'credit_card', 'installments' => 1],
            'cartao_3x' => ['payment_method' => 'credit_card', 'installments' => 3],
            'cartao_6x' => ['payment_method' => 'credit_card', 'installments' => 6],
            'cartao_12x' => ['payment_method' => 'credit_card', 'installments' => 12],
            'boleto' => ['payment_method' => 'boleto', 'installments' => 1]
        ];

        $scenariosToTest = array_merge($defaultScenarios, $scenarios);

        foreach ($scenariosToTest as $name => $scenario) {
            $transactionData = array_merge([
                'amount' => $baseAmount,
                'user_id' => $this->user?->id
            ], $scenario);

            $calculation = $this->calculateNetAmount($transactionData);

            $results[$name] = [
                'scenario' => $scenario,
                'gross_amount' => $calculation['gross_amount'],
                'total_fees' => $calculation['total_fees'],
                'net_amount' => $calculation['net_amount'],
                'fee_percentage' => $calculation['fees']['fee_percentage'],
                'installment_amount' => $scenario['installments'] > 1 ?
                    $calculation['gross_amount'] / $scenario['installments'] : null,
                'recommended' => false
            ];
        }

        // Marca o cenário recomendado (menor taxa)
        $lowestFeeScenario = array_keys($results, min(array_column($results, 'total_fees')));
        if (!empty($lowestFeeScenario)) {
            $results[$lowestFeeScenario[0]]['recommended'] = true;
        }

        return $results;
    }

    // Métodos auxiliares privados

    private function calculateGatewayFee(string $paymentMethod, float $amount, int $installments): float
    {
        // Taxas específicas de cada gateway
        $gatewayFees = [
            'pix' => ['percentage' => 0, 'fixed' => 0],
            'credit_card' => ['percentage' => 2.9, 'fixed' => 0.39],
            'boleto' => ['percentage' => 0, 'fixed' => 2.99],
            'bank_transfer' => ['percentage' => 0, 'fixed' => 0]
        ];

        $config = $gatewayFees[$paymentMethod] ?? ['percentage' => 0, 'fixed' => 0];

        return ($amount * $config['percentage'] / 100) + $config['fixed'];
    }

    private function calculateInstallmentFee(float $amount, int $installments): float
    {
        if ($installments <= 1) {
            return 0;
        }

        // Taxa de parcelamento progressiva
        $installmentRates = [
            2 => 0,    // 2x sem juros
            3 => 1.5,  // 3x com 1.5% a.m.
            4 => 2.0,
            5 => 2.5,
            6 => 2.5,
            7 => 3.0,
            8 => 3.0,
            9 => 3.5,
            10 => 3.5,
            11 => 4.0,
            12 => 4.0
        ];

        $monthlyRate = $installmentRates[$installments] ?? 4.0;

        // Cálculo de juros compostos
        if ($monthlyRate > 0) {
            $factor = pow(1 + ($monthlyRate / 100), $installments);
            $totalWithInterest = $amount * $factor;
            return $totalWithInterest - $amount;
        }

        return 0;
    }

    private function calculateAdditionalFees(array $transactionData): array
    {
        $fees = [];

        // Taxa antifraude para transações de cartão acima de R$ 100
        if ($transactionData['payment_method'] === 'credit_card' && $transactionData['amount'] > 100) {
            $fees['antifraud'] = 0.30;
        }

        // Taxa de conversão para transações internacionais
        if (($transactionData['international'] ?? false)) {
            $fees['conversion'] = $transactionData['amount'] * 0.038; // 3.8%
        }

        return $fees;
    }

    private function getAffiliateId(User $user, array $transactionData): ?int
    {
        // Verifica se há um afiliado associado
        return $user->affiliate_id ?? $transactionData['affiliate_id'] ?? null;
    }

    private function calculateAffiliateCommission(float $amount, int $affiliateId, array $transactionData): ?array
    {
        // Taxa padrão de comissão de afiliado (pode ser configurável)
        $commissionRate = 5.0; // 5%

        $commissionAmount = ($amount * $commissionRate) / 100;

        return [
            'user_id' => $affiliateId,
            'commission_type' => 'referral',
            'commission_percentage' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'transaction_amount' => $amount
        ];
    }

    private function calculateMultilevelCommissions(float $amount, User $user, array $transactionData): array
    {
        $commissions = [];

        // Implementar lógica de multinível se necessário
        // Por exemplo: comissão para o afiliado do afiliado

        return $commissions;
    }

    private function calculateProductCommission(float $amount, int $productId, array $transactionData): ?array
    {
        // Implementar comissões específicas por produto
        // Buscar configuração de comissão do produto

        return null;
    }
}