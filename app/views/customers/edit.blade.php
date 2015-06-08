@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>Update Customer</h1>
        
        {{ Form::model($customer, array('route' => array('customer.update', $customer->id), 'method' => 'PATCH')) }}
        
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
        		{{ Form::label('name', 'Name:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('name', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('phone', 'Phone:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('phone', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('mobile', 'Mobile:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('mobile', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('email', 'Email:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('email', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('address', 'Address:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::textarea('address', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('postcode', 'Postcode:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('postcode', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::Submit('Update Customer', array('class' => 'btn btn-info')) }} 
        	</div>
        </div>
        {{ Form::close() }}
    </div>
</div>

@stop