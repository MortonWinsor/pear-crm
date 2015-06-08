@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-lg-12">
        <h1>All Users</h1>
        <div class="row">
            <div class="col-sm-4">
                {{ link_to_route('users.create', 'Add New User', null, array('class' => 'btn btn-info')) }}
            </div>
        </div>
    @if($users->count())    
        <div class="responsive-table work">
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ link_to_route('users.show', $user->username, array($user->id)) }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
    	<div class="row">
        	<div class="col-sm-3">
        		There are no users on the system
        	</div>
        </div>
    @endif
    </div>
</div>

@stop