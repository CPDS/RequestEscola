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
    
    public function index(){
        return view('local.index');
    }

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
            $local->status = 'Ativo';
            $local->save();
        }

    }

    public function list(){

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
            
        }


        
    }
   
    public function update(Request $request){
        
    }

    public function destroy(Request $request){
        
    }

    public function ativar(Request $request){

    }
}
