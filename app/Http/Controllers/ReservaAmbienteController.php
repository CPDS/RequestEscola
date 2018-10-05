<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservaAmbienteController extends Controller
{
  
    public function index()
    {
        return view('reservas.ambiente.index');
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
