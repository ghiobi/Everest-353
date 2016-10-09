@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-card__title padding-bottom--0">
            <h1 class="mdl-card__title-text">Add Funds</h1>
        </div>
        <div class="mdl-card__supporting-text padding-top--0">
            <p>
                @include('components.success-notification')
            </p>
            <form role="form" method="POST" action="{{ url('funds/add') }}">
                {{ csrf_field() }}

                @include('components.input-text', [
                        'name' => 'amount',
                        'label' => 'Amount to be added',
                        'errors' => $errors
                ])
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Add
                </button>
            </form>
        </div>
    </div>
@endsection