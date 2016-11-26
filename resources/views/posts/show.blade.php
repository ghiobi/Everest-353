@extends('layouts.app')

@section('content')
    <div class="container section">
        <div class="row">
            <div class="col-md-8">
                <h2>{{ $post->name }}</h2>
                <p class="lead">{{ $post->description }}</p>
                <span>
                    Departure: {{ $post->departure_pcode }} | Destination: {{ $post->destination_pcode }} | Max riders: {{ $post->num_riders }}
                </span>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        Next trip at ... with currently 0 riders.
                    </div>
                    <div class="card-block ">
                        <p class="text-xs-center" style="font-size: 32px">Now for {{ $post->cost() }}</p>
                        <form action="">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input">
                                    <small>By Checking this you agree to the terms and the cost of this trip.</small>
                                </label>
                            </div>
                            <button class="btn btn-info btn-block">
                                Join
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card text-xs-center">
            <div class="card-header">
                Comments
            </div>
            <ul class="list-group list-group-flush">
                @if($post->messages as $message)
                    <li class="list-group-item">{{ $message->body }}</li>
                @else
                    <li class="list-group-item">Cras justo odio</li>
                @endif
            </ul>
            <div class="card-footer">

            </div>
        </div>
    </div>
@endsection