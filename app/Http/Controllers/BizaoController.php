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
            $response = Http::withHeaders($headers)->post('https://api.bizao.com/debitCard/v1', [
                'order_id' => $order_id,
                'reference' => 'Anas',
                'amount' => $request->montant,
                'currency' => 'XOF',
                'return_url' => 'https://anasngo.org/',
                'state' => 'anasngo'
            ]);

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
