@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>New User</h1>
        
        {{ Form::open(array('route' => 'users.store')) }}
        
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
        	<div class="col-sm-2">
        		{{ Form::label('username', 'Name:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('username', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('email', 'Email:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::email('email', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('role_id', 'Role:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::select('role_id', $roles, null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('password', 'Password:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::password('password', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('password_confirmation', 'Confirm Password:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::password('password_confirmation', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>

@stop