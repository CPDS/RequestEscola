<?php  

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Response;
use Datatables;
use DB;
use Hash;
use Auth;
use Validator;
use App\Ambiente;


class AmbienteController extends Controller
{
	public function index()
    {
        return view('ambiente.index');
    }

    public function setDataButtons(Ambiente $ambiente){
    	
    }
}

