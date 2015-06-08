@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">

        <div class="responsive-table order" >
            <table style="width:100%;">
                <tr>
                    <th>Order#</th>
                    <th>Customer</th>
                    <th>Part#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if($history->count())
                @foreach($history as $order)
                	@if($order->items != '' && $order->items->count())
                	@foreach($order->items as $item)
                    <tr>
                        <td>{{ link_to_route('orders.show', $order->id, array($order->id)) }}</td>
                        <td>{{ link_to_route('customer.show', $order->customer != '' ? $order->customer->name : '', array($order->customer_id)) }}</td>
                        <td>{{ $item->part_number  }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->status['name'] }}</td>
                        <td>
                            @if($item->status_id == '1')
                                {{ link_to_route('ajax.ordered', 'Part Ordered', array('id' => $item->id), array('class' => 'btn btn-info btn-xs')) }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                	@endif
                @endforeach
                @endif
            </table>
        </div>

    </div>
</div>

@stop