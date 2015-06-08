@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-4">
        <h1>Update Work</h1>
        
        {{ Form::model($job, array('route' => array('work.update', $job->id), 'method' => 'PATCH')) }}
        
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
        		{{ Form::label('description', 'Description:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::textarea('description', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-3">
        		{{ Form::label('status_id', 'Status:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::select('status_id', $status, null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                {{ Form::label('time', 'Time:') }} 
            </div>
            <div class="col-sm-3">
                {{ Form::selectRange('time', 0.5, 16, $job->time, null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                {{ Form::label('notes', 'Notes:') }} 
            </div>
            <div class="col-sm-3">
                {{ Form::textarea('notes', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
            </div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::Submit('Update Work', array('class' => 'btn btn-info')) }} 
        	</div>
        </div>
        {{ Form::close() }}
    </div>
</div>

@stop