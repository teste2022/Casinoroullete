<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ApiController extends Controller
{
    public function transaction_history()
    {
        if (Auth::check()){
            $results = DB::table('wallet_change')->where('user_id', Auth::user()->id)->get();
            return $results;
        } else {
            return redirect('login');
        }
    }

    public function admin_transaction_history($userid)
    {
        if (Auth::check()){
            $results = DB::table('wallet_change')->where('user_id', $userid)->get();
            return $results;
        } else {
            return redirect('login');
        }
    }

    public function site_inventory()
    {
        $results = DB::table('inventory')->where('in_trade', '0')->get();
        $results = json_decode($results, true);
        $output_prices = [];
        foreach($results as $key => $value){
            $price = $value['price'];
            if((time() - strtotime($value['deposit_date'])) - 10800 > 605000) {
                array_push($output_prices, [
                    'classid' => $value['classid'],
                    'name' => $value['name'],
                    'price' => $price,
                    'img' => 'https://steamcommunity-a.akamaihd.net/economy/image/' . $value['img'] . '/300fx300f',
                    'color' => $value['color']
                ]);
            }
        }
        return ['inventory' => $output_prices, 'prices' => $output_prices];
    }

    public function free_coins()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return;
            if(strpos(Auth::user()->username, 'VGOPunk.com') !== false) {
                if(Auth::user()->csgo == 'true'){
                    if(Auth::user()->last_free_use + 86400 < time()){
                        DB::table('users')->where('id', Auth::user()->id)->update([
                            'wallet' => DB::raw('wallet + 30'),
                            'last_free_use' => time()
                        ]);
                        DB::table('wallet_change')->insert([
                            'user_id' => Auth::user()->id,
                            'change' => 30,
                            'reason' => 'Free coins '.date("Y-m-d H:i:s")
                        ]);
                        return ['success' => true, 'message' => 'freeSuccess', 'payload' => [30], 'value' => '30'];
                    } else {
                        $seconds = (Auth::user()->last_free_use + 86400) - time();
                        $days    = floor($seconds / 86400);
                        $hours   = floor(($seconds - ($days * 86400)) / 3600);
                        $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                        $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
                        return ['success' => false, 'message' => 'freeUsed', 'payload' => [$hours, $minutes, $seconds]];
                    }
                } else {
                    return ['success' => false, 'message' => 'freeNoCS'];
                }
            } else {
                return ['success' => false, 'message' => 'freeBadNickname', 'payload' => ['VGOPunk.com']];
            }
        } else {
            return redirect('login');
        }
    }

    public function group_join()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return;
            if(Auth::user()->csgo == 'true'){
                if(Auth::user()->group_used == 0){
                    if(Auth::user()->last_group_use + 150 < time()){
                        $clan = 0;
                        $in_group = 0;
                        $url = 'http://steamcommunity.com/profiles/'.Auth::user()->steamid.'/?xml=1';
                        $file = file_get_contents($url);
                        $xml = simplexml_load_string($file);
                        foreach($xml->groups->group as $key=>$val){    
                            if($val->groupID64 == 103582791463335180){
                                $in_group = 1;
                                break;
                            }
                        }

                        DB::table('users')->where('id', Auth::user()->id)->update(['last_group_use' => time()]);
                        if($in_group == 1){
                            DB::table('users')->where('id', Auth::user()->id)->update(['group_used' => '1']);
                            DB::table('users')->where('id', Auth::user()->id)->update(['wallet' => DB::raw('wallet + 30')]);
                            DB::table('wallet_change')->insert([
                                'user_id' => Auth::user()->id,
                                'change' => '30',
                                'reason' => 'Free coins - group'
                            ]);
                            return ['success' => true, 'message' => 'freeSuccess', 'payload' => [30], 'value' => '30'];
                        } else {
                            return ['success' => false, 'message' => 'freeNotInGroup'];
                        }
                    } else {
                        $seconds = (Auth::user()->last_group_use + 150) - time();
                        $m = date("i", $seconds);
                        $s = date("s", $seconds);
                        return ['success' => false, 'message' => 'freeCooldown', 'payload' => [$m, $s]];
                    }
                } else {
                    return ['success' => false, 'message' => 'freeAlreadyUsed'];
                }
            } else {
                return ['success' => false, 'message' => 'freeNoCS'];
            }
        } else {
            return redirect('login');
        }
    }

    public function affiliates_collect()
    {
        if(empty(Input::get('targetSID'))) return ['success' => false, 'reason' => 'affiliatesNoIDSupplied'];
        if(gettype(Input::get('targetSID')) !== 'string') return ['success' => false, 'reason' => 'affiliatesNoIDSupplied'];
        
        $targetSID = htmlentities(strip_tags(Input::get('targetSID')));
        $user = DB::table('users')->where('id', $targetSID)->first();
        
        if(!$user) return ['success' => false, 'reason' => 'affiliatesNoUserFound'];
        if(empty($user->code)) return ['success' => false, 'reason' => 'affiliatesNoReferral'];
        
        $rows = DB::table('users')->where(['inviter' => $user->id])->count();
        $rows -= $user->collected;

        $fee = 5; 
        if($rows >= 1500) {
            $fee = 10;
        } else if($rows > 250) {
            $fee = 7; 
        } else if($rows > 50) {
            $fee = 6;
        }
        
        $profit = ($rows * $fee);
        if($profit < 1) return ['success' => false, 'reason' => 'affiliatesNoCoinsToCollect'];
        
        DB::table('users')->where('id', $targetSID)->update([
            'collected' => DB::raw('collected + ' . $rows),
            'wallet' => DB::raw('wallet + ' . $profit)
        ]);

        DB::table('wallet_change')->insert([
            'user_id' => $targetSID,
            'change' => $profit,
            'reason' => 'Affiliates - ' . $targetSID
        ]);

        return [
            'success' => true,
            'reffered' => $rows + Auth::user()->collected,
            'profit' => $profit
        ];
    }
}

}