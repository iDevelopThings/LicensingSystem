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

Route::get('/', function ()
{
	return view('welcome');
});

Route::auth();

/**
 * Application Api functionality
 */
Route::group(['prefix' => 'api', 'as' => 'api', 'namespace' => 'Api'], function ()
{
	
	Route::group(['prefix' => 'product', 'as' => 'product'], function ()
	{
		Route::post('/create', 'ProductController@create');
		Route::get('/get', 'ProductController@getProducts');
		Route::get('/delete/{product}', 'ProductController@deleteProduct');
		
		/**
		 * View product endpoints
		 */
		Route::get('/get/{product}/info', 'ProductController@getProductInfo');
		Route::post('/get/{product}/create_user', 'ProductController@createUser');
		Route::get('/get/{product}/users', 'ProductController@getUsers');
		Route::post('/get/{product}/create_api_key', 'ProductController@createApiKey');
		
		Route::get('/get/{product}/keys', 'ProductController@getKeys');
		Route::post('/get/{product}/create_key', 'ProductController@createKey');
		
		/**
		 * Product user functions
		 */
		Route::post('/get/{product}/user/{user}/delete', 'ProductController@deleteUser');
		Route::get('/get/{product}/user/{user}', 'ProductController@getUser');
		
		/**
		 * Product key functions
		 */
		Route::post('/get/{product}/key/{key}/delete', 'ProductController@deleteKey');
	});
	
});

/**
 * Public Api functionality
 */
Route::group(['prefix' => 'api', 'as' => 'api', 'namespace' => 'Api', 'middleware' => 'publicApi'], function ()
{
	Route::group(['prefix' => 'v1', 'as' => 'v1', 'namespace' => 'V1'], function ()
	{
		
		Route::group(['prefix' => 'product', 'as' => 'product'], function ()
		{
			Route::post('/key/{key}/activate', 'ProductController@activateKey');
			Route::get('/key/{key}', 'ProductController@keyInfo');
			Route::post('/create_user', 'ProductController@createUser');
			Route::get('/get_user/{user}', 'ProductController@getUser');
			
		});
		
	});
});


Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'product', 'as' => 'product'], function ()
{
	Route::get('/view/{product}', 'ProductController@viewProduct');
});