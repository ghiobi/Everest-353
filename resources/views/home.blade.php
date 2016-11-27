@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container text-xs-center">
            <h3 class="display-4 mb-2">Get started by searching for a ride!</h3>
            <form class="form-inline" action="/home/search" method="GET">
                <div class="form-group{{ ($errors->has('departure_postal_code'))? ' has-danger' : '' }}">
                    <input name="departure_postal_code" type="text" class="form-control" id="form__query" placeholder="Departure Postal Code" {{ old('departure_postal_code') }}>
                </div>
                <div class="form-group{{ ($errors->has('departure_radius'))? ' has-danger' : '' }}">
                    <input name="departure_radius" type="text" class="form-control" id="form__query" placeholder="Radius of Departure (km)" {{ old('departure_radius') }}>
                </div>
                <br>
                <div class="form-group">
                    <label class="radio-inline"><input type="radio" name="trip_type" value="long" checked> Long Distance Trips</label>
                    <label class="radio-inline"><input type="radio" name="trip_type" value="short"> Short Distance Trips</label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            @if($errors->has('departure_postal_code'))
                <div class="form-control-feedback">
                    {{ $errors->first('departure_postal_code') }}
                </div>
            @endif
            @if($errors->has('departure_radius'))
                <div class="form-control-feedback">
                    {{ $errors->first('departure_radius') }}
                </div>
            @endif
        </div>
    </div>
    <div class="container section">
        <h1 class="font-weight-normal mb-2">Found {{count($nearest_posts)}} results for 'Toronto'.</h1>
        <div class="row">
            @foreach ($nearest_posts as $post => $distance)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{{$post->name}}</h4>
                            <p class="card-text">{{$post->description}}</p>
                            <a href="/post/{{$post->id}}" class="btn btn-primary">View post details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="container section">
        <div class="row">
            <div class="col-md-6">
                <h5>Get to know your country!</h5>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci asperiores aut dicta dolore et illo illum ipsum minima nemo nisi optio perferendis quidem quos ratione sunt ut vitae, voluptatum.</p>
                <a href="#">Learn More</a>
            </div>
        </div>
    </div>
@endsection
