@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
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
                @foreach($equipment as $equip)
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