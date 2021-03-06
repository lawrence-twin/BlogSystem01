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

Route::get('/', 'PostsController@index')->name('top');

// こちらにもcreateを定義しないとページ遷移できない
// 理由がわからない
Route::resource('posts', 'PostsController', ['only' => ['create', 'show']]);

// 記事更新系はユーザ権限必須
Route::resource('posts', 'PostsController', ['only' => ['store', 'create', 'edit', 'update', 'destroy']])->middleware('auth');


Route::resource('comments', 'CommentsController', ['only' => ['store', 'show', 'edit', 'update', 'destroy']]);

Route::get('/about', function() {
		return view('about');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
    Route::get('/', function () {
        return view('admin.welcome');
    });
    Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');

Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login');

Route::get('register', 'Admin\Auth\RegisterController@showRegisterForm')->name('admin.register');
Route::post('register', 'Admin\Auth\RegisterController@register')->name('admin.register');

Route::get('password/rest', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');


});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function(){
    Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
    Route::get('home', 'Admin\HomeController@index')->name('admin.home');
});

