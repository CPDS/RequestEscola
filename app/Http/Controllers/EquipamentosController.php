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
        //dd($tipoequipamentos->all());
        $locais = Locais::where('status',true)->get();
        
        return view('equipamento.index',compact('tipoequipamentos','locais'));
    }

    //Função para criar botões 
    private function setDataButtons(Equipamentos $equipamento){
       
        //Pegar papel logado
        $usuarioLogado = Auth::user();
        
        $dados = 'data-nome="'.$equipamento->nome.
        '" data-tipoEquipamento="'.$equipamento->fk_tipo_equipamento.
        '" data-status="'.$equipamento->status.
        '" data-local="'.$equipamento->fk_local.
        '" data-tombo="'.$equipamento->num_tombo.
        '" data-codigo="'.$equipamento->codigo.
        '" data-marca="'.$equipamento->marca.'"';

        $dados_visualizar = 'data-nome="'.$equipamento->nome.
        '" data-tipoEquipamento="'.$equipamento->tipoEquipamento->nome.
        '" data-status="'.$equipamento->status.
        '" data-local="'.$equipamento->local->nome.
        '" data-tombo="'.$equipamento->num_tombo.
        '" data-codigo="'.$equipamento->codigo.
        '" data-marca="'.$equipamento->marca.'"';
        
        $btnVisualizar = '<a class="btn btn-info btnVisualizar" '.$dados_visualizar.' title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';
        
        //Exibir botões para usuários administradores
        if($usuarioLogado->hasRole('Administrador')){
            $btnEditar = ' <a data-id="'.$equipamento->id.'" class="btn btn-primary btnEditar" '.$dados.' title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';
            $btnExcluir = ' <a data-id="'.$equipamento->id.'" class="btn btn-danger btnExcluir" title="Excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';
            
            if($equipamento->status != "Defeito")
                $btnDefeito = ' <a  data-id="'.$equipamento->id.'" class="btn btn-warning btnDefeito" title="Informar Defeito" data-toggle="tooltip" ><i class="fa fa-exclamation-triangle"></i> </a>';
        }else{
            $btnEditar = '';
            $btnExcluir = '';
            $btnDefeito = '';
        }
        //$btnDefeito = '';
        return $btnVisualizar.$btnEditar.$btnExcluir.$btnDefeito;
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $rules = array(
            'nome' => 'required',
            'id_tipo_equipamento' => 'required',
            'id_local' => 'required',
            'codigo' => 'required',
            'marca' => 'required',
        );

        $attributeNames = array(
            'nome' => 'nome',
            'id_tipo_equipamento' => 'Tipo de equipamento',
            'id_local' => 'local',
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
            $equipamento->fk_tipo_equipamento = $request->id_tipo_equipamento;
            $equipamento->fk_local = $request->id_local;
            $equipamento->num_tombo = $request->num_tombo;
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
        $equipamento = Equipamentos::where('status','!=','Inativo')->get();
        
        return Datatables::of($equipamento)
        ->editColumn('acao', function($equipamento){
            return $this->setDataButtons($equipamento);
        })
        ->editColumn('nome', function($equipamento){
            return $equipamento->nome;
        })
        ->editColumn('fk_tipo_equipamento', function($equipamento){
            return $equipamento->tipoEquipamento->nome;
        })
        ->editColumn('codigo', function($equipamento){
            return $equipamento->codigo;
        })
        ->editColumn('marca', function($equipamento){
            return $equipamento->marca;
        })
        ->editColumn('status', function($equipamento){
            if($equipamento->status == "Ativo")
                return "<span class='label label-success' style='font-size:14px'>Ativo</span>";
            if($equipamento->status == "Em Manutencao")
                return "<span class='label label-warning' style='font-size:14px'>Em Manutenção</span>";
            if($equipamento->status == "Defeito")
                return "<span class='label label-danger' style='font-size:14px'>Com defeito</span>";

        })
        ->escapeColumns([0])
        ->make(true);
    }

  
    public function update(Request $request)
    {
        $rules = array(
            'nome' => 'required',
            'id_tipo_equipamento' => 'required',
            'id_local' => 'required',
            'codigo' => 'required',
            'marca' => 'required',
        );

        $attributeNames = array(
            'nome' => 'nome',
            'id_tipo_equipamento' => 'Tipo de equipamento',
            'id_local' => 'local',
            'codigo' => 'codigo',
            'marca' => 'marca',
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else{

            $equipamento = Equipamentos::find($request->id);
            $equipamento->nome = $request->nome;
            $equipamento->fk_tipo_equipamento = $request->id_tipo_equipamento;
            $equipamento->fk_local = $request->id_local;
            $equipamento->num_tombo = $request->num_tombo;
            $equipamento->codigo = $request->codigo;
            $equipamento->marca = $request->marca;
        // $equipamento->status = 'Ativo';
            $equipamento->save();

            $equipamento->setAttribute('buttons', $this->setDataButtons($equipamento));
            return response()->json($equipamento);
        }
    }

    public function destroy(Request $request)
    {
        //
        $equipamento = Equipamentos::find($request->id);
        $equipamento->status = 'Inativo';
        $equipamento->save();
        return response()->json($equipamento);
    }
}
