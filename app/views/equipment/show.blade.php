@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <h1>Equipment Details</h1>
        <div class="row">
            <div class="col-sm-3 col-sm-offset-9">
                {{ link_to_route('equipment.edit', 'Edit', array($equipment->id), array('class' => 'btn btn-info')) }}
            </div>
        </div>
        <div class="row">
        	<div class="col-sm-2">
        		Make:
        	</div>
        	<div class="col-sm-3">
        		{{ $equipment->make }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		Model:
        	</div>
        	<div class="col-sm-3">
        		{{ $equipment->model }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		Serial:
        	</div>
        	<div class="col-sm-3">
        		{{ $equipment->serial }}
        	</div>
        </div>
        <div class="row">
        	<div class="col-sm-2">
        		Service Interval: 
        	</div>
        	<div class="col-sm-3">
        		{{ $equipment->service_interval }}
        	</div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                Last Serviced: 
            </div>
            <div class="col-sm-3">
                {{ date('d/m/Y', strtotime($equipment->last_serviced)) }}
            </div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		Type:
        	</div>
        	<div class="col-sm-3">
        		{{ $equipment->equip_type->name }}
        	</div>
        </div>
    </div>
</div>

@stop