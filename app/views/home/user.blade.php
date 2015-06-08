@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-4">
        <h1>Change User</h1>
        {{ Form::open(array('route' => 'post.changeuser', 'method' => 'POST')) }}
       
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
        	<div class="col-sm-6">
        		{{ Form::label('username', 'Select new username') }} 
        	</div>
        	<div class="col-sm-4">
        		{{ Form::select('user', $user) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::Submit('Change', array('class' => 'btn btn-info')) }} 
        	</div>
        </div>
        {{ Form::close() }}
        
    </div>
</div>

@stop