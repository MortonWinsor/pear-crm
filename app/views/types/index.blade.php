@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-sm-4">
        <h1>All Machine Types</h1>
    </div>
    <div class="col-sm-2">
        {{ link_to_route('types.create', 'Add Machine Type', null, array('class' => 'btn btn-info')) }}
    </div>
        
    @if($types->count())    
        <div class="responsive-table work">
            <table style="width:100%;">
                <tr>
                    <th>Name</th>
                </tr>
                @foreach($types as $type)
                    <tr>
                        <td>{{ link_to_route('types.edit', $type->name, array($type->id)) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
    	<div class="row">
        	
        	<div class="col-sm-3">
        		There are no machine types on the system
        	</div>
        </div>
    @endif
    </div>
</div>

@stop