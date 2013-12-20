<h1>Register for a new account!</h1>

{{ Form::open(['route' => 'tenants.store']) }}
  {{ Form::label('username', 'username') }}
  {{ Form::text('username') }}

  {{ Form::label('password', 'password') }}
  {{ Form::password('password') }}

  {{ Form::submit('Create!') }}
{{ Form::close() }}
