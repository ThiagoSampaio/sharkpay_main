<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard')->with('alert', 'Modulo de estruturas de taxa ainda nao foi implementado.');
    }

    public function create()
    {
        return $this->index();
    }

    public function store(Request $request)
    {
        return $this->index();
    }

    public function edit($id)
    {
        return $this->index();
    }

    public function update(Request $request, $id)
    {
        return $this->index();
    }

    public function destroy($id)
    {
        return $this->index();
    }
}