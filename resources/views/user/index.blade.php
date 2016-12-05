@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>Users</h1>
            <p class="lead">Manage Users and Statistics</p>
        </div>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Balance
                    </th>
                    <th>
                        Rating
                    </th>
                    <th>
                        Number of Posts
                    </th>
                    <th>
                        Number of Trips
                    </th>
                    <th>
                        Joined
                    </th>
                    <th>
                        Activity
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <img class="img-fluid rounded-circle" src="{{ $user->avatarUrl(35) }}" alt="" width="35">
                            <a href="/user/{{ $user->id }}"><span>{{ $user->fullName() }}</span></a>
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $user->balance() }}
                        </td>
                        <td>
                            {{ $user->getRating() }}
                        </td>
                        <td>
                            {{ $user->posts()->count() }}
                        </td>
                        <td>
                            {{ $user->rides()->count() + $user->hosts()->count() }}
                        </td>
                        <td>
                            {{ $user->created_at }}
                        </td>
                        <td>
                            @if($user->updated_at->diffInMonths(\Carbon\Carbon::now()) < 3)
                                <small>Had activity {{ $user->updated_at->diffForHumans() }}.</small>
                            @else
                                <small>Inactive more than 3 months.</small>
                            @endif
                        </td>
                        <td>
                            <a href="/user/{{ $user->id }}/edit" class="btn btn-primary btn-sm">Edit</a>
                            @if(Auth::user()->hasRole('admin'))
                                <form class="d-inline" action="/user/{{ $user->id }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('patch') }}
                                    <input type="hidden" name="_request" value="suspend">
                                    <button class="btn btn-warning btn-sm">{{ ($user->is_suspended)? 'Unsuspend' : 'Suspend' }}</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection