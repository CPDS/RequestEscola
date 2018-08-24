<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Validator;
use Response;
use DataTables;
use DB;
use App\TipoEquipamentos;
use Auth;

class TipoEquipamentoController extends Controller
{
    //Método principal
    public function index(){
        return view('tipoEquipamento.index');
    }

    //Função para criar botões 
    private function setDataButtons(TipoEquipamentos $tipoEquipamento){
        //Variável de status
        if($tipoEquipamento->status)
            $status = 'Ativo';
        else
            $status = 'Inativo';

        //Pegar o Usuário logado
        $roleUsuarioLogado = Auth::user()->id;

        $dados = 'data-nome="'.$tipoEquipamento->nome.'" data-observacao="'.$tipoEquipamento->observacao.'" data-status="'.$status.'"';

        $btnVisualizar = '<a class="btn btn-info btnVisualizar" '. $dados .' title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';

        $btnEditar = ' <a data-id="'.$tipoEquipamento->id.'" class="btn btn-primary btnEditar" '. $dados .' title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';

        $btnExcluir = ' <a data-id="'.$tipoEquipamento->id.'" class="btn btn-danger btnExcluir" title="Desativar" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';
            
        //Caso o usuário seja o adm
        if($roleUsuarioLogado == 1){
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
            $tipoEquipamento = new TipoEquipamentos();
            $tipoEquipamento->nome = $request->nome;
            $tipoEquipamento->observacao = $request->observacao;
            $tipoEquipamento->status = 'Ativo';
            $tipoEquipamento->save();
            
            $tipoEquipamento->setAttribute('buttons', $this->setDataButtons($tipoEquipamento));
            return response()->json($tipoEquipamento);

        }
    }

    //Listar Tipo de Equipamento
    public function list(){
        $tipoEquipamento = tipoEquipamentos::where('status','Ativo')->get();
        
        return Datatables::of($tipoEquipamento)
        ->editColumn('acao',function($tipoEquipamento){
            return $this->setDataButtons($tipoEquipamento);
        })
        ->editColumn('nome', function($tipoEquipamento){
            return $tipoEquipamento->nome;
        })
        ->editColumn('observacao', function($tipoEquipamento){
            return $tipoEquipamento->observacao;
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
            $tipoEquipamento = tipoEquipamentos::find($request->id);
            $tipoEquipamento->nome = $request->nome;
            $tipoEquipamento->observacao = $request->observacao;
            $tipoEquipamento->status = true;
            $tipoEquipamento->save();

        }
    }
    //Desativando tipo de equipamento
    public function destroy(Request $request){
        $tipoEquipamento = tipoEquipamentos::find($request->id);
        $tipoEquipamento->status = false;      
        $tipoEquipamento->save();
        return response()->json($tipoEquipamento);
    }

}
