@extends('layouts.app')

@section('content')
    <div class="page-title mdl-color--grey-200">
        <div class="mdl-typography--text-center">
            <h1 class="mdl-typography--display-3">drive more. together.</h1>
            <a href="{{ url('home') }}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                FIND A RIDE
            </a>
        </div>
    </div>
    <div class="section">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
                <div class="mdl-card__media">
                    <img src="">
                </div>
                <div class="mdl-card__title">
                    <h4 class="mdl-card__title-text">Get going on Super</h4>
                </div>
                <div class="mdl-card__supporting-text">
                    <span class="mdl-typography--font-light mdl-typography--subhead">Four tips to make your switch to Super quick and easy</span>
                </div>
                <div class="mdl-card__actions">
                    <a class="mdl-button mdl-js-button mdl-typography--text-uppercase" href="" data-upgraded=",MaterialButton">
                        Make the switch
                        <i class="material-icons">chevron_right</i>
                    </a>
                </div>
            </div>

            <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
                <div class="mdl-card__media">
                    <img src="">
                </div>
                <div class="mdl-card__title">
                    <h4 class="mdl-card__title-text">Create your own Super character</h4>
                </div>
                <div class="mdl-card__supporting-text">
                    <span class="mdl-typography--font-light mdl-typography--subhead">Turn the little green Super mascot into you, your friends, anyone!</span>
                </div>
                <div class="mdl-card__actions">
                    <a class="mdl-button mdl-js-button mdl-typography--text-uppercase" href="" data-upgraded=",MaterialButton">
                        super.com
                        <i class="material-icons">chevron_right</i>
                    </a>
                </div>
            </div>

            <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
                <div class="mdl-card__media">
                    <img src="">
                </div>
                <div class="mdl-card__title">
                    <h4 class="mdl-card__title-text">Get a clean customisable home screen</h4>
                </div>
                <div class="mdl-card__supporting-text">
                    <span class="mdl-typography--font-light mdl-typography--subhead">A clean, simple, customisable home screen that comes with the power of Google Now: Traffic alerts, weather and much more, just a swipe away.</span>
                </div>
                <div class="mdl-card__actions">
                    <a class="mdl-button mdl-js-button mdl-typography--text-uppercase" href="" data-upgraded=",MaterialButton">
                        Download now
                        <i class="material-icons">chevron_right</i>
                    </a>
                </div>
            </div>

            <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
                <div class="mdl-card__media">
                    <img src="">
                </div>
                <div class="mdl-card__title">
                    <h4 class="mdl-card__title-text">Millions to choose from</h4>
                </div>
                <div class="mdl-card__supporting-text">
                    <span class="mdl-typography--font-light mdl-typography--subhead">Hail a taxi, find a recipe, run through a temple – Google Play has all the apps and games that let you make your Super device uniquely yours.</span>
                </div>
                <div class="mdl-card__actions">
                    <a class="mdl-button mdl-js-button mdl-typography--text-uppercase" href="" data-upgraded=",MaterialButton">
                        Find apps
                        <i class="material-icons">chevron_right</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
