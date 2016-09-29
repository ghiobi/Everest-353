@extends('layouts.auth')

@section('content')
    <div class="mdl-card mdl-shadow--3dp fwidth">
        <div class="mdl-card__title padding-bottom--0">
            <h2 class="mdl-card__title-text">Login</h2>
        </div>
        <div class="mdl-card__supporting-text padding-top--0">
            <form role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
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
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect margin-bottom--15" for="form__remember">
                    <input type="checkbox" id="form__remember" class="mdl-checkbox__input" name="remember">
                    <span class="mdl-checkbox__label">Remember Me</span>
                </label>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Login
                </button>
            </form>
        </div>
    </div>
    <div class="auth-more-info">
        <a class="pull-right" href="{{ url('/password/reset') }}">
            Forgot Your Password?
        </a>
        <a href="/register">
            Create Account
        </a>
    </div>
@endsection
