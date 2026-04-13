<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Auth;
use DB;

class MarketplaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware('affiliate.approved'); // Middleware customizado
    }

    public function index(Request $request)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        // Filtros
        $category = $request->category_id;
        $search = $request->search;
        $sortBy = $request->sort_by ?? 'popular';

        // Query de produtos
        $query = Product::where('status', 1)
            ->where('affiliate_enabled', 1);

        if ($category) {
            $query->where('cat_id', $category);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Ordenação
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('total_sales', 'desc');
                break;
            case 'commission':
                $query->orderBy('affiliate_commission_rate', 'desc');
                break;
            case 'price_high':
                $query->orderBy('amount', 'desc');
                break;
            case 'price_low':
                $query->orderBy('amount', 'asc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->with('category')->paginate(24);

        // Adicionar informações de comissão para cada produto
        $products->getCollection()->transform(function($product) use ($affiliate) {
            $product->affiliate_commission = $product->affiliate_commission_rate ?? $affiliate->commission_rate;
            $product->estimated_commission = ($product->amount * $product->affiliate_commission) / 100;
            return $product;
        });

        // Categorias para filtro
        $categories = ProductCategory::where('status', 1)->get();

        // Estatísticas do marketplace
        $stats = [
            'total_products' => Product::where('status', 1)->where('affiliate_enabled', 1)->count(),
            'avg_commission' => $affiliate->commission_rate,
            'top_sellers' => $this->getTopSellers(5)
        ];

        return view('affiliate.marketplace.index', compact('products', 'categories', 'stats', 'lang'));
    }

    public function show($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        $product = Product::where('status', 1)
            ->where('affiliate_enabled', 1)
            ->with(['category', 'user'])
            ->findOrFail($id);

        // Calcular comissão
        $commissionRate = $product->affiliate_commission_rate ?? $affiliate->commission_rate;
        $estimatedCommission = ($product->amount * $commissionRate) / 100;

        // Verificar se já está promovendo
        $isPromoting = DB::table('affiliate_links')
            ->where('affiliate_id', $affiliate->id)
            ->where('product_id', $id)
            ->exists();

        // Estatísticas do produto
        $productStats = [
            'total_sales' => $product->total_sales ?? 0,
            'conversion_rate' => $product->conversion_rate ?? 0,
            'avg_rating' => $product->avg_rating ?? 0,
            'total_affiliates' => DB::table('affiliate_links')
                ->where('product_id', $id)
                ->distinct('affiliate_id')
                ->count()
        ];

        // Materiais promocionais disponíveis
        $promoMaterials = DB::table('product_promo_materials')
            ->where('product_id', $id)
            ->get();

        return view('affiliate.marketplace.show', compact(
            'product',
            'commissionRate',
            'estimatedCommission',
            'isPromoting',
            'productStats',
            'promoMaterials',
            'lang'
        ));
    }

    public function promote($id)
    {
        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        $product = Product::where('status', 1)
            ->where('affiliate_enabled', 1)
            ->findOrFail($id);

        // Verificar se já está promovendo
        $existingLink = DB::table('affiliate_links')
            ->where('affiliate_id', $affiliate->id)
            ->where('product_id', $id)
            ->first();

        if ($existingLink) {
            return back()->with('info', 'Você já está promovendo este produto!');
        }

        // Gerar link de afiliado
        $linkCode = $affiliate->affiliate_code . '-' . strtoupper(substr(md5($id . time()), 0, 6));
        $affiliateUrl = route('product.buy', ['id' => $id, 'ref' => $linkCode]);

        // Criar link de afiliado
        DB::table('affiliate_links')->insert([
            'affiliate_id' => $affiliate->id,
            'product_id' => $id,
            'link_code' => $linkCode,
            'url' => $affiliateUrl,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('affiliate.links.index')
            ->with('success', 'Link de afiliado criado com sucesso! Comece a promover agora.');
    }

    public function stopPromoting($id)
    {
        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        DB::table('affiliate_links')
            ->where('affiliate_id', $affiliate->id)
            ->where('product_id', $id)
            ->delete();

        return back()->with('success', 'Você não está mais promovendo este produto.');
    }

    private function getTopSellers($limit = 5)
    {
        return Product::where('status', 1)
            ->where('affiliate_enabled', 1)
            ->orderBy('total_sales', 'desc')
            ->limit($limit)
            ->get(['id', 'name', 'amount', 'total_sales']);
    }
}
