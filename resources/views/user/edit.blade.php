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
                <table class="profile-edit-table">
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                @include('components.input-text', [
                                    'name' => 'first_name',
                                    'label' => 'First Name',
                                    'value' => $user->first_name,
                                    'errors' => $errors
                                ])
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>

                                @include('components.input-text', [
                                    'name' => 'last_name',
                                    'label' => 'Last Name',
                                    'value' => $user->last_name,
                                    'errors' => $errors
                                ])
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                @include('components.input-text', [
                                    'name' => 'timezone',
                                    'label' => 'Time Zone',
                                    'value' => $user->timezone,
                                    'errors' => $errors
                                ])
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
                                    <input type="hidden" name="is_visible_birth_date" value="0">
                                    <input type="checkbox" id="switch-1" class="mdl-switch__input"
                                           {{ ($user->is_visible_birth_date)? 'checked ' : '' }}name="is_visible_birth_date" value="1">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            </td>
                            <td>

                                @include('components.input-text', [
                                    'name' => 'birth_date',
                                    'label' => 'Birth Date',
                                    'value' => $user->birth_date->toDateString(),
                                    'errors' => $errors,
                                    'class' => 'datepicker'
                                ])

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
                                    <input type="hidden" name="is_visible_address" value="0">
                                    <input type="checkbox" id="switch-2" class="mdl-switch__input"
                                           {{ ($user->is_visible_address)? 'checked ' : '' }}name="is_visible_address"
                                           value="1">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            </td>
                            <td>
                                @include('components.input-text', [
                                    'name' => 'address',
                                    'label' => 'Address',
                                    'value' => $user->address,
                                    'errors' => $errors
                                ])
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-3">
                                    <input type="hidden" name="is_visible_license_num" value="0">
                                    <input type="checkbox" id="switch-3" class="mdl-switch__input"
                                           {{ ($user->is_visible_license_num)? 'checked ' : '' }}name="is_visible_license_num"
                                           value="1">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            </td>
                            <td>
                                @include('components.input-text', [
                                    'name' => 'license_num',
                                    'label' => 'License Number',
                                    'value' => $user->license_num,
                                    'errors' => $errors
                                ])
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-4">
                                    <input type="hidden" name="is_visible_policies" value="0">
                                    <input type="checkbox" id="switch-4" class="mdl-switch__input"
                                           {{ ($user->is_visible_policies)? 'checked ' : '' }}name="is_visible_policies"
                                           value="1">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            </td>
                            <td>
                                @include('components.input-text', [
                                    'name' => 'policies',
                                    'label' => 'Policies (Separate policies with a semicolon)',
                                    'value' => (empty($user->policies))? '' : implode(';', $user->policies),
                                    'errors' => $errors
                                ])
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-5">
                                    <input type="hidden" name="is_visible_external_email" value="0">
                                    <input type="checkbox" id="switch-5" class="mdl-switch__input"
                                           {{ ($user->is_visible_external_email)? 'checked ' : '' }}name="is_visible_external_email"
                                           value="1">
                                    <span class="mdl-switch__label"></span>
                                </label>
                            </td>
                            <td>
                                @include('components.input-text', [
                                    'name' => 'external_email',
                                    'label' => 'External Email',
                                    'value' => $user->external_email,
                                    'errors' => $errors
                                ])
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="_request" value="profile">

                @if($user->avatar)
                    <img src="{{ url('images/' . $user->avatar . '?w=90') }}" alt="">
                @endif
                <div class="mdl-textfield mdl-js-textfield{{ ($errors->has('avatar'))? ' is-invalid' : '' }} mdl-textfield--floating-label fwidth">
                    <input type="file" class="mdl-textfield__input " id="form__avatar" name="avatar" accept="image/*">
                    <label class="mdl-textfield__label label-input--fixed" for="form__avatar" >Avatar (optional, 300 by 300 minimum, 5MB max)</label>
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