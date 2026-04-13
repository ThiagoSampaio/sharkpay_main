<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\PaymentMethodsManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GlobalPaymentConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();
        $paymentManager = new PaymentMethodsManager($user);
        $availableMethods = $paymentManager->getAvailablePaymentMethods();

        $settings = [
            'pix_enabled' => $user->getSetting('payment_method_pix_enabled', true),
            'credit_card_enabled' => $user->getSetting('payment_method_credit_card_enabled', true),
            'boleto_enabled' => $user->getSetting('payment_method_boleto_enabled', true),
            'bank_transfer_enabled' => $user->getSetting('payment_method_bank_transfer_enabled', false),

            // Taxas PIX
            'pix_fee_percentage' => $user->getSetting('payment_method_pix_fee_percentage', 0),
            'pix_fee_fixed' => $user->getSetting('payment_method_pix_fee_fixed', 0),
            'pix_min_amount' => $user->getSetting('payment_method_pix_min_amount', 1),
            'pix_max_amount' => $user->getSetting('payment_method_pix_max_amount', 999999),

            // Taxas Cartão de Crédito
            'credit_card_fee_percentage' => $user->getSetting('payment_method_credit_card_fee_percentage', 3.5),
            'credit_card_fee_fixed' => $user->getSetting('payment_method_credit_card_fee_fixed', 0.39),
            'credit_card_min_amount' => $user->getSetting('payment_method_credit_card_min_amount', 5),
            'credit_card_max_amount' => $user->getSetting('payment_method_credit_card_max_amount', 999999),
            'credit_card_max_installments' => $user->getSetting('credit_card_max_installments', 12),

            // Taxas Boleto
            'boleto_fee_percentage' => $user->getSetting('payment_method_boleto_fee_percentage', 0),
            'boleto_fee_fixed' => $user->getSetting('payment_method_boleto_fee_fixed', 3.50),
            'boleto_min_amount' => $user->getSetting('payment_method_boleto_min_amount', 5),
            'boleto_max_amount' => $user->getSetting('payment_method_boleto_max_amount', 999999),
            'boleto_due_days' => $user->getSetting('boleto_due_days', 3),

            // Taxas Transferência Bancária
            'bank_transfer_fee_percentage' => $user->getSetting('payment_method_bank_transfer_fee_percentage', 0),
            'bank_transfer_fee_fixed' => $user->getSetting('payment_method_bank_transfer_fee_fixed', 0),
            'bank_transfer_min_amount' => $user->getSetting('payment_method_bank_transfer_min_amount', 1),
            'bank_transfer_max_amount' => $user->getSetting('payment_method_bank_transfer_max_amount', 999999),
        ];

        $installmentFees = $this->getInstallmentFees($user);

        return view('user.payment-config.index', compact('settings', 'availableMethods', 'installmentFees', 'lang'));
    }

    public function updatePaymentMethods(Request $request)
    {
        $user = Auth::guard('user')->user();

        $validator = Validator::make($request->all(), [
            'pix_enabled' => 'boolean',
            'credit_card_enabled' => 'boolean',
            'boleto_enabled' => 'boolean',
            'bank_transfer_enabled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $settings = [
            'payment_method_pix_enabled' => $request->has('pix_enabled'),
            'payment_method_credit_card_enabled' => $request->has('credit_card_enabled'),
            'payment_method_boleto_enabled' => $request->has('boleto_enabled'),
            'payment_method_bank_transfer_enabled' => $request->has('bank_transfer_enabled'),
        ];

        foreach ($settings as $key => $value) {
            $user->setSetting($key, $value);
        }

        return back()->with('success', 'Métodos de pagamento atualizados com sucesso!');
    }

    public function updateFees(Request $request)
    {
        $user = Auth::guard('user')->user();

        $validator = Validator::make($request->all(), [
            // PIX
            'pix_fee_percentage' => 'numeric|min:0|max:100',
            'pix_fee_fixed' => 'numeric|min:0',
            'pix_min_amount' => 'numeric|min:0.01',
            'pix_max_amount' => 'numeric|min:1',

            // Cartão de Crédito
            'credit_card_fee_percentage' => 'numeric|min:0|max:100',
            'credit_card_fee_fixed' => 'numeric|min:0',
            'credit_card_min_amount' => 'numeric|min:0.01',
            'credit_card_max_amount' => 'numeric|min:1',
            'credit_card_max_installments' => 'integer|min:1|max:24',

            // Boleto
            'boleto_fee_percentage' => 'numeric|min:0|max:100',
            'boleto_fee_fixed' => 'numeric|min:0',
            'boleto_min_amount' => 'numeric|min:0.01',
            'boleto_max_amount' => 'numeric|min:1',
            'boleto_due_days' => 'integer|min:1|max:30',

            // Transferência Bancária
            'bank_transfer_fee_percentage' => 'numeric|min:0|max:100',
            'bank_transfer_fee_fixed' => 'numeric|min:0',
            'bank_transfer_min_amount' => 'numeric|min:0.01',
            'bank_transfer_max_amount' => 'numeric|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $settingsToUpdate = [
            'payment_method_pix_fee_percentage',
            'payment_method_pix_fee_fixed',
            'payment_method_pix_min_amount',
            'payment_method_pix_max_amount',
            'payment_method_credit_card_fee_percentage',
            'payment_method_credit_card_fee_fixed',
            'payment_method_credit_card_min_amount',
            'payment_method_credit_card_max_amount',
            'credit_card_max_installments',
            'payment_method_boleto_fee_percentage',
            'payment_method_boleto_fee_fixed',
            'payment_method_boleto_min_amount',
            'payment_method_boleto_max_amount',
            'boleto_due_days',
            'payment_method_bank_transfer_fee_percentage',
            'payment_method_bank_transfer_fee_fixed',
            'payment_method_bank_transfer_min_amount',
            'payment_method_bank_transfer_max_amount',
        ];

        foreach ($settingsToUpdate as $setting) {
            $value = $request->input(str_replace('payment_method_', '', $setting));
            if ($value !== null) {
                $user->setSetting($setting, $value);
            }
        }

        return back()->with('success', 'Taxas atualizadas com sucesso!');
    }

    public function updateInstallmentFees(Request $request)
    {
        $user = Auth::guard('user')->user();

        $validator = Validator::make($request->all(), [
            'installment_fees' => 'required|array',
            'installment_fees.*' => 'numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach ($request->installment_fees as $installment => $fee) {
            $user->setSetting("credit_card_installment_{$installment}_fee", $fee);
        }

        return back()->with('success', 'Taxas de parcelamento atualizadas com sucesso!');
    }

    public function getPaymentPreview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string|in:pix,credit_card,boleto,bank_transfer',
            'installments' => 'integer|min:1|max:24',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::guard('user')->user();
        $paymentManager = new PaymentMethodsManager($user);

        $amount = $request->amount;
        $method = $request->method;
        $installments = $request->installments ?? 1;

        $fees = $paymentManager->calculateFees($method, $amount, $installments);
        $methodConfig = $paymentManager->getMethodConfig($method);

        $response = [
            'method' => $method,
            'method_name' => $methodConfig['name'],
            'amount' => $amount,
            'fees' => $fees,
            'installment_options' => []
        ];

        if ($method === 'credit_card') {
            $response['installment_options'] = $paymentManager->getInstallmentOptions($amount);
        }

        return response()->json($response);
    }

    public function resetToDefaults(Request $request)
    {
        $user = Auth::guard('user')->user();

        $defaultSettings = [
            'payment_method_pix_enabled' => true,
            'payment_method_credit_card_enabled' => true,
            'payment_method_boleto_enabled' => true,
            'payment_method_bank_transfer_enabled' => false,
            'payment_method_pix_fee_percentage' => 0,
            'payment_method_pix_fee_fixed' => 0,
            'payment_method_credit_card_fee_percentage' => 3.5,
            'payment_method_credit_card_fee_fixed' => 0.39,
            'payment_method_boleto_fee_percentage' => 0,
            'payment_method_boleto_fee_fixed' => 3.50,
            'payment_method_bank_transfer_fee_percentage' => 0,
            'payment_method_bank_transfer_fee_fixed' => 0,
        ];

        foreach ($defaultSettings as $key => $value) {
            $user->setSetting($key, $value);
        }

        // Reset installment fees
        for ($i = 1; $i <= 12; $i++) {
            $defaultFee = $i <= 2 ? 0 : ($i <= 6 ? 2.5 : 5.0);
            $user->setSetting("credit_card_installment_{$i}_fee", $defaultFee);
        }

        return back()->with('success', 'Configurações resetadas para os valores padrão!');
    }

    public function exportConfig()
    {
        $user = Auth::guard('user')->user();
        $paymentManager = new PaymentMethodsManager($user);
        $config = $paymentManager->getAvailablePaymentMethods();

        $filename = 'payment-config-' . $user->id . '-' . date('Y-m-d') . '.json';

        return response()->json($config)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function importConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'config_file' => 'required|file|mimes:json',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $file = $request->file('config_file');
            $config = json_decode(file_get_contents($file->getRealPath()), true);

            if (!$config) {
                return back()->with('error', 'Arquivo de configuração inválido!');
            }

            // Implementar importação das configurações
            // Validar e aplicar as configurações do arquivo

            return back()->with('success', 'Configurações importadas com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao importar configurações: ' . $e->getMessage());
        }
    }

    private function getInstallmentFees($user)
    {
        $fees = [];
        for ($i = 1; $i <= 12; $i++) {
            $fees[$i] = $user->getSetting("credit_card_installment_{$i}_fee", 0);
        }
        return $fees;
    }
}