<h1>Login form</h1>

{{ Form::open() }}
{{ Form::label('username', 'Username')}}
{{ Form::text('username')}}

{{ Form::label('password', 'Password')}}
{{ Form::password('password')}}

{{ Form::submit('Login')}}
{{ Form::close() }}
