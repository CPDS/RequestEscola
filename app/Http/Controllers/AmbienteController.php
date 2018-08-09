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
    /*
    private function setDataButtons(Ambiente $ambiente){
    	/*
    		$dados = 'data-nome="'.$usuario->name.'" data-email="'.$usuario->email.'" data-telefone="'.$usuario->telefone.'" data-funcao="'.$usuario->funcao.'"
          	data-rua="'.$usuario->rua.'" data-numero="'.$usuario->numero.'" data-cidade="'.$usuario->cidade .'" data-estado="'.$usuario->estado.'"
           data-status="'.$status.'"'; 
        */
/*
    	$btnVisualizar = '<a class="btn btn-info btnVisualizar"  title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';

        $btnEditar = ' <a data-id=" " class="btn btn-primary btnEditar"  title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';

        $btnExcluir = ' <a data-id=" " class="btn btn-danger btnExcluir" title="Desativar" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';

        return $btnVisualizar.$btnEditar.$btnExcluir;
    }

    public function listar(){
        //$ambiente = Ambiente::all();
        
        return Datatables::of($ambiente)
        ->editColumn('acao',function($ambiente){
            return $this->setDataButtons($ambiente);
        })
        ->make(true);
    }*/
}