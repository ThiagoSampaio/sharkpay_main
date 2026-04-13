<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class LinksController extends Controller
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

        $links = DB::table('affiliate_links')
            ->join('products', 'affiliate_links.product_id', '=', 'products.id')
            ->where('affiliate_links.affiliate_id', $affiliate->id)
            ->select('affiliate_links.*', 'products.name as product_name')
            ->orderBy('affiliate_links.created_at', 'desc')
            ->paginate(20);

        return view('affiliate.links.index', compact('links', 'lang'));
    }

    public function analytics($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        $link = DB::table('affiliate_links')
            ->join('products', 'affiliate_links.product_id', '=', 'products.id')
            ->where('affiliate_links.id', $id)
            ->where('affiliate_links.affiliate_id', $affiliate->id)
            ->select('affiliate_links.*', 'products.name as product_name', 'products.amount')
            ->firstOrFail();

        $analytics = [
            'clicks' => $link->clicks,
            'conversions' => $link->conversions,
            'revenue' => $link->revenue,
            'conversion_rate' => $link->clicks > 0 ? round(($link->conversions / $link->clicks) * 100, 2) : 0
        ];

        return view('affiliate.links.analytics', compact('link', 'analytics', 'lang'));
    }
}
