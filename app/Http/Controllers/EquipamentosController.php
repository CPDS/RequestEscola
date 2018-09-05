<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\TipoEquipamentos;
use App\Locais;
use Validator;
use Response;
use DataTables;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Equipamentos;


class EquipamentosController extends Controller
{
    
    public function index()
    {
        $tipoequipamentos = TipoEquipamentos::where('status','Ativo')->get();
        $locais = Locais::where('status',true)->get();
        
        return view('equipamento.index',compact('tipoequipamentos','locais'));
    }

    //Função para criar botões 
    private function setDataButtons(Equipamentos $equipamento){
       
    //Pegar papel logado
    $usuarioLogado = Auth::user();
    
    $dados = 'data-nome="'.$equipamento->nome.
    '" data-tipoEquipamento="'.$equipamento->tipoEquipamento->nome.
    '" data-status="'.$equipamento->status.
    '" data-local="'.$equipamento->local->nome.
    '" data-tombo="'.$equipamento->num_tombo.
    '" data-codigo="'.$equipamento->codigo.
    '" data-marca="'.$equipamento->marca;
    
    $btnVisualizar = '<a class="btn btn-info btnVisualizar" '. $dados .' title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';
    
    //Exibir botões para usuários administradores
    if($usuarioLogado->hasRole('Administrador')){
        $btnEditar = ' <a data-id="'.$equipamento->id.'" class="btn btn-primary btnEditar" '. $dados .' title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';
        $btnExcluir = ' <a data-id="'.$equipamento->id.'" class="btn btn-danger btnExcluir" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';
    }else{
        $btnEditar = '';
        $btnExcluir = '';
    }
    
    return $btnVisualizar.$btnEditar.$btnExcluir;
        
    }

    public function store(Request $request)
    {
        $rules = array(
            'nome' => 'required',
            'tipoEquipamento' => 'required',
            'locao' => 'required',
            'codigo' => 'required',
            'marca' => 'required',
        );

        $attributeNames = array(
            'nome' => 'nome',
            'tipoEquipamento' => 'tipoEquipamento',
            'locao' => 'locao',
            'codigo' => 'codigo',
            'marca' => 'marca',
        );

        $messages = array(
            'same' => 'Campo Obrigatório'
        );

        $validator = Validator::make(Input::all(), $rules, $messages);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            $equipamento = new Equipamentos();
            $equipamento->nome = $request->nome;
            $equipamento->fk_tipo_equipamento = $request->tipoEquipamento;
            $equipamento->fk_local = $request->local;
            $equipamento->num_tombo = $request->tombo;
            $equipamento->codigo = $request->codigo;
            $equipamento->marca = $request->marca;
            $equipamento->status = 'Ativo';
            $equipamento->save();

            $equipamento->setAttribute('buttons', $this->setDataButtons($equipamento));
            return response()->json($equipamento);
        }
        
    }

  
    public function list()
    {
        //
    }

  
    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
