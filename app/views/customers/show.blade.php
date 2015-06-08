@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>View Customer Details</h1>
        <div class="row">
        	<div class="col-sm-3">
        		{{ link_to_route('customer.index', 'List Customers') }}
        	</div>
        	<div class="col-sm-1 col-sm-offset-8">
        		{{ link_to_route('customer.edit', 'Edit', array($customer->id), array('class' => 'btn btn-info')) }}
        	</div>
        </div>
        <div class="row">
        	<div class="col-sm-2">
        		Name:
        	</div>
        	<div class="col-sm-3">
        		{{ $customer->name }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		Phone:
        	</div>
        	<div class="col-sm-3">
        		{{ $customer->phone }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		Mobile:
        	</div>
        	<div class="col-sm-3">
        		{{ $customer->mobile }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		Email: 
        	</div>
        	<div class="col-sm-3">
        		{{ $customer->email }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		Address:
        	</div>
        	<div class="col-sm-3">
        		{{ $customer->address }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		Postcode:
        	</div>
        	<div class="col-sm-3">
        		{{ $customer->postcode }}
        	</div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <h2>Work</h2>
            </div>
        </div>
        <div class="responsive-table work">
            <table style="width:100%;">
                <tr>
                    <th>Job#</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Equipment</th>
                    <th>Description</th>
                </tr>
                @foreach($work as $job)
                    <tr>
                        <td>{{ link_to_route('work.show', $job->id, array($job->id)) }}</td>
                        <td>{{ $job->status['name'] }}</td>
                        <td>{{ $job->customer != '' ? $job->customer->name : '' }}</td>
                        <td>
                            @if($job->equipments != '')
                                @foreach($job->equipments as $equip)
                                    {{ $equip->equip_type->name . "<br />" }}
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if($job->equipments != '')
                                @foreach($job->equipments as $equip)
                                    {{ $equip->make . " " . $equip->model . " " . $equip->serial . "<br />"  }}
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $job->description }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <h2>Equipment</h2>
            </div>
        </div>
        <div class="responsive-table work">
            <table style="width:100%;">
                <tr>
                    <th>Type</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Serial</th>
                    <th></th>
                </tr>
                @foreach($equipment as $equip)
                    <tr>
                        <td>{{{ $equip->equip_type->name }}}</td>
                        <td>{{ link_to_route('equipment.show', $equip->make, array($equip->id)) }}</td>
                        <td>{{ link_to_route('equipment.show', $equip->model, array($equip->id)) }}</td>
                        <td>{{ link_to_route('equipment.show', $equip->serial, array($equip->id)) }}</td>
                        <td>{{ link_to_route('equipment.edit', 'Edit', array($equip->id), array('class' => 'btn btn-info btn-xs')) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <h2>Orders</h2>
            </div>
        </div>
        <div class="responsive-table order">
            <table style="width:100%;">
                <tr>
                    <th>Order#</th>
                    <th>Customer</th>
                    <th>Part#</th>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
                @if($orders->count())
                @foreach($orders as $order)
                    @if($order->items != '' && $order->items->count())
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ link_to_route('orders.show', $order->id, array($order->id)) }}</td>
                        <td>{{ link_to_route('customer.show', $order->customer != '' ? $order->customer->name : '', array($order->customer_id)) }}</td>
                        <td>{{ $item->part_number }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->status['name'] }}</td>
                    </tr>
                    @endforeach
                    @endif
                @endforeach
                @endif
            </table>
        </div>

</div>

@stop