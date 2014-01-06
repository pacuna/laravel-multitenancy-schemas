<?php


Route::group(array('domain' => '{account}.local.dev', 'before' => 'tenantFilter'), function()
{
  //login form for tenants
  Route::get('/', 'TenantsController@login');
  Route::post('/', 'TenantsController@createSession');

});

Route::get('/', 'HomeController@index');
Route::post('/tenants', ['as' => 'tenants.store', 'uses' => 'TenantsController@store']);


//before filter subdomain
Route::filter('tenantFilter', function(){

  //parse the url in order to get the subdomain
  $url = Request::url();
  $url = parse_url($url);
  $host = explode('.', $url['host']);
  $subdomain = $host[0];

  //verify the existence of subdomain
  $user = Tenant::where('subdomain', '=', $subdomain)->firstOrFail();

  //if user exists, change the schema to the tenant schema
  PGSchema::switchTo($subdomain);
});

