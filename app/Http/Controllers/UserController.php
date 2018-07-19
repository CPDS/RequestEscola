<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipamento;
use DB;
use DataTables;

class UserController extends Controller
{
    //
    
    public function index()
    {
        return view('usuario.index');
    }

    public function listar()
    {
        $Equipamento = Equipamento::orderBy('id','desc')->get();

        return Datatables::of($Equipamento)->make(true);
    }
}
