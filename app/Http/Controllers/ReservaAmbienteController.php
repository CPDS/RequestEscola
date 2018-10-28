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
    AmbienteReserva
};

class ReservaAmbienteController extends Controller
{
  

    function __construct(){
        
        //Reservas aguardando retirada
        $reservas = Reservas::with('ambienteReserva')
        ->where('data_inicial','<',DB::raw('now()'))
        ->where('data_final','>',DB::raw('now()'))
        ->where('status','Reservado')
        ->select('id')
        ->get();
        
        //Reservas Em uso
        $reservas_em_uso = Reservas::with('ambienteReserva')
        ->where('data_final','<',DB::raw('now()'))
        ->where('status','Em uso')
        ->select('id')
        ->get();
        
        //reservas finalizadas
        $finalizados = Reservas::with('ambienteReserva')
        ->whereRaw('data_final + interval \'2 minute\' < now()')
        ->where('status','Finalizada')
        ->select('id')
        ->get();

        //Atualizando a reserva para em uso
        if($reservas!= null){
            foreach($reservas as $reserva){
                Reservas::where('id',$reserva->id)->update([
                    'status' => 'Em uso'
                ]);
            }
        }

        //Atualizando reserva para finalizada
        if($reservas_em_uso != null){
            foreach($reservas_em_uso as $reserva){
                Reservas::where('id',$reserva->id)->update([
                    'status' => 'Finalizada'
                    ]);
            }
        }

        if($finalizados != null){
            foreach($finalizados as $reserva){
                AmbienteReserva::where('fk_reserva',$reserva->id)
                ->update(['status' => false]);
            }
        }

    }
  

    public function index()
    {
        $ambientes = Ambiente::where('status','Ativo')->get();
        //dd($ambientes);
        return view('reservas.ambiente.index', compact('ambientes'));
    }

    private function reservados(){

    }

    //Turno
    private function turno(Reservas $reservas){

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
            return 'Manhã';
        if($hora_inicial >= $tarde_inicio && $hora_final <= $tarde_final)
            return 'Tarde';
        if($hora_inicial >= $noite_inicio && $hora_final <= $noite_final)
            return 'Noite';
        if($hora_inicial >= $manha_inicio && $hora_final <= $tarde_final)
            return 'Manhã e Tarde';
        if($hora_inicial >= $tarde_inicio && $hora_final <= $noite_final)
            return 'Tarde e Noite';
        else
            return 'Manhã, Tarde e Noite';
    }
    //Botões
    private function setDataButtons(Reservas $reservas){
        
        //recuperando ambientes reservados
        $ambientes = AmbienteReserva::where('tipo',true)
        ->where('status','!=',false)
        ->orwhere('fk_reserva',$reservas->id)
        ->get();
        //dd($ambientes);
        
        //Recuperando data e hora final da reserva e convertendo o formato
        $data_final = date('d/m/Y',strtotime($reservas->data_final));
        $hora_final = date('H:i',strtotime($reservas->data_final));
       
        //recuperando hora inicial da reserva
        $hora_inicial = date('H:i',strtotime($reservas->data_inicial));
        //dd($ambientes);

        //preenchendo os botões
        foreach($ambientes as $ambiente){
            
            //dados do botão visualizar
            $dadosVisualizar = 'data-id="'.$reservas->id.
            '" data-local="'.$ambiente->ambiente->local->nome.
            '" data-numero="'.$ambiente->ambiente->numero_ambiente.
            '" data-hora_incio="'.$hora_inicial.
            '" data-data_final="'.$data_final.
            '" data-hora_final="'.$hora_final.
            '" data-observacao="'.$reservas->observacao.
            '" data-telefone="'.$reservas->usuario->telefone.
            '" data-responsavel="'.$reservas->usuario->name.
            '" data-ambiente="'.$ambiente->ambiente->tipo->nome.
            '" data-feedback="'.$reservas->feedback.'"';
            
            //dados para botão editar
            $dados_editar = 'data-id="'.$reservas->id.
            '" data-solicitante="'.$ambiente->solicitante.
            '" data-responsavel="'.$reservas->usuario->name.
            '" data-telefone="'.$ambiente->telefone.
            '" data-ambiente="'.$ambiente->fk_ambiente.'"';

            //Dados cancelar
            $dados_cancelar = 'data-id="'.$reservas->id.
            '" data-descricao="'.$ambiente->ambiente->descricao.'" ';
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
        else if($reservas->fk_usuario == Auth::user()->id)
            $btnExcluir = ' <a data-id="'.$reservas->id.'" class="btn btn-sm btn-danger btnExcluir" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';            

        //Botões para colaboradores (Administradores e funcionários)
        if(Auth::user()->hasRole('Administrador|Funcionário')){
            if($reservas->status == 'Reservado' || $reservas->status == 'Em uso')
                $btnEditar = ' <a  class="btn btn-sm btn-primary btnEditar"'.$dados_editar.' title="Editar" data-toggle="tooltip" ><i class="fa fa- fa-pencil-square-o"></i></a>';
            /*if($reservas->status == 'Em uso')
                $btnFinalizar = ' <a   class="btn btn-sm btn-success btnFinalizar" data-id="'. $reservas->id .'" title="Finalizar" data-toggle="tooltip" ><i class="glyphicon glyphicon-import"></i></a>';*/
        }
        //botão para feedback
        if($reservas->status == 'Finalizada' && $reservas->feedback == null){
            $btnFeedback = ' <a  data-id="'.$reservas->id.'" class="btn btn-sm btn-success btnFeedback" title="Feedback" data-toggle="tooltip" ><i class="fa fa-thumbs-up"></i> </a>';
        }
        //retornando todos os botões 
        return $btnVisualizar .
         $btnEditar .
         $btnFeedback.
         $btnCancelar .
         $btnExcluir;

    }
    //Criar Reserva
    public function store(Request $request)
    {
        $rules = array(
            'hora_inicial' => 'required',
            'hora_final' => 'required',
            'data_inicial' => 'required',
            'data_final' => 'required',
            'solicitante' => 'required',
            'responsavel' => 'required',
            'telefone' => 'required',
            'ambiente' => 'required',
        );

        $attributeNames = array(
            'hora_inicial' => 'Horário Inicial',
            'hora_final' => 'Horário Final',
            'data_inicial' => 'Data Inicial',
            'data_final' => 'Data Final',
            'solicitante' => 'Solicitante',
            'responsavel' => 'Responsável',
            'telefone' => 'Telefone',
            'ambiente' => 'Ambiente',
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails())
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        else{
            //data e hora de  retirada
            $data_retirada = $request->data_inicial.' '.$request->hora_inicial.':00';
            //Data de reserva convertida
            $data_retirada_str = date('Y-m-d H:i:s',strtotime($data_retirada));
            //Data e hora de  Entrega
            $data_entrega = $request->data_final.' '.$request->hora_final.':00';
            //Data da entrega convertida
            $data_entrega_str = date('Y-m-d H:i:s',strtotime($data_retirada));
            //data atual mais 1 semana
            $atual_mais_7 = date('Y-m-d H:i:s',strtotime('+ 1 week'));
            //data atual
            $atual = date('Y-m-d H:i:s',strtotime('now'));
            
            //tratamentos de tempo
            if($data_retirada_str > $atual_mais_7)
                return Response::json(array('errors' => ['A data do agendamento não deve ter antecedência superior a 7 dias']));
            if($data_retirada_str < $atual)
                return Response::json(array('errors' => ['A data do agendamento deve superior a data atual']));
            if($data_entrega_str < $data_retirada_str)
                return Response::json(array('errors' => ['A data do agendamento deve superior a data de retirada do ambiente']));
            
            //tratamentos de solicitante
            if($request->ch_usuario_logado){
                $solicitante = Auth::user()->name;
                $telefone = Auth::user()->telefone;
            }
            else{
                $solicitante = $request->solicitante;
                $telefone = $request->telefone;
            }

            //persistendo no banco

            $reserva = new Reservas();
            $ambiente_reserva = new AmbienteReserva();
            
            $reserva->fk_usuario = Auth::user()->id;
            $reserva->data_inicial = $data_retirada;
            $reserva->data_final = $data_entrega;
            $reserva->observacao = $request->observacao;
            $reserva->status = 'Reservado';
            $reserva->save();

            $ambiente_reserva->fk_reserva = $reserva->id;
            $ambiente_reserva->fk_ambiente = $request->ambiente;
            $ambiente_reserva->tipo = true; //Garantindo que é uma reserva do tipo "reserva de ambiente"
            $ambiente_reserva->solicitante = $solicitante;
            $ambiente_reserva->telefone = $telefone;
            $ambiente_reserva->status = true;
            $ambiente_reserva->save();
            
            $reserva->setAttribute('buttons', $this->setDataButtons($reserva)); 
            return response()->json($reserva);
        }
    }

    //Atualizar pedido
    public function update(Request $request)
    {

    }
    /*  listar ambientes reservados e atendidos
        para colaboradores e professores
    */
    public function list(){
        //Capiturar Usuário Logado
        $usuario_logado = Auth::user();
        
        //Consulta para Colaboradores
        if($usuario_logado->hasRole('Administrador|Funcionário')){
        
            $reservas = Reservas::whereRaw('status = \'Finalizada\' and data_final + interval \'2 minute\' > now()')
            ->orwhere('status','Em uso')
            ->orwhere('status','Reservado')
            ->orwhere('status','Cancelada')
            ->orwhere('fk_usuario',$usuario_logado->id)
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
        ->editColumn('turno', function($reservas){
            return $this->turno($reservas);
        })
        ->editColumn('ambiente', function($reservas){
             $ambientes = AmbienteReserva::with('ambiente')
            ->where('fk_reserva',$reservas->id)
            ->first();  
            return $ambientes->ambiente->tipo->nome;
        })
        ->editColumn('solicitante', function($reservas){
             $ambientes = AmbienteReserva::with('ambiente')
            ->where('fk_reserva',$reservas->id)
            ->first();
            return $ambientes->solicitante;
        })
        ->editColumn('data', function($reservas){
            return date('d/m/Y',strtotime($reservas->data_inicial));
        })
        ->editColumn('status', function($reservas){
            $status = $reservas->status;
                if($status == 'Reservado')
                    return "<span class='label label-warning' style='font-size:14px'>Reservado</span>";
                if($status == 'Em uso')
                     return "<span class='label label-primary' style='font-size:14px'>Em uso</span>";
                if($status == 'Cancelada')
                    return "<span class='label label-danger' style='font-size:14px'>Cancelada</span>";  
                //reserva já finalizada
                if($reservas->feedback == null)
                    return "<span class='label label-danger' style='font-size:14px'>Finalizada</span>";
                else
                    return "<span class='label label-success' style='font-size:14px'>Finalizada</span>"; 
        })
        ->escapeColumns([0])
        ->make(true);
    }

       
    //Cancelar Reserva 
    public function cancelar(Request $request)
    {
        
        AmbienteReserva::where('fk_reserva',$request->id)
        ->update([
            'status' => false
        ]);
        $reserva = Reservas::find($request->id);
        $reserva->status = 'Cancelada';
        if($reserva->fk_usuario == Auth::user()->id)
            $reserva->feedback = 'Cancelada pelo próprio usuário';
        else
            $reserva->feedback = 'Cancelada por '.Auth::user()->name;
        
        $reserva->save();

        $reserva->setAttribute('buttons', $this->setDataButtons($reserva)); 
        return response()->json($reserva);

    }

    //excluir reserva
    public function destroy(Request $request){

    }
}
