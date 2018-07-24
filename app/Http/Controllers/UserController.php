<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use DataTables;
use Hash;

class UserController extends Controller
{
    //
    
    public function index()
    {
        return view('usuario.index');
    }

    //Função para criar botões 
    private function setDataButtons(User $usuario){

         $dados = 'data-nome="'.$usuario->name.'" data-email="'.$usuario->email.'" data-telefone="'.$usuario->telefone.'" data-funcao="'.$usuario->funcao.'" data-rua="'.$usuario->rua.'" data-numero="'.$usuario->numero.'" data-cidade="'.$usuario->cidade .'" data-estado="'.$usuario->estado.'" data-status="'.$usuario->status.'"';

        $btnVisualizar = '<a class="btn btn-info btnVisualizar" '. $dados .' title="Visualizar" data-toggle="tooltip" ><i class="fa fa-eye"></i></a>';
        $btnEditar = ' <a  data-id="'.$usuario->id.'" class="btn btn-primary btnEditar" '. $dados .' title="Editar" data-toggle="tooltip" ><i class="fa fa- fa-pencil-square-o"></i></a> ';
        $btnExcluir = ' <a  data-id="'.$usuario->id.'" class="btn btn-danger btnExcluir" title="Excluir" data-toggle="tooltip" ><i class="fa fa-trash-o"></i> </a> ';
        
        //caso status do úsuario seja inativo
        if(!$usuario->status){
            $btnAtivar = '<a  data-id="'.$usuario->id.'" class="btn btn-warning btnAtivar" '. $dados .' title="Ativar Usúário" data-toggle="tooltip" ><i class="fa fa-user-plus"> </i></a>';
            return $btnVisualizar.$btnEditar.$btnExcluir.$btnAtivar;
        }else{
            return $btnVisualizar.$btnEditar.$btnExcluir;
        }
        
    }


    public function listar()
    {
        $usuario = User::all();
        
        return Datatables::of($usuario)
        ->editColumn('acao',function($usuario){
            return $this->setDataButtons($usuario);
        })
        ->editColumn('status',function($usuario){
            if($usuario->status)
                return "<span class='label label-success' style='font-size:14px'>Ativo</span>";
            else
                return "<span class='label label-default' style='font-size:14px'>Inativo</span>";
        })->escapeColumns([0])
        ->make(true);
    }

    //função para Cadastrar usuários
    public function store(Request $request){

         $rules = array(
            'nome' => 'required',
            'email' => 'required|email|unique:users,email',
            'senha' => 'required|min:8|same:confirmarsenha',
            'rua' => 'required',
            'telefone' => 'required',
            'funcao' => 'required',
            'numero' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
        );

        $attributeNames = array(
            'confirmarsenha' => 'confirmar senha',
            'funcao' => 'função',
        );

        $messages = array(
            'same' => 'Essas senhas não coincidem.'
        );

        $validator = Validator::make(Input::all(), $rules, $messages);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            //recuperando dados do formulário e salvando no banco
            $usuario = new User();
            $usuario->name = $request->nome;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->senha);
            $usuario->funcao = $request->funcao;
            $usuario->telefone = $request->telefone;
            $usuario->rua = $request->rua;
            $usuario->numero = $request->numero;
            $usuario->cidade = $request->cidade;
            $usuario->estado = $request->estado;
            $usuario->status = true;

            $usuario->save();

            $usuario->setAttribute('buttons', $this->setDataButtons($usuario));

            return response()->json($usuario);
        }
    }

    //Função para atualizar dados do Usuário
    public function update(Request $request){
        $usuario = User::find($request->id);

        
    }


}
