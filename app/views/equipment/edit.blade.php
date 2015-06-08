@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-4">
        <h1>Update Equipment</h1>
        
        {{ Form::model($equipment, array('route' => array('equipment.update', $equipment->id), 'method' => 'PATCH')) }}
        
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
        		{{ Form::label('make', 'Make:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('make', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('model', 'Model:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('model', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('serial', 'Serial:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('serial', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>


        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('last_serviced', 'Last Serviced:') }}  
            </div>
            <div class="col-sm-3">
                {{ Form::text('last_serviced', $equipment->last_serviced == '0000-00-00 00:00:00' ? date('d/m/Y', time()) : date('d/m/Y', strtotime($equipment->last_serviced)) , array('id' => 'last_serviced', 'class' => 'ui-widget ui-widget-content ui-corner-all')) }}
            </div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('type_id', 'Type:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::select('type_id', $types, null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>
        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::Submit('Update Equipment', array('class' => 'btn btn-info')) }} 
        	</div>
        </div>
        {{ Form::close() }}
    </div>
</div>

<script>
  $(function() {
    $( "#last_serviced" ).datepicker({ dateFormat: "dd/mm/yy" });
  });
</script>
@stop