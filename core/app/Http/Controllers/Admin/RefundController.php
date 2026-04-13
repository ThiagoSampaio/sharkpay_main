<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class RefundController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard')->with('alert', 'Modulo de reembolsos administrativos ainda nao foi implementado.');
    }

    public function pending()
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