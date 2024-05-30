<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ErrorController extends Controller
{
    public function error404($view)
	{
		if (Auth::check()){
			if(Auth::user()->banned) return view('banned');
		}
		$view->with(['game' => 'other', 'mode' => 'error404']);
	}
}
/*
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class ErrorController extends Controller
{

	public function error404($view)
	{
		$token = '';
		$time = time()-34;
		if (Auth::check()){
			if(Auth::user()->banned) return view('banned');
		}
		$view->with(['token' => $token, 'time' => $time, 'game' => 'other', 'mode' => 'error404']);
	}

}
*/