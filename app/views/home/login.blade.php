@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <h1>Login</h1>
        {{ Form::open(array('action' => 'HomeController@postlogin', 'method' => 'POST')) }}
       
        @if($errors->any())
        <div class="row">
            <div class="col-sm-4">
                @if(Session::has('message'))
                <p>{{ Session::get('message') }}</p>
                @endif
                <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }} 
                </ul>
            </div>
        </div>
        @endif

        <div class="row">
        	<div class="col-sm-3">
        		{{ Form::label('username', 'Username') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('username', Input::old('username')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-3">
        		{{ Form::label('password', 'Password') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::password('password') }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::Submit('Login', array('class' => 'btn btn-info')) }} 
        	</div>
        </div>
        {{ Form::close() }}
        
    </div>
</div>

@stop