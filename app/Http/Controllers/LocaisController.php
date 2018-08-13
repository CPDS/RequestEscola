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
use App\Locais;
use Hash;

class LocaisController extends Controller
{
    
    //Método principal
    public function index(){
        return view('local.index');
    }

    //Função para criar botões 
    private function setDataButtons(User $local){
        //Variável de status
        if($local->status)
            $status = 'Ativo';
        else
            $status = 'Inativo';
        //Pegar o usuário logado
        $roleUsuarioLogado = Auth::user()->id;
        
        $dados = 'data-nome="'.$local->nome.'" data-observacao="'.$local->observacao.'" data-status="'.$status.'"';

        $btnVisualizar = '<a class="btn btn-info btnVisualizar" '. $dados .' title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';

        $btnEditar = ' <a data-id="'.$local->id.'" class="btn btn-primary btnEditar" '. $dados .' title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';

        $btnExcluir = ' <a data-id="'.$local->id.'" class="btn btn-danger btnExcluir" title="Desativar" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';
            
        //caso sseja usuário adm
        if($roleUsuarioLogado == 1){
            return $btnVisualizar.$btnEditar.$btnExcluir;
        }else{
            return $btnVisualizar;
        }
    }


    //Adicionando Local
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

        $validator = Validator::make(Input::all(), $rules, $messages);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            $local = new Locais();
            $local->nome = $request->nome;
            $local->descricao = $request->descricao;
            $local->status = true;
            $local->save();
            
            $local->setAttribute('buttons', $this->setDataButtons($local));
            return response()->json($local);

        }

    }
    //listando os locais
    public function list(){
        $local = Locais::where('status', true)->get();

        return Datatables::of($local)
        ->editColumn('acao',function($local){
            return $this->setDataButtons($local);
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
            $local = Locais::find($request->id);
            $local->nome = $request->nome;
            $local->observacao = $request->observacao;
            $local->status = true;
            $local->save();

        }
    }

    //Desativar Local
    public function destroy(Request $request){
        $local = Locais::find($request->id);
        $local->status = false;      
        $local->save();
        return response()->json($local);
    }

}
