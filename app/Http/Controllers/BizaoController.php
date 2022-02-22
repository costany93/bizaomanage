<?php

namespace App\Http\Controllers;

use App\Donateur;
use App\Helpers\GetMyAccessCode;
use App\Helpers\MyPrivateToken;
use App\Http\Requests\Bizaorequest;
use App\Mail\PaymentSuccessMail;
use App\Notification;
use App\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BizaoController extends Controller
{
    //
    

    public function getApiUrl(Bizaorequest $request){
        $input = $request->all();

        $pays_id = $request->pays;
        $headers = MyPrivateToken::getMyPrivateToken();
        $order_id = 'Anas_'.time();
        $url = MyPrivateToken::getMyApiUrl();

        $data =MyPrivateToken::getMyData($request->montant, $order_id);
        
        $response = Http::withHeaders($headers)->post($url, $data);

        $input['reference_don'] = $order_id;
        $input['pays_id'] = $pays_id;

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

    public function checkAccess(Request $request){
        $validate = $request->validate([
            "code" => ['required']
        ]);

        $access = GetMyAccessCode::getMyAccessCode($request->code);

        if($access == true){
            $code = $request->code;
            $pays = Pays::pluck('name', 'id')->all();
            return view('homescreen', compact('pays','code'));
        }else{
            return redirect("donation");
        }
        
    }

    //Cette fonction me permet de mettre à jour les status des transactions et de renvoyer les nouvelles données au format json
    public function getDataFromDatabaseApi(Request $request){

        $transactions = DB::table('donateurs')->get();

        $headers = MyPrivateToken::getHeadersStatus();
        $url = MyPrivateToken::getStatusUrl();


        $access_validation = $request->header('access-validation');
        $access_code = $request->header('access-code');
        $access_name = $request->header('access-name');

        $my_access_code = MyPrivateToken::getAccessCode();
        $my_access_validation = MyPrivateToken::getAccessValidation();
        $my_access_name = MyPrivateToken::getAccessName();

        if($access_validation == $my_access_validation && $access_code == $my_access_code && $access_name == $my_access_name){
            
            foreach($transactions as $transaction){
            

            $response = Http::withHeaders($headers)->get($url.$transaction->reference_don);

            if($response->status() == 200){
                $update = DB::table('donateurs')
              ->where('id', $transaction->id)
              ->update(['status' => $response['status']]);
            }
        }
        $transactions_updates = DB::table('donateurs')->get();

        return response()->json($transactions_updates);

        }

        

        return response()->json("Cannot access");
    }

    //Nous retourne des informations des transactions sur une période données et en fonction du status des transactions
    public function getDataFromPeriodApi(Request $request){
        //Request access header my access header check
        $access_validation = $request->header('access-validation');
        $access_code = $request->header('access-code');
        $access_name = $request->header('access-name');

        //Get my access
        $my_access_code = MyPrivateToken::getAccessCode();
        $my_access_validation = MyPrivateToken::getAccessValidation();
        $my_access_name = MyPrivateToken::getAccessName();


        //make my access headers check 
        if($access_validation == $my_access_validation && $access_code == $my_access_code && $access_name == $my_access_name){

            //check my input required fields
            if($request->input('begin_date') && $request->input('endate') && $request->input('status')){


             
                $transactions = DB::table('donateurs')
                ->select()
                ->whereBetween('created_at', [$request->input('begin_date'), $request->input('endate')])
                ->where('status', '=', $request->input('status'))
                ->get();
    
    
                return response()->json($transactions);
            }else{
                return response()->json("Some field missed, check all required fields. Data not found");
            }

        }else{
            return response()->json('Access denied');
        }
        
    }






    public function PaymentSuccess($order_id){

       /* $donateur = Donateur::where('reference_don', $order_id)->get()->first();

        $pays = Pays::where('id', $donateur->pays_id)->get()->first();

        $pays_name = $pays->name;
        $details = [
            "nom" => $donateur->nom,
            "prenom" => $donateur->prenom,
            "title" => "Merci pour votre don fait à ANAS",
            "body" => "Nous vous remercions infiniment du don que vous venez de faire à l'Association Nationale des Albinos du Sénégal",
            "montant" => $donateur->montant,
            "pays" => $pays_name,
            "date" => $donateur->created_at
        ];

        Mail::to($donateur->email)->send(new PaymentSuccessMail($details));*/

        echo "mail envoyé";
    }

    public function getRecu($order_id){

        
        /*$pdf = PDF::loadView('pdf.recu');
        return $pdf->download('reçu'.time().".pdf");*/

        return view("pdf.recu");
    }

    /*public function postCountries(){
        $country_list = array(
            "Afghanistan",
            "Albania",
            "Algeria",
            "Andorra",
            "Angola",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegovina",
            "Botswana",
            "Brazil",
            "Brunei",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Colombi",
            "Comoros",
            "Congo (Brazzaville)",
            "Congo",
            "Costa Rica",
            "Cote d'Ivoire",
            "Croatia",
            "Cuba",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "East Timor (Timor Timur)",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Fiji",
            "Finland",
            "France",
            "Gabon",
            "Gambia, The",
            "Georgia",
            "Germany",
            "Ghana",
            "Greece",
            "Grenada",
            "Guatemala",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Honduras",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, North",
            "Korea, South",
            "Kuwait",
            "Kyrgyzstan",
            "Laos",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macedonia",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Mauritania",
            "Mauritius",
            "Mexico",
            "Micronesia",
            "Moldova",
            "Monaco",
            "Mongolia",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepal",
            "Netherlands",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Poland",
            "Portugal",
            "Qatar",
            "Romania",
            "Russia",
            "Rwanda",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Vincent",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Serbia and Montenegro",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "Spain",
            "Sri Lanka",
            "Sudan",
            "Suriname",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syria",
            "Taiwan",
            "Tajikistan",
            "Tanzania",
            "Thailand",
            "Togo",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Vatican City",
            "Venezuela",
            "Vietnam",
            "Yemen",
            "Zambia",
            "Zimbabwe"
        );

        for($i = 0; $i < count($country_list); $i++){
            echo $country_list[$i].'<br>';

            Pays::create(['name' => $country_list[$i]]);
        }
    }*/
}
