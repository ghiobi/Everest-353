@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>Have a conversation in real time.</h1>
            <p class="lead">Be happy.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Your conversations.</h3>
                @if(count($conversations) > 0)
                    <ul class="list-group">
                        @foreach($conversations as $conversation)
                            <li class="list-group-item">
                                <a href="/conversation/{{ $conversation->id }}">With ->
                                @foreach($conversation->users as $user)
                                    @if(Auth::user()->id != $user->id)
                                        {{ $user->fullName() }}.
                                    @endif
                                @endforeach
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="section text-xs-center">
                        <h3>No conversations.</h3>
                        <p class="lead mb-0">Make a conversations now! <i class="fa fa-arrow-circle-o-right"></i></p>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <h4>Create a conversation with...</h4>
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form action="/conversation" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Select a person!</label>
                        <select name="with" id="" class="form-control">
                            @foreach($users as $user)
                                @if(Auth::user()->id != $user->id)
                                    <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-outline-primary btn-block" type="submit">Make Chat!</button>
                </form>
            </div>
        </div>
    </div>
@endsection