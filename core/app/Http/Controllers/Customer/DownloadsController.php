<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;

class DownloadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Produtos comprados com acesso
        $products = DB::table('product_access')
            ->join('products', 'product_access.product_id', '=', 'products.id')
            ->where('product_access.user_id', $user->id)
            ->where('product_access.status', 'active')
            ->select(
                'products.*',
                'product_access.granted_at',
                'product_access.expires_at',
                'product_access.access_type',
                'product_access.access_count'
            )
            ->orderBy('product_access.granted_at', 'desc')
            ->paginate(20);

        // Estatísticas de downloads
        $stats = [
            'total_products' => DB::table('product_access')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->count(),
            'total_downloads' => DB::table('downloads')
                ->where('user_id', $user->id)
                ->sum('download_count'),
            'recent_downloads' => DB::table('downloads')
                ->where('user_id', $user->id)
                ->whereDate('last_downloaded_at', '>=', now()->subDays(7))
                ->count()
        ];

        return view('customer.downloads.index', compact('products', 'stats', 'lang'));
    }

    public function files($productId)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Verificar acesso ao produto
        $access = DB::table('product_access')
            ->where('user_id', $user->id)
            ->where('product_id', $productId)
            ->where('status', 'active')
            ->first();

        if (!$access) {
            return redirect()->route('customer.downloads.index')
                ->with('error', 'Você não tem acesso a este produto.');
        }

        // Verificar se expirou
        if ($access->expires_at && now()->gt($access->expires_at)) {
            return redirect()->route('customer.downloads.index')
                ->with('error', 'Seu acesso a este produto expirou.');
        }

        // Buscar produto e arquivos
        $product = Product::findOrFail($productId);

        $files = DB::table('product_files')
            ->where('product_id', $productId)
            ->get();

        // Histórico de downloads deste produto
        $downloadHistory = DB::table('downloads')
            ->where('user_id', $user->id)
            ->where('product_id', $productId)
            ->orderBy('last_downloaded_at', 'desc')
            ->limit(10)
            ->get();

        return view('customer.downloads.files', compact('product', 'files', 'access', 'downloadHistory', 'lang'));
    }

    public function download($fileId)
    {
        $user = Auth::user();

        // Buscar arquivo
        $file = DB::table('product_files')->where('id', $fileId)->firstOrFail();

        // Verificar acesso
        $access = DB::table('product_access')
            ->where('user_id', $user->id)
            ->where('product_id', $file->product_id)
            ->where('status', 'active')
            ->first();

        if (!$access) {
            abort(403, 'Acesso negado a este arquivo.');
        }

        // Verificar limite de downloads
        if ($file->download_limit) {
            $downloadCount = DB::table('downloads')
                ->where('user_id', $user->id)
                ->where('file_id', $fileId)
                ->value('download_count') ?? 0;

            if ($downloadCount >= $file->download_limit) {
                return back()->with('error', 'Limite de downloads atingido para este arquivo.');
            }
        }

        // Registrar download
        DB::table('downloads')->updateOrInsert(
            [
                'user_id' => $user->id,
                'file_id' => $fileId,
                'product_id' => $file->product_id
            ],
            [
                'file_name' => $file->file_name,
                'file_path' => $file->file_path,
                'file_size' => $file->file_size,
                'download_count' => DB::raw('download_count + 1'),
                'last_downloaded_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'updated_at' => now()
            ]
        );

        // Atualizar contador de acesso
        DB::table('product_access')
            ->where('user_id', $user->id)
            ->where('product_id', $file->product_id)
            ->update([
                'access_count' => DB::raw('access_count + 1'),
                'last_accessed_at' => now()
            ]);

        // Fazer download do arquivo
        if (Storage::exists($file->file_path)) {
            return Storage::download($file->file_path, $file->original_name);
        }

        return back()->with('error', 'Arquivo não encontrado.');
    }

    public function history()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        $downloads = DB::table('downloads')
            ->join('products', 'downloads.product_id', '=', 'products.id')
            ->where('downloads.user_id', $user->id)
            ->select(
                'downloads.*',
                'products.name as product_name',
                'products.thumbnail'
            )
            ->orderBy('downloads.last_downloaded_at', 'desc')
            ->paginate(50);

        return view('customer.downloads.history', compact('downloads', 'lang'));
    }
}
