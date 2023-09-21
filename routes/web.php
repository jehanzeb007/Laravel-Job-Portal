<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

  //Admin login routes
  Route::get('admin', array('uses' =>'Auth\AuthController@login'));
  Route::get('admin/login', array('uses' =>'Auth\AuthController@login', 'as' => 'admin_login'));
  Route::post('admin/login', array('uses' =>'Auth\AuthController@loginPost', 'as' => 'admin_loginPost'));
  Route::get('admin/forgot_password', array('uses' =>'Auth\AuthController@forgotPassword', 'as' => 'admin_forgot_password'));
  Route::post('admin/send_mail', array('uses' =>'Auth\AuthController@sendMail', 'as' => 'admin_send_mail'));
  Route::get('admin/send_mail/{token}', array('uses' =>'Auth\AuthController@passwordVerification', 'as' => 'admin_password_verification'));
  Route::post('admin/reset_password', array('uses' =>'Auth\AuthController@resetPassword', 'as' => 'admin_reset_password'));
  Route::get('admin/logout', array('uses' =>'Auth\AuthController@logout', 'as' => 'admin_logout'));

