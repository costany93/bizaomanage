<?php

use App\Pays;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    /*$order_id = 'Anas_'.time();
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'country-code' => 'CI',
        'category' => 'BIZAO-RETAIL',
        'lang' => 'en',
        'authorization' => 'Bearer c59e5f8c-b093-3aef-a158-223e845a6e8e',
        'Cookie' => 'SERVERID=s0; SERVERID=s1',
    ])->post('https://api.bizao.com/debitCard/v1', [
        'order_id' => $order_id,
        'reference' => 'Anas',
        'amount' => 500,
        'currency' => 'XOF',
        'return_url' => 'https://anasngo.org/',
        'state' => 'anasngo'
    ]);

    return $response['payment_url'];*/

    $pays = Pays::pluck('name', 'id')->all();
    return view('homescreen', compact('pays'));
});

route::match(['get', 'post'], '/notification', 'BizaoController@bizaoNotification')->name('notification');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/bizaogeturl', 'BizaoController@getApiUrl');

//Route::get('/pays', 'BizaoController@postCountries');
