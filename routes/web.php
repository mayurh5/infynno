<?php

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
    return view('welcome');
});

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
     
        Route::get('/register', 'Auth\RegisterController@show')->name('register.show');
        Route::post('/register', 'Auth\RegisterController@register')->name('register.perform');

        Route::get('/login', 'Auth\LoginController@show')->name('login.show');
        Route::post('/login', 'Auth\LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
     
        Route::get('/logout', 'Auth\LogoutController@perform')->name('logout.perform');

        Route::get('/list/blog', 'HomeController@getBlogDataJson')->name('blog.list');
        Route::get('/create/blog', 'HomeController@createBlog')->name('blog.create');
        Route::post('/store/blog', 'HomeController@storeBlog')->name('blog.store');
        Route::get('/edit/blog/{id}', 'HomeController@editBlog')->name('blog.edit');
        Route::post('/upadate/blog', 'HomeController@updateBlog')->name('blog.update');
        Route::get('/delete/blog/{id}', 'HomeController@deleteBlog')->name('blog.delete');



    });
});
