@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-card__title padding-bottom--0">
            <h1 class="mdl-card__title-text">Mail Sent</h1>
        </div>
        <div class="mdl-card__supporting-text padding-top--0">
            @if(!empty($messages))
                @foreach($messages as $message)
                    <p>
                        <img src="{{ url( 'images/' . (($message->messageable->avatar) ? $message->messageable->avatar . '?w=50' : 'dummy_avatar.jpg')) }}" alt="" style="max-width: 50px">
                        {{ $message->messageable->first_name . ' ' . $message->messageable->last_name }}
                    </p>
                    <p>
                        {{$message->created_at->diffForHumans()}} - You sent: {{ $message->body }}
                    </p>
                @endforeach
            @else
                <p>
                    You did not send any messages.
                </p>
            @endif
        </div>
    </div>
@endsection