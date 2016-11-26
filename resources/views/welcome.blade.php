@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>Drive more. Together</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet, commodi debitis doloribus eligendi excepturi explicabo id inventore iure maiores modi necessitatibus obcaecati odio quasi quibusdam quis, rem tempora vel voluptates!</p>
                </div>
                <div class="col-md-4">
                    <div class="card auth-tabs">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs float-xs-left">
                                <li class="nav-item">
                                    <a class="nav-link" href="#login">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#register">Register</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-block">
                            <div class="card-text" id="login" style="display: none">
                                <form action="/login" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ ($errors->has('email'))? ' has-danger' : '' }}">
                                        <label for="form__email">Email</label>
                                        <input type="text" class="form-control" id="form__email"name="email">
                                        @if($errors->has('email'))
                                            <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="form__password">Password</label>
                                        <input type="password" class="form-control" id="form__password" name="password">
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </form>
                            </div>
                            <div class="card-text" id="register" style="display: none">
                                <form action="/register" enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    @if(count($errors) > 0)
                                        <div class="alert alert danger">
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="form__first_name">First Name</label>
                                                <input type="text" class="form-control" id="form__first_name" name="first_name">
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="form__last_name">Last Name</label>
                                                <input type="text" class="form-control" id="form__last_name" name="last_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="form__password">Password</label>
                                        <input type="password" class="form-control" id="form__password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="form__password">Confirm Password</label>
                                        <input type="password" class="form-control" id="form__password_confirmation" name="password_confirmation">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Avatar</label>
                                        <input type="file" class="form-control-file" name="avatar" accept="image/*">
                                        <small class="form-text text-muted">Optional, 300 by 300 minimum, 5MB max</small>
                                    </div>
                                    <button class="btn btn-primary btn-block">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(function(){
                            $('.auth-tabs').tabs({
                                classes: {
                                    'ui-tabs-anchor': 'active'
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="container section">
        <div class="row">
            <div class="col-md-4 text-xs-center">
                <div style="margin-bottom: 15px">
                    <i class="fa fa-bandcamp fa-5x"></i>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, aliquid aspernatur cumque.</p>
            </div>
            <div class="col-md-4 text-xs-center">
                <div style="margin-bottom: 15px">
                    <i class="fa fa-handshake-o fa-5x"></i>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, aliquid aspernatur cumque.</p>
            </div>
            <div class="col-md-4 text-xs-center">
                <div style="margin-bottom: 15px">
                    <i class="fa fa-car fa-5x"></i>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, aliquid aspernatur cumque.</p>
            </div>
        </div>
    </div>
@endsection
