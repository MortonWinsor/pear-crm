@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-sm-4">
        <h1>All Parts</h1>
    </div>
    <div class="col-sm-2">
        {{ link_to_route('parts.create', 'Add Part', null, array('class' => 'btn btn-info')) }}
    </div>
        
    @if($parts->count())    
        <div class="responsive-table work">
            <table style="width:100%;">
                <tr>
                    <th>Name</th>
                </tr>
                @foreach($parts as $part)
                    <tr>
                        <td>{{ link_to_route('parts.edit', $part->part, array($part->id)) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
    	<div class="row">
        	
        	<div class="col-sm-3">
        		There are no parts on the system
        	</div>
        </div>
    @endif
    </div>
</div>

@stop