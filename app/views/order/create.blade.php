@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-sm-4">
        <div class="row">
            <div class="col-lg-12">
                <h2>Customer Details</h2>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-2">
                        {{ Form::label('customer', 'Search:') }} 
                    </div>
                    <div class="col-sm-3">
                        {{ Form::text('customer') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        {{ link_to('#', 'New Customer', array('class' => 'btn btn-info btn-lg', 'id' => 'addCustomer')) }}
                    </div>
                </div>
            </div>
            <div class="col-lg-12" id="customerDetails">
                
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                {{ link_to('#', 'Order', array('class' => 'btn btn-info btn-lg', 'id' => 'addOrder')) }}
            </div>
        </div>

    </div>

    <div class="col-sm-8">
        <h2>order</h2>
        <div id="orderNumber">
        </div>
    </div>
    
    <div class="col-sm-8">
        <div class="table-responsive">
            (remove button)
            <table id="orderTable" style="width:75%;">
                <tr>
                    <th>
                        Part#
                    </th>
                    <th>
                        Name
                    </th>
                </tr>
            </table>
        </div>
    </div>
    
</div>

<div id="customerDialog" class="row">
    <div class="col-lg-12">
        <h1>New Customer</h1>
        
        {{ Form::open(array('route' => 'customer.store', 'id' => 'form-new-customer')) }}
        
        
        <div class="row">
            <div class="col-sm-4" id="customer-error">
                @if($errors->any())
                @if(Session::has('message'))
                <p>{{ Session::get('message') }}</p>
                @endif
                <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }} 
                </ul>
                @endif
            </div>
        </div>
        
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

        {{ Form::close() }}
    </div>
</div>


<div id="orderDialog" class="row">
    <div class="col-lg-12">
        <h1>Order Details</h1>
        
        {{ Form::open(array('route' => 'orders.store', 'id' => 'form-new-order')) }}
        
        
        <div class="row">
            <div class="col-sm-4" id="order-error">
                @if($errors->any())
                @if(Session::has('message'))
                <p>{{ Session::get('message') }}</p>
                @endif
                <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }} 
                </ul>
                @endif
            </div>
        </div>
        

        {{ Form::hidden('customer_id', null, array('id' => 'customer_id')) }}
        {{ Form::hidden('order_id', null, array('id' => 'order_id')) }}

        <div class="row">
            <div class="col-sm-4">
                {{ link_to('#', 'Another Item', array('class' => 'btn btn-info btn-lg', 'id' => 'addOneItem')) }}
            </div>
        </div>

        <div class="table-responsive">
            <table id="itemTable">
                <tr>
                    <th>
                        Part#
                    </th>
                    <th>
                        Name
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
                {{ Form::hidden('orderCount', 0, array('id' => 'orderCount', 'class' => 'ui-widget ui-widget-content ui-corner-all')) }}
            </table>
        </div>

        {{ Form::close() }}
    </div>
</div>

<script type="text/javascript">
    $(function() {

        $('#addCustomer').button().click(function() {
            $('#customerDialog').dialog("open");
        });

        function loadButtons() {
            $('#addOrder').button().click(function() {
                $('#orderDialog').dialog("open");
            });

            $('#addOneItem').button().click(function() {
                count = $('#itemCount').val();
                row = '<tr>';
                row = row + '<td><input name="order[' + count + '][part_number]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><input name="order[' + count + '][name]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><input name="order[' + count + '][status_id]" type="checkbox" value="2" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '</tr>'; 
                $('#itemTable tr:last').after(row);

                $('#itemCount').val($('#itemCount').val() + 1);
            });
        }

        $('#customer').autocomplete({
            source: function( request, response ) {
            $.ajax({
              url: "{{ action('CustomersController@getCustomers') }}",
              dataType: "jSon",
              data: {
                q: request.term
              },
              success: function( data ) {
                response( data );
              }
            });
          },
          minLength: 2,
          select: function( event, ui ) {
                $('#addCustomer').hide();
                $('#customerDetails').html(ui.item.name + '<br />' +
                                                ui.item.phone + '<br />' +
                                                ui.item.mobile + '<br />' +
                                                ui.item.email + '<br />' +
                                                ui.item.address + '<br />' +
                                                ui.item.postcode + '<br />');
                
                $('#customer_id').val(ui.item.id);
                $('#customer').val(ui.item.name);

                loadButtons();

                return false;

          }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( "<a>" + item.name + "<br>" + item.phone + "<br>" + item.postcode + "</a>" )
            .appendTo( ul );
        };


        $('#customerDialog').dialog({
            autoOpen: false,
            width: 'auto', // overcomes width:'auto' and maxWidth bug
            maxWidth: 600,
            height: 'auto',
            modal: true,
            fluid: true, //new option
            resizable: false,
            buttons: [
                {
                    text: "Save",
                    click: function() { 
                        $('#form-new-customer').submit();
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

        $('#form-new-customer').submit(function(e)
        {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                dataType : 'jSon',
                success:function(data, textStatus, jqXHR) 
                {
                    //data: return data from server
                    if(data.errors){
                        e = '<ul>';
                        for(i = 0; i < data.errors.length; i++){
                            e = e + "<li>" + data.errors[i] + "</li>";
                        }
                        e = e + "</ul>";
                        $('#customer-error').html(e);
                        $('#customer-error').addClass("bg-danger text-danger")
                    }else{
                        $('#customerDialog').dialog("close");
                        $('#addCustomer').hide();
                        $('#customerDetails').html(data.name + '<br />' +
                                                    data.phone + '<br />' +
                                                    data.mobile + '<br />' +
                                                    data.email + '<br />' +
                                                    data.address + '<br />' +
                                                    data.postcode + '<br />');

                        $('#customer_id').val(data.id);

                        loadButtons();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails  
                    $('#customerDialog').dialog("open");    

                }
            });
            e.preventDefault(); //STOP default action
            e.unbind(); //unbind. to stop multiple form submit.
        });

        $('#orderDialog').dialog({
            autoOpen: false,
            width: 'auto', // overcomes width:'auto' and maxWidth bug
            maxWidth: 600,
            height: 'auto',
            modal: true,
            fluid: true, //new option
            resizable: false,
            buttons: [
                {
                    text: "Save",
                    click: function() { 
                        $('#form-new-order').submit();
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

        $('#form-new-order').submit(function(e)
        {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                dataType : 'jSon',
                success:function(data, textStatus, jqXHR) 
                {
                    //data: return data from server
                    if(data.errors){
                        e = '<ul>';
                        for(i = 0; i < data.errors.length; i++){
                            e = e + "<li>" + data.errors[i] + "</li>";
                        }
                        e = e + "</ul>";
                        $('#order-error').html(e);
                        $('#order-error').addClass("bg-danger text-danger")
                    }else{
                        $('#orderDialog').dialog("close");

                        $('#orderNumber').html("Order Number: " + data.id);

                        var row = '';
                        for(var i = 0; i < data.items.length; i++) {
                            
                            row = '<tr>';
                            row = row + '<td>' + data.items[i].part_number + '</td>';
                            row = row + '<td>' + data.items[i].name + '</td>';   
                            row = row + '</tr>';
                            $('#orderTable tr:last').after(row);
                        }

                        //handle if form is resubmitted
                        //set Job_id within form
                        $('#order_id').val(data.id);
                        //clear form
                        $('#itemTable :input').val("");
                        //all equipment will be returned so table needs to be fixed so that duplicates are not shown
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails   
                    $('#orderDialog').dialog("open");   
                }
            });
            e.preventDefault(); //STOP default action
            e.unbind(); //unbind. to stop multiple form submit.
        });

    });

</script>
@stop