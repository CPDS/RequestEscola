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
    Locais,
    Equipamentos,
    EquipamentoReservas, 
    TipoAmbiente,
    AmbienteReserva
};

class ReservaEquipamentoController extends Controller
{
    
    public function index()
    {   
        $locais = Locais::where('status',true)->get();
        $ambientes = Ambiente::where('status','Ativo')->get();
        $tipoAmbientes = TipoAmbiente::where('status',true)->get();
        return view('reservas.equipamento.index',compact('locais','ambientes','tipoAmbientes'));
    }

    //Botões
    private function setDataButtons(Reservas $reservas){
    
        
        //recuperando dados de ambiente
        $ambientes = AmbienteReserva::where('fk_reserva',$reservas->id)
        ->where('status','Ativo')->first();

        $equipamento_reservas = EquipamentoReservas::where('status','!=','Inativo')
        ->where('fk_reserva',$reservas->id)
        ->get();

        $equipamentos = '';
        //equipamentos
        foreach($equipamento_reservas as $equipamento){
            $equipamentos .= 'Tipo: '.$equipamento->equipamento->tipoEquipamento->nome;
            if(!$equipamento->equipamento->codigo)
                $equipamentos .= 'Tombo: '.$equipamento->equipamento->num_tombo;
            else
                $equipamentos .= 'Código: '.$equipamento->equipamento->codigo;
            
        }   

        //dd($equipamento_reservas);
        //dd($reservas);
        

        
        //Recuperando data e hora final da reserva e convertendo o formato
        $data_final = date('d/m/Y',strtotime($reservas->data_final));
        $hora_final = date('H:i',strtotime($reservas->data_final));
        $data_inicio_editar = $reservas->data_inicial;
        $data_fim_editar = $reservas->data_final;
        //recuperando hora inicial da reserva
        $hora_inicial = date('H:i',strtotime($reservas->data_inicial));
        //dd($equipamento_reservas);
        
        //preenchendo os botões
        foreach($equipamento_reservas as $equipamento){
            //dd($ambiente);
            if($reservas->status == 'Reservado'){
                //dados do botão visualizar
                $dadosVisualizar = 'data-id="'.$reservas->id.
                '" data-observacao="'.$reservas->observacao.
                '" data-telefone="'.$reservas->usuario->telefone.
                '" data-responsavel="'.$reservas->usuario->name.
                '" data-feedback="'.$reservas->feedback.
                '" data-equipamentos="'.$equipamentos.'"';
            }    
            //dados para botão editar
            $dados_editar = 'data-id="'.$reservas->id.
            '" data-solicitante="'.$reservas->solicitante.
            '" data-responsavel="'.$reservas->usuario->name.
            '" data-telefone="'.$reservas->telefone.
            '" data-ambiente="'.$ambiente->fk_ambiente.
            '" data-local="'.$ambiente->ambiente->fk_local.
            '" data-data_hora_inicio="'.$data_inicio_editar.
            '" data-data_hora_termino="'.$data_fim_editar.
            '" data-ambiente_padrao="manter"
               data-ambiente_novo="novo"';

            //Dados cancelar
            $dados_cancelar = 'data-id="'.$reservas->id.
            '" data-descricao="'.$ambiente->ambiente->descricao.'" ';
            //dados feedback
            $dados_feedback = 'data-id_feedback="'.$reservas->id.
            '" data-feedback="'.$reservas->feedback.'"';
        }
    
        //botões
        $btnVisualizar = '<a class="btn btn-sm btn-info btnVisualizar" '.$dadosVisualizar.' title="Visualizar" data-toggle="tooltip" ><i class="fa fa-eye"></i></a>';
        $btnEditar = '';
        $btnFeedback = '';
        $btnExcluir= '';
        $btnCancelar = '';

        //Condição para botão excluir e cancelar
        if($reservas->status == 'Reservado' || $reservas->status == 'Em uso')
            $btnCancelar = ' <a '.$dados_cancelar.' class="btn btn-sm btn-danger btnCancelar" title="Cancelar" data-toggle="tooltip"><i class="fa fa-times"></i></a>';    
        else if($reservas->fk_usuario == Auth::user()->id && $reservas->feedback != null)
            $btnExcluir = ' <a data-id="'.$reservas->id.'" class="btn btn-sm btn-danger btnExcluir" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';            

        //Botões para colaboradores (Administradores e funcionários)
        if(Auth::user()->hasRole('Administrador|Funcionário')){
            if($reservas->status == 'Reservado' || $reservas->status == 'Em uso')
                $btnEditar = ' <a  class="btn btn-sm btn-primary btnEditar"'.$dados_editar.' title="Editar" data-toggle="tooltip" ><i class="fa fa- fa-pencil-square-o"></i></a>';
            /*if($reservas->status == 'Em uso')
                $btnFinalizar = ' <a   class="btn btn-sm btn-success btnFinalizar" data-id="'. $reservas->id .'" title="Finalizar" data-toggle="tooltip" ><i class="glyphicon glyphicon-import"></i></a>';*/
        }
        //botão para feedback
        if($reservas->status == 'Finalizada' && $reservas->feedback == null && $reservas->fk_usuario == Auth::user()->id){
            $btnFeedback = ' <a  class="btn btn-sm btn-success btnFeedback" '.$dados_feedback.' title="Feedback" data-toggle="tooltip" ><i class="fa fa-thumbs-up"></i> </a>';
        }
        //retornando todos os botões 
        return $btnVisualizar .
         $btnEditar .
         $btnFeedback.
         $btnCancelar .
         $btnExcluir;

    }

    //listar pedidos para colaboradores e professores
    public function list(){
    
        //Capiturar Usuário Logado
        $usuario_logado = Auth::user();
        
        //Consulta para Colaboradores
        if($usuario_logado->hasRole('Administrador|Funcionário')){
            $reservas = Reservas::where('status','Reservado')
            ->get();
            //dd($reservas);
        }else{//Consulta para professores
            $reservas = Reservas::where('fk_usuario',$usuario_logado->id)
            ->where('status', '!=', 'Inativo')
            ->get();
        }
        //dados de ambiente
           
        return Datatables::of($reservas)
        ->editColumn('acao', function($reservas){
            return $this->setDataButtons($reservas);
        })
        ->editColumn('solicitante', function($reservas){
             $equipamento_reserva = EquipamentoReservas::where('fk_reserva',$reservas->id)
            ->where('status','!=','Inativo')
            ->first();
            return $equipamento_reserva->solicitante;
        })
        ->editColumn('data', function($reservas){
            return date('d/m/Y',strtotime($reservas->data_inicial));
        })
        ->editColumn('hora_inicial', function($reservas){
            return date('H:i',strtotime($reservas->data_inicial));
        })
        ->editColumn('hora_final', function($reservas){
            return date('H:i',strtotime($reservas->data_final));
        })
        ->editColumn('telefone', function($reservas){
            $equipamento_reserva = EquipamentoReservas::where('fk_reserva',$reservas->id)
            ->where('status','!=','Inativo')
            ->first();
            return $equipamento_reserva->telefone;
        })
        ->editColumn('status', function($reservas){
            $status = $reservas->status;
                if($status == 'Reservado')
                    return "<span class='label label-warning' style='font-size:14px'>Reservado</span>";
                if($status == 'Retirado')
                     return "<span class='label label-primary' style='font-size:14px'>Em uso</span>";
                if($status == 'Cancelado')
                    return "<span class='label label-danger' style='font-size:14px'>Cancelada</span>";  
                if($status == 'Expirado')
                    return "<span class='label label-danger' style='font-size:14px'>Expirado</span>";
                else
                    return "<span class='label label-success' style='font-size:14px'>Finalizada</span>"; 
        })
        ->escapeColumns([0])
        ->make(true);

    }

    //lista de atendidos para colaboradores
    public function atendidos(){

        //Capiturar Usuário Logado
        $usuario_logado = Auth::user();

        $reservas = Reservas::where('status','Retirado')
        ->orwhereRaw('status = \'Expirado\' and data_final + interval \'2 minute\' > now()')
        ->orwhereRaw('status = \'Cancelado\' and data_final + interval \'2 minute\' > now()')
        ->orwhereRaw('status = \'Finalizada\' and data_hora_entrega + interval \'2 minute\' > now()')
        ->orwhereRaw('status != \'Inativo\' and status != \'Reservado\' and fk_usuario = ?',[$usuario_logado->id])
        ->get();
        return Datatables::of($reservas)
        ->editColumn('acao', function($reservas){
            return $this->setDataButtons($reservas);
        })
        ->editColumn('solicitante', function($reservas){
             $equipamento_reserva = EquipamentoReservas::where('fk_reserva',$reservas->id)
            ->where('status','!=','Inativo')
            ->first();
            return $equipamento_reserva->solicitante;
        })
        ->editColumn('data', function($reservas){
            return date('d/m/Y',strtotime($reservas->data_inicial));
        })
        ->editColumn('hora_inicial', function($reservas){
            return date('H:i',strtotime($reservas->data_inicial));
        })
        ->editColumn('hora_final', function($reservas){
            return date('H:i',strtotime($reservas->data_final));
        })
        ->editColumn('telefone', function($reservas){
            $equipamento_reserva = EquipamentoReservas::where('fk_reserva',$reservas->id)
            ->where('status','!=','Inativo')
            ->first();
            return $equipamento_reserva->telefone;
        })
        ->editColumn('status', function($reservas){
            return "<span class='label label-warning' style='font-size:14px'>Reservado</span>";
        })
        ->escapeColumns([0])
        ->make(true);
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

    //Retirar equipamento
    public function retirar(Request $request){

    }

    //Finalizar reserva
    public function finalizar(Request $request){

    }
    
}
