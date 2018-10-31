<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use Response;


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
        
        //Verificando se o usuário esta ativo
        if($usuario->status)
            return view('dashboards.administrador');
        else{
            echo "<script>alert('Usuário $usuario->name desabilitado! Favor entrar em contato com o Administrador do sistema!');</script>";
            Auth::logout();
            return view('vendor.adminlte.auth.login');

        }
    }
}
