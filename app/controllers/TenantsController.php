<?php

class TenantsController extends \BaseController {

  public function store() {
      //first create the user in the public schema
    $username = Input::get('username');
    $password = Hash::make(Input::get('password'));
    $data = array('username' => $username, 'password' => $password);

    $tenant = Tenant::create(['subdomain' => $username, 'password' => $password]);

    //fire the event that moves between schemas and creates the users table in the schema of this tenant
    Event::fire('tenant.create', [$data]);

    return 'your account was created successfully. You can access your admin panel in '.$username.'.local.dev. Your data access is admin/[yourpassword]';
  }

  public function login($subdomain){
    return View::make('tenants.login');
  }

  public function createSession($subdomain) {

    $username = Input::get('username');
    $password = Input::get('password');
    if (Auth::attempt(['username' => $username, 'password' => $password])) return 'logged in!';

    else return 'incorrect data';
  }

}
