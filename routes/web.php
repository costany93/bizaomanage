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

    $pays = Pays::pluck('name', 'id')->all();
    return view('homescreen', compact('pays'));
});

Route::match(['post','get'],'/donation', 'BizaoController@checkAccess')->name('access');


route::match(['post', 'get'], '/notification', 'BizaoController@bizaoNotification')->name('notification');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/bizaogeturl', 'BizaoController@getApiUrl');

Route::get('/paiement-success/{order_id}','BizaoController@PaymentSuccess');

Route::get('/download/{order_id}','BizaoController@getRecu');

//Route::get('/pays', 'BizaoController@postCountries');
