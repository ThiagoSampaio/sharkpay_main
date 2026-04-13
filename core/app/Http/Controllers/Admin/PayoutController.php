<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard')->with('alert', 'Modulo de payouts administrativos ainda nao foi implementado.');
    }

    public function pending()
    {
        return $this->index();
    }

    public function approveBatch(Request $request)
    {
        return $this->index();
    }

    public function approve($id)
    {
        return $this->index();
    }

    public function reject($id)
    {
        return $this->index();
    }

    public function show($id)
    {
        return $this->index();
    }
}