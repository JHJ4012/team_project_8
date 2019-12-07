<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/japan/modify/{id}', 'JapanController@modifyShow');
Route::resource('/japan', 'JapanController');
// Route::post('/formSubmit', 'JapanController@formSubmit');

Route::resource('/japan', 'JapanController');
Route::get('/japan/modify/{id}','JapanController@modifyShow' );
Route::resource('/qna', 'QnaController');


Route::resource('/member', 'MembersController');
Route::post('/login', 'UserController@login');
Route::post('/join', 'UserController@register');

Route::group(['middleware'=>'auth.api'], function(){
    Route::get('logout', 'UserController@logout');
});
