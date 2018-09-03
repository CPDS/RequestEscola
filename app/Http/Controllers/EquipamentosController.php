<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\TipoEquipamentos;
use App\Locais;
use Validator;
use Response;
use DataTables;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;


class EquipamentosController extends Controller
{
    
    public function index()
    {
        $tipoequipamentos = TipoEquipamentos::where('status','Ativo')->get();
        $locais = Locais::where('status',true)->get();
        
        return view('equipamento.index',compact('tipoequipamentos','locais'));
    }

    public function store(Request $request)
    {
        
    }

  
    public function list()
    {
        //
    }

  
    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
