@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <a href="/user/{{ $user->id }}">Back to profile.</a>
            <h1 class="display-4">Your Profile</h1>
            <p class="lead">Show your true self!</p>
        </div>
    </div>
    <div class="container section">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Success!</strong> {{ Session::get('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-9">
                <h3 class="mb-1">Profile info</h3>
                <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <input type="hidden" name="_request" value="profile">
                    <div class="form-group row{{ ($errors->has('first_name'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__first_name">First Name</label>
                        <div class="col-xs-10">
                            <input class="form-control" id="form__first_name" type="text" value="{{ $user->first_name }}" name="first_name">
                            @if($errors->has('first_name'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('first_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ ($errors->has('last_name'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__last_name">Last Name</label>
                        <div class="col-xs-10">
                            <input class="form-control" id="form__last_name" type="text" value="{{ $user->last_name }}" name="last_name">
                            @if($errors->has('last_name'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('last_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ ($errors->has('timezone'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__timezone">Tiemzone</label>
                        <div class="col-xs-10">
                            <input class="form-control" id="form__timezone" type="text" value="{{ $user->timezone }}" name="timezone">
                            @if($errors->has('timezone'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('timezone') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ ($errors->has('birth_date'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__birth_date">Brithday</label>
                        <div class="col-xs-10">
                            <div class="input-group">
                                <input class="form-control" id="form__birth_date" type="text" value="{{ $user->birth_date }}" name="birth_date">
                                <span class="input-group-addon">
                                    <input type="hidden" name="is_visible_birth_date" value="0">
                                    <input type="checkbox" name="is_visible_birth_date" {{ ($user->is_visible_birth_date)? 'checked' : '' }} value="1">
                                </span>
                            </div>
                            @if($errors->has('birth_date'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('birth_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ ($errors->has('address'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__address">Address</label>
                        <div class="col-xs-10">
                            <div class="input-group">
                                <input class="form-control" id="form__address" type="text" value="{{ $user->address }}" name="address">
                                <span class="input-group-addon">
                                    <input type="hidden" name="is_visible_address" value="0">
                                    <input type="checkbox" name="is_visible_address" {{ ($user->is_visible_address)? 'checked' : '' }}  value="1">
                                </span>
                            </div>
                            @if($errors->has('address'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ ($errors->has('license_num'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__license_num">Licence Number</label>
                        <div class="col-xs-10">
                            <div class="input-group">
                                <input class="form-control" id="form__license_num" type="text" value="{{ $user->license_num }}" name="license_num">
                                <span class="input-group-addon">
                                    <input type="hidden" name="is_visible_license_num" value="0">
                                    <input type="checkbox" name="is_visible_license_num" {{ ($user->is_visible_license_num)? 'checked' : '' }} value="1">
                                </span>
                            </div>
                            @if($errors->has('license_num'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('license_num') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ ($errors->has('policies'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__policies">Policies</label>
                        <div class="col-xs-10">
                            <div class="input-group">
                                <input class="form-control" id="form__policies" type="text" value="{{ (empty($user->policies))? '' : implode(';', $user->policies) }}" name="policies">
                                <span class="input-group-addon">
                                    <input type="hidden" name="is_visible_policies" value="0">
                                    <input type="checkbox" name="is_visible_policies" {{ ($user->is_visible_policies)? 'checked' : '' }} value="1">
                                </span>
                            </div>
                            @if($errors->has('policies'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('policies') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ ($errors->has('external_email'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__external_email">External Email</label>
                        <div class="col-xs-10">
                            <div class="input-group">
                                <input class="form-control" id="form__external_email" type="text" value="{{ $user->external_email }}" name="external_email">
                                <span class="input-group-addon">
                                    <input type="hidden" name="is_visible_external_email" value="0">
                                    <input type="checkbox" name="is_visible_external_email" {{ ($user->is_visible_external_email)? 'checked' : '' }} value="1">
                                </span>
                            </div>
                            @if($errors->has('external_email'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('external_email') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ ($errors->has('avatar'))? ' has-danger' : '' }}">
                        <label class="col-xs-2 col-form-label" for="form__avatar">Avatar</label>
                        <div class="col-xs-10">
                            <input type="file" id="form__avatar" accept="image/*" name="avatar">
                            <div class="form-control-feedback">
                                @if($user->avatar)
                                    <img src="{{ url('images/' . $user->avatar . '?w=50') }}" alt="">
                                @endif
                                <span>Optional, 300 by 300 minimum, 5MB max</span>
                            </div>
                            @if($errors->has('avatar'))
                                <span class="form-control-feedback">{{ $errors->first('avatar') }}</span>
                            @endif
                        </div>
                        @if($user->avatar)
                            <img src="{{ url('images/' . $user->avatar . '?w=90') }}" alt="">
                        @endif
                    </div>
                    <div class="clearfix">
                        <button class="btn btn-primary float-xs-right" type="submit">Update!</button>
                    </div>
                </form>
                <h3 class="mt-2 mb-1">Change Password</h3>
                <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <input type="hidden" name="_request" value="password">
                    <div class="form-group row">
                        <label class="col-xs-2 col-form-label">Password</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="password" name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-2 col-form-label">Confirm</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="password" name="password_confirmation">
                        </div>
                    </div>
                    <div class="clearfix">
                        <button class="btn btn-primary float-xs-right" type="submit">Change!</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <h3>Need Help?</h3>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A architecto, corporis dignissimos eaque eius, et facere impedit ipsam laudantium molestias natus quam sunt totam vel veritatis! Doloribus ex quod ut.</p>
            </div>
        </div>
    </div>
@endsection