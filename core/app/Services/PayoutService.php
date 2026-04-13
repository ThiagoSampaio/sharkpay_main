<?php

namespace App\Services;

use App\Models\Payout;
use App\Models\PaymentSplit;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PayoutService
{
    /**
     * Obtém o saldo disponível para saque
     */
    public function getAvailableBalance($userId): float
    {
        $user = User::find($userId);
        if (!$user) {
            return 0;
        }

        // Total recebido
        $totalReceived = Invoice::where('user_id', $userId)
            ->where('status', 'paid')
            ->sum('amount');

        // Total de splits recebidos
        $totalSplits = PaymentSplit::where('recipient_id', $userId)
            ->where('status', 'completed')
            ->sum('net_amount');

        // Total já sacado
        $totalPayouts = 0;

        if ($this->hasPayoutsTable()) {
            $totalPayouts = Payout::where('user_id', $userId)
                ->whereIn('status', ['completed', 'processing', 'scheduled'])
                ->sum('amount');
        }

        // Total de taxas pagas
        $totalFees = $this->calculateTotalFees($userId);

        // Saldo disponível = (Recebido + Splits) - (Saques + Taxas)
        return ($totalReceived + $totalSplits) - ($totalPayouts + $totalFees);
    }

    /**
     * Obtém o valor mínimo para saque
     */
    public function getMinimumPayoutAmount(): float
    {
        return config('payouts.minimum_amount', 10.00);
    }

    /**
     * Calcula a taxa do saque
     */
    public function calculatePayoutFee(float $amount, string $method): float
    {
        $fees = [
            'pix' => ['fixed' => 0, 'percentage' => 0],
            'bank_transfer' => ['fixed' => 9.90, 'percentage' => 0],
            'wallet' => ['fixed' => 0, 'percentage' => 1.5]
        ];

        $fee = $fees[$method] ?? ['fixed' => 0, 'percentage' => 0];

        return $fee['fixed'] + ($amount * $fee['percentage'] / 100);
    }

    /**
     * Reserva saldo para saque
     */
    public function reserveBalance($userId, float $amount): bool
    {
        $available = $this->getAvailableBalance($userId);

        if ($available < $amount) {
            return false;
        }

        // Criar registro de reserva ou atualizar saldo do usuário
        // Implementar lógica de reserva

        return true;
    }

    /**
     * Libera saldo reservado
     */
    public function releaseReservedBalance($userId, float $amount): bool
    {
        // Implementar lógica para liberar saldo reservado
        return true;
    }

    /**
     * Processa payouts automáticos
     */
    public function processAutomaticPayouts(): int
    {
        if (!$this->hasPayoutsTable()) {
            return 0;
        }

        $processed = 0;

        $payouts = Payout::where('status', 'scheduled')
            ->where('automatic', true)
            ->where('scheduled_date', '<=', Carbon::now())
            ->get();

        foreach ($payouts as $payout) {
            if ($this->processPayout($payout)) {
                $processed++;
            }
        }

        return $processed;
    }

    /**
     * Processa um payout específico
     */
    public function processPayout(Payout $payout): bool
    {
        try {
            $payout->markAsProcessing();

            // Integrar com gateway de pagamento
            switch ($payout->payout_method) {
                case 'pix':
                    $result = $this->processPixPayout($payout);
                    break;
                case 'bank_transfer':
                    $result = $this->processBankTransfer($payout);
                    break;
                default:
                    $result = false;
            }

            if ($result) {
                $payout->markAsCompleted($result['external_id'] ?? null);
                return true;
            } else {
                $payout->markAsFailed('Erro no processamento');
                return false;
            }

        } catch (\Exception $e) {
            $payout->markAsFailed($e->getMessage());
            return false;
        }
    }

    /**
     * Processa payout via PIX
     */
    private function processPixPayout(Payout $payout): array
    {
        // Implementar integração com provider de PIX
        // Por exemplo: Fitbank, Banco Original, etc.

        return [
            'success' => true,
            'external_id' => 'PIX-' . time()
        ];
    }

    /**
     * Processa transferência bancária
     */
    private function processBankTransfer(Payout $payout): array
    {
        // Implementar integração com provider bancário

        return [
            'success' => true,
            'external_id' => 'TED-' . time()
        ];
    }

    /**
     * Calcula total de taxas pagas
     */
    private function calculateTotalFees($userId): float
    {
        // Implementar cálculo real de taxas
        // Baseado em transações e configurações

        $totalTransactions = Invoice::where('user_id', $userId)
            ->where('status', 'paid')
            ->sum('amount');

        // Taxa média de 3.5% (exemplo)
        return $totalTransactions * 0.035;
    }

    /**
     * Obtém estatísticas de payouts
     */
    public function getPayoutStats($userId): array
    {
        if (!$this->hasPayoutsTable()) {
            return [
                'total_withdrawn' => 0,
                'pending_payouts' => 0,
                'average_payout' => 0,
                'last_payout' => null,
                'next_scheduled' => null,
            ];
        }

        return [
            'total_withdrawn' => Payout::where('user_id', $userId)
                ->where('status', 'completed')
                ->sum('net_amount'),

            'pending_payouts' => Payout::where('user_id', $userId)
                ->whereIn('status', ['scheduled', 'processing'])
                ->sum('net_amount'),

            'average_payout' => Payout::where('user_id', $userId)
                ->where('status', 'completed')
                ->avg('net_amount'),

            'last_payout' => Payout::where('user_id', $userId)
                ->where('status', 'completed')
                ->orderBy('processed_at', 'desc')
                ->first(),

            'next_scheduled' => Payout::where('user_id', $userId)
                ->where('status', 'scheduled')
                ->orderBy('scheduled_date', 'asc')
                ->first()
        ];
    }

    /**
     * Get pending amount for user
     */
    public function getPendingAmount(User $user): float
    {
        if (!$this->hasPayoutsTable()) {
            return 0;
        }

        return Payout::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');
    }

    /**
     * Get processing amount for user
     */
    public function getProcessingAmount(User $user): float
    {
        if (!$this->hasPayoutsTable()) {
            return 0;
        }

        return Payout::where('user_id', $user->id)
            ->where('status', 'processing')
            ->sum('amount');
    }

    /**
     * Get total paid out for user
     */
    public function getTotalPaidOut(User $user): float
    {
        if (!$this->hasPayoutsTable()) {
            return 0;
        }

        return Payout::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('net_amount');
    }

    /**
     * Get payout fees
     */
    public function getPayoutFees(): array
    {
        return [
            'pix' => 1.00,
            'ted' => 8.00,
            'doc' => 8.00,
        ];
    }

    /**
     * Get minimum payout
     */
    public function getMinimumPayout(): float
    {
        return $this->getMinimumPayoutAmount();
    }

    private function hasPayoutsTable(): bool
    {
        static $hasPayoutsTable;

        if ($hasPayoutsTable === null) {
            $hasPayoutsTable = Schema::hasTable('payouts');
        }

        return $hasPayoutsTable;
    }
}