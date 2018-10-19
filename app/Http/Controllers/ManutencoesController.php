<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Manutencoes;
use App\User;
use App\Reservas;
use App\Equipamentos;
use App\TipoEquipamentos;
use App\Pavilhao;
use Carbon\Carbon;
use Mail;
use Response;
use DataTables;
use DB;
use Hash;
use Auth;
use Validator;

class ManutencoesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$equipamentos = Equipamentos::where('status','Ativo')->get();
    	$usuario = User::where('status',true)->get();

        return view('manutencao.funcionarios.index', compact('equipamentos','usuario'));
    }

    private function setDataButtons(Manutencoes $manutencao){

        //Pegar papel logado
        $usuarioLogado = Auth::user();
        
        $dados = 'data-tombo="'.$manutencao->equipamento->num_tombo.
        '" data-tipo_equipamento="'.$manutencao->equipamento->id_tipo_equipamento.
        '" data-data="'.date('d/m/Y',strtotime($manutencao->data)).
        '" data-descricao="'.$manutencao->descricao.
        '" data-destino="'.$manutencao->destino.
        '" data-usuario="'.$manutencao->usuario->nome.
        '" data-status="'.$manutencao->status.'"';

        $dados_visualizar = 'data-tombo="'.$manutencao->equipamento->num_tombo.
        '" data-tipo_equipamento="'.$manutencao->equipamento->id_tipo_equipamento.
        '" data-data="'.date('d/m/Y',strtotime($manutencao->data)).
        '" data-descricao="'.$manutencao->descricao.
        '" data-destino="'.$manutencao->destino.
        '" data-usuario="'.$manutencao->usuario->nome.
        '" data-status="'.$manutencao->status.'"';
        
        $btnVisualizar = '<a class="btn btn-info btnVisualizar" '.$dados_visualizar.' title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';
        
        
        //Exibir botões para usuários administradores
        if($usuarioLogado->hasRole('Administrador')){
            $btnEditar = ' <a data-id="'.$manutencao->id.'" class="btn btn-primary btnEditar" '.$dados.' title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';
            $btnConserto = ' <a  data-id="'.$manutencao->id.'" class="btn btn-success btnConserto" title="Conserto" data-toggle="tooltip" ><i class="fa fa-cog"></i> </a>';
            /*$btnExcluir = ' <a data-id="'.$manutencao->id.'" class="btn btn-danger btnExcluir" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';*/

            if($manutencao->status == 'Ativo')
                return $btnVisualizar.$btnEditar.$btnConserto;
            else
                $btnConserto = '';
        }
        else{
            $btnEditar = '';
            $btnExcluir = '';
        } 
    }

    public function list()
    {
        $manutencao = Manutencoes::with('usuario')
        ->with('equipamento')
        //->where('id_usuario', Auth::user()->id)
        ->where('status', 'Ativo')
        ->get();

        return Datatables::of($manutencao)
        ->editColumn('acao', function ($manutencao) {
            return $this->setDataButtons($manutencao);
        })
        ->editColumn('tombo', function ($manutencao) {
            return $manutencao->equipamento->num_tombo;
        })
        ->editColumn('status', function($manutencao){
            $status = $manutencao->status;
            return "<span class='label label-success' style='font-size:14px'>Ativo</span>";
        })
        ->editColumn('id_equipamento', function ($manutencao) {
            return $manutencao->id_equipamento;
        })
        ->editColumn('data', function ($manutencao) {
            return date('d/m/Y', strtotime($manutencao->data));
        })
        ->make(true);
    }

    public function store(Request $request)
    {
        $rules = array(
           'id_equipamento' => 'required',
           'descricao' => 'required',
       );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        else{ 

            $dataAtual = Carbon::now(); //pega a hora atual do PC
            
            $manutencao = new Manutencao();
            $manutencao->id_equipamento = $request->id_equipamento;
            $manutencao->descricao = $request->descricao;
            $manutencao->id_usuario = Auth::user()->id;
            $manutencao->data = $dataAtual->toDateTimeString();
            $manutencao->destino = $request->destino;
            $manutencao->status = "Ativo";

            $manutencao->save();
            //$equipamento->save();
            $manutencao->setAttribute('buttons', $this->setDataButtons($manutencao));

            return response()->json();

        }
    }
    
}