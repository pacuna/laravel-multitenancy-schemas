<?php


Route::group(array('domain' => '{account}.local.dev'), function()
{
  //login form for tenants
  Route::get('/', 'TenantsController@login');
  Route::post('/', 'TenantsController@createSession');

});

Route::get('/', 'HomeController@index');
Route::post('/tenants', ['as' => 'tenants.store', 'uses' => 'TenantsController@store']);