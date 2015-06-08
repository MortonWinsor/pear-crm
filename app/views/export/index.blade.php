@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-6">
        <h1>Export</h1>
        {{ Form::open(array('route' => 'export.export', 'method' => 'POST', 'target' => '_blank')) }}
       
        @if($errors->any())
        <div class="row">
            <div class="col-sm-12">
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
        	<div class="col-sm-4">
        		{{ Form::label('type', 'Select Export') }} 
        	</div>
        	<div class="col-sm-4">
        		{{ Form::select('type', $type, null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::Submit('Export', array('class' => 'btn btn-info')) }} 
        	</div>
        </div>
        {{ Form::close() }}
        
    </div>
</div>

@stop