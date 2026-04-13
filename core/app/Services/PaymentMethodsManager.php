<?php

namespace App\Services;

use App\Models\User;
use App\Models\Settings;
use Illuminate\Support\Collection;

class PaymentMethodsManager
{
    protected $user;
    protected $globalSettings;

    public function __construct(User $user = null)
    {
        $this->user = $user;
        $this->globalSettings = $this->getGlobalSettings();
    }

    public function getAvailablePaymentMethods(): array
    {
        $methods = [
            'pix' => $this->getPixConfig(),
            'credit_card' => $this->getCreditCardConfig(),
            'boleto' => $this->getBoletoConfig(),
            'bank_transfer' => $this->getBankTransferConfig(),
        ];

        return array_filter($methods, function($config) {
            return $config['enabled'];
        });
    }

    public function getPixConfig(): array
    {
        $enabled = $this->isMethodEnabled('pix');

        return [
            'enabled' => $enabled,
            'name' => 'PIX',
            'description' => 'Pagamento instantâneo',
            'icon' => 'pix-icon.png',
            'fee_percentage' => $this->getFeeForMethod('pix', 'percentage'),
            'fee_fixed' => $this->getFeeForMethod('pix', 'fixed'),
            'min_amount' => $this->getMinAmountForMethod('pix'),
            'max_amount' => $this->getMaxAmountForMethod('pix'),
            'processing_time' => 'Imediato',
            'providers' => $this->getActiveProviders('pix')
        ];
    }

    public function getCreditCardConfig(): array
    {
        $enabled = $this->isMethodEnabled('credit_card');

        return [
            'enabled' => $enabled,
            'name' => 'Cartão de Crédito',
            'description' => 'Parcelamento em até 12x',
            'icon' => 'credit-card-icon.png',
            'fee_percentage' => $this->getFeeForMethod('credit_card', 'percentage'),
            'fee_fixed' => $this->getFeeForMethod('credit_card', 'fixed'),
            'min_amount' => $this->getMinAmountForMethod('credit_card'),
            'max_amount' => $this->getMaxAmountForMethod('credit_card'),
            'max_installments' => $this->getMaxInstallments(),
            'installment_fees' => $this->getInstallmentFees(),
            'processing_time' => '2-3 dias úteis',
            'providers' => $this->getActiveProviders('credit_card')
        ];
    }

    public function getBoletoConfig(): array
    {
        $enabled = $this->isMethodEnabled('boleto');

        return [
            'enabled' => $enabled,
            'name' => 'Boleto Bancário',
            'description' => 'Vencimento em 3 dias úteis',
            'icon' => 'boleto-icon.png',
            'fee_percentage' => $this->getFeeForMethod('boleto', 'percentage'),
            'fee_fixed' => $this->getFeeForMethod('boleto', 'fixed'),
            'min_amount' => $this->getMinAmountForMethod('boleto'),
            'max_amount' => $this->getMaxAmountForMethod('boleto'),
            'due_days' => $this->getBoletoDueDays(),
            'processing_time' => '1-2 dias úteis após pagamento',
            'providers' => $this->getActiveProviders('boleto')
        ];
    }

    public function getBankTransferConfig(): array
    {
        $enabled = $this->isMethodEnabled('bank_transfer');

        return [
            'enabled' => $enabled,
            'name' => 'Transferência Bancária',
            'description' => 'TED/DOC',
            'icon' => 'bank-transfer-icon.png',
            'fee_percentage' => $this->getFeeForMethod('bank_transfer', 'percentage'),
            'fee_fixed' => $this->getFeeForMethod('bank_transfer', 'fixed'),
            'min_amount' => $this->getMinAmountForMethod('bank_transfer'),
            'max_amount' => $this->getMaxAmountForMethod('bank_transfer'),
            'processing_time' => '1-2 dias úteis',
            'providers' => $this->getActiveProviders('bank_transfer')
        ];
    }

    public function calculateFees(string $method, float $amount, int $installments = 1): array
    {
        $config = $this->getMethodConfig($method);

        $feePercentage = $config['fee_percentage'] ?? 0;
        $feeFixed = $config['fee_fixed'] ?? 0;

        // Adicionar taxa de parcelamento para cartão de crédito
        if ($method === 'credit_card' && $installments > 1) {
            $installmentFee = $this->getInstallmentFee($installments);
            $feePercentage += $installmentFee;
        }

        $percentageFee = ($amount * $feePercentage) / 100;
        $totalFee = $percentageFee + $feeFixed;
        $netAmount = $amount - $totalFee;

        return [
            'gross_amount' => $amount,
            'fee_percentage' => $feePercentage,
            'fee_fixed' => $feeFixed,
            'percentage_fee_amount' => $percentageFee,
            'total_fee' => $totalFee,
            'net_amount' => $netAmount,
            'installments' => $installments
        ];
    }

    public function getInstallmentOptions(float $amount): array
    {
        $maxInstallments = $this->getMaxInstallments();
        $minInstallmentAmount = $this->getMinInstallmentAmount();
        $options = [];

        for ($i = 1; $i <= $maxInstallments; $i++) {
            $installmentAmount = $amount / $i;

            if ($installmentAmount < $minInstallmentAmount && $i > 1) {
                break;
            }

            $fee = $this->getInstallmentFee($i);
            $totalAmount = $amount * (1 + ($fee / 100));
            $finalInstallmentAmount = $totalAmount / $i;

            $options[] = [
                'installments' => $i,
                'installment_amount' => $finalInstallmentAmount,
                'total_amount' => $totalAmount,
                'fee_percentage' => $fee,
                'display' => $i === 1 ?
                    'À vista R$ ' . number_format($amount, 2, ',', '.') :
                    $i . 'x de R$ ' . number_format($finalInstallmentAmount, 2, ',', '.') .
                    ($fee > 0 ? ' (com juros)' : ' (sem juros)')
            ];
        }

        return $options;
    }

    public function getBestPaymentMethod(float $amount): ?string
    {
        $methods = $this->getAvailablePaymentMethods();
        $bestMethod = null;
        $lowestFee = PHP_FLOAT_MAX;

        foreach ($methods as $methodName => $config) {
            if (!$config['enabled']) continue;

            $fees = $this->calculateFees($methodName, $amount);

            if ($fees['total_fee'] < $lowestFee) {
                $lowestFee = $fees['total_fee'];
                $bestMethod = $methodName;
            }
        }

        return $bestMethod;
    }

    protected function isMethodEnabled(string $method): bool
    {
        if ($this->user) {
            $userSetting = $this->user->getSetting("payment_method_{$method}_enabled");
            if ($userSetting !== null) {
                return (bool) $userSetting;
            }
        }

        return $this->globalSettings["payment_method_{$method}_enabled"] ?? true;
    }

    protected function getFeeForMethod(string $method, string $type): float
    {
        $settingKey = "payment_method_{$method}_fee_{$type}";

        if ($this->user) {
            $userFee = $this->user->getSetting($settingKey);
            if ($userFee !== null) {
                return (float) $userFee;
            }
        }

        return (float) ($this->globalSettings[$settingKey] ?? 0);
    }

    protected function getMinAmountForMethod(string $method): float
    {
        $settingKey = "payment_method_{$method}_min_amount";

        if ($this->user) {
            $userMin = $this->user->getSetting($settingKey);
            if ($userMin !== null) {
                return (float) $userMin;
            }
        }

        return (float) ($this->globalSettings[$settingKey] ?? 1);
    }

    protected function getMaxAmountForMethod(string $method): float
    {
        $settingKey = "payment_method_{$method}_max_amount";

        if ($this->user) {
            $userMax = $this->user->getSetting($settingKey);
            if ($userMax !== null) {
                return (float) $userMax;
            }
        }

        return (float) ($this->globalSettings[$settingKey] ?? 999999);
    }

    protected function getMaxInstallments(): int
    {
        if ($this->user) {
            $userMax = $this->user->getSetting('credit_card_max_installments');
            if ($userMax !== null) {
                return (int) $userMax;
            }
        }

        return (int) ($this->globalSettings['credit_card_max_installments'] ?? 12);
    }

    protected function getMinInstallmentAmount(): float
    {
        return (float) ($this->globalSettings['credit_card_min_installment_amount'] ?? 5);
    }

    protected function getInstallmentFee(int $installments): float
    {
        if ($installments <= 1) return 0;

        $settingKey = "credit_card_installment_{$installments}_fee";

        if ($this->user) {
            $userFee = $this->user->getSetting($settingKey);
            if ($userFee !== null) {
                return (float) $userFee;
            }
        }

        return (float) ($this->globalSettings[$settingKey] ?? 0);
    }

    protected function getInstallmentFees(): array
    {
        $fees = [];
        $maxInstallments = $this->getMaxInstallments();

        for ($i = 1; $i <= $maxInstallments; $i++) {
            $fees[$i] = $this->getInstallmentFee($i);
        }

        return $fees;
    }

    protected function getBoletoDueDays(): int
    {
        if ($this->user) {
            $userDays = $this->user->getSetting('boleto_due_days');
            if ($userDays !== null) {
                return (int) $userDays;
            }
        }

        return (int) ($this->globalSettings['boleto_due_days'] ?? 3);
    }

    protected function getActiveProviders(string $method): array
    {
        // Retornar provedores ativos para cada método
        $providers = [
            'pix' => ['fitbank', 'banco_original'],
            'credit_card' => ['cielo', 'stripe'],
            'boleto' => ['fitbank', 'banco_original'],
            'bank_transfer' => ['banco_original']
        ];

        return $providers[$method] ?? [];
    }

    protected function getMethodConfig(string $method): array
    {
        $configs = [
            'pix' => $this->getPixConfig(),
            'credit_card' => $this->getCreditCardConfig(),
            'boleto' => $this->getBoletoConfig(),
            'bank_transfer' => $this->getBankTransferConfig()
        ];

        return $configs[$method] ?? [];
    }

    protected function getGlobalSettings(): array
    {
        // Implementar cache aqui para melhor performance
        $settings = Settings::first();
        return $settings ? $settings->toArray() : [];
    }
}