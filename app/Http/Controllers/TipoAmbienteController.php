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
use App\{
    TipoAmbiente
};
class TipoAmbienteController extends Controller
{
    //Método principal
    public function index(){
        return view('tipoAmbiente.index');
    }

    //Função para criar botões 
    private function setDataButtons(TipoAmbiente $tipoAmbiente){
    
        //Pegar o Usuário logado
        $roleUsuarioLogado = Auth::user();

        $dados = 'data-nome="'.$tipoAmbiente->nome.'" data-descricao="'.$tipoAmbiente->descricao.'"';

        $btnVisualizar = '<a class="btn btn-info btnVisualizar" '. $dados .' title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';

        $btnEditar = ' <a data-id="'.$tipoAmbiente->id.'" class="btn btn-primary btnEditar" '. $dados .' title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';

        $btnExcluir = ' <a data-id="'.$tipoAmbiente->id.'" class="btn btn-danger btnExcluir" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';
            
        //Caso o usuário seja o adm
        if($roleUsuarioLogado->hasRole('Administrador')){
            return $btnVisualizar.$btnEditar.$btnExcluir;
        }else{
            return $btnVisualizar;
        }
    }

    //Cadastrar Tipo de Equipamento
    public function store(Request $request){
        $rules = array(
            'nome' => 'required',
        );

        $attributeNames = array(
            'nome' => 'nome',
        );

        $messages = array(
            'same' => 'Campo nome obrigatório.'
        );
        //dd($request->all());
        $validator = Validator::make(Input::all(), $rules, $messages);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            $tipoAmbiente = new TipoAmbiente();
            $tipoAmbiente->nome = $request->nome;
            $tipoAmbiente->descricao = $request->descricao;
            $tipoAmbiente->status = true;
            $tipoAmbiente->save();
            
            $tipoAmbiente->setAttribute('buttons', $this->setDataButtons($tipoAmbiente));
            return response()->json($tipoAmbiente);

        }
    }

    //Listar Tipo de Equipamento
    public function list(){
        $tipoAmbiente = tipoAmbiente::where('status',true)
        ->get();
        
        return Datatables::of($tipoAmbiente)
        ->editColumn('acao',function($tipoAmbiente){
            return $this->setDataButtons($tipoAmbiente);
        })
        ->editColumn('nome', function($tipoAmbiente){
            return $tipoAmbiente->nome;
        })
        ->editColumn('descricao', function($tipoAmbiente){
            return $tipoAmbiente->descricao;
        })
        ->editColumn('status', function($tipoAmbiente){
            if($tipoAmbiente->status)
                return " <span class='label label-success' style='font-size:14px'>Ativo</span>";
            else
                return " <span class='label label-default' style='font-size:14px'>Inativo</span>";
        })
        ->escapeColumns([0])
        ->make(true);
    }

    //Atualizando dados
    public function update(Request $request){
        $rules = array(
            'nome' => 'required',
        );

        $attributeNames = array(
            'nome' => 'nome',
        );

        $messages = array(
            'same' => 'Campo nome obrigatório.'
        );

        $validator = Validator::make(Input::all(), $rules, $messages);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            $tipoAmbiente = tipoAmbiente::find($request->id);
            $tipoAmbiente->nome = $request->nome;
            $tipoAmbiente->descricao = $request->descricao;
            $tipoAmbiente->status = true;
            $tipoAmbiente->save();
        }
    }
    //Desativando tipo de equipamento
    public function destroy(Request $request){
        $tipoAmbiente = tipoAmbiente::find($request->id);
        $tipoAmbiente->status = false;      
        $tipoAmbiente->save();
        return response()->json($tipoAmbiente);
    }
}
