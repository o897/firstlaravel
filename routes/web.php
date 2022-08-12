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

Auth::routes();

Route::post('follow/{user}', 'FollowsController@store');

Route::get('/', 'PostsController@index');

Route::get('/email', function () {
    return new App\Mail\NewUserWelcomeMail();
});

Route::get('/p/create', 'PostsController@create');
//Passing whatever that comes after /p/
Route::post('/p', 'PostsController@store');
//Best practice is to  anything with a variavle at the end
Route::get('/p/{post}', 'PostsController@show');


Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
// this route will go to the @edit action and will return our view
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
//this rout will be the one to do all the heavy lifting #update
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
