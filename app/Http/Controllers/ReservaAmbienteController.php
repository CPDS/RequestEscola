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
       
        //recuperando hora inicial da reserva
        $hora_inicial = date('H:i',strtotime($reservas->data_inicial));
        
        /*Turnos
            Manhã: 07:30 às 11:20
            Tarde: 14:00 às 18:00
            Noite: 18:30 às 22:30
        */
       
        //Definindo varivaveis de turno
        $manha_inicio = date('H:i',strtotime("07:30"));
        $manha_final = date('H:i',strtotime("11:20"));

        $tarde_inicio = date('H:i',strtotime("14:00"));
        $tarde_final = date('H:i',strtotime("18:00"));

        $noite_inicio = date('H:i',strtotime("18:30"));
        $noite_final = date('H:i',strtotime("22:30"));

        //Comparação de horario por turno
        if($hora_inicial >= $manha_inicio && $hora_final <= $manha_final)
            $turno = 'Manhã';
        else if($hora_inicial >= $tarde_inicio && $hora_final <= $tarde_final)
            $turno = 'Tarde';
        else if($hora_inicial >= $noite_inicio && $hora_final <= $noite_final)
            $turno = 'Noite';
        else if($hora_inicial >= $manha_inicio && $hora_final <= $tarde_final)
            $turno = 'Manhã e Tarde';
        else if($hora_inicial >= $tarde_inicio && $hora_final <= $noite_final)
            $turno = 'Tarde e Noite';
        else
            $turno = 'Manhã, Tarde e Noite';

        //conteudo da reserva
        $dadosVisualizar = 'data-id="'.$reservas->id.
        '" data-local="'.$ambientes->ambiente->local->nome.
        '" data-numero="'.$ambientes->ambiente->numero_ambiente.
        '" data-hora_incio="'.$hora_inicial.
        '" data-data_final="'.$data_final.
        '" data-hora_final="'.$hora_final.
        '" data-descricao="'.$reservas->observacao.
        '" data-telefone="'.$reservas->usuario->telefone.'"';

    
        $btnVisualizar = '<a class="btn btn-sm btn-info btnVisualizar" '.$dadosVisualizar.' title="Visualizar" data-toggle="tooltip" ><i class="fa fa-eye"></i></a>';

        $btnExcluir = ' <a data-id="'.$reservas->id.'" class="btn btn-danger btnExcluir" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';

        $btnEditar = '';
        
        //Botões para colaboradores (Administradores e funcionários)
        if(Auth::user()->hasRole('Administrador|Funcionário'))
            $btnEditar = ' <a  data-id="'.$reservas->id.'" class="btn btn-sm btn-primary btnEditar" title="Editar" data-toggle="tooltip" ><i class="fa fa- fa-pencil-square-o"></i></a>';
        
        
        return $btnVisualizar . $btnEditar . $btnExcluir;

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
        //Consulta para Colaboradores
        if($usuario_logado->hasRole('Administrador|Funcionário')){
            $reservas = Reservas::where('status','Reservado')
            ->get();
        }else{//Consulta para professores
            $reservas = Reservas::with('usuario')
            ->where('status','Reservado')
            ->get();
        }
        
        return Datatables::of($reservas)
        ->editColumn('acao', function($reservas){
            return $this->setDataButtons($reservas);
                //return 'Acao';
        })
        ->escapeColumns([0])
        ->make(true);
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
