@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div class="fwidth">
            <form action="">
                @include('components.input-text', [
                    'name' => 'name',
                    'label' => 'Post Title',
                    'value' => old('name'),
                    'errors' => $errors
                ])
                @include('components.input-textarea', [
                    'name' => 'description',
                    'label' => 'Description',
                    'value' => old('description'),
                    'errors' => $errors
                ])
                <div class="mdl-textfield mdl-js-textfield{{ ($errors->has('num_riders'))? ' is-invalid' : '' }} mdl-textfield--floating-label fwidth">
                    <input type="number" class="mdl-textfield__input" id="form__num_riders" name="form__num_riders" value="{{ old('num_riders') }}">
                    <label class="mdl-textfield__label " for="form__num_riders" >Number of Riders</label>
                    @if($errors->has('num_riders'))
                        <span class="mdl-textfield__error">{{ $errors->first('num_riders') }}</span>
                    @endif
                </div>
                @include('components.input-text', [
                    'name' => 'departure_pcode',
                    'label' => 'Departure Postal Code',
                    'value' => old('departure_pcode'),
                    'errors' => $errors
                ])
                @include('components.input-text', [
                    'name' => 'destination_pcode',
                    'label' => 'Destination Postal Code',
                    'value' => old('destination_pcode'),
                    'errors' => $errors
                ])
                <fieldset class="selector-wrapper">
                    <label>Trip Type:</label>
                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="form__type_1">
                        <input type="radio" id="form__type_1" class="mdl-radio__button" name="type" value="1" checked>
                        <span class="mdl-radio__label">Local Trip</span>
                    </label>
                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="form__type_2">
                        <input type="radio" id="form__type_2" class="mdl-radio__button" name="type" value="0">
                        <span class="mdl-radio__label">Long Distance Trip</span>
                    </label>
                </fieldset>
                <fieldset class="selector-wrapper">
                    <label>Frequency:</label>
                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="form__one_time_1">
                        <input type="radio" id="form__one_time_1" class="mdl-radio__button" name="one_time" value="1" checked>
                        <span class="mdl-radio__label">One Time</span>
                    </label>
                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="form__one_time_2">
                        <input type="radio" id="form__one_time_2" class="mdl-radio__button" name="one_time" value="0" >
                        <span class="mdl-radio__label">Frequent</span>
                    </label>
                </fieldset>
                <div class="datepicker-wrapper" style="display: block">
                    @include('components.input-text', [
                        'name' => 'departure_date',
                        'label' => 'Departure Date',
                        'value' => old('departure_date'),
                        'errors' => $errors,
                        'class' => 'datepicker'
                    ])
                </div>
                <div class="type-wrapper" style="display: block">
                    <div class="frequent-wrapper" style="display: none">
                        <fieldset>
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form_every_sun">
                                <input type="hidden" name="every_sun" value="0">
                                <input type="checkbox" id="form_every_sun" class="mdl-checkbox__input" name="every_sun" value="1">
                                <span class="mdl-checkbox__label">Sunday</span>
                            </label>
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form_every_mon">
                                <input type="hidden" name="every_mon" value="0">
                                <input type="checkbox" id="form_every_mon" class="mdl-checkbox__input" name="every_mon" value="1">
                                <span class="mdl-checkbox__label">Monday</span>
                            </label>
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form_every_tues">
                                <input type="hidden" name="every_tues" value="0">
                                <input type="checkbox" id="form_every_tues" class="mdl-checkbox__input" name="every_tues" value="1">
                                <span class="mdl-checkbox__label">Tuesday</span>
                            </label>
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form_every_wed">
                                <input type="hidden" name="every_wed" value="0">
                                <input type="checkbox" id="form_every_wed" class="mdl-checkbox__input" name="every_wed" value="1">
                                <span class="mdl-checkbox__label">Wednesday</span>
                            </label>
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form_every_thur">
                                <input type="hidden" name="every_thur" value="0">
                                <input type="checkbox" id="form_every_thur" class="mdl-checkbox__input" name="every_thur" value="1">
                                <span class="mdl-checkbox__label">Thursday</span>
                            </label>
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form_every_fri">
                                <input type="hidden" name="every_fri" value="0">
                                <input type="checkbox" id="form_every_fri" class="mdl-checkbox__input" name="every_fri" value="1">
                                <span class="mdl-checkbox__label">Friday</span>
                            </label>
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="form_every_sat">
                                <input type="hidden" name="every_sat" value="0">
                                <input type="checkbox" id="form_every_sat" class="mdl-checkbox__input" name="every_sat" value="1">
                                <span class="mdl-checkbox__label">Saturday</span>
                            </label>
                        </fieldset>
                    </div>
                    @include('components.input-text', [
                        'name' => 'destination_pcode',
                        'label' => 'Departure Time',
                        'value' => old('destination_pcode'),
                        'errors' => $errors,
                        'class' => 'timepicker'
                    ])
                </div>
                <div class="type-wrapper" style="display: none">
                    <div class="frequent-wrapper">
                        <select name="frequency">
                            <option value="0">Every Sunday</option>
                            <option value="1">Every Monday</option>
                            <option value="2">Every Tuesday</option>
                            <option value="3">Every Wednesday</option>
                            <option value="4">Every Thursday</option>
                            <option value="5">Every Friday</option>
                            <option value="6">Every Saturday</option>
                            <option value="7">Twice-Monthly</option>
                            <option value="8">Monthly</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Post
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function(){
            $type_wrapper = $('.type-wrapper');

            $('input[name="type"]').change(function(){
                $type_wrapper.hide();
                $type_wrapper.eq($(this).val() == 1? 0 : 1).show();
            });

            $('input[name="one_time"]').change(function () {
                if($(this).val() == 1){
                    $('.datepicker-wrapper').show();
                    $('.frequent-wrapper').hide();
                } else {
                    $('.datepicker-wrapper').hide();
                    $('.frequent-wrapper').show();
                }
            });
        });
    </script>
@endsection