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
use App\Reservas;

class ReservaAmbienteController extends Controller
{
  
    public function index()
    {
        return view('reservas.ambiente.index');
    }

    //Botões
    private function setDataButtons(Reservas $reservas){
        
        //recuperando ambientes reservados
        $ambientes = AmbienteReserva::where('status',true)
        ->where('tipo',true)
        ->where('fk_reserva',$reservas->id)
        ->first();

        //Recuperando data e hora final da reserva e convertendo o formato
        $data_final = date('d/m/Y',strtotime($reservas->data_final));
        $hora_final = date('H:i',strtotime($reservas->data_final));
        
        //conteudo da reserva
        $dados = 'data-id_reserva="'.$reservas->id.
        '" data-ambiente="'.$ambientes->ambiente->tipo.
        '" data-local="'.$ambientes->ambiente->local->nome.
        '" data-numero="'.$ambientes->ambiente->numero_ambiente.
        '" data-data_final="'.$data_final.
        '" data-hora="'.$hora_final.
        '" data-descricao="'.$reservas->observacao.'"';

        //Botões para colaboradores (Administradores e funcionários)
        if(Auth::user()->hasRole('Administrador|Funcionário')){
            


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
        $usuario_logado = Auth::user();
        //Selecionar todas as reservas
        if($usuario_logado->hasRole('Administrador|Funcionário')){
            //selecionar reservas de ambiente
            /*$reservas = Reservas::with('usuario')
            ->where('status','Reservado')
            ->get();*/
            $reservas = Reservas::where('status','Reservado')
            ->get();
            //dd($reservas);

            return Datatables::of($reservas)
            ->editColumn('acao', function($reservas){
                return $this->setDataButtons($reservas);
                //return 'Acao';
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
