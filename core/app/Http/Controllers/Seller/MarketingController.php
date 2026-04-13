<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use DB;

class MarketingController extends Controller
{
    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $tools = [
            'discount_codes' => DB::table('discount_codes')->where('user_id', $user->id)->count(),
            'email_campaigns' => DB::table('campaigns')->where('user_id', $user->id)->where('type', 'email')->count(),
            'promo_materials' => DB::table('product_promo_materials')->whereIn('product_id',
                Product::where('user_id', $user->id)->pluck('id')
            )->count(),
            'active_affiliates' => DB::table('affiliate_links')->whereIn('product_id',
                Product::where('user_id', $user->id)->pluck('id')
            )->distinct('affiliate_id')->count()
        ];

        return view('seller.marketing.index', compact('tools', 'lang'));
    }

    public function discounts()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $discounts = DB::table('discount_codes')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('seller.marketing.discounts', compact('discounts', 'lang'));
    }

    public function createDiscount(Request $request)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'code' => 'required|string|unique:discount_codes,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date'
        ]);

        DB::table('discount_codes')->insert([
            'user_id' => $user->id,
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'max_uses' => $request->max_uses,
            'expires_at' => $request->expires_at,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Código de desconto criado!');
    }

    public function promoMaterials()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $products = Product::where('user_id', $user->id)->get();

        return view('seller.marketing.promo-materials', compact('products', 'lang'));
    }

    public function uploadPromoMaterial(Request $request, $productId)
    {
        $user = Auth::guard('user')->user();

        $product = Product::where('user_id', $user->id)->findOrFail($productId);

        $request->validate([
            'type' => 'required|in:banner,image,video',
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:10240'
        ]);

        $path = $request->file('file')->store('promo_materials', 'public');

        DB::table('product_promo_materials')->insert([
            'product_id' => $productId,
            'type' => $request->type,
            'title' => $request->title,
            'file_path' => $path,
            'created_at' => now()
        ]);

        return back()->with('success', 'Material promocional enviado!');
    }
}
