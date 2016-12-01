@extends('layouts.app')

@section('content')
    <div class="jumbotron text-xs-center">
        <div class="container">
            <h1 class="display-1">Settings</h1>
            <p class="lead">System settings are applied immediately.</p>
        </div>
    </div>
    <div class="container section">
        <div class="row flex-items-xs-center">
            <div class="col-md-6">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        <p><strong>Success!</strong> {{ Session::get('success') }}</p>
                    </div>
                @endif

                @if(count($errors)> 0)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                @foreach($settings as $setting)
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">{{ $setting->display_name }}</h4>
                            <p>{{ $setting->description }}</p>
                            <form action="/setting/{{ $setting->key }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="value" value="{{ $setting->value }}" >
                                        <span class="input-group-btn">
                                            <button class="btn btn-warning" type="submit">Update!</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection