@extends('layouts.app')

@section('content')
    <div class="container section">
        <h1 class="display-4 mb-2">
            Hello {{ Auth::user()->fullName() }}!
        </h1>
        @if(App\Setting::find('public_announcement')->value != '')
            <div class="alert alert-warning" role="alert">
                <h2>
                    Public Announcement:
                </h2>
                <p>
                    {{App\Setting::find('public_announcement')->value}}
                </p>
            </div>
        @endif
        <div class="card mb-2">
            <div class="card-block p-1" style="background-color: #f3f3f3;">
                <form action="" class="form-inline">
                    <div class="form-group{{ ($errors->has('postal_start')? ' has-danger' : '' ) }}">
                        <input type="text" class="form-control" name="postal_start" placeholder="Postal Code Start (eg. A0A 1A1)" value="{{ $search['postal_start'] }}" required pattern="[A-z]\d[A-z]\s?(\d[A-z]\d)?$" maxlength="7">
                        @if($errors->has('postal_start'))
                            <div class="form-control-feedback">
                                {{ $errors->first('postal_start') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('postal_end')? ' has-danger' : '' ) }}">
                        <input type="text" class="form-control" name="postal_end" placeholder="Postal Code Destination (eg. A0A 1A1)" value="{{ $search['postal_end'] }}" pattern="[A-z]\d[A-z]\s?(\d[A-z]\d)?$" maxlength="7">
                        @if($errors->has('postal_end'))
                            <div class="form-control-feedback">
                                {{ $errors->first('postal_end') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <select name="radius" id="" class="form-control" title="Radius" required>
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
                                <div>
                                @if($post->postable_type == \App\LocalTrip::class)
                                    S: {{ $post->departure_pcode }} | E: {{ $post->destination_pcode }} |
                                @endif
                                    {{ $post->cost() }} | <i class="fa fa-comments-o"></i> {{ count($post->messages) }} | <i class="fa fa-car" aria-hidden="true"></i>: {{ $post->num_riders }} |
                                    <a href="#"><i  class="fa fa-map" data-toggle="modal" data-target="#post-modal-{{$loop->index}}"></i></a>
                                    <div class="modal fade" id="post-modal-{{$loop->index}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <iframe class="w-100" height="360" src="https://www.google.com/maps/embed/v1/directions?origin={{ $post->departure_pcode }}&destination={{ $post->destination_pcode }}&key=AIzaSyCgfUnLm9_WaYa9hov9l8z4dhVdUuQ6nRg"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($post->postable_type != \App\LocalTrip::class)
                                    <div>
                                        S: {{ $post->postable->departure_city }}, {{ $post->postable->departure_province }} | E: {{ $post->postable->destination_city }}, {{ $post->postable->destination_province }}
                                    </div>
                                @endif
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
                                    <a class="d-block" href="/trip/{{$current_trip->id}}">{{$current_trip->name}}</a>
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
                                    <a class="d-block" href="/trip/{{$posted_trip->id}}">{{$posted_trip->name}}</a>
                                </div>
                            @endforeach
                        </li>
                    @endif
                    <li class="list-group-item">
                        <h5 class="font-weight-light">Notifications</h5>
                        @foreach($notifications as $notification)
                            <div class="sidebar-item notifications">
                                <a href="{{ $notification->data['url'] }}">{{ $notification->data['message'] }}</a>
                            </div>
                        @endforeach
                        @if(count($notifications) == 0)
                            <small class="text-muted">No notifications.</small>
                        @else
                            <form action="/notifications/clear" method="post" class="">
                                {{ csrf_field() }}
                                <button class="btn btn-sm btn-danger">
                                    Clear <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        @endif
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
