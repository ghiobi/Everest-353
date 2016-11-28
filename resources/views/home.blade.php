@extends('layouts.app')

@section('content')
    <div class="container section">
        <h1 class="display-4 mb-2">
            Hello! {{ Auth::user()->fullName() }}
        </h1>
        <div class="card mb-2">
            <div class="card-block p-1" style="background-color: #f3f3f3;">
                <form action="" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" name="postal_start" placeholder="Postal Code Start" value="{{ $search['postal_start'] }}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="postal_end" placeholder="Postal Code Destination" value="{{ $search['postal_end'] }}">
                    </div>
                    <div class="form-group">
                        <select name="radius" id="" class="form-control" title="Radius">
                            @for ($i = 5; $i <= 50; $i += 5)
                                <option value="{{ $i }}"{{ ($search['radius'] == $i)? ' selected' : ''}}>{{ $i }} KM</option>
                            @endfor
                        </select>
                    </div>
                    <label class="form-check-inline">
                        <input class="form-check-input" type="radio" name="type" value="0"{{ (request()->type != 0)? '' : ' checked' }}> Any
                    </label>
                    <label class="form-check-inline">
                        <input class="form-check-input" type="radio" name="type" value="1"{{ (request()->type != 1)? '' : ' checked' }}> Local
                    </label>
                    <label class="form-check-inline">
                        <input class="form-check-input" type="radio" name="type" value="2"{{ (request()->type != 2)? '' : ' checked' }}> Long Distance
                    </label>
                    <button class="btn btn-primary float-xs-right" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="card-deck">
                    @foreach($posts as $post)
                        <div class="card card-post mb-1">
                            <div class="card-block">
                                <div><small>Posted {{ $post->created_at->diffForHumans() }}</small></div>
                                <h4 class="card-title"><a href="/post/{{ $post->id }}">{{ $post->name }}</a>
                                </h4>
                                <p class="card-text">{{ substr($post->description, 0, 160) . ((strlen($post->description) > 160)? '...' : '') }}</p>
                                <div>S: {{ $post->departure_pcode }} | E: {{ $post->destination_pcode }} | {{ $post->cost() }} |
                                    <i class="fa fa-comments-o"></i> {{ count($post->messages) }} | <i class="fa fa-car" aria-hidden="true"></i>: {{ $post->num_riders }}</div>
                                <div class="tag-container">
                                    <div class="tag tag-default tag-trip">{{ ($post->postable_type == \App\LocalTrip::class)? 'Local' : 'Long Distance'}}</div>
                                    <div class="tag tag-info">{{ ($post->one_time)? 'One Time' : 'Frequent'}}</div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="media">
                                    <a class="media-left" href="/user/{{ $post->poster->id }}">
                                        <img class="media-object rounded-circle" src="{{ $post->poster->avatarUrl(45) }}" width="45">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading" style="font-size: 14px">Hosted By</h4>
                                        {{ $post->poster->fullName() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Found {{ count($posts) }} results.</small>
            </div>
            <div class="col-md-3">
                <ul class="list-group">
                    @if(count($current_trips) > 0)
                        <li class="list-group-item">
                            <h5 class="font-weight-light">Current Trips</h5>
                            @foreach($current_trips as $current_trip)
                                <div class="sidebar-item">
                                    <small class="text-muted">{{ $current_trip->status() }}</small>
                                    <a class="d-block" href="/trip/{{$current_trip->id}}">{{$current_trip['post']['name']}}</a>
                                </div>
                            @endforeach
                        </li>
                    @endif
                    @if(count($posted_trips)> 0)
                        <li class="list-group-item">
                            <h5 class="font-weight-light">Hosting Trips</h5>
                            @foreach($posted_trips as $posted_trip)
                                <div class="sidebar-item">
                                    <small class="text-muted">{{ $posted_trip->status() }}</small>
                                    <a class="d-block" href="/trip/{{$posted_trip->id}}">{{$posted_trip['post']['name']}}</a>
                                </div>
                            @endforeach
                        </li>
                    @endif
                    <li class="list-group-item">
                        <h5 class="font-weight-light">Notifications</h5>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="jumbotron mb-0">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Get to know your country!</h5>
                    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci asperiores aut dicta dolore et illo illum ipsum minima nemo nisi optio perferendis quidem quos ratione sunt ut vitae, voluptatum.</p>
                    <a href="#">Learn More</a>
                </div>
            </div>
        </div>
    </div>
@endsection
