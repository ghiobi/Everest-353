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
                                <div>{{$user->posts->count()}}</div>
                                <div>posts</div>
                            </div>
                            <div class="col-xs">
                                <div>{{$user->rides()->count()}}</div>
                                <div>trips</div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Active, logged in {{ $user->updated_at->diffForHumans() }}.</li>
                        @if($user->external_email && $user->is_visible_external_email)
                            <li class="list-group-item">
                                {{ $user->external_email }}
                            </li>
                        @endif
                        @if($user->address && $user->is_visible_address)
                            <li class="list-group-item">
                                {{ $user->address }}
                            </li>
                        @endif
                        @if($user->license_num && $user->is_visible_license_num)
                            <li class="list-group-item">
                                {{ $user->license_num }}
                            </li>
                        @endif
                        @if($user->birth_date && $user->is_visible_birth_date)
                            <li class="list-group-item">
                                {{ $user->birth_date->toFormattedDateString() }}
                            </li>
                        @endif
                        @if($user->policies && $user->is_visible_policies)
                            <li class="list-group-item">
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
                    <div class="card">
                        <div class="card-block">
                            <div class="card-title">
                                <a href="/post/{{$post->id}}"><h4 class="card-title">{{$post->name}}</h4></a>
                                <h6 class="card-subtitle text-muted">Departure: {{ $post->departure_pcode }} | Destination: {{ $post->destination_pcode }} | Max riders: {{ $post->num_riders }}</h6>
                            </div>
                            <p class="card-text">{{$post->description}}</p>
                            @if(canEdit($user->id))
                                <a href="/post/{{$post->id}}/edit" class="btn btn-outline-info">Update</a>
                                <a href="#" class="delete btn btn-outline-danger"><i class="fa fa-trash"></i> Delete</a>
                                <form action="/post/{{$post->id}}/" method="post" style="display: none">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection