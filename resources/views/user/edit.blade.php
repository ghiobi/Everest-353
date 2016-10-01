@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        @include('components.success-notification')
    </div>
    <div class="mdl-grid">
        <div class="fwidth">
            <a href="{{ route('user.show', ['user' => $user->id]) }}">Back to Profile</a>
            <h3>Update Profile Info</h3>
            <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="_request" value="profile">
                @include('components.input-text', [
                    'name' => 'first_name',
                    'label' => 'First Name',
                    'value' => $user->first_name,
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'last_name',
                    'label' => 'Last Name',
                    'value' => $user->last_name,
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'timezone',
                    'label' => 'Time Zone',
                    'value' => $user->timezone,
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'birth_date',
                    'label' => 'Birth Date',
                    'value' => $user->birth_date,
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'address',
                    'label' => 'Address',
                    'value' => $user->address,
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'license_num',
                    'label' => 'License Number',
                    'value' => $user->license_num,
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'policies',
                    'label' => 'Policies',
                    'value' => (empty($user->policies))? '' : implode(';', $user->policies),
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'external_email',
                    'label' => 'External Email',
                    'value' => $user->external_email,
                    'errors' => $errors
                ])
                @if($user->avatar)
                    <img src="{{ url('images/' . $user->avatar . '?w=90') }}" alt="">
                @endif
                <div class="mdl-textfield mdl-js-textfield{{ ($errors->has('avatar'))? ' is-invalid' : '' }} mdl-textfield--floating-label fwidth">
                    <input type="file" class="mdl-textfield__input " id="form__avatar" name="avatar" accept="image/*">
                    <label class="mdl-textfield__label label-input--file" for="form__avatar" >Avatar (optional, 300 by 300 minimum, 5MB max)</label>
                    @if($errors->has('avatar'))
                        <span class="mdl-textfield__error">{{ $errors->first('avatar') }}</span>
                    @endif
                </div>
                <button type="submit">Update Profile Info</button>
            </form>
            <h3>UPDATE PASSWORD</h3>
            <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="_request" value="password">
                <div class="mdl-textfield mdl-js-textfield{{ ($errors->has('password'))? ' is-invalid' : '' }} mdl-textfield--floating-label fwidth">
                    <input type="password" class="mdl-textfield__input " id="form__password" name="password">
                    <label class="mdl-textfield__label " for="form__password" >Password</label>
                    @if($errors->has('password'))
                        <span class="mdl-textfield__error">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mdl-textfield mdl-js-textfield{{ ($errors->has('password_confirmation'))? ' is-invalid' : '' }} mdl-textfield--floating-label fwidth">
                    <input type="password" class="mdl-textfield__input " id="form__password_confirmation" name="password_confirmation">
                    <label class="mdl-textfield__label " for="form__password_confirmation" >Confirm Password</label>
                    @if($errors->has('password_confirmation'))
                        <span class="mdl-textfield__error">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <button type="submit">Update Password</button>
            </form>
        </div>
    </div>
@endsection