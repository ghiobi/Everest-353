@extends('layouts.auth')

<!-- Main Content -->
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="mdl-card mdl-shadow--3dp fwidth" style="min-height: auto">
        <div class="mdl-card__title padding-bottom--0">
            <h2 class="mdl-card__title-text">Reset Password</h2>
        </div>
        <div class="mdl-card__supporting-text padding-top--0">
            <form role="form" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}
                @include('components.input-text', [
                    'name' => 'email',
                    'label' => 'Email',
                    'errors' => $errors
                ])
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Send Password Reset Link
                </button>
            </form>
        </div>
    </div>
@endsection
