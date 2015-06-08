@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>Historic Work</h1>
        <div class="row">
             <div class="col-sm-6">
                {{ Form::open(array('route' => 'work.history', 'method' => 'GET')) }}
                <div class="row">
                    <div class="col-sm-3">{{ Form::label('q', 'Job Number:') }} </div>
                    <div class="col-sm-4">{{ Form::text('q', $q) }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-3">{{ Form::label('start', 'Start date:') }}</div>
                    <div class="col-sm-4">{{ Form::text('start', $start, array('id' => 'start')) }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-3">{{ Form::label('end', 'End Date:') }}</div>
                    <div class="col-sm-4">{{ Form::text('end', $end, array('id' => 'end')) }}</div>
                </div>
                {{ Form::Submit('Search', array('class' => 'btn btn-info')) }} 
                {{ Form::close() }}
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
                @foreach($history as $job)
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

    </div>
</div>

<script type="text/javascript">
    $(function() {
        $( "#start" ).datepicker( { dateFormat: "dd/mm/yy", setDate: "{{ date('d/m/Y', strtotime('-3months', time())) }}" });
        $( "#end" ).datepicker( { dateFormat: "dd/mm/yy", setDate: "{{ date('d/m/Y', time()) }}"});
    });

</script>
@stop