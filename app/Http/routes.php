<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', function () {
	return 'cs411';
    //return view('welcome');
});
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('signup', function () {
    return view('auth.register');
});
Route::get('signin', function () {
    return view('auth.login');
});

//Route::get('/','MessageController@index');
//Route::get('dashboard','MessageController@showAll');
Route::get('ride',"MessageController@showRide");
//Route::get('dashboard/movie',"MessageController@showMovie");
//Route::get('dashboard/restaurant',"MessageController@showRestaurant");

Route::get('message/search','MessageController@search');
Route::post('message/result','MessageController@result');

Route::get('message/create','MessageController@create');
Route::post('message/store','MessageController@store');

Route::post('message/analysis','MessageController@analysis');

Route::get('message/createIP','MessageController@createIP');
Route::post('message/createIII', 'MessageController@createIII');
Route::post('message/recommend', 'MessageController@recommend');

Route::get('messages/{id}','MessageController@show');

Route::get('message/edit/{id}','MessageController@edit');
Route::post('message/update','MessageController@update');
Route::delete('{id}', 'MessageController@delete');

Route::auth();

//-----------------------------------------------Profile
Route::get('profile/edit', 'UserController@edit')->name('profile.edit');
Route::post('profile/update', 'UserController@update')->name('profile.update');
Route::get('profile/{id}', 'UserController@profile')->name('profile');

//-----------------------------------------------Movie
Route::group(['middleware' => 'auth'], function(){
	Route::resource('movie','MovieController',[
		'only' => ['index','store','show','destroy','create','edit'],
	]);
	Route::post('movie/update','MovieController@update');
});

//-----------------------------------------------Restaurant
Route::group(['middleware' => 'auth'], function(){
	Route::resource('restaurant','RestaurantController',[
		'only' => ['index','store','show','destroy','create','edit'],
	]);
	Route::post('restaurant/update','RestaurantController@update');
	
});





