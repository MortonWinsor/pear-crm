@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>All Customers</h1>
        <div class="row">
             <div class="col-sm-3">
                {{ Form::open(array('route' => 'customer.index', 'method' => 'GET')) }}
                {{ Form::text('q', $q) }}
                {{ Form::Submit('Search', array('class' => 'btn btn-info')) }} 
                {{ Form::close() }}
            </div>
            <div class="col-sm-2 col-sm-offset-7">
                {{ link_to_route('customer.create', 'New Customer', null, array('class' => 'btn btn-info')) }}
            </div>
        </div>
    @if($customers->count())    
        <div class="responsive-table work">
            <table style="width:100%;">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Postcode</th>
                </tr>
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ link_to_route('customer.show', $customer->name, array($customer->id)) }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->postcode }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="row">
            
            <div class="col-sm-12">
                {{ $customers->links() }}
            </div>
        </div>
    @else
    	<div class="row">
        	
        	<div class="col-sm-3">
        		There are no customers on the system
        	</div>
        </div>
    @endif
    </div>
</div>

@stop