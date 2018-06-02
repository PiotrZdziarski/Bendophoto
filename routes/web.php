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
Route::post('/reporting', ['uses' => 'UIcontroller@reporting', 'as' => 'reporting']);

Route::post('/reportuser', ['uses' => 'UIcontroller@reportuser', 'as' => 'reportuser']);

Route::post('/deleteaccont', ['uses' => 'UIcontroller@deleteaccont', 'as' => 'deleteaccont'])->middleware('auth');

Route::post('/saveeditedprofile', ['uses' => 'UIcontroller@saveeditedprofile', 'as' => 'saveeditedprofile']);

Route::get('/editprofile', ['uses' => 'HomeController@editprofile', 'as' => 'editprofile'])->middleware('auth');

Route::get('/explore', ['uses' => 'HomeController@explore', 'as' => 'explore'])->middleware('auth');

Route::get('/bendoline', ['uses' => 'HomeController@bendoline', 'as' => 'bendoline'])->middleware('auth');

Route::post('/newpostlink', ['uses' => 'UIcontroller@newpostlink', 'as' => 'newpostlink']);

Route::post('/unfollow', ['uses' => 'UIcontroller@unfollow', 'as' => 'unfollow']);

Route::get('/notificationshow',array('uses' => 'UIcontroller@notificationshow'));

Route::get('searching/{lookingfor}' , array('uses' => 'UIcontroller@searching'));

Route::post('/notifacationlink', ['uses' => 'UIcontroller@notifacationlink', 'as' => 'notificationlink']);

Route::post('/follow', ['uses' => 'UIcontroller@follow', 'as' => 'follow']);

Route::get('/searching', function(){
 // it is just for clear table after not typing anything in searcher
});

Route::get('/profile/{user}', ['uses' => 'HomeController@userprofile', 'as' => 'userprofile']);

Route::post('/addpost', ['uses' => 'UIcontroller@addpost', 'as' => 'addpost']);

Route::post('/typecomment', ['uses' => 'profile@typecomment', 'as' => 'typecomment']);

Route::get('/addingpost', ['uses' => 'UIcontroller@addingpost', 'as' => 'addingpost'])->middleware('auth');

Route::post('/addpicture', ['uses' => 'profile@addingprofilepicture', 'as' => 'addingprofilepicture']);

Route::post('/liking/{postid}/{username}', array('uses' => 'profile@likingmethod'));

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'index'])->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
