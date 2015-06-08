@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
          <li role="presentation" class="li-work {{ $tab == 'in' ? 'active' : '' }}" id="li-work-in"><a href="#" id="button-work-in">All Work</a></li>
          <li role="presentation" class="li-work {{ $tab == 'part' ? 'active' : '' }}" id="li-waiting-parts"><a href="#" id="button-waiting-parts">Waiting Parts</a></li>
          <li role="presentation" class="li-work {{ $tab == 'comp' ? 'active' : '' }}" id="li-work-complete"><a href="#" id="button-work-complete">Work Completed</a></li>
        </ul>

        <div id="work-in" class="work row" {{ $tab == 'in' ? '' : 'style="display:none;"' }}>
            <div class="col-sm-12">
                {{ link_to('#', 'filter', array('id' => 'filterLink'))}} / {{ link_to('#', 'search', array('id' => 'searchLink'))}}
            </div>
            <div id="filterDiv" class="col-sm-6">
                {{ Form::open(array('route' => 'work.index', 'method' => 'GET')) }}
                {{ Form::select('f', $types, $filter, array('class' => 'ui-widget ui-widget-content ui-corner-all')) }}
                {{ Form::submit('Filter', array('class' => 'btn btn-info')) }}
                {{ Form::close() }}
            </div>
            
            <div class="col-sm-6" id="searchDiv">
                {{ Form::open(array('route' => 'work.index', 'method' => 'GET')) }}
                {{ Form::text('q', $q) }}
                {{ Form::Submit('Search', array('class' => 'btn btn-info')) }} 
                {{ Form::close() }}
            </div>
        
            <div class="responsive-table">
                <table style="width:100%;">
                    <tr>
                        <th>Job#</th>
                        <th>Status</th>
                        <th>Logged Date</th>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Equipment</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    @if($work_in->count())
                    @foreach($work_in as $job)
                        <tr {{ $job->status_id == '2' ? 'class="blue"' : ($job->status_id == '3' ? 'class="orange"' : '') }} >
                            <td>{{ link_to_route('work.show', $job->id, array($job->id)) }}</td>
                            <td>{{ $job->status['name'] }}</td>
                            <td>{{ date('d/m/Y', strtotime($job->created_at)) }}</td>
                            <td>{{ link_to_route('customer.show', $job->customer != '' ? $job->customer->name : '', array($job->customer_id), array('title' => $job->customer != '' ? $job->customer->phone . ' ' . $job->customer->email : '')) }}</td>
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
                                        @if($equip->us == '1')
                                            {{ '<span class="us">' }}
                                            {{{ $equip->make . " " . $equip->model . " " . $equip->serial  }}}
                                            {{ '</span>' }}
                                        @else
                                            {{{ $equip->make . " " . $equip->model . " " . $equip->serial  }}}
                                        @endif
                                            {{ '<br />' }}
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $job->description }}</td>
                            
                            <td>
                                @if($job->status_id == '1')
                                    {{ link_to_action('JobsController@getCompleted', 'Work Completed', array('id' => $job->id, 'b' => 'l', 'tab' => 'in'), array('class' => 'btn btn-info btn-xs')) }}
                                @elseif($job->status_id == '2')
                                    {{ link_to_action('JobsController@getContacted', 'Customer Contacted', array('id' => $job->id, 'b' => 'l', 'tab' => 'in'), array('class' => 'btn btn-info btn-xs')) }}
                                    {{ link_to_action('JobsController@getPaid', 'History', array('id' => $job->id, 'b' => 'l', 'tab' => 'in'), array('class' => 'btn btn-info btn-xs')) }}
                                @elseif($job->status_id == '3')
                                    {{ link_to_action('JobsController@getPaid', 'Move to History', array('id' => $job->id, 'b' => 'l', 'tab' => 'in'), array('class' => 'btn btn-info btn-xs')) }}
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </table>
            </div>
        </div>

        <div id="waiting-parts" class="responsive-table work" {{ $tab == 'part' ? '' : 'style="display:none;"' }}>
            <table style="width:100%;">
                <tr>
                    <th>Job#</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Equipment</th>
                    <th>Description</th>
                    <th></th>
                </tr>
                @if($waiting_parts->count())
                @foreach($waiting_parts as $job)
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
                        <td>
                            @if($job->status_id == '5')
                                {{ link_to_action('JobsController@getStarted', 'Work Restarted', array('id' => $job->id, 'b' => 'l', 'tab' => 'part'), array('class' => 'btn btn-info btn-xs')) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                @endif
            </table>
        </div>

        <div id="work-complete" class="responsive-table work" {{ $tab == 'comp' ? '' : 'style="display:none;"' }}>
            <table style="width:100%;">
                <tr>
                    <th>Job#</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Equipment</th>
                    <th>Description</th>
                    <th></th>
                </tr>
                @if($work_complete->count())
                @foreach($work_complete as $job)
                    <tr>
                        <td>{{ link_to_route('work.show', $job->id, array($job->id)) }}</td>
                        <td>{{ $job->status['name'] }}</td>
                        <td>{{ $job->customer != '' ? $job->customer->name : '' }}</td>
                        <td>{{ $job->customer != '' ? $job->customer->phone : '' }}</td>
                        <td>{{ $job->customer != '' ? $job->customer->email : '' }}</td>
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
                        <td>
                            @if($job->status_id == '2')
                                {{ link_to_action('JobsController@getContacted', 'Customer Contacted', array('id' => $job->id, 'b' => 'l', 'tab' => 'comp'), array('class' => 'btn btn-info btn-xs')) }}
                            @elseif($job->status_id == '3')
                                {{ link_to_action('JobsController@getPaid', 'Move to History', array('id' => $job->id, 'b' => 'l', 'tab' => 'comp'), array('class' => 'btn btn-info btn-xs')) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                @endif
            </table>
        </div>


    </div>
</div>

<script type="text/javascript">
    $(function() {

        $('#filterDiv').hide();
        $('#searchDiv').hide();

        $( document ).tooltip();

        $('#filterLink').click(function() {
            $('#filterDiv').slideToggle();
        });

        $('#searchLink').click(function() {
            $('#searchDiv').slideToggle();
        });

        $('#button-work-in').button().click(function() {
            $('.work').hide('slide');
            $('#work-in').show('slide');
            $('.li-work').removeClass('active');
            $('#li-work-in').addClass('active');
        });
        $('#button-waiting-parts').button().click(function() {
            $('.work').hide('slide');
            $('#waiting-parts').show('slide');
            $('.li-work').removeClass('active');
            $('#li-waiting-parts').addClass('active');
        });
        $('#button-work-complete').button().click(function() {
            $('.work').hide('slide');
            $('#work-complete').show('slide');
            $('.li-work').removeClass('active');
            $('#li-work-complete').addClass('active');
        });

    });

</script>
@stop