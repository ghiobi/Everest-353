@extends('layouts.app')

@section('content')
    <div class="container section">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img class="card-img-top img-fluid" src="{{ $user->avatarUrl(340) }}" alt="">
                    <div class="card-block">
                        <h4 class="card-title text-xs-center">{{ $user->first_name . ' ' . $user->last_name }}</h4>
                        <div class="row flex-items-xs-between text-xs-center">
                            <div class="col-xs">
                                <div>{{$user->getRating()}}</div>
                                <div>rating</div>
                            </div>
                            <div class="col-xs">
                                <div>{{$user->posts()->count() }}</div>
                                <div>posts</div>
                            </div>
                            <div class="col-xs">
                                <div>{{$user->rides()->count() + $user->hosts()->count() }}</div>
                                <div>trips</div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-muted">
                            <small>Active, had activity {{ $user->updated_at->diffForHumans() }}.</small>
                        </li>
                        @if($user->external_email && $user->is_visible_external_email)
                            <li class="list-group-item">
                                {{ $user->external_email }}
                            </li>
                        @endif
                        @if($user->address && $user->is_visible_address)
                            <li class="list-group-item" data-toggle="tooltip" data-placement="bottom" title="Address">
                                {{ $user->address }}
                            </li>
                        @endif
                        @if($user->license_num && $user->is_visible_license_num)
                            <li class="list-group-item" data-toggle="tooltip" data-placement="bottom" title="License">
                                {{ $user->license_num }}
                            </li>
                        @endif
                        @if($user->birth_date && $user->is_visible_birth_date)
                            <li class="list-group-item" data-toggle="tooltip" data-placement="bottom" title="Birthday">
                                {{ $user->birth_date->toFormattedDateString() }}
                            </li>
                        @endif
                        @if($user->policies && $user->is_visible_policies)
                            <li class="list-group-item" data-toggle="tooltip" data-placement="bottom" title="Policies">
                                @foreach($user->policies as $policy)
                                    <span class="tag tag-default">{{ $policy }}</span>
                                @endforeach
                            </li>
                        @endif
                    </ul>
                    <div class="card-block">
                        <a href="{{ url('mail/compose?recipient_id=' . $user->id) }}" class="card-link">Send Message</a>
                        @if(Auth::user()->id == $user->id || Auth::user()->hasRole('admin'))
                            <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="card-link">Edit Profile</a>
                        @endif
                    </div>
                </div>
                @if(Auth::user()->id == $user->id || Auth::user()->hasRole('admin'))
                    <ul class="list-group">
                        @if(count($old_posts) > 0)
                            <li class="list-group-item">
                                <h5 class="font-weight-light">Old Posts</h5>
                                @foreach($old_posts as $old_post)
                                    <div class="sidebar-item">
                                        <a class="d-block" href="/post/{{$old_post->id}}">{{$old_post->name}}</a>
                                    </div>
                                @endforeach
                            </li>
                        @endif
                        @if(count($old_trips) > 0)
                            <li class="list-group-item">
                                <h5 class="font-weight-light">Old Trips</h5>
                                @foreach($old_trips as $old_trip)
                                    <div class="sidebar-item">
                                        <small class="text-muted">{{ $old_trip->status() }}</small>
                                        <a class="d-block" href="/trip/{{$old_trip->id}}">{{$old_trip->name}}</a>
                                    </div>
                                @endforeach
                            </li>
                        @endif
                        @if(count($old_hosts) > 0)
                            <li class="list-group-item">
                                <h5 class="font-weight-light">Old Hosted Trips</h5>
                                @foreach($old_hosts as $old_host)
                                    <div class="sidebar-item">
                                        <small class="text-muted">{{ $old_host->status() }}</small>
                                        <a class="d-block" href="/trip/{{$old_host->id}}">{{$old_host->name}}</a>
                                    </div>
                                @endforeach
                            </li>
                        @endif
                        @if(count($old_hosts) == 0 && count($old_trips) == 0 && count($old_posts) == 0)
                            <li class="list-group-item">
                                <h5 class="font-weight-light text-xs-center mb-0">No Archive <i class="fa fa-archive"></i></h5>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
            <div class="col-md-9">
                @if(count($user->posts) == 0)
                    <table class="h-100 w-100">
                        <tbody>
                            <tr>
                                <td class="align-middle text-xs-center">
                                    <h3>This user has no posts. <i class="fa fa-frown-o"></i></h3>
                                    <p class="text-muted">Maybe one day.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
                @foreach($user->posts as $post)
                    <div class="card mb-1">
                        <div class="card-block">
                            <div><small>Posted {{ $post->created_at->diffForHumans() }}</small></div>
                            <h4 class="card-title"><a href="/post/{{ $post->id }}">{{ $post->name }}</a>
                            </h4>
                            <p class="card-text">{{ substr($post->description, 0, 260) . ((strlen($post->description) > 160)? '...' : '') }}</p>
                            <div>
                                S: {{ $post->departure_pcode }} | E: {{ $post->destination_pcode }} |
                                {{ $post->cost() }} | <i class="fa fa-comments-o"></i> {{ count($post->messages) }} |
                                Max riders: {{ $post->num_riders }} |
                                <a href="#"><i  class="fa fa-map" data-toggle="modal" data-target="#post-modal-{{$loop->index}}"></i></a>
                                <div class="modal fade" id="post-modal-{{$loop->index}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <iframe class="w-100" height="360" src="//www.google.com/maps/embed/v1/directions?origin={{ $post->departure_pcode }}&destination={{ $post->destination_pcode }}&key=AIzaSyCgfUnLm9_WaYa9hov9l8z4dhVdUuQ6nRg"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($post->postable_type != \App\LocalTrip::class)
                                <div>From: {{ $post->postable->departure_city }}, {{ $post->postable->departure_province }} | To: {{ $post->postable->destination_city }}, {{ $post->postable->destination_province }}</div>
                            @endif
                            <div>
                                @if(! $post->one_time)
                                    @if($post->postable_type == \App\LocalTrip::class)
                                        {{ $post->postable->displayFrequency() }}
                                    @else
                                        {{ $post->postable->displayFrequency() }}
                                    @endif
                                @endif
                            </div>
                            <div class="tag-container">
                                <div class="tag tag-default">{{ ($post->postable_type == \App\LocalTrip::class)? 'Local' : 'Long Distance'}}</div>
                                <div class="tag tag-info">{{ ($post->one_time)? 'One Time' : 'Frequent'}}</div>
                            </div>
                        </div>
                        @if(canEdit($user->id))
                            <div class="card-footer">
                                <a href="/post/{{$post->id}}/edit" class="btn btn-outline-info">Update</a>
                                <a href="#" class="delete btn btn-outline-danger"><i class="fa fa-trash"></i> Delete</a>
                                <form action="/post/{{$post->id}}/" method="post" style="display: none">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection