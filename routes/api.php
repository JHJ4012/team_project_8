<?php

use Illuminate\Http\Request;


Route::post('/login', 'UserController@login');
Route::post('/join', 'UserController@register');
Route::group(['middleware'=>'auth.api'], function(){
    Route::get('logout', 'UserController@logout');
});

Route::get('/japan/modify/{id}', 'JapanController@modifyShow');
Route::resource('/japan', 'JapanController');

Route::resource('/qna', 'QnaController');

Route::resource('/member', 'MemberController');