<?php

namespace App\Http\Controllers;

use App\Models\CheckoutBuilder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutBuilderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $data['lang'] = parent::getLanguageVars("user_layout_pages");

        $checkouts = CheckoutBuilder::byUser(Auth::guard('user')->id())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.checkout-builder.index', compact('checkouts'))->with($data);
    }

    public function create()
    {
        $data['lang'] = parent::getLanguageVars("user_layout_pages");

        $products = Product::where('user_id', Auth::guard('user')->id())
            ->where('status', 1)
            ->get();

        return view('user.checkout-builder.create', compact('products'))->with($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'funnel_config' => 'required|array',
            'upsell_products' => 'nullable|array',
            'upsell_products.*' => 'exists:products,id',
            'downsell_products' => 'nullable|array',
            'downsell_products.*' => 'exists:products,id',
            'payment_methods' => 'nullable|array',
            'theme_config' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $checkoutBuilder = new CheckoutBuilder();
        $checkoutBuilder->user_id = Auth::guard('user')->id();
        $checkoutBuilder->name = $request->name;
        $checkoutBuilder->description = $request->description;
        $checkoutBuilder->funnel_config = $request->funnel_config;
        $checkoutBuilder->upsell_products = $request->upsell_products;
        $checkoutBuilder->downsell_products = $request->downsell_products;
        $checkoutBuilder->payment_methods = $request->payment_methods ?? $checkoutBuilder->getDefaultPaymentMethods();
        $checkoutBuilder->theme_config = array_merge($checkoutBuilder->getDefaultThemeConfig(), $request->theme_config ?? []);
        $checkoutBuilder->status = 'draft';

        $checkoutBuilder->save();

        return redirect()->route('user.checkout-builder.show', $checkoutBuilder->id)
            ->with('success', 'Checkout Builder criado com sucesso!');
    }

    public function show($id)
    {
        $data['lang'] = parent::getLanguageVars("user_layout_pages");

        $checkout = CheckoutBuilder::byUser(Auth::guard('user')->id())
            ->with(['user', 'orders'])
            ->findOrFail($id);

        $analytics = $this->getCheckoutAnalytics($checkout);

        return view('user.checkout-builder.show', compact('checkout', 'analytics'))->with($data);
    }

    public function edit($id)
    {
        $data['lang'] = parent::getLanguageVars("user_layout_pages");

        $checkout = CheckoutBuilder::byUser(Auth::guard('user')->id())->findOrFail($id);

        $products = Product::where('user_id', Auth::guard('user')->id())
            ->where('status', 1)
            ->get();

        return view('user.checkout-builder.edit', compact('checkout', 'products'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $checkout = CheckoutBuilder::byUser(Auth::guard('user')->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'funnel_config' => 'required|array',
            'upsell_products' => 'nullable|array',
            'upsell_products.*' => 'exists:products,id',
            'downsell_products' => 'nullable|array',
            'downsell_products.*' => 'exists:products,id',
            'payment_methods' => 'nullable|array',
            'theme_config' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $checkout->update([
            'name' => $request->name,
            'description' => $request->description,
            'funnel_config' => $request->funnel_config,
            'upsell_products' => $request->upsell_products,
            'downsell_products' => $request->downsell_products,
            'payment_methods' => $request->payment_methods,
            'theme_config' => array_merge($checkout->theme_config ?? [], $request->theme_config ?? [])
        ]);

        return redirect()->route('user.checkout-builder.show', $checkout->id)
            ->with('success', 'Checkout Builder atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $checkout = CheckoutBuilder::byUser(Auth::guard('user')->id())->findOrFail($id);

        if ($checkout->total_orders > 0) {
            return back()->with('error', 'Não é possível excluir um checkout que já possui pedidos.');
        }

        $checkout->delete();

        return redirect()->route('user.checkout-builder.index')
            ->with('success', 'Checkout Builder excluído com sucesso!');
    }

    public function activate($id)
    {
        $checkout = CheckoutBuilder::byUser(Auth::guard('user')->id())->findOrFail($id);
        $checkout->activate();

        return back()->with('success', 'Checkout ativado com sucesso!');
    }

    public function deactivate($id)
    {
        $checkout = CheckoutBuilder::byUser(Auth::guard('user')->id())->findOrFail($id);
        $checkout->deactivate();

        return back()->with('success', 'Checkout desativado com sucesso!');
    }

    public function preview($slug)
    {
        $checkout = CheckoutBuilder::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $upsellProducts = $checkout->getUpsellProducts();
        $downsellProducts = $checkout->getDownsellProducts();

        return view('checkout-builder.preview', compact('checkout', 'upsellProducts', 'downsellProducts'));
    }

    public function duplicate($id)
    {
        $original = CheckoutBuilder::byUser(Auth::guard('user')->id())->findOrFail($id);

        $duplicate = $original->replicate();
        $duplicate->name = $original->name . ' (Cópia)';
        $duplicate->slug = null; // Will be generated by mutator
        $duplicate->status = 'draft';
        $duplicate->total_orders = 0;
        $duplicate->total_revenue = 0;
        $duplicate->conversion_rate = 0;
        $duplicate->save();

        return redirect()->route('user.checkout-builder.edit', $duplicate->id)
            ->with('success', 'Checkout duplicado com sucesso!');
    }

    public function analytics($id)
    {
        $data['lang'] = parent::getLanguageVars("user_layout_pages");

        $checkout = CheckoutBuilder::byUser(Auth::guard('user')->id())->findOrFail($id);
        $analytics = $this->getDetailedAnalytics($checkout);

        return view('user.checkout-builder.analytics', compact('checkout', 'analytics'))->with($data);
    }

    private function getCheckoutAnalytics($checkout)
    {
        return [
            'total_visits' => rand(100, 1000), // Placeholder - implement real tracking
            'total_orders' => $checkout->total_orders,
            'total_revenue' => $checkout->total_revenue,
            'conversion_rate' => $checkout->conversion_rate_formatted,
            'average_order_value' => $checkout->total_orders > 0 ? $checkout->total_revenue / $checkout->total_orders : 0
        ];
    }

    private function getDetailedAnalytics($checkout)
    {
        // Placeholder for detailed analytics
        return [
            'daily_stats' => [],
            'payment_methods_breakdown' => [],
            'upsell_performance' => [],
            'abandonment_rate' => 0,
            'top_exit_points' => []
        ];
    }

    public function exportData($id)
    {
        $checkout = CheckoutBuilder::byUser(Auth::guard('user')->id())->findOrFail($id);

        // Implementation for exporting checkout data
        // Can be CSV, PDF, etc.

        return response()->json(['message' => 'Export functionality to be implemented']);
    }
}