<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use DB;

class MarketplaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $status = $request->status ?? 'all';
        $category = $request->category ?? 'all';

        $query = Product::with('user');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($category !== 'all') {
            $query->where('category_id', $category);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estatísticas do marketplace
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 1)->count(),
            'pending_review' => Product::where('status', 0)->count(),
            'total_revenue' => DB::table('transactions')->where('status', 1)->sum('amount'),
            'total_sales' => DB::table('orders')->where('status', 1)->count()
        ];

        $categories = DB::table('categories')->get();

        return view('admin.marketplace.index', compact('products', 'stats', 'categories', 'status', 'category', 'lang'));
    }

    public function show($id)
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $product = Product::with('user')->findOrFail($id);

        // Métricas do produto
        $metrics = [
            'total_sales' => DB::table('order_products')
                ->where('product_id', $id)
                ->count(),
            'revenue' => DB::table('order_products')
                ->join('orders', 'order_products.order_id', '=', 'orders.id')
                ->where('order_products.product_id', $id)
                ->where('orders.status', 1)
                ->sum('order_products.price'),
            'refunds' => DB::table('refunds')
                ->where('product_id', $id)
                ->where('status', 'approved')
                ->count(),
            'avg_rating' => rand(35, 50) / 10, // Implementar sistema de avaliações
            'total_reviews' => rand(10, 200) // Implementar sistema de avaliações
        ];

        // Vendas recentes
        $recentSales = DB::table('orders')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('order_products.product_id', $id)
            ->select(
                'orders.*',
                'users.name as customer_name',
                'users.email as customer_email'
            )
            ->orderBy('orders.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.marketplace.show', compact('product', 'metrics', 'recentSales', 'lang'));
    }

    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 1]);

        return back()->with('success', 'Produto aprovado e publicado no marketplace!');
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'status' => 2,
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'Produto rejeitado.');
    }

    public function suspend($id, Request $request)
    {
        $request->validate([
            'suspension_reason' => 'required|string|max:500'
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'status' => 3,
            'suspension_reason' => $request->suspension_reason
        ]);

        return back()->with('success', 'Produto suspenso.');
    }

    public function reactivate($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 1]);

        return back()->with('success', 'Produto reativado.');
    }

    public function featured()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $featuredProducts = Product::where('is_featured', true)
            ->with('user')
            ->orderBy('featured_order', 'asc')
            ->get();

        return view('admin.marketplace.featured', compact('featuredProducts', 'lang'));
    }

    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_featured' => !$product->is_featured]);

        $message = $product->is_featured ? 'Produto adicionado aos destaques!' : 'Produto removido dos destaques.';
        return back()->with('success', $message);
    }

    public function updateFeaturedOrder(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->products as $item) {
            Product::where('id', $item['id'])->update(['featured_order' => $item['order']]);
        }

        return back()->with('success', 'Ordem dos destaques atualizada!');
    }

    public function categories()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $categories = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->select(
                'categories.*',
                DB::raw('COUNT(products.id) as product_count')
            )
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.icon', 'categories.created_at')
            ->orderBy('categories.name', 'asc')
            ->get();

        return view('admin.marketplace.categories', compact('categories', 'lang'));
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50'
        ]);

        DB::table('categories')->insert([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'icon' => $request->icon,
            'created_at' => now()
        ]);

        return back()->with('success', 'Categoria criada com sucesso!');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50'
        ]);

        DB::table('categories')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'icon' => $request->icon
            ]);

        return back()->with('success', 'Categoria atualizada!');
    }

    public function deleteCategory($id)
    {
        $productCount = Product::where('category_id', $id)->count();

        if ($productCount > 0) {
            return back()->with('error', 'Não é possível excluir categoria com produtos associados.');
        }

        DB::table('categories')->where('id', $id)->delete();

        return back()->with('success', 'Categoria removida.');
    }
}
