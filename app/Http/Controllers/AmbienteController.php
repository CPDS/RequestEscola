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


class AmbienteController extends Controller
{
	// 
	
	public function index(){
        return view('ambiente.index');
    }
    
    private function setDataButtons(Ambiente $ambiente){
    	
    	$dados = 'data-fk_local="'.$ambiente->fk_local.'" data-tipo="'.$ambiente->tipo.'" data-descricao="'.$ambiente->descricao.'" data-numero_ambiente="'.$ambiente->numero_ambiente.'"data-status="'.$status.'"'; 
    
    	$btnVisualizar = '<a class="btn btn-info btnVisualizar"  title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';

        $btnEditar = ' <a data-id=" " class="btn btn-primary btnEditar"  title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';

        $btnExcluir = ' <a data-id=" " class="btn btn-danger btnExcluir" title="Desativar" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';

        return $btnVisualizar.$btnEditar.$btnExcluir;
    }

    public function listar(){
        $ambiente = Ambiente::all();
        
        return Datatables::of($ambiente)
        ->editColumn('acao',function($ambiente){
            return $this->setDataButtons($ambiente);
        })
        ->editColumn('tipo', function($ambiente){
            return $ambiente->tipo;
        })
        ->editColumn('descricao', function($ambiente){
            return $ambiente->descricao;
        })
        ->editColumn('numero_ambiente', function($ambiente){
            return $ambiente->numero_ambiente;
        })
        ->editColumn('status', function($ambiente){
            if($ambiente->status)
                return " <span class='label label-success' style='font-size:14px'>Ativo</span>";
            else
                return " <span class='label label-default' style='font-size:14px'>Inativo</span>";
        })
        ->escapeColumns([0])
        ->make(true);
    }
}