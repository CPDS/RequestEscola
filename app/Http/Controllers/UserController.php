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
use App\User;
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
        //Variável de status
        if($usuario->status)
            $status = 'Ativo';
        else
            $status = 'Inativo';
        
        //Variável de Função
        if($usuario->funcao == 1)
            $tipoFuncao = 'Administrador';
        else if($usuario->funcao == 2)
            $tipoFuncao = 'Funcionário';
        else
            $tipoFuncao = 'Professor';

        $dados = 'data-nome="'.$usuario->name.'" data-email="'.$usuario->email.'" data-telefone="'.$usuario->telefone.'" data-funcao="'.$usuario->funcao.'"
            data-endereco="'.$usuario->endereco.'" data-cidade="'.$usuario->cidade .'" data-estado="'.$usuario->estado.'"
            data-status="'.$status.'" data-tipoFuncao="'.$tipoFuncao.'"';

            $btnVisualizar = '<a class="btn btn-info btnVisualizar" '. $dados .' title="Visualizar" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';

            $btnEditar = ' <a data-id="'.$usuario->id.'" class="btn btn-primary btnEditar" '. $dados .' title="Editar" data-toggle="tooltip"><i class="fa fa- fa-pencil-square-o"></i></a>';

            $btnExcluir = ' <a data-id="'.$usuario->id.'" class="btn btn-danger btnExcluir" title="Desativar" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';
            
            //caso status do úsuario seja inativo
            if(!$usuario->status){
                $btnAtivar = ' <a data-id="'.$usuario->id.'" class="btn btn-warning btnAtivar" '. $dados .' title="Ativar Usúário" data-toggle="tooltip" ><i class="fa fa-user-plus"> </i></a>';
                return $btnVisualizar.$btnEditar.$btnAtivar;
            }else{
                return $btnVisualizar.$btnEditar.$btnExcluir;
            }
        }

        //Função listar
        public function listar(){
            $usuario = User::all();
            
            return Datatables::of($usuario)
            ->editColumn('acao',function($usuario){
                return $this->setDataButtons($usuario);
            })
            ->editColumn('status',function($usuario){
                if($usuario->status)
                    return " <span class='label label-success' style='font-size:14px'>Ativo</span>";
                else
                    return " <span class='label label-default' style='font-size:14px'>Inativo</span>";
            })
            ->editColumn('funcao', function($usuario){
                if($usuario->funcao == 1)
                    return "Administrador";
                else if($usuario->funcao == 2)
                    return "Funcionário";
                else
                    return "Professor";
            })
            ->escapeColumns([0])
            ->make(true);
        }

    //função para Cadastrar usuários
    public function store(Request $request){
        //dd($request->all());
        $rules = array(
            'nome' => 'required',
            'email' => 'required|email|unique:users,email',
            'senha' => 'required|min:8|same:confirmarsenha',
            'endereco' => 'required',
            'telefone' => 'required',
            'funcao' => 'required',
            'numero' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'funcao' => 'required',
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
            $usuario->endereco = $request->endereco;
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
        $rules = array(
            'nome' => 'required',
            'funcao' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'cidade' => 'required',
            'estado' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        
        if($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            $usuario = User::find($request->id);
            $usuario->name = $request->nome;
            $usuario->email = $request->email;
            $usuario->funcao = $request->funcao;
            $usuario->telefone = $request->telefone;
            $usuario->endereco = $request->endereco;
            $usuario->numero = $request->numero;
            $usuario->cidade = $request->cidade;
            $usuario->estado = $request->estado;
            $usuario->save();

            $usuario->setAttribute('buttons',$this->setDataButtons($usuario));
            return response()->json($usuario);
        }
    }

    //desativar Funcionário
    public function destroy(Request $request){
        $usuario = User::find($request->id);
        $usuario->status = false;      
        $usuario->save();
        return response()->json($usuario);
    }
    //Ativar Usuário
    public function ativar(Request $request){
        $usuario = User::find($request->id);
        $usuario->status = true;
        $usuario->save();
        return response()->json($usuario);
    }

}