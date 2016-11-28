@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">{{ $trip->name }}</h1>
            <p class="lead">{{ $trip->description }}</p>
            <a href="/post/{{ $trip->post_id }}">Back to original post.</a>
        </div>
    </div>
    <div class="container section">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Trip Info <span class="tag tag-default">{{ $trip->status() }}</span>
                    </div>
                    <div class="card-block">
                        <div class="media">
                            <a class="media-left" href="/user/{{ $trip->host->id }}">
                                <img class="media-object rounded-circle" src="{{ $trip->host->avatarUrl(45) }}" width="45">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading" style="font-size: 14px">Hosted By</h4>
                                {{ $trip->host->fullName() }}
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <ul class="pl-1">
                                <li>Departure: {{ $trip->departure_datetime }}</li>
                                <li>Departure Address: {{ $trip->departure_pcode }}</li>
                                <li>Arrival: {{ ($trip->arrival_datetime)? $trip->arrival_datetime : '' }}</li>
                                <li>Arrival Address: {{ $trip->arrival_pcode }} </li>
                                <li>Cost: {{ $trip->cost() }}</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <h6 class="font-weight-normal mb-1">Riders:</h6>
                            @foreach($trip->users as $user)
                                <div @if(! $loop->last && count($trip->users) > 1) style="margin-bottom: 5px;" @endif>
                                    <div class="media">
                                        <a class="media-left" href="#">
                                            <img class="img-fluid rounded-circle mr-1" src="{{ $user->avatarUrl(45) }}" width="45" alt="">
                                        </a>
                                        <div class="media-body">
                                            <div>{{ $user->fullName() }}</div>
                                            @if($user->pivot->rating != null)
                                                <div class="ratings">
                                                    @for($i = 0; $i < $user->pivot->rating; $i++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </li>
                        @if(Auth::user()->id != $trip->post->poster->id)
                            <li class="list-group-item">
                                @if($trip->isRider(Auth::user())->pivot->rating == null)
                                        <form action="/trip/{{$trip->id}}/rate" method="post">
                                            {{ csrf_field() }}
                                            <h5 class="font-weight-normal mb-1">Rate your trip!</h5>
                                            <div class="form-group">
                                                <select name="rating">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                                @if($errors->has('rating'))
                                                    <div class="form-control-feedback">
                                                        {{ $error->first('rating') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <button class="btn btn-outline-info btn-block">
                                                Submit!
                                            </button>
                                        </form>
                                        <script>
                                            $(function(){
                                                $('select[name="rating"]').barrating({
                                                    theme: 'fontawesome-stars'
                                                });
                                            });
                                        </script>
                                @else
                                    <div class="text-xs-center">
                                        <h5 class="font-weight-normal" style="margin-bottom: 5px">Thanks for rating!</h5>
                                    </div>
                                @endif
                            </li>
                        @endif

                        @if(Auth::user()->id == $trip->post->poster->id && empty($trip->arrival_datetime))
                            <li class="list-group-item">
                                <form action="/trip/{{ $trip->id }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('patch') }}
                                    <button class="card-link btn btn-outline-warning btn-block">
                                        Complete Trip
                                    </button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Message Board
                    </div>
                    <div class="card-block">
                        @if(count($trip->messages) > 0)
                            @foreach($trip->messages as $message)
                                <div class="media" @if(! $loop->last && count($trip->messages) > 1) style="margin-bottom: 10px;" @endif>
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
                                <h4>No group messages? <i class="fa fa-frown-o"></i></h4>
                                <p class="lead mb-0">Get to know each other because it's going to be a ride!</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <form action="/trip/{{ $trip->id }}/message" method="post">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <textarea name="body" rows="3" class="form-control" placeholder="Drop a message..."></textarea>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary h-100">Send!</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection