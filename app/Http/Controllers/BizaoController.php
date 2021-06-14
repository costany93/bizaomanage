<?php

namespace App\Http\Controllers;

use App\Donateur;
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


        $order_id = 'Anas_'.time();
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'country-code' => 'CI',
                'category' => 'BIZAO-RETAIL',
                'lang' => 'en',
        
                'Cookie' => 'SERVERID=s0; SERVERID=s1',
            ])->post('https://api.bizao.com/debitCard/v1', [
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
        Notification::create($input);
        return response()->json($request);
    }
}
