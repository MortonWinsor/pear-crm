@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>Reports</h1>
    </div>
    <div class="col-lg-6">
        <h2>{{ link_to_route('reports.users', 'Hours Worked') }}</h2>

        <div class="table-responsive">
            <table>
                <tr>
                    <th>
                        Username
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Hours
                    </th>
                    <th>
                        Number of equipment
                    </th>
                </tr>
                @if(count($users))
                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->username }}
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($user->status_date)) }}
                            </td>
                            <td>
                                {{ $user->total }}
                            </td>
                            <td>
                                {{ $user->equip }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <h2>Jobs in Each Status</h2>

        <div class="table-responsive">
            <table>
                <tr>
                    <th>
                        Status
                    </th>
                    <th>
                        Total
                    </th>
                </tr>
                @if(count($status))
                    @foreach($status as $stat)
                        <tr>
                            <td>
                                {{ $stat->name }}
                            </td>
                            <td>
                                {{ $stat->total }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        <h2>Equipment Requiring Service</h2>

        <div class="responsive-table work">
            <table style="width:100%;">
                <tr>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Serial</th>
                    <th>Last Service</th>
                </tr>
                @foreach($service as $equip)
                    <tr>
                        <td>{{ link_to_route('customer.show', $equip->customer->name, array($equip->customer->id)) }}</td>
                        <td>{{{ $equip->equip_type->name }}}</td>
                        <td>{{ link_to_route('equipment.show', $equip->make, array($equip->id)) }}</td>
                        <td>{{ link_to_route('equipment.show', $equip->model, array($equip->id)) }}</td>
                        <td>{{ link_to_route('equipment.show', $equip->serial, array($equip->id)) }}</td>
                        <td>{{{ date('d/m/Y', strtotime($equip->last_serviced)) }}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
  	</div>
</div>

@stop