<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user();
        $permissoes = $usuario->getPermissionsViaRoles();
        //dd($permissoes);
        //Verificando se o usuário esta ativo
        if($usuario->status)
            return view('home',compact('usuario','permissoes'));
        else{
            Auth::logout();
            return view('vendor.adminlte.auth.login');
        }
    }
}
