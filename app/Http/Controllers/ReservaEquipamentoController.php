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
use Hash;
use App\{
    Reservas,
    Ambiente,
    Locais
};

class ReservaEquipamentoController extends Controller
{
    
    public function index()
    {
        return view('reservas.equipamento.index');
    }

  
    public function store(Request $request)
    {
        //
    }

  
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
