@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-4 col-lg-offset-8">
        {{ link_to_route('orders.history', 'Old Orders', null, array('class' => 'btn btn-info btn-xs')) }}
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
          <li role="presentation" class="li-order {{ $tab == 'req' ? 'active' : '' }}" id="li-part-required"><a href="#" id="button-part-required">Part required</a></li>
          <li role="presentation" class="li-order {{ $tab == 'ord' ? 'active' : '' }}" id="li-part-ordered"><a href="#" id="button-part-ordered">Parts Ordered</a></li>
          <li role="presentation" class="li-order {{ $tab == 'rec' ? 'active' : '' }}" id="li-part-received"><a href="#" id="button-part-received">Parts Recieved</a></li>
        </ul>

        <div id="part-required" class="responsive-table order" {{ $tab == 'req' ? '' : 'style="display:none;"' }}>
            <table style="width:100%;">
                <tr>
                    <th>Order#</th>
                    <th>Customer</th>
                    <th>Part#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if($required->count())
                @foreach($required as $order)
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

        <div id="part-ordered" class="responsive-table order" {{ $tab == 'ord' ? '' : 'style="display:none;"' }}>
            <table style="width:100%;">
                <tr>
                    <th>Order#</th>
                    <th>Customer</th>
                    <th>Part#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if($ordered->count())
                @foreach($ordered as $order)
                	@if($order->items != '' && $order->items->count())
                	@foreach($order->items as $item)
                    <tr>
                        <td>{{ link_to_route('orders.show', $order->id, array($order->id)) }}</td>
                        <td>{{ link_to_route('customer.show', $order->customer != '' ? $order->customer->name : '', array($order->customer_id)) }}</td>
                        <td>{{ $item->part_number }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->status['name'] }}</td>
                        <td>
                            @if($item->status_id == '2')
                                {{ link_to_route('ajax.received', 'Part Received', array('id' => $item->id), array('class' => 'btn btn-info btn-xs')) }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                	@endif
                @endforeach
                @endif
            </table>
        </div>

        <div id="part-received" class="responsive-table order" {{ $tab == 'rec' ? '' : 'style="display:none;"' }}>
            <table style="width:100%;">
                <tr>
                    <th>Order#</th>
                    <th>Customer</th>
                    <th>Part#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if($recieved->count())
                @foreach($recieved as $order)
                	@if($order->items != '' && $order->items->count())
                	@foreach($order->items as $item)
                    <tr>
                        <td>{{ link_to_route('orders.show', $order->id, array($order->id)) }}</td>
                        <td>{{ link_to_route('customer.show', $order->customer != '' ? $order->customer->name : '', array($order->customer_id)) }}</td>
                        <td>{{ $item->part_number }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->status['name'] }}</td>
                        <td>
                            @if($item->status_id == '3')
                                {{ link_to_route('ajax.pickup', 'Part Picked Up', array('id' => $item->id), array('class' => 'btn btn-info btn-xs')) }}
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

<script type="text/javascript">
    $(function() {

        $('#button-part-required').button().click(function() {
            $('.order').hide('slide');
            $('#part-required').show('slide');
            $('.li-order').removeClass('active');
            $('#li-part-required').addClass('active');
        });
        $('#button-part-ordered').button().click(function() {
            $('.order').hide('slide');
            $('#part-ordered').show('slide');
            $('.li-order').removeClass('active');
            $('#li-part-ordered').addClass('active');
        });
        $('#button-part-received').button().click(function() {
            $('.order').hide('slide');
            $('#part-received').show('slide');
            $('.li-order').removeClass('active');
            $('#li-part-received').addClass('active');
        });

    });

</script>
@stop