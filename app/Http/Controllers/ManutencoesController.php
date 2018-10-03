<?php

namespace App\Http\Controllers;

use App\Manutencoes;
use App\Http\Controllers\Controller;

class ManutencoesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manutencao.index');
    }
}