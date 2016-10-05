@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-card__title padding-bottom--0">
            <h1 class="mdl-card__title-text">Mail Inbox</h1>
        </div>
        <div class="mdl-card__supporting-text padding-top--0">
            @if(!empty($messages))
                @foreach($messages as $message)
                    <p>
                        <img src="{{ url( 'images/' . (($message->sender->avatar) ? $message->sender->avatar . '?w=50' : 'dummy_avatar.jpg')) }}" alt="" style="max-width: 50px">
                        {{ $message->sender->first_name . ' ' . $message->sender->last_name }}
                    </p>
                    <p>{{$message->created_at->diffForHumans()}} - Said: {{ $message->body }}</p>
                    <p>
                        <form role="form" method="GET" action="{{ url('/mail/compose') }}">
                            <input type="hidden" name="recipient_id" value="{{$message->sender->id}}"/>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                                Reply
                            </button>
                        </form>
                    </p>
                @endforeach
            @else
                <p>
                    Your inbox is empty.
                </p>
            @endif
        </div>
    </div>
@endsection