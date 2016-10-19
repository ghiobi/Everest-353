@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div class="fwidth">
            <form action="">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label fwidth">
                    <input class="mdl-textfield__input" type="text" id="form__name" >
                    <label class="mdl-textfield__label" for="form__name">Name</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label fwidth">
                    <input class="mdl-textfield__input" type="text" id="form__description" >
                    <label class="mdl-textfield__label" for="form__description">Description</label>
                </div>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="form__trip_type_1">
                    <input type="radio" id="form__trip_type_1" class="mdl-radio__button" value="short_distance" checked>
                    <span class="mdl-radio__label">Local Trip</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="form__trip_type_2">
                    <input type="radio" id="form__trip_type_2" class="mdl-radio__button" value="long_distance">
                    <span class="mdl-radio__label">Long Distance Trip</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="form__trip_type_2">
                    <input type="radio" id="form__trip_type_2" class="mdl-radio__button" name="frequency" value="one_time" checked>
                    <span class="mdl-radio__label">One Time</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="form__trip_type_1">
                    <input type="radio" id="form__trip_type_1" class="mdl-radio__button" name="frequency" value="frequent" >
                    <span class="mdl-radio__label">Frenquent</span>
                </label>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="form__num_riders" >
                    <label class="mdl-textfield__label" for="form__num_riders">Number Of Riders</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="form__departure_pcode" >
                    <label class="mdl-textfield__label" for="form__departure_pcode">Departure Postal Code</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="form__destination_pcode" >
                    <label class="mdl-textfield__label" for="form__destination_pcode">Destination Postal Code</label>
                </div>
                <div >
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form__monday">
                        <input type="checkbox" id="form__monday" class="mdl-checkbox__input" value="0">
                        <span class="mdl-checkbox__label">Monday</span>
                    </label>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form__tuesday">
                        <input type="checkbox" id="form__tuesday" class="mdl-checkbox__input" value="1">
                        <span class="mdl-checkbox__label">Tuesday</span>
                    </label>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form__wednesday">
                        <input type="checkbox" id="form__wednesday" class="mdl-checkbox__input" value="2">
                        <span class="mdl-checkbox__label">Wednesday</span>
                    </label>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form__thursday">
                        <input type="checkbox" id="form__thursday" class="mdl-checkbox__input" value="3">
                        <span class="mdl-checkbox__label">Thursday</span>
                    </label>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form__friday">
                        <input type="checkbox" id="form__friday" class="mdl-checkbox__input" value="4">
                        <span class="mdl-checkbox__label">Friday</span>
                    </label>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form__saturday">
                        <input type="checkbox" id="form__saturday" class="mdl-checkbox__input" value="5">
                        <span class="mdl-checkbox__label">Staturday</span>
                    </label>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form__sunday">
                        <input type="checkbox" id="form__sunday" class="mdl-checkbox__input" value="6">
                        <span class="mdl-checkbox__label">Sunday</span>
                    </label>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label fwidth">
                        <input class="mdl-textfield__input" type="time" id="form__time" >
                        <label class="mdl-textfield__label label-input--fixed" for="form__name">Departure Time</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

@endsection