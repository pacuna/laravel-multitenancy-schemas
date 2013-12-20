<?php

class TenantsController extends \BaseController {

  public function store() {
    //first create the user in the public schema
    $username = Input::get('username');
    $password = Hash::make(Input::get('password'));

    $tenant = Tenant::create(['subdomain' => $username, 'password' => $password]);

    //create the new schema
    $query = DB::statement('CREATE SCHEMA '.$username);

    //switch to this schema
    $query = DB::statement('SET search_path TO '.$username);

    //create a users table for this schema
    Schema::create('users', function($table)
    {
        $table->increments('id');
        $table->string('username');
        $table->string('password');
        $table->timestamps();
    });

    //create the first user for this schema
    User::create(['username' => 'admin', 'password' => $password]);

    //back to the public schema

    $query = DB::statement('SET search_path TO public');

    return 'your account was created successfully. You can access your admin panel in '.$username.'.local.dev. Your data access is admin/[yourpassword]';
  }

  public function login($subdomain){
    //TODO: check if subdomain exists
    
    return View::make('tenants.login');
  }

  public function createSession($subdomain) {

    //set the schema for this subdomain
    $query = DB::statement('SET search_path TO '.$subdomain);
    $username = Input::get('username');
    $password = Input::get('password');
  
    if (Auth::attempt(['username' => $username, 'password' => $password])) return 'logged in!';

    else return 'incorrect data';
  }

}