@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h2>Hours Worked in the Last 6 Weeks</h2>

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
    
</div>

@stop