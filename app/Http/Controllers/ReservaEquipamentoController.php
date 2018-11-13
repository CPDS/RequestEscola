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
    AmbienteReserva,
    TipoEquipamentos
};

class ReservaEquipamentoController extends Controller
{

    function __construct(){
        $reserva = Reservas::whereRaw('status = \'Reservado\' and data_final < now()')
        ->get();
        
        Reservas::whereRaw('status = \'Reservado\' and data_final < now()')
        ->update([
            'status' => 'Expirado',
            'feedback' => 'Reserva Expirada'
        ]);
        
        foreach($reserva as $reservas){
            EquipamentoReservas::where('fk_reserva',$reservas->id)
            ->update([
                'status' => 'Inativo'
            ]);
            AmbienteReserva::where('fk_reserva',$reservas->id)
            ->update([
                'status' => 'Inativo'
            ]);
        }

    }
    
    public function index()
    {   
        $locais = Locais::where('status',true)->get();
        $ambientes = Ambiente::where('status','Ativo')->get();
        $tipoAmbientes = TipoAmbiente::where('status',true)->get();
        return view('reservas.equipamento.index',compact('locais','ambientes','tipoAmbientes'));
    }

    //selecionar equipamentos reservados
    public static function Equipamentos_reservados($data_inicio, $data_final){
        //convertendo para formato americano
        $data_inicio = date('Y-m-d H:i:s',strtotime($data_inicio));
        $data_final = date('Y-m-d H:i:s',strtotime($data_final));
         
        //Todos os ambientes ocupados no dia escolhido + hora inicial + hora final das reservas
        $consulta = 'select equipamentos.id,
        reservas.data_inicial,reservas.data_final,
        equipamento_reservas.status from equipamentos join equipamento_reservas
        on equipamentos.id = equipamento_reservas.fk_equipamento
        join reservas on equipamento_reservas.fk_reserva = reservas.id
        where ? between data_inicial and data_final
        or ? between data_inicial and data_final
        and equipamento_reservas.status = ?
        and reservas.status = ? or reservas.status = ?';
        
        //Associando atributos e executando a consulta sql  
        $Reservados = DB::select($consulta,[
            $data_inicio,
            $data_final,
            'Ativo',
            'Reservado',
            'Retirado'
        ]);

        return $Reservados;
    }

    //Retorna equipamentos reservados para javascript
    public function reservados(Request $request){
        $dados = explode(',',$request->dados);
        $local = $dados[0];
        $data_inicio = $dados[1];
        $data_final = $dados[2];

       //tipos de Equipamento
       $tipos = TipoEquipamentos::where('status','Ativo')->get();
        
       $paraReservar = array();
       $tipoEquipamento = array();
       //pecorrendo por cada tipo de Equipamento
       foreach($tipos as $tipo){
        
        //armazenando os tipos de equipamentos
        array_push($tipoEquipamento,[
            'id' => $tipo->id,
            'nome' => $tipo->nome
        ]);
        $naoPodeUsar = array();
        //recuperando os equipamentos reservados
        $equipamentos_reservados = ReservaEquipamentoController::Equipamentos_reservados($data_inicio, $data_final);
        
        if($equipamentos_reservados != null){
                foreach($equipamentos_reservados as $equipamento_reservado){
                    if($equipamento_reservado->status)
                        array_push($naoPodeUsar,$equipamento_reservado->fk_ambiente);
                }
            }

            //condições para selecionar os equipamentos a serem reservados
            if($equipamentos_reservados == null){
                $equipamento_que_sera_reservado = Equipamentos::where('status','Ativo')
                ->where('fk_local',$local)
                ->get();
            }else{
                $equipamento_que_sera_reservado = Equipamentos::where('status','Ativo')
                ->where('fk_local',$local)
                ->whereNotIn('id',$naoPodeUsar)
                ->get();
            }
        }
        //dd($equipamento_que_sera_reservado);
        //populando array de ambientes disponíveis
        foreach ($equipamento_que_sera_reservado as $equipamento_que_sera_Reservado2) {
                        
            array_push($paraReservar,[
                'id' => $equipamento_que_sera_Reservado2->id,
                'codigo' => $equipamento_que_sera_Reservado2->codigo,
                'fk_tipo' => $equipamento_que_sera_Reservado2->fk_tipo_equipamento
            ]);  
        }

        //retornando arrays
        return response()->json(['equipamentos'=> $paraReservar, 'tipoEquipamento' => $tipoEquipamento]);
        
    }


    //Botões
    private function setDataButtons($reservas){
        
        //recuperando dados de ambiente
        $ambientes = AmbienteReserva::where('fk_reserva',$reservas->id)
        ->where('status','Ativo')->first();
        //dd($ambientes);
        $equipamento_reservas = EquipamentoReservas::where('status','!=','Inativo')
        ->where('fk_reserva',$reservas->id)
        ->get();
        

        $equipamentos = '';
        //equipamentos
        foreach($equipamento_reservas as $equipamento){
            $equipamentos .= ' Tipo: '.$equipamento->equipamento->tipoEquipamento->nome;
            if(!$equipamento->equipamento->codigo)
                $equipamentos .= ' Tombo: '.$equipamento->equipamento->num_tombo;
            else
                $equipamentos .= ' Código: '.$equipamento->equipamento->codigo;
                
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
        
        //Dados
        $dadosVisualizar = '';
        $dadosEditar = '';
        $dadosCancelar = '';
        $dadoFeedback = '';
        $dadosRetirar = '';

        $usuarioRetirada = '';
        $usuarioEntrega = '';

        //preenchendo os botões
        foreach($equipamento_reservas as $equipamento){
            
            //Caso tenha retirado o equipamento
            if($reservas->data_hora_retirada)
                $usuarioRetirada = $ambientes->reserva->usuarioRetirada->name;
            //caso tenha entrege os equipamentos
            if($reservas->data_hora_entrega)
                $usuarioEntrega = $ambientes->reserva->usuarioEntrega->name;
            
             //dados do botão visualizar
             $dadosVisualizar = 'data-id="'.$reservas->id.
             '" data-observacao="'.$reservas->observacao.
             '" data-telefone="'.$ambientes->reserva->usuario->telefone.
             '" data-responsavel="'.$reservas->name.
             '" data-feedback="'.$reservas->feedback.
             '" data-equipamentos="'.$equipamentos.
             '" data-hora_retirada="'.$reservas->data_hora_retirada.
             '" data-hora_entrega="'.$reservas->data_hora_entrega.
             '" data-usuario_retirada="'.$usuarioRetirada.
             '" data-usuario_entrega="'.$usuarioEntrega.
             '" data-ambiente="'.$ambientes->ambiente->tipo->nome.' Nº: '.$ambientes->ambiente->numero_ambiente.
             '" data-local="'.$equipamento->equipamento->local->nome.
             '"';
            
            //dados para botão editar
            $dadosEditar = 'data-id="'.$reservas->id.
            '" data-solicitante="'.$ambientes->reserva->usuario->telefone.
            '" data-responsavel="'.$reservas->name.
            '" data-telefone="'.$reservas->solicitante_telefone.
            '" data-ambiente="'.$ambientes->fk_ambiente.
            '" data-local="'.$ambientes->ambiente->fk_local.
            '" data-data_hora_inicio="'.$data_inicio_editar.
            '" data-data_hora_termino="'.$data_fim_editar.
            '" data-ambiente_padrao="manter"
               data-ambiente_novo="novo"';

            //Dados cancelar
            $dadosCancelar = 'data-id="'.$reservas->id.
            '" data-descricao="'.$ambientes->ambiente->descricao.'" ';
            //dados feedback
            $dadoFeedback = 'data-id_feedback="'.$reservas->id.
            '" data-feedback="'.$reservas->feedback.'"';
            //dados retirar
            $dadosRetirar = ' data-id="'.$reservas->id.
            '"data-equipamentos="'.$equipamentos.'"';
        }
    
        //botões
        $btnVisualizar = '<a class="btn btn-sm btn-info btnVisualizar" '.$dadosVisualizar.' title="Visualizar" data-toggle="tooltip" ><i class="fa fa-eye"></i></a>';
        $btnEditar = '';
        $btnFeedback = '';
        $btnExcluir= '';
        $btnCancelar = '';
        $btnFinalizar = '';
        $btnRetirar = '';
        //Condição para botão excluir e cancelar
        if($reservas->status == 'Reservado' || $reservas->status == 'Retirado')
            $btnCancelar = ' <a '.$dadosCancelar.' class="btn btn-sm btn-danger btnCancelar" title="Cancelar" data-toggle="tooltip"><i class="fa fa-times"></i></a>';    
        else if($reservas->fk_usuario == Auth::user()->id && $reservas->feedback != null)
            $btnExcluir = ' <a data-id="'.$reservas->id.'" class="btn btn-sm btn-danger btnExcluir" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';            

        //Botões para colaboradores (Administradores e funcionários)
        if(Auth::user()->hasRole('Administrador|Funcionário')){
            if($reservas->status == 'Reservado' || $reservas->status == 'Retirado')
                $btnEditar = ' <a  class="btn btn-sm btn-primary btnEditar"'.$dadosEditar.' title="Editar" data-toggle="tooltip" ><i class="fa fa- fa-pencil-square-o"></i></a>';
            if($reservas->status == 'Retirado')
                $btnFinalizar = ' <a   class="btn btn-sm btn-success btnFinalizar" data-id="'. $reservas->id .'" title="Finalizar" data-toggle="tooltip" ><i class="glyphicon glyphicon-import"></i></a>';
            if($reservas->status == 'Reservado')
                $btnRetirar = ' <a  class="btn btn-sm btn-success btnRetirar" '. $dadosRetirar.' title="Retirar" data-toggle="tooltip" ><i class="glyphicon glyphicon-export"></i></a>';
        }
        //botão para feedback
        if($reservas->status == 'Finalizada' && $reservas->feedback == null && $reservas->fk_usuario == Auth::user()->id){
            $btnFeedback = ' <a  class="btn btn-sm btn-success btnFeedback" '.$dadoFeedback.' title="Feedback" data-toggle="tooltip" ><i class="fa fa-thumbs-up"></i> </a>';
        }
        //retornando todos os botões 
        return $btnVisualizar.
         $btnEditar.
         $btnRetirar.
         $btnFeedback.
         $btnCancelar.
         $btnFinalizar.
         $btnExcluir;

    }


    //listar pedidos para colaboradores (reservados) e professores (todos)
    public function list(){
    
        //Capiturar Usuário Logado
        $usuario_logado = Auth::user();
        
        //Consulta para Colaboradores
        if($usuario_logado->hasRole('Administrador|Funcionário')){
            $reservas = DB::table('reservas')
            ->join('equipamento_reservas','reservas.id','=','equipamento_reservas.fk_reserva')
            ->join('users','reservas.fk_usuario','=','users.id')
            ->where('reservas.status','Reservado')
            ->groupBy('reservas.id','users.id')
            ->select('reservas.fk_usuario','data_inicial','data_final','data_hora_retirada'
            ,'data_hora_entrega','fk_reserva_externa','fk_usuario_retirada','fk_usuario_entrega','reservas.solicitante'
            ,'reservas.solicitante_telefone','parecer','reservas.observacao','feedback','reservas.status','reservas.id'
            ,'users.name')
            ->get();
            //dd($reservas);
        }else{//Consulta para professores
            $reservas = DB::table('reservas')
            ->join('equipamento_reservas','reservas.id','=','equipamento_reservas.fk_reserva')
            ->join('users','reservas.fk_usuario','=','users.id')
            ->where('reservas.fk_usuario',$usuario_logado->id)
            ->where('reservas.status', '!=', 'Inativo')
            ->groupBy('reservas.id','users.id')
            ->select('reservas.fk_usuario','data_inicial','data_final','data_hora_retirada'
            ,'data_hora_entrega','fk_reserva_externa','fk_usuario_retirada','fk_usuario_entrega','solicitante'
            ,'solicitante_telefone','parecer','reservas.observacao','feedback','reservas.status','reservas.id'
            ,'users.name')
            ->get();
        }
        //dados de ambiente
           
        return Datatables::of($reservas)
        ->editColumn('acao', function($reservas){
            return $this->setDataButtons($reservas);
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
        ->editColumn('telefone',function($reservas){
            return $reservas->solicitante_telefone;
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

    //lista de atendidos para colaboradores. Para professores exibe por um  tempo
    public function atendidos(){

        //Capiturar Usuário Logado
        $usuario_logado = Auth::user();

        $reservas = DB::table('reservas')
        ->join('equipamento_reservas','reservas.id','=','fk_reserva')
        ->join('users','reservas.fk_usuario','=','users.id')
        ->where('reservas.status','Retirado')
        ->orwhereRaw('reservas.status = \'Expirado\' and reservas.data_final + interval \'2 minute\' > now()')
        ->orwhereRaw('reservas.status = \'Cancelado\' and reservas.data_final + interval \'2 minute\' > now()')
        ->orwhereRaw('reservas.status = \'Finalizada\' and reservas.data_hora_entrega + interval \'2 minute\' > now()')
        ->orwhereRaw('reservas.status != \'Inativo\' and reservas.status != \'Reservado\' and reservas.fk_usuario = ?',[$usuario_logado->id])
        ->groupBy('reservas.id','users.id')
        ->select('reservas.fk_usuario','data_inicial','data_final','data_hora_retirada'
        ,'data_hora_entrega','fk_reserva_externa','fk_usuario_retirada','fk_usuario_entrega','solicitante'
        ,'solicitante_telefone','parecer','reservas.observacao','feedback','reservas.status','reservas.id'
        ,'users.name')
        ->get();
        
        return Datatables::of($reservas)
        ->editColumn('acao', function($reservas){
            return $this->setDataButtons($reservas);
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
        ->editColumn('telefone',function($reservas){
            return $reservas->solicitante_telefone;
        })
        ->editColumn('status', function($reservas){
            $status = $reservas->status;
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
  
    //Criando reserva
    public function store(Request $request)
    {
        
        $rules = array(
            'hora_inicial' => 'required',
            'hora_final' => 'required',
            'data' => 'required',
            'solicitante' => 'required',
            'responsavel' => 'required',
            'telefone' => 'required',
            'ambiente' => 'required',
            'local' => 'required',
            'equipamentos' => 'required'
        );

        $attributeNames = array(
            'hora_inicial' => 'Horário Inicial',
            'hora_final' => 'Horário Final',
            'data' => 'Data',
            'solicitante' => 'Solicitante',
            'responsavel' => 'Responsável',
            'telefone' => 'Telefone',
            'ambiente' => 'Ambiente',
            'local' => 'Local',
            'equipamento' => 'Equipamentos'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);

        
        if ($validator->fails())
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    
        else{
            //dd($request->all());
            $data_retirada = $request->data.' '.$request->hora_inicial;
            $data_entrega = $request->data.' '.$request->hora_final;

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
            $reserva->solicitante = $solicitante;
            $reserva->solicitante_telefone = $telefone;
            $reserva->status = 'Reservado';
            $reserva->save();

            //Salvando na tabela intermediária (equipamento_reservas)
            $reserva->equipamento()->attach($request->equipamentos);
            //Salvando na tabela intermediária (ambiente_reservas)
            $reserva->ambiente()->attach([$request->ambiente],
                ['tipo' => false,
                'status' => 'Ativo']
            );
            /*foreach($request->equipamentos as $equipamento){
                $equipamento_reserva = new EquipamentoReservas();
                $equipamento_reserva->fk_reserva = $reserva->id;
                $equipamento_reserva->fk_equipamento = $equipamento;

                $equipamento_reserva->save();
            }

            $ambiente = new AmbienteReseva();
            $ambiente->fk_reserva = $reserva->id;
            $ambiente->fk_ambiente = $request->ambiente;
            $ambiente->tipo = false;
            $ambiete->status = 'Ativo';
            $ambiente->save();*/


            $reserva->setAttribute('buttons', $this->setDataButtons($reserva)); 
            return response()->json($reserva);
            
        }
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
