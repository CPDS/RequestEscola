<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Validator;
use Response;
use DataTables;
use DB;
use Auth;
use Hash;
use App\{
    Reservas,
    Ambiente,
    Locais
};

class ReservaEquipamentoController extends Controller
{
    
    public function index()
    {   
        $locais = Locais::where('status',true)->get();
        return view('reservas.equipamento.index',compact('locais'));
    }

    //listar pedidos para colaboradores e professores
    public function list(){

    }

    //lista de atendidos para colaboradores
    public function atendidos(){

    }
  
    //Criando reserva
    public function store(Request $request)
    {
        //
    }

    //Atualizando Reserva
    public function update(Request $request)
    {
        //
    }

    //Excluindo reserva
    public function destroy(Request $request)
    {
        //
    }
    
    //Cancelando reserva
    public function cancelar(Request $request){

    }
    
}
