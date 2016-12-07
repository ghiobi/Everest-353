@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4">
                Compose a message to someone.
            </h1>
            <p class="lead">Getting in touch!</p>
        </div>
    </div>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mail">Mail Inbox</a></li>
            <li class="breadcrumb-item"><a href="/mail/sent">Mail Sent</a></li>
            <li class="breadcrumb-item active">Compose Message</li>
        </ol>
        <div class="row">
            <div class="col-sm-6">
                <form action="/mail" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Recipient</label>
                        <select name="recipient_id" class="form-control" required>
                            @foreach ($all_users as $user)
                                @if ($user->id == Auth::user()->id)
                                    @continue
                                @endif
                                <option value="{{$user->id}}" @if ($recipient != null && $user->id == $recipient->id) selected @endif>
                                    {{$user->first_name}} {{$user->last_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="form__body">Your Message</label>
                        <textarea class="form-control" id="form__body" rows="5" name="body" placeholder="Drop a message..." minlength="1"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Send!</button>
                </form>
            </div>
        </div>
    </div>
@endsection