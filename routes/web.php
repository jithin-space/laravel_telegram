<?php


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
   $users = App\User::count();
   $messages = \App\Message::count();
   $textMessages = \App\TextMessage::count();
   $docMessages = \App\DocMessage::count();
    return view('welcome',['user'=>$users,'messages'=>$messages,'text'=>$textMessages,'docs'=>$docMessages]);
});

Route::post('hook','WebhookController@handle');

Route::get('/users/userCount', 'UserController@userCount');
// Route::get('/varieties/{id}/heat', 'VarietyController@heat')->name('varieties.heat');
Route::resource('/users','UserController',['only'=>['index','show']]);
Route::resource('/messages','MessageController',['only'=>['index','show']]);

// Route::get('/update','WebhookController@handleTest');
