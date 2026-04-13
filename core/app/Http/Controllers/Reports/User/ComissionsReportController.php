<?php

namespace App\Http\Controllers\Reports\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComissionsReportController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('user.dashboard')->with('alert', 'Relatorio de comissoes indisponivel no momento.');
    }
}