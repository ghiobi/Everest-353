@extends('layouts.app')

@section('content')
    <div class="page-title mdl-color--grey-200">
        <h1 class="mdl-typography--text-center">Login</h1>
    </div>
    <div class="section">
        <div class="mdl-grid">
            <div class="mdl-cell--12-col-tablet mdl-cell--4-col mdl-cell--4-offset-desktop">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    @include('components.input-text', [
                        'name' => 'email',
                        'label' => 'Email',
                        'errors' => $errors
                    ])
                    <div class="mdl-textfield mdl-js-textfield{{ ($errors->has('password'))? ' is-invalid' : '' }} mdl-textfield--floating-label full-width">
                        <input type="password" class="mdl-textfield__input " id="form__password" name="password">
                        <label class="mdl-textfield__label " for="form__password" >Password</label>
                        @if($errors->has('password'))
                            <span class="mdl-textfield__error">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mbottom-10" for="form__remember">
                        <input type="checkbox" id="form__remember" class="mdl-checkbox__input" name="remember">
                        <span class="mdl-checkbox__label">Remember Me</span>
                    </label>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                        Login
                    </button>
                    <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" href="{{ url('/password/reset') }}">
                        Forgot Your Password?
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
