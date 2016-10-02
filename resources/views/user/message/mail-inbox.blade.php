@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div>
            <h1>Mail Inbox</h1>
            @foreach($messages as $message)
                <p>
                    <img src="{{ url( 'images/' . (($message->sender->avatar) ? $message->sender->avatar . '?w=50' : 'dummy_avatar.jpg')) }}" alt="" style="max-width: 50px">
                    {{ $message->sender->first_name . ' ' . $message->sender->last_name }}
                </p>
                <p>Said: {{ $message->body }}</p>
            @endforeach
        </div>
    </div>
@endsection