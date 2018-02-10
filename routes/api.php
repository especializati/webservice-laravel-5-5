<?php
// Routes prefix, version API
$this->group(['prefix' => 'v1'], function(){
    
    // Routes authentication e refresh token
    $this->post('auth', 'Auth\AuthApiController@authenticate');
    $this->post('auth-refresh', 'Auth\AuthApiController@refreshToken');
   
    // Routes restrict, authentication by JWT: https://github.com/tymondesigns/jwt-auth
	$this->group(['middleware' => [], 'namespace' => 'Api\v1'], function () {

		// Controller Resource API, Products
	    $this->apiResource('products', 'ProductController');

	    // Controller Resource API, Tasks
	    $this->apiResource('tasks', 'TaskController');

	});
   
});