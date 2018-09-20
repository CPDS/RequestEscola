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
use App\Ambiente;
use App\Locais;
use Hash;


class AmbienteController extends Controller
{
	// 
	public function index(){
        $locais = Locais::where('status',true)->get();

        return view('ambiente.index',compact('locais'));
    }
    
    private function setDataButtons(Ambiente $ambiente){

        //Pegar papel logado
        $usuarioLogado = Auth::user();        

    	$dados = 'data-local="'.$ambiente->local->nome.
        '" data-tipo="'.$ambiente->tipo.
        '" data-descricao="'.$ambiente->descricao.
        '" data-numero_ambiente="'.$ambiente->numero_ambiente.
        '" data-status="'.$ambiente->status.'"'; 
    
    	$btnVisualizar = '<a class="btn btn-info btnVisualizar" '. $dados .' title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';

       //Exibir botões para usuários administradores
        if($usuarioLogado->hasRole('Administrador'))
        {
            $btnEditar = ' <a data-id="'.$ambiente->id.'" class="btn btn-primary btnEditar" '. $dados .' title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';
            $btnExcluir = ' <a data-id="'.$ambiente->id.'" class="btn btn-danger btnExcluir" title="Desativar" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';
             if($ambiente->status == 'Inativo')
             {
                $btnAtivar = ' <a data-id="'.$ambiente->id.'" class="btn btn-warning btnAtivar" '. $dados .' title="Ativar Ambiente" data-toggle="tooltip" ><i class="fa fa-plus"> </i></a>';
                return $btnVisualizar.$btnEditar.$btnAtivar;
            }
            else
            {
                return $btnVisualizar.$btnEditar.$btnExcluir;
            }
        }
        else{
            $btnEditar = '';
            $btnExcluir = '';
            $btnAtivar = '';
        }    
    }

    public function store(Request $request)
    {
        $rules = array(
            'tipo' => 'required',
            'descricao' => 'required',
            'id_local' => 'required',
            'numero_ambiente' => 'required',
        );

        $attributeNames = array(
            'descricao' => 'descrição',
            'id_local' => 'local',
            'numero_ambiente' => 'número do ambiente',
        );

        $messages = array(
            'same' => 'Campo Obrigatório'
        );

        $validator = Validator::make(Input::all(), $rules, $messages);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            $ambiente = new Ambiente();
            $ambiente->tipo = $request->tipo;
            $ambiente->descricao = $request->descricao;
            $ambiente->fk_local = $request->id_local;
            $ambiente->numero_ambiente = $request->numero_ambiente;
            $ambiente->status = 'Ativo';
            $ambiente->save();

            $ambiente->setAttribute('buttons', $this->setDataButtons($ambiente));
            return response()->json($ambiente);
        }
    }

    public function list(){
        
        $ambiente = Ambiente::all();
        //$ambiente = Ambiente::where('status','Ativo')->get();
        
        return Datatables::of($ambiente)
        ->editColumn('acao',function($ambiente){
            return $this->setDataButtons($ambiente);
        })
        ->editColumn('status', function($ambiente){
            
            if($ambiente->status == 'Ativo')
                return " <span class='label label-success' style='font-size:14px'>Ativo</span>";
            else
                return " <span class='label label-default' style='font-size:14px'>Inativo</span>";
        })
        ->editColumn('fk_local', function($ambiente){
            return $ambiente->local->nome;
        })
        ->escapeColumns([0])
        ->make(true);
    }

    public function update(Request $request)
    {
        $rules = array(
            'tipo' => 'required',
            'descricao' => 'required',
            'id_local' => 'required',
            'numero_ambiente' => 'required',
        );

        $attributeNames = array(
            'descricao' => 'descrição',
            'id_local' => 'local',
            'numero_ambiente' => 'número do ambiente',
        );

        $messages = array(
            'same' => 'Campo Obrigatório'
        );

        $validator = Validator::make(Input::all(), $rules, $messages);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            $ambiente = Ambiente::find($request->id);
            $ambiente->tipo = $request->tipo;
            $ambiente->descricao = $request->descricao;
            $ambiente->fk_local = $request->id_local;
            $ambiente->numero_ambiente = $request->numero_ambiente;
         // $ambiente->status = 'Ativo';
            $ambiente->save();

            $ambiente->setAttribute('buttons',$this->setDataButtons($ambiente));
            return response()->json($ambiente);
        }
    }

    public function destroy(Request $request)
    {
        $ambiente = Ambiente::find($request->id);
        $ambiente->status = 'Inativo';
        $ambiente->save();
        return response()->json($ambiente);
    }

    public function ativar(Request $request)
    {
        //
        $ambiente = Ambiente::find($request->id);
        $ambiente->status = 'Ativo';
        $ambiente->save();
        return response()->json($ambiente);
    }
}