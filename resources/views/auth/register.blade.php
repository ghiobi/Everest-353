@extends('layouts.auth')

@section('content')
    <div class="mdl-card mdl-shadow--3dp fwidth">
        <div class="mdl-card__title padding-bottom--0">
            <h2 class="mdl-card__title-text">Register</h2>
        </div>
        <div class="mdl-card__supporting-text padding-top--0">
            <form role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                @include('components.input-text', [
                    'name' => 'first_name',
                    'label' => 'First Name',
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'last_name',
                    'label' => 'Last Name',
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'email',
                    'label' => 'Email',
                    'errors' => $errors
                ])
                <div class="mdl-textfield mdl-js-textfield{{ ($errors->has('password'))? ' is-invalid' : '' }} mdl-textfield--floating-label fwidth">
                    <input type="password" class="mdl-textfield__input " id="form__password" name="password">
                    <label class="mdl-textfield__label " for="form__password" >Password</label>
                    @if($errors->has('password'))
                        <span class="mdl-textfield__error">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mdl-textfield mdl-js-textfield{{ ($errors->has('password'))? ' is-invalid' : '' }} mdl-textfield--floating-label fwidth">
                    <input type="password" class="mdl-textfield__input " id="form__password_confirmation" name="password_confirmation">
                    <label class="mdl-textfield__label " for="form__password_confirmation" >Confirm Password</label>
                    @if($errors->has('password_confirmation'))
                        <span class="mdl-textfield__error">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Register
                </button>
            </form>
        </div>
    </div>
    <div class="auth-more-info">
        <a href="/">
            Go Back Home
        </a>
        <a class="pull-right" href="/login">
            Already have an account?
        </a>
    </div>
@endsection
