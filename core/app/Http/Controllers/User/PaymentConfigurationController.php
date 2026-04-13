<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use App\Models\PaymentSplit;
use Illuminate\Http\Request;
use Auth;

class PaymentConfigurationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get fee structures
        $feeStructures = FeeStructure::where('user_id', $user->id)->get();

        // Get payment splits
        $paymentSplits = PaymentSplit::where('user_id', $user->id)->get();

        // Mock data for demonstration
        $averageFee = 2.5;
        $totalFeesMonth = 1250.00;
        $activeMethodsCount = 4;

        // Mock gateways
        $gateways = collect([
            (object)[
                'id' => 1,
                'name' => 'Cielo',
                'provider' => 'Cielo API',
                'is_active' => true,
            ],
            (object)[
                'id' => 2,
                'name' => 'PIX Fitbank',
                'provider' => 'Fitbank',
                'is_active' => true,
            ],
        ]);

        // Mock installment config
        $installmentConfig = (object)[
            'max_installments' => 12,
            'min_installment_amount' => 50,
            'interest_rate' => 2.99,
            'show_installment_savings' => true,
        ];

        $data = [
            'title' => 'Configuração de Pagamentos',
            'feeStructures' => $feeStructures,
            'paymentSplits' => $paymentSplits,
            'averageFee' => $averageFee,
            'totalFeesMonth' => $totalFeesMonth,
            'activeMethodsCount' => $activeMethodsCount,
            'gateways' => $gateways,
            'installmentConfig' => $installmentConfig,
        ];

        return view('user.payment-configuration.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'fixed_fee' => 'required|numeric|min:0',
            'percentage_fee' => 'required|numeric|min:0|max:100',
        ]);

        $user = Auth::user();

        FeeStructure::create([
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'fee_type' => 'custom',
            'fixed_fee' => $request->fixed_fee,
            'percentage_fee' => $request->percentage_fee,
            'is_active' => true,
        ]);

        return redirect()->route('user.payment-configuration.index')
            ->with('success', 'Método de pagamento adicionado com sucesso!');
    }

    public function updateInstallments(Request $request)
    {
        $request->validate([
            'max_installments' => 'required|integer|min:1|max:24',
            'min_installment_amount' => 'required|numeric|min:5',
            'interest_rate' => 'required|numeric|min:0|max:10',
        ]);

        // Save installment configuration (would be saved to database or config)
        // For now, just redirect back with success message

        return redirect()->route('user.payment-configuration.index')
            ->with('success', 'Configuração de parcelamento atualizada com sucesso!');
    }

    public function createSplit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'split_type' => 'required|in:percentage,fixed',
            'recipients' => 'required|array',
            'recipients.*.name' => 'required|string',
            'recipients.*.value' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        // Process recipients
        $recipients = [];
        foreach ($request->recipients as $recipient) {
            if (!empty($recipient['name']) && !empty($recipient['value'])) {
                $recipients[] = [
                    'name' => $recipient['name'],
                    'percentage' => $request->split_type === 'percentage' ? $recipient['value'] : 0,
                    'amount' => $request->split_type === 'fixed' ? $recipient['value'] : 0,
                ];
            }
        }

        PaymentSplit::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'split_type' => $request->split_type,
            'recipients' => $recipients,
            'conditions' => [],
            'is_active' => true,
        ]);

        return redirect()->route('user.payment-configuration.index')
            ->with('success', 'Split de pagamento criado com sucesso!');
    }

    public function toggleFee($id)
    {
        $user = Auth::user();
        $fee = FeeStructure::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $fee->update(['is_active' => !$fee->is_active]);

        return redirect()->route('user.payment-configuration.index')
            ->with('success', 'Status da taxa atualizado com sucesso!');
    }

    public function deleteSplit($id)
    {
        $user = Auth::user();
        $split = PaymentSplit::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $split->delete();

        return redirect()->route('user.payment-configuration.index')
            ->with('success', 'Split removido com sucesso!');
    }

    public function toggleGateway($id)
    {
        // Toggle gateway status (would be saved to database)
        return response()->json(['success' => true]);
    }
}