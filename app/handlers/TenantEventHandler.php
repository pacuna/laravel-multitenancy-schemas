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
        PGSchema::create($username);

        //switch to this schema
        PGSchema::switchTo($username);

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
        PGSchema::switchTo();

    }
    public function subscribe($events)
    {
        $events->listen('tenant.create', 'Events\TenantEventHandler@onCreate');
    }
}


