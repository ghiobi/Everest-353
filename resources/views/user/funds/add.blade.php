@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>No no! Looks like you need to adds some funds.</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur corporis cumque delectus deleniti dignissimos dolores dolorum est exercitationem explicabo illo, ipsum, minus nemo neque nesciunt nulla odit reprehenderit saepe voluptatum.</p>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title text-xs-center">In balance ${{ Auth::user()->balance() }}</h4>
                            <div class="card-text">
                                <form action="/funds/add" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ ($errors->has('amount'))? ' has-danger' : '' }}">
                                        <label for="form__amount">Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" class="form-control" id="form__amount" name="amount">
                                        </div>
                                        @if($errors->has('amount'))
                                            <div class="form-control-feedback">
                                                {{ $errors->first('amount') }}
                                            </div>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-block">Add!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section text-xs-center">
        <div class="container">
            <h2 class="display-3">Learn More on how to save!</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores, assumenda consequuntur cum debitis dolorum ex hic, ipsam labore laudantium mollitia porro quas quod ratione sequi sit tempora temporibus voluptate voluptatum?</p>
            <button class="btn btn-info">Learn More</button>
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
                    <i class="fa fa-bandcamp fa-5x"></i>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, aliquid aspernatur cumque.</p>
            </div>
            <div class="col-md-4 text-xs-center">
                <div style="margin-bottom: 15px">
                    <i class="fa fa-bandcamp fa-5x"></i>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, aliquid aspernatur cumque.</p>
            </div>
        </div>
    </div>
@endsection