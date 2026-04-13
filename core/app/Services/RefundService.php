<?php

namespace App\Services;

use App\Models\Refund;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;

class RefundService
{
    /**
     * Verifica se uma transação é elegível para reembolso
     */
    public function checkRefundEligibility(string $transactionId): array
    {
        $invoice = Invoice::where('ref', $transactionId)->first();

        if (!$invoice) {
            return [
                'eligible' => false,
                'reason' => 'Transação não encontrada'
            ];
        }

        // Verificar status da transação
        if ($invoice->status !== 'paid') {
            return [
                'eligible' => false,
                'reason' => 'Apenas transações pagas podem ser reembolsadas'
            ];
        }

        // Verificar prazo para reembolso (ex: 90 dias)
        $refundDeadline = $invoice->created_at->addDays(90);
        if (Carbon::now()->greaterThan($refundDeadline)) {
            return [
                'eligible' => false,
                'reason' => 'Prazo para reembolso expirado (90 dias)'
            ];
        }

        // Verificar se já foi totalmente reembolsado
        $totalRefunded = Refund::where('original_transaction_id', $transactionId)
            ->where('status', 'completed')
            ->sum('refund_amount');

        if ($totalRefunded >= $invoice->amount) {
            return [
                'eligible' => false,
                'reason' => 'Transação já foi totalmente reembolsada'
            ];
        }

        // Verificar se há reembolso pendente
        $pendingRefund = Refund::where('original_transaction_id', $transactionId)
            ->whereIn('status', ['requested', 'approved', 'processing'])
            ->exists();

        if ($pendingRefund) {
            return [
                'eligible' => false,
                'reason' => 'Já existe um reembolso em processamento para esta transação'
            ];
        }

        return [
            'eligible' => true,
            'available_amount' => $invoice->amount - $totalRefunded
        ];
    }

    /**
     * Calcula a taxa de reembolso
     */
    public function calculateRefundFee(float $amount, string $paymentMethod): float
    {
        // Taxas por método de pagamento
        $fees = [
            'pix' => 0, // Sem taxa para PIX
            'credit_card' => 5.00, // Taxa fixa de R$ 5,00
            'boleto' => 3.50, // Taxa fixa de R$ 3,50
            'bank_transfer' => 0 // Sem taxa
        ];

        return $fees[$paymentMethod] ?? 0;
    }

    /**
     * Processa reembolsos aprovados
     */
    public function processApprovedRefunds(): int
    {
        $processed = 0;

        $refunds = Refund::where('status', 'approved')->get();

        foreach ($refunds as $refund) {
            if ($this->processRefund($refund)) {
                $processed++;
            }
        }

        return $processed;
    }

    /**
     * Processa um reembolso específico
     */
    public function processRefund(Refund $refund): bool
    {
        try {
            $refund->markAsProcessing();

            // Buscar dados da transação original
            $invoice = Invoice::where('ref', $refund->original_transaction_id)->first();

            if (!$invoice) {
                $refund->markAsFailed('Transação original não encontrada');
                return false;
            }

            // Integrar com gateway de pagamento
            $result = $this->processRefundWithGateway($refund, $invoice);

            if ($result['success']) {
                $refund->markAsCompleted($result['external_id'] ?? null);

                // Atualizar saldo do usuário
                $this->updateUserBalance($refund);

                return true;
            } else {
                $refund->markAsFailed($result['error'] ?? 'Erro desconhecido');
                return false;
            }

        } catch (\Exception $e) {
            $refund->markAsFailed($e->getMessage());
            return false;
        }
    }

    /**
     * Processa reembolso com o gateway
     */
    private function processRefundWithGateway(Refund $refund, Invoice $invoice): array
    {
        $paymentMethod = $invoice->payment_method ?? 'unknown';

        switch ($paymentMethod) {
            case 'pix':
                return $this->refundPix($refund, $invoice);

            case 'credit_card':
                return $this->refundCreditCard($refund, $invoice);

            case 'boleto':
                return $this->refundBoleto($refund, $invoice);

            default:
                return [
                    'success' => false,
                    'error' => 'Método de pagamento não suportado para reembolso'
                ];
        }
    }

    /**
     * Reembolso via PIX
     */
    private function refundPix(Refund $refund, Invoice $invoice): array
    {
        // Implementar integração com provider de PIX
        // Exemplo: criar uma transferência PIX reversa

        return [
            'success' => true,
            'external_id' => 'PIX-REF-' . time()
        ];
    }

    /**
     * Reembolso de cartão de crédito
     */
    private function refundCreditCard(Refund $refund, Invoice $invoice): array
    {
        // Implementar integração com gateway de cartão
        // Exemplo: Cielo, Stripe, etc.

        return [
            'success' => true,
            'external_id' => 'CC-REF-' . time()
        ];
    }

    /**
     * Reembolso de boleto
     */
    private function refundBoleto(Refund $refund, Invoice $invoice): array
    {
        // Boleto geralmente requer dados bancários do cliente
        // Implementar transferência bancária ou PIX

        return [
            'success' => true,
            'external_id' => 'BOL-REF-' . time()
        ];
    }

    /**
     * Atualiza saldo do usuário após reembolso
     */
    private function updateUserBalance(Refund $refund): void
    {
        // Implementar lógica para ajustar saldo
        // Pode envolver criar um registro de transação negativa
        // ou ajustar diretamente o saldo disponível
    }

    /**
     * Notifica sobre solicitação de reembolso
     */
    public function notifyRefundRequest(Refund $refund): void
    {
        // Enviar notificação para administradores
        // Enviar e-mail para o cliente
        // Criar registro de auditoria
    }

    /**
     * Obtém estatísticas de reembolsos
     */
    public function getRefundStats($userId = null): array
    {
        $query = Refund::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return [
            'total_refunded' => $query->where('status', 'completed')->sum('refund_amount'),
            'pending_refunds' => $query->whereIn('status', ['requested', 'approved'])->count(),
            'refund_rate' => $this->calculateRefundRate($userId),
            'average_processing_time' => $this->getAverageProcessingTime($userId),
            'most_common_reasons' => $this->getMostCommonReasons($userId)
        ];
    }

    /**
     * Calcula taxa de reembolso
     */
    private function calculateRefundRate($userId = null): float
    {
        $invoiceQuery = Invoice::where('status', 'paid');
        $refundQuery = Refund::where('status', 'completed');

        if ($userId) {
            $invoiceQuery->where('user_id', $userId);
            $refundQuery->where('user_id', $userId);
        }

        $totalTransactions = $invoiceQuery->count();
        $totalRefunds = $refundQuery->count();

        return $totalTransactions > 0 ? ($totalRefunds / $totalTransactions) * 100 : 0;
    }

    /**
     * Obtém tempo médio de processamento
     */
    private function getAverageProcessingTime($userId = null): float
    {
        $query = Refund::where('status', 'completed')
            ->whereNotNull('processed_at');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $refunds = $query->get();

        if ($refunds->isEmpty()) {
            return 0;
        }

        $totalDays = 0;
        foreach ($refunds as $refund) {
            $totalDays += $refund->requested_at->diffInDays($refund->processed_at);
        }

        return $totalDays / $refunds->count();
    }

    /**
     * Obtém motivos mais comuns de reembolso
     */
    private function getMostCommonReasons($userId = null): array
    {
        $query = Refund::select('reason', DB::raw('count(*) as count'));

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->groupBy('reason')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->toArray();
    }
}