<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Tickets de suporte
        $tickets = DB::table('support_tickets')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Estatísticas
        $stats = [
            'total_tickets' => DB::table('support_tickets')
                ->where('user_id', $user->id)
                ->count(),
            'open_tickets' => DB::table('support_tickets')
                ->where('user_id', $user->id)
                ->where('status', 'open')
                ->count(),
            'resolved_tickets' => DB::table('support_tickets')
                ->where('user_id', $user->id)
                ->where('status', 'resolved')
                ->count(),
            'avg_response_time' => '2h 30min' // Calcular real
        ];

        return view('customer.support.index', compact('tickets', 'stats', 'lang'));
    }

    public function create()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        // Categorias de suporte
        $categories = [
            'technical' => 'Problema Técnico',
            'billing' => 'Financeiro/Cobrança',
            'product' => 'Produto/Conteúdo',
            'account' => 'Minha Conta',
            'other' => 'Outros'
        ];

        // Produtos do usuário (para contexto)
        $products = DB::table('product_access')
            ->join('products', 'product_access.product_id', '=', 'products.id')
            ->where('product_access.user_id', Auth::id())
            ->where('product_access.status', 'active')
            ->select('products.id', 'products.name')
            ->get();

        return view('customer.support.create', compact('categories', 'products', 'lang'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|in:technical,billing,product,account,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'message' => 'required|string|min:10',
            'product_id' => 'nullable|exists:products,id',
            'attachments.*' => 'nullable|file|max:5120' // 5MB
        ]);

        // Gerar ticket ID
        $ticketId = 'TKT' . now()->format('YmdHis') . rand(1000, 9999);

        // Criar ticket
        $ticketDbId = DB::table('support_tickets')->insertGetId([
            'ticket_id' => $ticketId,
            'user_id' => $user->id,
            'subject' => $request->subject,
            'category' => $request->category,
            'priority' => $request->priority,
            'product_id' => $request->product_id,
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Adicionar primeira mensagem
        DB::table('support_messages')->insert([
            'ticket_id' => $ticketDbId,
            'user_id' => $user->id,
            'message' => $request->message,
            'is_staff' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Upload de anexos
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support_attachments', 'public');

                DB::table('support_attachments')->insert([
                    'ticket_id' => $ticketDbId,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'created_at' => now()
                ]);
            }
        }

        // Enviar notificação para staff (implementar)

        return redirect()->route('customer.support.show', $ticketDbId)
            ->with('success', 'Ticket criado com sucesso! Você receberá uma resposta em breve.');
    }

    public function show($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        $ticket = DB::table('support_tickets')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Mensagens do ticket
        $messages = DB::table('support_messages')
            ->leftJoin('users', 'support_messages.user_id', '=', 'users.id')
            ->where('support_messages.ticket_id', $id)
            ->select(
                'support_messages.*',
                'users.name as user_name',
                'users.email'
            )
            ->orderBy('support_messages.created_at', 'asc')
            ->get();

        // Anexos
        $attachments = DB::table('support_attachments')
            ->where('ticket_id', $id)
            ->get();

        // Produto relacionado
        $product = null;
        if ($ticket->product_id) {
            $product = DB::table('products')
                ->where('id', $ticket->product_id)
                ->first();
        }

        return view('customer.support.show', compact('ticket', 'messages', 'attachments', 'product', 'lang'));
    }

    public function reply(Request $request, $id)
    {
        $user = Auth::user();

        // Verificar se o ticket pertence ao usuário
        $ticket = DB::table('support_tickets')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Não permitir responder ticket fechado
        if ($ticket->status == 'closed') {
            return back()->with('error', 'Este ticket está fechado.');
        }

        $request->validate([
            'message' => 'required|string|min:5',
            'attachments.*' => 'nullable|file|max:5120'
        ]);

        // Adicionar mensagem
        $messageId = DB::table('support_messages')->insertGetId([
            'ticket_id' => $id,
            'user_id' => $user->id,
            'message' => $request->message,
            'is_staff' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Upload de anexos
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support_attachments', 'public');

                DB::table('support_attachments')->insert([
                    'ticket_id' => $id,
                    'message_id' => $messageId,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'created_at' => now()
                ]);
            }
        }

        // Atualizar ticket
        DB::table('support_tickets')
            ->where('id', $id)
            ->update([
                'status' => 'awaiting_staff',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Mensagem enviada com sucesso!');
    }

    public function close($id)
    {
        $user = Auth::user();

        DB::table('support_tickets')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->update([
                'status' => 'closed',
                'closed_at' => now(),
                'updated_at' => now()
            ]);

        return redirect()->route('customer.support.index')
            ->with('success', 'Ticket fechado com sucesso!');
    }

    public function reopen($id)
    {
        $user = Auth::user();

        $ticket = DB::table('support_tickets')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 'closed')
            ->first();

        if (!$ticket) {
            return back()->with('error', 'Ticket não encontrado ou não está fechado.');
        }

        DB::table('support_tickets')
            ->where('id', $id)
            ->update([
                'status' => 'open',
                'closed_at' => null,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Ticket reaberto com sucesso!');
    }

    public function faq()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        // FAQ categorizado
        $faqs = [
            'Geral' => [
                ['question' => 'Como faço para acessar meus produtos?', 'answer' => 'Acesse o menu "Meus Downloads" para ver todos os produtos que você comprou.'],
                ['question' => 'Como solicitar reembolso?', 'answer' => 'Você pode solicitar reembolso em até 7 dias após a compra, na página de detalhes do pedido.'],
            ],
            'Pagamentos' => [
                ['question' => 'Quais formas de pagamento são aceitas?', 'answer' => 'Aceitamos PIX, Cartão de Crédito, Boleto e Transferência Bancária.'],
                ['question' => 'Quando meu pagamento será processado?', 'answer' => 'PIX: instantâneo. Cartão: até 2 dias úteis. Boleto: até 3 dias úteis.'],
            ],
            'Produtos' => [
                ['question' => 'Tenho limite de downloads?', 'answer' => 'Alguns produtos podem ter limite de downloads. Verifique na página do produto.'],
                ['question' => 'Os produtos têm prazo de acesso?', 'answer' => 'Produtos avulsos: acesso vitalício. Assinaturas: enquanto estiver ativa.'],
            ]
        ];

        return view('customer.support.faq', compact('faqs', 'lang'));
    }
}
