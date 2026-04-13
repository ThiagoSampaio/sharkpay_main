<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Verificar se já é afiliado
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        if ($affiliate) {
            return redirect()->route('affiliate.dashboard')
                ->with('info', 'Você já é um afiliado!');
        }

        // Informações do programa de afiliados
        $programInfo = [
            'commission_rate' => 10, // 10% padrão
            'min_payout' => 100.00,
            'payment_methods' => ['PIX', 'Transferência Bancária'],
            'cookie_duration' => 30, // 30 dias
            'benefits' => [
                'Comissão de até 15% em todas as vendas',
                'Pagamentos semanais via PIX',
                'Materiais promocionais exclusivos',
                'Dashboard com estatísticas em tempo real',
                'Suporte dedicado para afiliados'
            ]
        ];

        return view('affiliate.register.index', compact('programInfo', 'lang'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Verificar se já é afiliado
        $existingAffiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        if ($existingAffiliate) {
            return back()->with('error', 'Você já é um afiliado!');
        }

        $request->validate([
            'payment_method' => 'required|in:pix,bank_transfer',
            'payment_details' => 'required|array',
            'terms_accepted' => 'required|accepted',
            'promotional_channels' => 'required|array',
            'promotional_channels.*' => 'in:social_media,blog,youtube,email,whatsapp,other',
            'audience_size' => 'nullable|string',
            'experience' => 'nullable|string'
        ]);

        // Gerar código de afiliado único
        do {
            $affiliateCode = strtoupper(Str::random(8));
        } while (DB::table('affiliates')->where('affiliate_code', $affiliateCode)->exists());

        // Criar registro de afiliado
        DB::table('affiliates')->insert([
            'user_id' => $user->id,
            'affiliate_code' => $affiliateCode,
            'commission_rate' => 10.00, // Taxa padrão
            'status' => 'pending', // Aguardando aprovação
            'payment_method' => $request->payment_method,
            'payment_details' => json_encode($request->payment_details),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Registrar informações adicionais
        DB::table('affiliate_applications')->insert([
            'user_id' => $user->id,
            'promotional_channels' => json_encode($request->promotional_channels),
            'audience_size' => $request->audience_size,
            'experience' => $request->experience,
            'status' => 'pending',
            'created_at' => now()
        ]);

        // Notificar admin (implementar)

        return redirect()->route('affiliate.register.pending')
            ->with('success', 'Sua solicitação foi enviada com sucesso! Você receberá uma resposta em até 48 horas.');
    }

    public function pending()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        if (!$affiliate) {
            return redirect()->route('affiliate.register.index');
        }

        if ($affiliate->status == 'approved') {
            return redirect()->route('affiliate.dashboard');
        }

        if ($affiliate->status == 'rejected') {
            $application = DB::table('affiliate_applications')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();

            return view('affiliate.register.rejected', compact('affiliate', 'application', 'lang'));
        }

        $application = DB::table('affiliate_applications')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('affiliate.register.pending', compact('affiliate', 'application', 'lang'));
    }

    public function updatePaymentMethod(Request $request)
    {
        $user = Auth::user();

        $affiliate = DB::table('affiliates')
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();

        if (!$affiliate) {
            return back()->with('error', 'Você não é um afiliado aprovado.');
        }

        $request->validate([
            'payment_method' => 'required|in:pix,bank_transfer',
            'payment_details' => 'required|array'
        ]);

        DB::table('affiliates')
            ->where('id', $affiliate->id)
            ->update([
                'payment_method' => $request->payment_method,
                'payment_details' => json_encode($request->payment_details),
                'updated_at' => now()
            ]);

        return back()->with('success', 'Método de pagamento atualizado com sucesso!');
    }
}
