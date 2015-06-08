@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>New Equipment</h1>
        
        {{ Form::open(array('route' => 'equipment.store')) }}
        
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
        {{ Form::hidden('customer_id')}}

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
                        {{ Form::text('customer', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
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
        	<div class="col-sm-2">
        		{{ Form::label('make', 'Make:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('make', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('model', 'Model:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('model', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('serial', 'Serial:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::text('serial', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('last_serviced', 'Last Serviced:') }}  
            </div>
            <div class="col-sm-3">
                {{ Form::text('last_serviced', date('d/m/Y', time()), array('id' => 'last_serviced', 'class' => 'ui-widget ui-widget-content ui-corner-all')) }}
            </div>
        </div>

        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::label('type_id', 'Type:') }} 
        	</div>
        	<div class="col-sm-3">
        		{{ Form::select('type_id', $types, null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
        	</div>
        </div>
        <div class="row">
        	<div class="col-sm-2">
        		{{ Form::Submit('New Equipment', array('class' => 'btn btn-info')) }} 
        	</div>
        </div>
        {{ Form::close() }}
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
                {{ Form::text('name') }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('phone', 'Phone:') }} 
            </div>
            <div class="col-sm-3">
                {{ Form::text('phone') }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('mobile', 'Mobile:') }} 
            </div>
            <div class="col-sm-3">
                {{ Form::text('mobile') }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('email', 'Email:') }} 
            </div>
            <div class="col-sm-3">
                {{ Form::text('email') }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('address', 'Address:') }} 
            </div>
            <div class="col-sm-3">
                {{ Form::textarea('address') }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('postcode', 'Postcode:') }} 
            </div>
            <div class="col-sm-3">
                {{ Form::text('postcode') }}
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
<script type="text/javascript">
    $(function() {

        $( "#last_serviced" ).datepicker( { dateFormat: "dd/mm/yy" });

        $('#addCustomer').button().click(function() {
            $('#customerDialog').dialog("open");
        });


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

                        $('#job_customer_id').val(data.id);
                        $('#equipment_customer_id').val(data.id);

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

    });

</script>

@stop