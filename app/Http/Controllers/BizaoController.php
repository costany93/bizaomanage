<?php

namespace App\Http\Controllers;

use App\Donateur;
use App\Helpers\MyPrivateToken;
use App\Http\Requests\Bizaorequest;
use App\Notification;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BizaoController extends Controller
{
    //

    public function getApiUrl(Bizaorequest $request){
        $input = $request->all();
        $headers = MyPrivateToken::getMyPrivateToken();
        $order_id = 'Anas_'.time();
        $url = MyPrivateToken::getMyApiUrl();

        $data =MyPrivateToken::getMyData($request->montant, $order_id);
        
        $response = Http::withHeaders($headers)->post($url, $data);

        $input['reference_don'] = $order_id;

        Donateur::create($input);

        $url_payment = $response['payment_url'];
        return redirect($url_payment);
    }

    public function bizaoNotification(Request $request){
        $input = $request->all();
        if($input == null){
            echo "en attente";
        }else{
            Notification::create($input);
        }
        
        return response()->json($request);
    }
}
