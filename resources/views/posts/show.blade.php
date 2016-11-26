@extends('layouts.app')

@section('content')
    <div class="container section">
        <div class="row mb-1">
            <div class="col-md-8">
                <h2>{{ $post->name }}</h2>
                <p class="lead">{{ $post->description }}</p>
                <p class="mb-1">
                    Departure: {{ $post->departure_pcode }} | Destination: {{ $post->destination_pcode }} | Max riders: {{ $post->num_riders }}
                </p>
            </div>
            <div class="col-md-4">
                @if($trip)
                    <div class="card h-100">
                        <div class="card-header">
                            Next trip at ... with currently 0 riders.
                        </div>
                        <div class="card-block ">
                            <p class="text-xs-center" style="font-size: 32px">Now for {{ $post->cost() }}</p>
                            <form action="/trip/{{ $trip->id }}/join" method="post">
                                @if(count($errors)> 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors as $error)
                                                {{ $error }}
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-check">
                                        <label class="form-check-label">
                                        <input type="hidden" name="confirm" value="0">
                                        <input type="checkbox" class="form-check-input" name="confirm" value="1">
                                        <small>By Checking this you agree to the terms and the cost of this trip.</small>
                                    </label>
                                </div>
                                <button class="btn btn-info btn-block" type="submit">
                                    Join
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card card-block text-xs-center card h-100">
                        <h4 class="card-title">Oh no...</h4>
                        <p class="card-text">Looks like we weren't able to find the next trip! Contact support for help!</p>
                        <a href="/home" class="btn btn-primary">Find another trip!</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="card text-xs-center">
                @if(count($post->messages) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($post->messages as $message)
                            <li class="list-group-item">
                                <img src="{{ $message->sender->avatarUrl(30) }}" width="35" class="img-fluid rounded-circle" alt="">
                                {{ $message->sender->fullName() }} {{ $message->body }}
                                <small class="float-xs-right">{{ $message->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="section">
                        <h3>No messages.</h3>
                        <p class="lead">Be first to comment!</p>
                    </div>
                @endif
            <div class="card-footer">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                             <button class="btn btn-outline-info" type="submit">Comment</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection