<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class CampaignsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        $campaigns = DB::table('campaigns')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('affiliate.campaigns.index', compact('campaigns', 'lang'));
    }

    public function create()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        return view('affiliate.campaigns.create', compact('lang'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:email,sms,push,banner',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        DB::table('campaigns')->insert([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'status' => 'draft',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('affiliate.campaigns.index')
            ->with('success', 'Campanha criada com sucesso!');
    }
}
