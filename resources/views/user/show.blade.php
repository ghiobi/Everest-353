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
                                <div>44</div>
                                <div>posts</div>
                            </div>
                            <div class="col-xs">
                                <div>1</div>
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
                                    <span class="badge">{{ $policy }}</span>
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
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Posts</h4>
                        <h6 class="card-subtitle text-muted">Support card subtitle</h6>
                    </div>
                    <div class="card-block">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Reviews</h4>
                        <h6 class="card-subtitle text-muted">Support card subtitle</h6>
                    </div>
                    <div class="card-block">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection