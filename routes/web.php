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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['web'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Authentication Routes...
    Route::get('login', 'AdminAuth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'AdminAuth\LoginController@login');
    Route::post('logout', 'AdminAuth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'AdminAuth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.update');

    // Email Verification Routes...
    Route::get('email/verify', 'AdminAuth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'AdminAuth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'AdminAuth\VerificationController@resend')->name('verification.resend');

    Route::group(['middleware' => ['admin.auth']], function () {
        Route::get('/', 'AdminController@index')->name('home');
    });

});

Route::get('/home', 'HomeController@index')->name('home');
