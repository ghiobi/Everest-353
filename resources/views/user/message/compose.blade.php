@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-card__title padding-bottom--0">
            <h1 class="mdl-card__title-text">Compose Message</h1>
        </div>
        <div class="mdl-card__supporting-text padding-top--0">
            <form role="form" method="POST" action="{{ url('/mail') }}">
                {{ csrf_field() }}
                @include('components.input-text', [
                        'name' => 'recipient_id',
                        'label' => 'Recipient ID',
                        'errors' => $errors,
                        'value' => $recipient_id
                ])
                @include('components.input-textarea', [
                        'name' => 'body',
                        'label' => 'Body',
                        'errors' => $errors
                ])
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Send
                </button>
            </form>
        </div>
    </div>
@endsection