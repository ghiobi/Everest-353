@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>Trips</h1>
            <p class="lead">Manage Trip</p>
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
                        Number of Riders
                    </th>
                    <th>
                        Message Count
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(count($trips) > 0)
                    @foreach($trips as $trip)
                        <tr>
                            <td>
                                <a href="/trip/{{ $trip->id }}">{{ $trip->name }}</a>
                            </td>
                            <td>
                                {{ count($trip->users) }}
                            </td>
                            <td>
                                {{ count($trip->messages) }}
                            </td>
                            <td>
                                {{ $trip->status() }}
                            </td>
                            <td>
                                @if(empty($trip->arrival_datetime))
                                    <form action="/trip/{{ $trip->id }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('patch') }}
                                        <button class="card-link btn btn-sm btn-outline-warning btn-block">
                                            Force Complete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-xs-center">
                        <td colspan="5">
                            <div class="section">
                                <h4>No trips... <i class="fa fa-frown-o"></i></h4>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection