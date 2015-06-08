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
                    <div class="col-sm-12">
                        {{ Form::label('customer', 'Current Customers or Job Numbers:') }} 
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
            <div class="col-lg-12">
                <h2>Services Available</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ link_to('#', 'Log Work', array('class' => 'btn btn-info btn-lg', 'id' => 'addWork')) }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ link_to('#', 'Order Parts', array('class' => 'btn btn-info btn-lg', 'id' => 'addOrder')) }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ link_to('#', 'New Equipment', array('class' => 'btn btn-info btn-lg', 'id' => 'addEquipment')) }}
            </div>
        </div>

    </div>

    <div id="currentWork" class="col-sm-8">
        <h2>Current Information</h2>

    </div>

    <div id="previousWork" class="col-sm-8">
        <h2>Previous Information</h2>

    </div>
</div>

<div id="customerDialog" class="row">
    <div class="col-lg-12">
        <h1>New Customer</h1>
        
        {{ Form::open(array('route' => 'customer.store', 'id' => 'form-new-customer')) }}
        
        
        <div class="row">
            <div class="col-sm-12" id="customer-error">
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


<div id="workDialog" class="row">
    <div class="col-lg-12">
        <h1>Log Work Details</h1>
        
        {{ Form::open(array('route' => 'work.store', 'id' => 'form-new-work')) }}
        
        
        <div class="row">
            <div class="col-sm-4" id="work-error">
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

        {{ Form::hidden('customer_id', null, array('id' => 'job_customer_id')) }}
        {{ Form::hidden('job_id', null, array('id' => 'job_id')) }}

        <div class="row">
            <div class="col-sm-8">
                <h3>Work Required:</h3>
            </div>
            <div class="col-sm-4">
                {{ link_to('#', 'Another Equipment', array('class' => 'btn btn-info btn-lg', 'id' => 'addOneWork')) }}
            </div>
        </div>

        <div class="table-responsive">
            <table id="workAddTable">
                <tr>
                    <th>
                        Make
                    </th>
                    <th>
                        Model
                    </th>
                    <th>
                        Serial
                    </th>
                    <th>
                        Type
                    </th>
                </tr>
                <tr>
                    <td>
                        {{ Form::text('equip[0][make]', null, array('class' => 'newEquip ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::text('equip[0][model]', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::text('equip[0][serial]', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::select('equip[0][type_id]', $types, null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::select('equip[0][works_id]', $works, null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                </tr>
                {{ Form::hidden('workCount', 1, array('id' => 'workCount')) }}
            </table>
        </div>

        <div class="row">
            <div class="col-sm-2">
                {{ Form::label('description', 'Description:') }} 
            </div>
            <div class="col-sm-10">
                {{ Form::textarea('description', null, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
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

        {{ Form::hidden('customer_id', null, array('id' => 'order_customer_id')) }}
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
                        {{ Form::checkbox('order[0][status_id]', '2') }}
                    </td>
                </tr>
                {{ Form::hidden('orderCount', 0, array('id' => 'orderCount')) }}
            </table>
        </div>

        {{ Form::close() }}
    </div>
</div>

<div id="equipmentDialog" class="row">
    <div class="col-lg-12">
        <h1>Equipment Details</h1>
        {{ Form::open(array('route' => 'equipment.store', 'id' => 'form-new-equipment')) }}
        {{ Form::hidden('customer_id', null, array('id' => 'equipment_customer_id', 'class' => 'ui-widget ui-widget-content ui-corner-all')) }}
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
                {{ Form::label('last_service', 'Last Service:') }}  
            </div>
            <div class="col-sm-3">
                {{ Form::text('last_service', date('d/m/Y', time()), array('id' => 'last_serviced', 'class' => 'ui-widget ui-widget-content ui-corner-all')) }}
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
        {{ Form::close() }}
    </div>
</div>


<script type="text/javascript">
    $(function() {

        $('#addCustomer').button().click(function() {
            $('#customerDialog').dialog("open");
        });

        function loadButtons() {
            $('#addWork').button().click(function() {
                $('#workDialog').dialog("open");
            });
            $('#addOrder').button().click(function() {
                $('#orderDialog').dialog("open");
            });
            $('#addEquipment').button().click(function() {
                $('#equipmentDialog').dialog("open");
            });

            $( "#last_serviced" ).datepicker( { dateFormat: "dd/mm/yy" });

            $('#addOneWork').button().click(function() {
                count = $('#workCount').val();
                row = '<tr>';
                row = row + '<td><input name="equip[' + count + '][make]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><input name="equip[' + count + '][model]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';   
                row = row + '<td><input name="equip[' + count + '][serial]" type="text" class="equipSerial ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><select name="equip[' + count + '][type_id]" class="ui-widget ui-widget-content ui-corner-all">';
                @foreach($types as $key => $type)
                row = row + '<option value="{{ $key }}">{{ $type }}</option>';
                @endforeach
                row = row + '</select></td>'; 
                row = row + '<td><select name="equip[' + count + '][works_id]" class="ui-widget ui-widget-content ui-corner-all">';
                @foreach($works as $key => $work)
                row = row + '<option value="{{ $key }}">{{ $work }}</option>';
                @endforeach
                row = row + '</select></td>'; 
                row = row + '</tr>'; 

                $('#workAddTable tr:last').after(row);

                $('#workCount').val($('#workCount').val() + 1);
            });

            $('#addOneItem').button().click(function() {
                count = $('#itemCount').val();
                row = '<tr>';
                row = row + '<td><input name="order[' + count + '][part_number]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><input name="order[' + count + '][name]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><input name="order[' + count + '][status_id]" type="checkbox" value="2"></td>';
                row = row + '</tr>'; 
                $('#itemTable tr:last').after(row);
                $('#itemCount').val($('#itemCount').val() + 1);
            });

            $('#addOneEquipment').button().click(function() {
                count = $('#equipCount').val();
                row = '<tr>';
                row = row + '<td><input name="equip[' + count + '][make]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';
                row = row + '<td><input name="equip[' + count + '][model]" type="text" class="ui-widget ui-widget-content ui-corner-all"></td>';   
                row = row + '<td><input name="equip[' + count + '][serial]" type="text" class="equipSerial"></td>';
                row = row + '<td><select name="equip[' + count + '][type_id]" class="ui-widget ui-widget-content ui-corner-all">';
                @foreach($types as $key => $type)
                row = row + '<option value="{{ $key }}">{{ $type }}</option>';
                @endforeach
                row = row + '</select></td>'; 
                row = row + '<td><select name="equip[' + count + '][works_id]" class="ui-widget ui-widget-content ui-corner-all">';
                @foreach($works as $key => $work)
                row = row + '<option value="{{ $key }}">{{ $work }}</option>';
                @endforeach  
                row = row + '</tr>'; 
                $('#equipTable tr:last').after(row);

                $('#equipCount').val($('#equipCount').val() + 1);
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
          minLength: 1,
          select: function( event, ui ) {
                $('#addCustomer').hide();
                $('#customerDetails').html('<a href="{{ url('customer') }}/' + ui.item.id + '">' + ui.item.name + '</a><br />' +
                                                ui.item.phone + '<br />' +
                                                ui.item.mobile + '<br />' +
                                                ui.item.email + '<br />' +
                                                ui.item.address + '<br />' +
                                                ui.item.postcode + '<br />');
                
                $('#job_customer_id').val(ui.item.id);
                $('#order_customer_id').val(ui.item.id);
                $('#equipment_customer_id').val(ui.item.id);
                $('#customer').val(ui.item.name);

                jobs = '';
                if(ui.item.jobs.length > 0) {
                    // set up header and table
                    jobs = '<h3>Work Log</h3><div class="table-responsive"><table>';
                    jobs = jobs + '<tr><th>Job#</th><th>Status</th><th>Logged Date</th><th>Type</th><th>Equipment</th><th>Description</th></tr>';

                    //loop throught data
                    for(i = 0; i < ui.item.jobs.length; ++i){
                        jobs = jobs + '<tr>';
                        jobs = jobs + '<td><a href="{{ url('work') }}/' + ui.item.jobs[i].id + '">' + ui.item.jobs[i].id + '</a></td>';
                        jobs = jobs + '<td>' + ui.item.jobs[i].status['name'] + '</td>';
                        
                        logged = new Date(ui.item.jobs[i].created_at);
                        var yyyy = logged.getFullYear().toString();                                    
                        var mm = (logged.getMonth()+1).toString(); // getMonth() is zero-based         
                        var dd  = logged.getDate().toString(); 

                        jobs = jobs + '<td>' + (dd[1]?dd:"0"+dd[0]) + '/' + (mm[1]?mm:"0"+mm[0]) + '/' + yyyy + '</td>';

                        if(ui.item.jobs[i].equipments.length > 0){
                            jobs = jobs + '<td>';
                            for(e = 0; e < ui.item.jobs[i].equipments.length; ++e) {
                                jobs = jobs + ui.item.jobs[i].equipments[e].equip_type['name'] + '<br />';
                            }
                            jobs = jobs + '</td>'
                        }
                        if(ui.item.jobs[i].equipments.length > 0){
                            jobs = jobs + '<td>';
                            for(e = 0; e < ui.item.jobs[i].equipments.length; ++e) {
                                if(ui.item.jobs[i].equipments[e].us == '1'){
                                    jobs = jobs + '<span class="us">';
                                }

                                jobs = jobs + ui.item.jobs[i].equipments[e].make;
                                jobs = jobs + ui.item.jobs[i].equipments[e].model;
                                jobs = jobs + ui.item.jobs[i].equipments[e].serial;

                                if(ui.item.jobs[i].equipments[e].us == '1'){
                                    jobs = jobs + '</span>';
                                }
                                jobs = jobs + '<br />';
                            }
                            jobs = jobs + '</td>'
                        }
                        jobs = jobs + '<td>' + ui.item.jobs[i].description + '</td>';
                        jobs = jobs + '</tr>';
                    }

                    //close table
                    jobs = jobs + '</table></div>';
                }

                orders = '';
                if(ui.item.orders.length > 0) {
                    // set up header and table
                    orders = '<h3>Orders</h3><div class="table-responsive"><table>';
                    orders = orders + '<tr><th>Order#</th><th>Part#</th><th>Name</th><th>Status</th></tr>';

                    //loop throught data
                    for(i = 0; i < ui.item.orders.length; ++i) {
                        
                        if(ui.item.orders[i].items.length > 0){
                            for(itm = 0; itm < ui.item.orders[i].items.length; ++itm) {
                                orders = orders + '<tr>';
                                orders = orders + '<td><a href="{{ url('orders') }}/' + ui.item.orders[i].id + '">' + ui.item.orders[i].id + '</td>';
                                orders = orders + '<td>' + ui.item.orders[i].items[itm].part_number + '</td>';
                                orders = orders + '<td>' + ui.item.orders[i].items[itm].name + '</td>';
                                orders = orders + '<td>' + ui.item.orders[i].items[itm].status['name'] + '</td>';
                                orders = orders + '</tr>';
                            }
                        }
                        
                    }

                    //close table
                    orders = orders + '</table></div>';
                }

                equipment = '';
                if(ui.item.equipment.length > 0) {
                    equipment = '<h3>Equipment</h3><div class="table-responsive"><table>';
                    equipment = equipment + '<tr><th>Type</th><th>Make</th><th>Model</th><th>Serial</th></tr>'
                    for(index = 0; index < ui.item.equipment.length; ++index) {

                        equipment = equipment + '<tr>';
                        equipment = equipment + '<td>' + ui.item.equipment[index].equip_type.name + '</td>';
                        equipment = equipment + '<td><a href="{{ url('equipment') }}/' + ui.item.equipment[index].id + '">' + ui.item.equipment[index].make + '</a></td>';
                        equipment = equipment + '<td><a href="{{ url('equipment') }}/' + ui.item.equipment[index].id + '">' + ui.item.equipment[index].model + '</a></td>';
                        equipment = equipment + '<td><a href="{{ url('equipment') }}/' + ui.item.equipment[index].id + '">' + ui.item.equipment[index].serial + '</a></td>';
                        equipment = equipment + '</tr>';
                        
                        row = '<tr>';
                        row = row + '<td><input name="equipOld[' + index + '][id]" type="checkbox" value="' + ui.item.equipment[index].id + '">' + ui.item.equipment[index].make + '</td>';
                        row = row + '<td>' + ui.item.equipment[index].model + '</td>';   
                        row = row + '<td>' + ui.item.equipment[index].serial + '</td>';
                        row = row + '<td>' + ui.item.equipment[index].equip_type.name + '</td>';  
                        row = row + '<td><select name="equipOld[' + index + '][works_id]" class="ui-widget ui-widget-content ui-corner-all">';
                        @foreach($works as $key => $work)
                        row = row + '<option value="{{ $key }}">{{ $work }}</option>';
                        @endforeach  
                        row = row + '</tr>'; 
                        $('#workAddTable tr:first').after(row); 

                        
                    }
                    //add row for current equipment
                    equipment = equipment + '</table></div>';
                }
                $('#previousWork').html('<h2>Previous Information</h2>' + jobs + orders + equipment)
                //add current jobs and orders
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

                        $('#job_customer_id').val(data.id);
                        $('#order_customer_id').val(data.id);
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

        $('#workDialog').dialog({
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
                        $('#form-new-work').submit();
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

        $('#form-new-work').submit(function(e)
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
                        $('#work-error').html(e);
                        $('#work-error').addClass("bg-danger text-danger")
                    }else{
                        $('#workDialog').dialog("close");
                        $('#addOrder').hide();
                        $('#addEquipment').hide();

                        html = '<h2>Current Information</h2><h3>Log Work</h3><div>Job Number: ' + data.id + '</div><div>' + data.description + '</div>';
                        html = html + '<div class="table-responsive"><table>';
                        html = html + '<tr><th>Make</th><th>Model</th><th>Serial</th><th>Type</th><th>Work Required</th></tr>';

                        works = {{ json_encode($works); }}

                        var row = '';
                        for(var i = 0; i < data.equipments.length; i++) {
                            if(!$('#eItem' + data.equipments[i].id).length){
                                row = row + '<tr id="eItem' + data.equipments[i].id + '" >';
                                row = row + '<td>' + data.equipments[i].make + '</td>';
                                row = row + '<td>' + data.equipments[i].model + '</td>';   
                                row = row + '<td>' + data.equipments[i].serial + '</td>';
                                row = row + '<td>' + data.equipments[i].equip_type.name + '</td>';  
                                row = row + '<td>' + works[data.equipments[i].pivot.works_id] + '</td>';  
                                row = row + '</tr>';
                            }
                            
                        }
                        html = html + row + '</table></div>';
                        $('#currentWork').html(html);

                        //handle if form is resubmitted
                        //set Job_id within form
                        $('#job_id').val(data.id);
                        //clear form
                        $('#workTable :input').val("");
                        //all equipment will be returned so table needs to be fixed so that duplicates are not shown
                    }
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails   
                    $('#workDialog').dialog("open");   
                }
            });
            e.preventDefault(); //STOP default action
            //e.unbind(); //unbind. to stop multiple form submit.
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
                        $('#addWork').hide();
                        $('#addEquipment').hide();

                        $('#orderNumber').html("Order Number: " + data.id);

                        html = '<h2>Current Information</h2><h3>Order Parts</h3><div>Order Number: ' + data.id + '</div>';
                        html = html + '<div class="table-responsive"><table>';
                        html = html + '<tr><th>Part#</th><th>Name</th><th>Ordered</th></tr>';

                        var row = '';
                        for(var i = 0; i < data.items.length; i++) {
                            if(!$('#oItem' + data.items[i].id).length){
                                row = row + '<tr id="oItem' + data.items[i].id + '" >';
                                row = row + '<td>' + data.items[i].part_number + '</td>';
                                row = row + '<td>' + data.items[i].name + '</td>';   
                                row = row + '</tr>';
                            }
                        }

                        html = html + row + '</table></div>';
                        $('#currentWork').html(html);

                        //handle if form is resubmitted
                        //set order_id within form
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
            //e.unbind(); //unbind. to stop multiple form submit.
        });
    
        $('#equipmentDialog').dialog({
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
                        $('#form-new-equipment').submit();
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

        $('#form-new-equipment').submit(function(e)
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
                    $('#equipmentDialog').dialog("close");
                    $('#addOrder').hide();
                    $('#addWork').hide();
                    $('#addEquipment').hide();

                    html = '<h2>Current Information</h2><h3>New Equipment</h3>';
                    html = html + '<div class="table-responsive"><table>';
                    html = html + '<tr><th>Make</th><th>Model</th><th>Serial</th><th>Type</th></tr>';

                    row = '<tr>';
                    row = row + '<td>' + data.make + '</td>';
                    row = row + '<td>' + data.model + '</td>';   
                    row = row + '<td>' + data.serial + '</td>';
                    row = row + '<td>' + data.equip_type.name + '</td>';   
                    row = row + '</tr>';

                    html = html + row + '</table></div>';
                        $('#currentWork').html(html);
                    //clear form
                    $('#itemTable :input').val("");
                    //all equipment will be returned so table needs to be fixed so that duplicates are not shown
                    
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    //if fails   
                    $('#equipmentDialog').dialog("open");   
                }
            });
            e.preventDefault(); //STOP default action
           // e.unbind(); //unbind. to stop multiple form submit.
        });

    });

</script>
@stop