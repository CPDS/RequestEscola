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
use App\Ambiente;
use App\Locais;
use App\AmbienteReserva;
use Hash;

class ReservaAmbienteController extends Controller
{
  
    public function index()
    {
        return view('reservas.ambiente.index');
    }

    //Botões
    private function setDataButtons(AmbienteReserva $reservas, Boolean $colaborador){
        //Botões para colaboradores (Administradores e funcionários)
        if($colaborador){
            $dados = 'data-id_reserva=""';
        }

    }
    //Criar Reserva
    public function store(Request $request)
    {
        //
    }

    //Atualizar pedido
    public function update(Request $request)
    {
        //
    }

    //listar ambientes reservados
    public function reservados(){
        //Capiturar Usuário Logado
        $usuario_logado = Auth::User;
        //Selecionar todas as reservas
        if($usuario_logado->hasRole('Administrador|Funcionário')){
            //selecionar reservas de ambiente
            $reservas = AmbienteReserva::where('status',true)
            ->where('tipo',true)->get();

            return Datatables::of($reservas)
            ->editColumn('acao', function($reservas){
                //return $this->setDataButtons($reservas,true);
                return 'Acao';
            })
            ->escapeColumns([0])
            ->make(true);
            
        }

    }

    //Listar ambientes reservados que estão em uso 
    public function atendidos(){

    }

    //Finalizar Reserva de ambiente
    public function finalizar(Request $request)
    {
        //
    }

    //Cancelar reserva
    public function destroy(Request $request){

    }
}
