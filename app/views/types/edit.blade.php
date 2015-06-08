@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>New Machine Type</h1>
        
        {{ Form::model($type, array('method' => 'PATCH', 'route' => array('types.update', $type->id))) }}
        
        @if($errors->any())
        <div class="row">
            <div class="col-sm-6">
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
            <div class="col-sm-5">
                This is to change the part that will appear on the engineers report.
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('name', 'Machine Type:') }} 
            </div>
            <div class="col-sm-3">
                {{ Form::text('name', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
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