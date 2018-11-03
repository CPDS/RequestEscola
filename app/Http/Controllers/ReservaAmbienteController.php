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
    AmbienteReserva,
    TipoAmbiente
};

class ReservaAmbienteController extends Controller
{
  

    function __construct(){
        
        //Reservas aguardando retirada
        Reservas::with('ambienteReserva')
        ->where('data_inicial','<',DB::raw('now()'))
        ->where('data_final','>',DB::raw('now()'))
        ->orwhere('data_final','<',DB::raw('now()'))
        ->where('status','Reservado')
        ->update([
            'status' => 'Em uso'
        ]);
        
        //Reservas Em uso 
        Reservas::with('ambienteReserva')
        ->where('data_final','<',DB::raw('now()'))
        ->where('status','Em uso')
        ->update([
            'status' => 'Finalizada'
            ]);
        
        //reservas finalizadas
        $finalizados = Reservas::with('ambienteReserva')
        ->whereRaw('data_final + interval \'2 minute\' < now()')
        ->where('status','Finalizada')
        ->select('id')
        ->get();
        //dd($finalizados);
        if($finalizados != null){
            foreach($finalizados as $reserva){
                AmbienteReserva::where('fk_reserva',$reserva->id)
                ->update(['status' => false]);
            }
        }

    }
  
    

    public function index()
    {
        $locais = Locais::where('status',true)->get();
        return view('reservas.ambiente.index', compact('locais'));
    }

    //selecionar ambientes reservados
    private function Ambientes_reservados($data_inicio, $data_final){
        //convertendo para formato americano
        $data_inicio = date('Y-m-d H:i:s',strtotime($data_inicio));
        $data_final = date('Y-m-d H:i:s',strtotime($data_final));
         
        //Todos os ambientes ocupados no dia escolhido + hora inicial + hora final das reservas
        $consulta = 'select ambiente_reservas.fk_ambiente,
        reservas.data_inicial,reservas.data_final,
        ambiente_reservas.status from ambientes join ambiente_reservas
        on ambiente_reservas.fk_ambiente = ambientes.id
        join reservas on ambiente_reservas.fk_reserva = reservas.id
        where ? between data_inicial and data_final
        or ? between data_inicial and data_final
        and ambiente_reservas.tipo = ? and ambiente_reservas.status = ?
        and reservas.status = ? or reservas.status = ?';
        
        //Associando atributos e executando a consulta sql  
        $Reservados = DB::select($consulta,[
            $data_inicio,
            $data_final,
            true,
            true,
            'Reservado',
            'Em uso'
        ]);

        return $Reservados;
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

    public function reservados(Request $request){
        //recuperando dados e querbando string
        $dados = explode(',',$request->dados);
        $local = $dados[0];
        $data_inicio = $dados[1];
        $data_final = $dados[2];

        /*Ambientes reservados
        $ambientes = Reservas::with('ambienteReserva')
        ->where('status','!=','Inativo')
        ->orwhere('status','!=','Finalizado')
        ->get();*/
        //Tipos de ambientes
        $tipos = TipoAmbiente::where('status',true)->get();
        $ambientes_reservados='';
        $paraReservar = array();
        $tipoAmbiente = array();
        

        //pecorrendo por cada tipo de ambiente
        foreach($tipos as $tipo){
            //array de ambientes reservados
            $naoPodeUsar = array();

            //armazenando os tipos de equipamentos
            array_push($tipoAmbiente,[
                'id' => $tipo->id,
                'nome' => $tipo->nome
            ]);
            //recuperando os ambientes reservados
            $ambientes_reservados = $this->Ambientes_reservados($data_inicio, $data_final);
            //adicionando ambientes reservados no array 
            if($ambientes_reservados != null){
                foreach($ambientes_reservados as $ambiente_reservado){
                    array_push($naoPodeUsar,$ambiente_reservado->fk_ambiente);
                }
            }

            //condições para selecionar ambientes a serem reservados
            if($ambientes_reservados == null){
                $ambiente_que_sera_reservado = Ambiente::where('status','Ativo')
                ->where('fk_local',$local)
                ->get();
            }else{
                $ambiente_que_sera_reservado = Ambiente::where('status','Ativo')
                ->where('fk_local',$local)
                ->whereNotIn('id',$naoPodeUsar)
                ->get();
            }

            
        }
        //populando array de ambientes disponíveis
        foreach ($ambiente_que_sera_reservado as $ambiente_que_sera_Reservado2) {
                        
            array_push($paraReservar,[
                'id' => $ambiente_que_sera_Reservado2->id,
                'fk_tipo' => $ambiente_que_sera_Reservado2->fk_tipo,
                'numero_ambiente' => $ambiente_que_sera_Reservado2->numero_ambiente
            ]);  
        }    
        //retornando arrays
        return response()->json(['ambientes'=> $paraReservar, 'tipoAmbiente' => $tipoAmbiente]);
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
        $data_inicio_editar = $reservas->data_inicial;
        $data_fim_editar = $reservas->data_final;
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
            '" data-ambiente="'.$ambiente->fk_ambiente.
            '" data-local="'.$ambiente->ambiente->fk_local.
            '" data-data_hora_inicio="'.$data_inicio_editar.
            '" data-data_hora_termino="'.$data_fim_editar.'"';

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
        $rules = array(
            'solicitante' => 'required',
            'telefone' => 'required',
            'observacao' => 'required',
            'id' => 'required',
        );

        $attributeNames = array(
            'solicitante' => 'Solicitante',
            'telefone' => 'Telefone',
            'observacao'=> 'Observação',
            'id'=> 'Identificação',
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails())
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        else{
            dd($request->all());
            $reserva_antiga = Reservas::where('id',$request->id)->first();

            $reserva = Reservas::find($request->id);
              
            $solicitante = $request->solicitante;
            $telefone = $request->telefone;
            
        }

    }
    /*  listar ambientes reservados e atendidos
        para colaboradores e professores
    */
    public function list(){
        //Capiturar Usuário Logado
        $usuario_logado = Auth::user();
        
        //Consulta para Colaboradores
        if($usuario_logado->hasRole('Administrador|Funcionário')){
        
            $reservas = Reservas::whereRaw('status = \'Finalizada\' or status = \'Cancelada\' and data_final + interval \'2 minute\' > now()')
            ->orwhere('status','Em uso')
            ->orwhere('status','Reservado')
            ->orwhereRaw('fk_usuario = ? and status != \'Inativo\'',[$usuario_logado->id])
            ->get();
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
        $atual = date('d/m/Y H:i:s',strtotime('now'));
        AmbienteReserva::where('fk_reserva',$request->id)
        ->update([
            'status' => false
        ]);
        $reserva = Reservas::find($request->id);
        $reserva->status = 'Cancelada';
        if($reserva->fk_usuario == Auth::user()->id)
            $reserva->feedback = "Cancelada pelo próprio usuário em $atual";
        else
            $reserva->feedback = "Cancelada por ".Auth::user()->name." em $atual";
        
        $reserva->save();

        $reserva->setAttribute('buttons', $this->setDataButtons($reserva)); 
        return response()->json($reserva);

    }

    //excluir reserva
    public function destroy(Request $request){
        $reserva = Reservas::find($request->id);
        $reserva->status = 'Inativo';
        $reserva->save();
        $reserva->setAttribute('buttons', $this->setDataButtons($reserva)); 
        return response()->json($reserva);

    }

    //feedback
    public function feedback(Request $request){
        $reserva = Reservas::find($request->id_feedback);
        if(!$request->feedback)
            $reserva->feedback = 'Nada a declarar';
        else
            $reserva->feedback = $request->feedback;
        $reserva->save();
        $reserva->setAttribute('buttons', $this->setDataButtons($reserva)); 
        return response()->json($reserva);
    }

}
