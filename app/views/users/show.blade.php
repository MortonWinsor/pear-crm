@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>User Details</h1>
        <div class="row">
            <div class="col-sm-3">
                {{ link_to_route('users.index', 'List Customers') }}
            </div>
            <div class="col-sm-3 col-sm-offset-3">
                {{ link_to_route('users.edit', 'Edit', array($user->id), array('class' => 'btn btn-info')) }}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                Username:
            </div>
            <div class="col-sm-3">
                {{{ $user->username }}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                Email:
            </div>
            <div class="col-sm-3">
                {{{ $user->email }}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                Role:
            </div>
            <div class="col-sm-3">
                {{{ $user->role->name }}}
            </div>
        </div>
    </div>
        @if($work->count())
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
                    </tr>
                    
                    @foreach($work as $job)
                        <tr>
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
                        </tr>
                    @endforeach
                    
                </table>
            </div>
        @endif
</div>

@stop