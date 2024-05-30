<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class SiteController extends Controller
{
   /*
   public function terms()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->steamid.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
			if(strlen(Auth::user()->code) > 0) $rows = DB::table('users')->where(['inviter' => Auth::user()->steamid])->get()->count(); else $rows = 0;
            if($rows >= 1500){
                $fee = 10;
            } else if($rows > 250){
                $fee = 7;
            } else if($rows > 50){
                $fee = 6;
            } else {
                $fee = 5;
            }
            $profit = ($rows * $fee) - Auth::user()->collected;
        }
        return view('terms', ['game' => 'other', 'mode' => 'terms', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
    }
	*/
	public function giveaway()
    {
		$data["reffered"] = "";
		$data["profit"] = "";
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
			$data = $this->getRefferalData();
        }
        return view('giveaway', ['game' => 'other', 'mode' => 'giveaway', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
    }

    public function games()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
			Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
        }
        return view('games');
    }


    public function maintenance()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
        }
        return view('maintenance');
    }

    public function coinflip()
    {
		$data["reffered"] = "";
		$data["profit"] = "";
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->steamid.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
			$data = $this->getRefferalData();
        }
        return view('coinflip', ['game' => 'coinflip', 'mode' => 'coinflip', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
    }
/*
    public function faq()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->steamid.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
        }
        return view('faq', ['game' => 'other', 'mode' => 'faq']);
    }
*/
	public function roulette()
	{
		$data["reffered"] = "";
		$data["profit"] = "";
		$data["reffered"] = "";
		$data["profit"] = "";
		if (Auth::check()){
			if(Auth::user()->banned) return view('banned');
			Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
          // Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
			$data = $this->getRefferalData();
		}
		return view('roulette', ['game' => 'roulette', 'mode' => 'roulette', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
	}
/*
	public function pf()
	{
		if (Auth::check()){
			if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->steamid.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
		}
		return view('pf', ['game' => 'other', 'mode' => 'pf']);
	}

	public function support()
	{
		if (Auth::check()){
				if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
		}
		return view('support', ['game' => 'other', 'mode' => 'support']);
	}
*/
    public function jackpot()
    {
		$data["reffered"] = "";
		$data["profit"] = "";
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
			$data = $this->getRefferalData();
        }
        return view('jackpot', ['game' => 'jackpot', 'mode' => 'jackpot', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
    }

    public function crash()
    {
		$data["reffered"] = "";
		$data["profit"] = "";
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
			$data = $this->getRefferalData();
        }
        return view('crash', ['game' => 'crash', 'mode' => 'crash', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
    }


    public function dice()
    {
		$data["reffered"] = "";
		$data["profit"] = "";
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
			$data = $this->getRefferalData();
        }
        return view('dice', ['game' => 'dice', 'mode' => 'dice', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
    }

    public function withdraw()
    {
		$data["reffered"] = "";
		$data["profit"] = "";
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
			$data = $this->getRefferalData();
			return view('withdraw', ['game' => 'other', 'mode' => 'withdraw', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
		}
		else {
            return redirect('auth/login');
        }
    }

    public function deposit()
    {
		$data["reffered"] = "";
		$data["profit"] = "";
    	if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
			$data = $this->getRefferalData();
            return view('deposit', ['game' => 'other', 'mode' => 'deposit', 'reffered' => $data["reffered"], 'profit' => $data["profit"]]);
        }
        else {
            return redirect('auth/login');
        }
    }

   /* public function profile()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
            return view('profile', ['game' => 'other', 'mode' => 'profile']);
        }
        else {
            return redirect('auth/login');
        }
    }

    public function history()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
            return view('history');
        }
        else {
            return redirect('auth/login');
        }
    }

    public function referrals()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
           Auth::user()->token_time = time(); Auth::user()->token = hash('sha256', random_bytes(10) . Auth::user()->id.'-'.time()); Auth::user()->logged_in = 0; Auth::user()->save();
            if(strlen(Auth::user()->code) > 0) $rows = DB::table('users')->where(['inviter' => Auth::user()->id])->get()->count(); else $rows = 0;
            if($rows >= 1500){
                $fee = 10;
            } else if($rows > 250){
                $fee = 7;
            } else if($rows > 50){
                $fee = 6;
            } else {
                $fee = 5;
            }
            $profit = ($rows * $fee) - Auth::user()->collected;
            return view('referrals', ['reffered' => $rows, 'profit' => $profit, 'game' => 'other', 'mode' => 'referrals']);
        }
        else {
            return redirect('auth/login');
        }
    }*/
	
	public function getRefferalData(){
		if(strlen(Auth::user()->code) > 0) $rows = DB::table('users')->where(['inviter' => Auth::user()->id])->get()->count(); else $rows = 0;
		$rows -=  Auth::user()->collected;
		if($rows >= 1500){
			$fee = 10;
		} else if($rows > 250){
			$fee = 7;
		} else if($rows > 50){
			$fee = 6;
		} else {
			$fee = 5;
		}
		$profit = ($rows * $fee);
		$data["profit"] = $profit;
		$data["reffered"] = $rows + Auth::user()->collected;
		return $data;
	}
}
