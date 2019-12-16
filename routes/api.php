<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'UserController@login');
Route::post('/join', 'UserController@register');
Route::group(['middleware'=>'auth.api'], function(){
    Route::get('logout', 'UserController@logout');
});

Route::get('/japan/modify/{id}', 'JapanController@modifyShow');
Route::resource('/japan', 'JapanController');
Route::resource('/qna', 'QnaController');
Route::resource('/member', 'MemberController');