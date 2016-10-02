@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Compose Message</div>

                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ url('/mail') }}">
                            {{ csrf_field() }}
                            @include('components.input-text', [
                                    'name' => 'recipient_id',
                                    'label' => 'Recipient ID',
                                    'errors' => $errors,
                                    'value' => $recipient_id
                            ])
                            @include('components.input-text', [
                                    'name' => 'body',
                                    'label' => 'Body',
                                    'errors' => $errors
                            ])
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                                Send
                            </button>
                        </form>
                    </div>

                    @include('components.success-notification')
                </div>
            </div>
        </div>
    </div>
@endsection
