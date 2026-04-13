<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        // Produtos que está promovendo
        $products = DB::table('affiliate_links')
            ->join('products', 'affiliate_links.product_id', '=', 'products.id')
            ->where('affiliate_links.affiliate_id', $affiliate->id)
            ->select(
                'affiliate_links.*',
                'products.name',
                'products.amount',
                'products.thumbnail'
            )
            ->orderBy('affiliate_links.created_at', 'desc')
            ->paginate(20);

        // Estatísticas
        $stats = [
            'total_products' => $products->total(),
            'total_clicks' => DB::table('affiliate_links')
                ->where('affiliate_id', $affiliate->id)
                ->sum('clicks'),
            'total_conversions' => DB::table('affiliate_links')
                ->where('affiliate_id', $affiliate->id)
                ->sum('conversions'),
            'total_revenue' => DB::table('affiliate_links')
                ->where('affiliate_id', $affiliate->id)
                ->sum('revenue')
        ];

        return view('affiliate.products.index', compact('products', 'stats', 'lang'));
    }
}
