@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container text-xs-center">
            <h3 class="display-4 mb-2">Get started by searching for a ride!</h3>
            <form class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" id="form__query" placeholder="Find a ride.">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
    <div class="container section">
        <h1 class="font-weight-normal mb-2">Found 43 results for 'toronto'.</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Special title treatment</h4>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Special title treatment</h4>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Special title treatment</h4>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Special title treatment</h4>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Special title treatment</h4>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
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
