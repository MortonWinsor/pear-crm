@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-sm-5">
        <h1>Work Details for Job #{{{ $job->id }}}</h1>
        
    </div>
    <div class="col-sm-2">
        {{ link_to('#', 'Engineers Report', array('class' => 'btn btn-info', 'id' => 'engineerButton')) }}
    </div>
    <div class="col-sm-1">
        {{ link_to_route('work.edit', 'Edit', array($job->id), array('class' => 'btn btn-info', 'id' => 'edit')) }}
    </div>
    <div class="col-sm-2">
        {{ link_to('#', 'Add Equipment', array('class' => 'btn btn-info', 'id' => 'addEquipment')) }}
    </div>
    <div class="col-sm-2">
        @if($job->status_id == '1')
            {{ link_to_action('JobsController@getCompleted', 'Work Completed', array('id' => $job->id, 'b' => 's'), array('class' => 'btn btn-info')) }}
            {{ link_to_action('JobsController@getWaiting', 'Waiting Parts', array('id' => $job->id, 'b' => 's'), array('class' => 'btn btn-info')) }}
        @elseif($job->status_id == '2')
            {{ link_to_action('JobsController@getContacted', 'Customer Contacted', array('id' => $job->id, 'b' => 's'), array('class' => 'btn btn-info')) }}
        @elseif($job->status_id == '3')
            {{ link_to_action('JobsController@getPaid', 'Move to History', array('id' => $job->id, 'b' => 's'), array('class' => 'btn btn-info')) }}
        @elseif($job->status_id == '5')
            {{ link_to_action('JobsController@getStarted', 'Work Restarted', array('id' => $job->id, 'b' => 's'), array('class' => 'btn btn-info')) }}
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="row">
            <div class="col-sm-12">
                <h3>Customer Details</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                Name:
            </div>
            <div class="col-sm-3">
                {{ $job->customer == '' ? '' : $job->customer->name }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                Phone:
            </div>
            <div class="col-sm-3">
                {{ $job->customer == '' ? '' : $job->customer->phone }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                Mobile:
            </div>
            <div class="col-sm-3">
                {{ $job->customer == '' ? '' : $job->customer->mobile }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                Email: 
            </div>
            <div class="col-sm-3">
                {{ $job->customer == '' ? '' : $job->customer->email }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                Address:
            </div>
            <div class="col-sm-3">
                {{ $job->customer == '' ? '' : $job->customer->address }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                Postcode:
            </div>
            <div class="col-sm-3">
                {{ $job->customer == '' ? '' : $job->customer->postcode }}
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-sm-12">
                <h3>Work Details</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                Logged Date:
            </div>
            <div class="col-sm-6">
                {{{ date('d/m/Y', strtotime($job->created_at)) }}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                Status:
            </div>
            <div class="col-sm-6">
                {{{ $job->status['name'] }}}
            </div>
        </div>
        @if($job->status_date != '0000-00-00 00:00:00')
        <div class="row">
            <div class="col-sm-3">
                Status Changed:
            </div>
            <div class="col-sm-6">
                {{{ date('d/m/Y', strtotime($job->status_date)) }}}
            </div>
        </div>
        @endif
        <div class="row">
        	<div class="col-sm-3">
        		Description:
        	</div>
        	<div class="col-sm-6">
        		{{{ $job->description }}}
        	</div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                Notes:
            </div>
            <div class="col-sm-6">
                {{{ $job->notes }}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                Equipment: 
            </div>
            <div class="col-sm-9">
               @if($job->equipments != '')
                    @foreach($job->equipments as $equip) 
                        @if($equip->us == '1')
                            {{ '<span class="us">' }}
                        @endif
                        {{ $equip->make . "<br />" . $equip->model . "<br />" . $equip->serial . "<br />" . $equip->equip_type->name . "<br />" }}
                        {{ $equip->pivot->works_id == '0' ? '' : $equip->pivot->work->name . '<br />' }}
                        Time working on machine: {{ $equip->pivot->time }}hours
                        {{ $equip->pivot->user_id == '0' ? '' :  "<br />by " . $equip->pivot->user->username }}
                        <br />
                        {{ $equip->pivot->notes }}
                        @if($equip->pivot->notes != '' )
                            <br />
                        @endif
                        @if($equip->us == '1')
                            {{ '</span>' }}
                        @endif
                        @if(Auth::user()->role_id < 3)
                        {{ link_to('#', 'Edit Equipment', array('class' => 'btn btn-info btn-xs edit-equipment', 'id' => 'edit-' . $equip->id, 'data-equipment-id' => $equip->id))  }}
                        <br />
                        {{ link_to_route('ajax.job.removed', 'Remove Equipment', array('id' => $job->id, 'eid' => $equip->id), array('class' => 'btn btn-info btn-xs')) . "<br /><br />"  }}
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="row">
            <div class="col-sm-12">
                <h3>Parts</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table id="engineerTable">
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Order Part
                    </th>
                    @if(Auth::user()->role_id < 3)
                    <th>
                    </th>
                    @endif
                </tr>
                @if($job->equipments != '')
                    @foreach($job->equipments as $equip)
                        @if($equip->parts != '')
                            <tr><td colspan="2">Parts for {{ $equip->make . ' ' . $equip->model . ' ' . $equip->serial  }}</td></tr>
                            @foreach($equip->parts as $part)
                                @if($part->job_id == $job->id)
                                <tr>
                                    <td>
                                        {{ $part->name }}
                                    </td>
                                    <td>
                                        {{ $part->order == '1' ? 'yes' : 'no' }}
                                    </td>
                                    @if(Auth::user()->role_id < 3)
                                    <td>
                                        {{ link_to_route('ajax.part.removed', 'Remove Part', array('id' => $job->id, 'eid' => $equip->id, 'pid' => $part->id), array('class' => 'btn btn-info btn-xs'))  }}
                                    </td>
                                    @endif
                                </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
    </div>

</div>


<div class="row"  id="engineerDialog">
    <div class="col-lg-12">
        <h1>Engineers Report</h1>
        
        {{ Form::open(array('action' => 'JobsController@postEngineer', 'id' => 'form-new-engineer')) }}
        
        
        <div class="row">
        	<div class="col-sm-4" id="engineer-error">
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
        
        {{ Form::hidden('job_id', $job->id)}}

        <div class="row">
            <div class="col-sm-12">
                {{ Form::label('status_id', "Status:") }} 
            </div>
            <div class="col-sm-12">
                {{ Form::select('status_id', $status, $job->status_id, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{ Form::label('notes', 'General Notes:') }}
            </div>
            <div class="col-sm-12">
                {{ Form::textarea('notes', $job->notes, array('rows' => '4', 'style' => 'width:100%;', 'class' => 'ui-widget ui-widget-content ui-corner-all')) }}
            </div>
        </div>
        
        @if($job->equipments != '')
            @foreach($job->equipments as $equip)
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Details for {{ $equip->make . ' ' . $equip->model . ' ' . $equip->serial }}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        {{ Form::label('time', 'Time working on machine:') }}
                    </div>
                    <div class="col-sm-4">
                        <?php $range = array('0' => '0', '0.5' => '0.5' , '1' => '1' , '1.5' => '1.5' , '2' => '2' , '2.5' => '2.5' , '3' => '3' , '3.5' => '3.5' , '4' => '4' , '4.5' => '4.5' , '5' => '5' , '5.5' => '5.5' , '6' => '6' , '6.5' => '6.5' , '7' => '7' , '7.5' => '7.5' , '8' => '8' , '8.5' => '8.5' , '9' => '9' , '9.5' => '9.5' , '10' => '10' , '10.5' => '10.5' , '11' => '11' , '11.5' => '11.5' , '12' => '12' , '12.5' => '12.5' , '13' => '13' , '13.5' => '13.5' , '14' => '14' , '14.5' => '14.5' , '15' => '15' , '15.5' , '16' => '16'); ?>
                        {{ Form::select('equip['.$equip->id.'][time]', $range, $equip->pivot->time, array('class' => 'spinner')) }}
                    </div>
                    <div class="col-sm-4">
                        {{ Form::label('us', 'Unserviceable:') }}
                        {{ Form::checkbox('equip['.$equip->id.'][us]', '1', $equip->us == '1' ? true : false, array('class' => 'ui-widget ui-widget-content ui-corner-all') ) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        {{ Form::label('user_id', 'Engineer:') }}
                    </div>
                    <div class="col-sm-8">
                        {{ Form::select('equip['.$equip->id.'][user_id]', $users, isset($equip->pivot->user_id) ? $equip->pivot->user_id : Auth::user()->id, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        {{ Form::label('notes', 'Machine Notes:') }}
                    </div>
                    <div class="col-sm-8">
                        {{ Form::textarea('equip['.$equip->id.'][notes]', $equip->pivot->notes, array('rows' => '4', 'style' => 'width:100%;', 'class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>
                                Part Used
                            </th>
                            <th>
                                Part Name
                            </th>
                            <th>
                                Order Part
                            </th>
                        </tr>
                        @foreach($parts as $key => $part)
                            @if((isset($usedParts[$equip->id]) && !in_array($part->id, $usedParts[$equip->id])) || !isset($usedParts[$equip->id]))
                                <tr>
                                    <td>
                                        {{ Form::hidden('part[c'.$equip->id.$key.'][equipment_id]', $equip->id ) }}
                                        {{ Form::checkbox('part[c'.$equip->id.$key.'][name]', $part->part, false, array('class' => 'ui-widget ui-widget-content ui-corner-all') ) }}
                                    </td>
                                    <td>
                                        {{ Form::label('part[c'.$equip->id.$key.'][name]', $part->part) }}
                                    </td>
                                    <td>
                                        {{ Form::checkbox('part[c'.$equip->id.$key.'][order]', '1', false, array('class' => 'ui-widget ui-widget-content ui-corner-all') ) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            @endforeach
        @endif
        <?php $count = 0; ?>
        <div class="row">
            <div class="col-sm-6">
                <h3>Extra Parts</h3>
            </div>
            <div class="row">
            <div class="col-sm-6">
                {{ link_to('#', 'Add Another Part', array('class' => 'btn btn-info', 'id' => 'addOnePart')) }}
            </div>
        </div>
        </div>
        <div class="table-responsive">
            <table id="engineerAddTable">      
                <tr>
                    <td>

                        @if(count($equips) > 1)
                            {{ Form::select('part['.$count.'][equipment_id]', $equips, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                        @elseif(count($equips) == 1)
                            <?php $keys = array_keys($equips); ?>
                            {{ Form::hidden('part['.$count.'][equipment_id]', $keys[0]) }}
                            <h4>{{ $equips[$keys[0]] }}</h4>
                        @endif
                    </td>
                    <td >
                        {{ Form::text('part['.$count.'][name]') }}
                    </td>
                        <td>
                            {{ Form::checkbox('part['.$count.'][order]', '1', false, array('class' => 'ui-widget ui-widget-content ui-corner-all') ) }}
                        </td>
                </tr>
                <?php $count++; ?>
                {{ Form::hidden('engineerCount', $count, array('id' => 'engineerCount')) }}
            </table>
        </div>

        {{ Form::close() }}
    </div>
</div>

<div id="equipmentDialog" class="row">
    <div class="col-lg-12">
        <h1>Equipment Details</h1>
        
        {{ Form::open(array('route' => 'equipment.storemultiple', 'id' => 'form-new-work')) }}
        
        
        <div class="row">
            <div class="col-sm-4" id="equipment-error">
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
        

        {{ Form::hidden('customer_id', $job->customer_id, array('id' => 'job_customer_id')) }}
        {{ Form::hidden('job_id', $job->id, array('id' => 'job_id')) }}

        <div class="row">
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
                @if($job->customer != '' && $job->customer->equipment != '')
                    @foreach($job->customer->equipment as $key => $equip)
                        @if(!in_array($equip->id, $jobEquip))
                            <tr>
                                <td><input name="equipOld[{{ $key }}]" type="checkbox" value="{{ $equip->id }}">{{ $equip->make }}</td>
                                <td>{{ $equip->model }}</td>  
                                <td>{{ $equip->serial }}</td>
                                <td>{{ $equip->equip_type->name }}</td>   
                            </tr> 
                        @endif
                    @endforeach
                @endif
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
                        {{ Form::select('equip[0][type_id]', $types, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                </tr>
                {{ Form::hidden('equipCount', 0, array('id' => 'equipCount', 'class' => 'newEquip ui-widget ui-widget-content ui-corner-all')) }}
            </table>
        </div>

        {{ Form::close() }}
    </div>
</div>

<div id="editEquipmentDialog" class="row">
    <div class="col-lg-12">
        <h1>Equipment Details</h1>
        
        {{ Form::open(array('route' => 'equipment.index', 'id' => 'form-edit-equipment', 'method' => 'PATCH')) }} 
        
        
        <div class="row">
            <div class="col-sm-4" id="editEquipment-error">
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
        

        <div class="table-responsive">
            <table>
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
                        {{ Form::text('make', null, array('id' => 'edit-equipment-make', 'class' => 'newEquip ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::text('model', null, array('id' => 'edit-equipment-model', 'class' => 'newEquip ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::text('serial', null, array('id' => 'edit-equipment-serial', 'class' => 'newEquip ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                    <td>
                        {{ Form::select('type_id', $types, null, array('id' => 'edit-equipment-type', 'class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                    </td>
                </tr>
            </table>
        </div>
        {{ Form::hidden('job_id', $job->id) }}
        {{ Form::close() }}
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('.spinner').spinner();

        $('#addOnePart').button().click(function() {
            count = $('#engineerCount').val();
            row = '<tr>';
            @if(count($equips) > 1)
                row = row + '<td><select name="part[' + count + '][equipment_id]"><?php foreach($equips as $key => $equip) echo '<option value="' . $key . '">' . $equip . '</option>'; ?></select></td>'; 
            @elseif(count($equips) == 1)
                <?php $keys = array_keys($equips); ?>
                row = row + '<td><input name="part[' + count + '][equipment_id]" type="hidden" value="{{ $keys[0] }}"><h4>{{ $equips[$keys[0]] }}</h4></td>';                            
            @endif
               
            row = row + '<td><input name="part[' + count + '][name]" type="text"></td>';
            row = row + '<td><input name="part[' + count + '][order]" type="checkbox" value="1"></td>';
            row = row + '</tr>'; 
            $('#engineerAddTable tr:last').after(row);

            $('#engineerCount').val($('#engineerCount').val() + 1);

        });

        $('#addOneWork').button().click(function() {
            count = $('#workCount').val();
            row = '<tr>';
            row = row + '<td><input name="equip[' + count + '][make]" type="text"></td>';
            row = row + '<td><input name="equip[' + count + '][model]" type="text"></td>';   
            row = row + '<td><input name="equip[' + count + '][serial]" type="text" class="equipSerial"></td>';
            row = row + '<td><select name="equip[' + count + '][type_id]"><option value="0">Lawn Mowers</option><option value="1">Lawn Tractors</option><option value="2">Chainsaws</option><option value="3">Bushcutters</option><option value="4">Blowers</option><option value="5">Hedge Trimmers</option><option value="6">Log Splitters</option></select></td>';   
            row = row + '</tr>'; 
            $('#workAddTable tr:last').after(row);

            $('#workCount').val($('#workCount').val() + 1);
        });

        $('#engineerButton').button().click(function() {
            $('#engineerDialog').dialog("open");
        });
        $('#addEquipment').button().click(function() {
            $('#equipmentDialog').dialog("open");
        });
        $('.edit-equipment').button().click(function() {
            $('#editEquipmentDialog').dialog("open");
            $('#form-edit-equipment').attr('action', $('#form-edit-equipment').attr('action') + '/' + $('#' + this.id).data('equipment-id'));
            //ajax call to get info
            $.ajax({
              url: "{{ action('EquipmentController@getEquipment') }}",
              dataType: "jSon",
              data: {
                id: $('#' + this.id).data('equipment-id')
              },
              success: function( data ) {
                $('#edit-equipment-make').val(data.make);
                $('#edit-equipment-model').val(data.model);
                $('#edit-equipment-serial').val(data.serial);
                $('#edit-equipment-type').val(data.type_id);
              }
            });
        })

        $('#engineerDialog').dialog({
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
                        $('#form-new-engineer').submit();
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

        $('#editEquipmentDialog').dialog({
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
                        $('#form-edit-equipment').submit();
                    },
                },
                {
                    text: "Cancel",
                    click: function() { 
                        $(this).dialog( "close" );
                    },
                }
              ]
        });

    });
</script>
@stop