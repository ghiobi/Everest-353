@extends('layouts.app')

@section('content')
    <div class="container section text-xs-center">
        <div class="row flex-items-xs-center">
            <div class="col-xs-8">
                <img src="/images/404.gif" alt="" class="img-fluid" width="340">
                <div style="font-size: 86px">403</div>
                <h1 style="font-weight: 300;">OOOPPS.! You are unauthorized to accessed this page!</h1>
                <a href="/">Return back home</a>
            </div>
        </div>
    </div>
@endsection