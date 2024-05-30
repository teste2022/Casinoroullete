<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class AdminController extends Controller
{
    public function profile($userid)
    {
        if (Auth::check()){
            if(Auth::user()->banned) {
                return view('banned');
            }

            // Remova a dependência de steamid e use o id do usuário
            DB::table('users')->where('id', Auth::user()->id)->update(['logged_in' => 0]);
            
            // Obtenha o usuário pelo id padrão do Laravel
            $user = DB::table('users')->where('id', $userid)->first();

            return view('admin/profile', ['game' => 'other', 'mode' => 'profile', 'user' => $user]);
        } else {
            return redirect('login');
        }
    }
}

