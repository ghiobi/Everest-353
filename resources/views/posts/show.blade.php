@extends('layouts.app')

@section('content')
    <div class="container section">
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong> {{ Session::get('success') }}</a>.
            </div>
        @endif
        <div class="row mb-1">
            <div class="col-md-8">
                <div class="media">
                    <a class="media-left" href="/user/{{ $post->poster->id }}">
                        <img class="media-object rounded-circle" src="{{ $post->poster->avatarUrl(45) }}" width="45">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading" style="font-size: 14px">Hosted By</h4>
                        {{ $post->poster->fullName() }}
                    </div>
                </div>
                <div class="tag-container">
                    <div class="tag tag-default">{{ ($post->postable_type == \App\LocalTrip::class)? 'Local' : 'Long Distance'}}</div>
                    <div class="tag tag-info">{{ ($post->one_time)? 'One Time' : 'Frequent'}}</div>
                    <small>Posted {{ $post->created_at->diffForHumans() }}</small>
                </div>
                <h2>{{ $post->name }}</h2>
                <p class="lead mb-0">{{ $post->description }}</p>
                <div>
                    Departure: {{ $post->departure_pcode }} | Destination: {{ $post->destination_pcode }} | Max riders: {{ $post->num_riders }}
                </div>
                @if($post->postable_type != \App\LocalTrip::class)
                    <div>From: {{ $post->postable->departure_city }}, {{ $post->postable->departure_province }} | To: {{ $post->postable->destination_city }}, {{ $post->postable->destination_province }}</div>
                @endif
                @if(! $post->one_time)
                    <div>
                            {{ $post->postable->displayFrequency() }}
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                @if($trip)
                    <div class="card h-100">
                        <div class="card-header">
                            Next trip on {{$trip->departure_datetime->toFormattedDateString()}}
                            at {{$trip->departure_datetime->format('h:i:s A')}}
                            with currently {{count($trip->users)}} riders.
                        </div>
                        <div class="card-block ">
                            <p class="text-xs-center" style="font-size: 32px">Now for {{ $post->cost() }}</p>
                            <form action="/trip/{{ $trip->id }}/join" method="post">
                                {{ csrf_field() }}
                                @if(count($errors)> 0)
                                    @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                    @endforeach
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
                        <div class="vcontainer">
                            <div class="valign">
                                <h4 class="card-title">Oh no...</h4>
                                <p class="card-text">Looks like we weren't able to find the next trip! It coult be expired or contact support for help!</p>
                                <a href="/home" class="btn btn-primary">Find another trip!</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-block">
                @if(count($post->messages) > 0)
                    @foreach($post->messages as $message)
                        <div class="media" @if(! $loop->last && count($post->messages) > 1) style="margin-bottom: 10px;" @endif>
                            <a class="media-left" href="/user/{{ $message->sender->id }}">
                                <img class="media-object rounded-circle" src="{{ $message->sender->avatarUrl(45) }}" width="45">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading" style="font-size: 14px">{{ $message->sender->fullName() }} <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small></h4>
                                {{ $message->body }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="section text-xs-center">
                        <h3>No messages.</h3>
                        <p class="lead mb-0">Be first to comment!</p>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <form action="/post/{{ $post->id }}/message" method="post">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="body">
                        <span class="input-group-btn">
                             <button class="btn btn-outline-info" type="submit">Comment</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection