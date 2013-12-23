<?php namespace Events;
use Tenant;
use DB;
use User;
use Schema;
use Hash;

class TenantEventHandler{

    public function onCreate(Array $data)
    {
        $username = $data['username'];
        $password = Hash::make($data['password']);

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

    }
    public function subscribe($events)
    {
        $events->listen('tenant.create', 'Events\TenantEventHandler@onCreate');
    }
}


