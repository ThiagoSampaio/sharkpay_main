<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function conversions()
    {
        return redirect()->route('affiliate.dashboard')->with('alert', 'Relatorio de conversoes indisponivel no momento.');
    }

    public function earnings()
    {
        return redirect()->route('affiliate.dashboard')->with('alert', 'Relatorio de ganhos indisponivel no momento.');
    }

    public function performance()
    {
        return redirect()->route('affiliate.dashboard')->with('alert', 'Relatorio de performance indisponivel no momento.');
    }
}