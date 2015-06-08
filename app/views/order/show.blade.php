@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>Order Details</h1>
        {{ link_to('#', 'Add Item', array('class' => 'btn btn-info', 'id' => 'addButton')) }}
        <div class="row">
            <div class="col-sm-2">
                Customer:
            </div>
            <div class="col-sm-3">
                {{{ $order->customer != '' ? $order->customer->name : '' }}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                Order Number:
            </div>
            <div class="col-sm-3">
                {{{ $order->id }}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                Items: 
            </div>
            <div class="col-sm-3">
               @if($order->items != '')
                    @foreach($order->items as $item)
                        {{ $item->part_number . "<br />" . $item->name . "<br />" . $item->status['name'] . "<br />" }}
                        @if($item->status_id == '1')
                         {{ link_to_route('ajax.order.removed', 'Remove Item', array('id' => $item->id), array('class' => 'btn btn-info')) . "<br /><br />" }}
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>


</div>


<div class="row"  id="addDialog">
    <div class="col-lg-12">
        <h1>Add Item to order</h1>
        
        {{ Form::open(array('route' => array('orders.update', $order->id), 'method' => 'PATCH', 'id' => 'form-new-add')) }}
        
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
            <div class="col-sm-6">
                {{ link_to('#', 'Add Another Item', array('class' => 'btn btn-info btn-lg', 'id' => 'addOnePart')) }}
            </div>
        </div>
        <div class="table-responsive">
            <table id="engineerTable">
                <tr>
                    <th>
                        Part Number
                    </th>
                    <th>
                        Part Name
                    </th>
                    <th>
                        Ordered
                    </th>
                </tr>
                <tr>
                    <td>
                        {{ Form::text('order[0][part_number]', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::text('order[0][name]', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::checkbox('order[0][status_id]', '2', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                </tr>
                {{ Form::hidden('orderCount', 1, array('id' => 'orderCount')) }}
            </table>
        </div>

        {{ Form::close() }}
    </div>
</div>

<script type="text/javascript">
    $(function() {
            $('#addOnePart').button().click(function() {
                count = $('#engineerCount').val();
                row = '<tr>';
                row = row + '<td><input name="part[' + count + '][part_number]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><input name="part[' + count + '][name]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><input name="order[' + count + '][status_id]" type="checkbox" value="2" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '</tr>'; 
                $('#engineerTable tr:last').after(row);

                $('#engineerCount').val($('#engineerCount').val() + 1);

            });

    });

    $('#addButton').button().click(function() {
            $('#addDialog').dialog("open");
        });

    $('#addDialog').dialog({
            autoOpen: false,
            width: 'auto', // overcomes width:'auto' and maxWidth bug
            maxWidth: 1200,
            height: 'auto',
            maxHeight: 600,
            modal: true,
            fluid: true, //new option
            resizable: false,
            buttons: [
                {
                    text: "Save",
                    click: function() { 
                        $('#form-new-add').submit();
                    },
                    class:"btn btn-info"
                },
                {
                    text: "Cancel",
                    click: function() { 
                        $(this).dialog( "close" );
                    },
                    class:"btn btn-info"
                }
              ]
        });

       

</script>
@stop