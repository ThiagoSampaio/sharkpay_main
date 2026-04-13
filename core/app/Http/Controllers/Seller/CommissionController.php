<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\Product;
use Auth;
use DB;

class CommissionController extends Controller
{
    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $commissions = Commission::where('user_id', $user->id)
            ->with('affiliate')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $summary = [
            'total' => Commission::where('user_id', $user->id)->sum('commission_amount'),
            'pending' => Commission::where('user_id', $user->id)->where('status', 'pending')->sum('commission_amount'),
            'approved' => Commission::where('user_id', $user->id)->where('status', 'approved')->sum('commission_amount'),
            'paid' => Commission::where('user_id', $user->id)->where('status', 'paid')->sum('commission_amount')
        ];

        return view('seller.commissions.index', compact('commissions', 'summary', 'lang'));
    }

    public function settings()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $products = Product::where('user_id', $user->id)->get();

        return view('seller.commissions.settings', compact('products', 'lang'));
    }

    public function updateProductCommission(Request $request, $productId)
    {
        $user = Auth::guard('user')->user();

        $product = Product::where('user_id', $user->id)->findOrFail($productId);

        $request->validate([
            'affiliate_commission_rate' => 'required|numeric|min:0|max:50'
        ]);

        $product->update([
            'affiliate_commission_rate' => $request->affiliate_commission_rate,
            'affiliate_enabled' => $request->has('affiliate_enabled')
        ]);

        return back()->with('success', 'Configuração de comissão atualizada!');
    }
}
