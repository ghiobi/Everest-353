@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>Create a post!</h1>
            <p class="lead">Remeber you must have a valid license number.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form action="/post" method="post">
                    {{ csrf_field() }}
                    <div class="form-group{{ ($errors->has('name'))? ' has-danger' : '' }}">
                        <label for="form__name">Name</label>
                        <input type="text" class="form-control" id="form__name" name="name" value="{{ old('name') }}">
                        @if($errors->has('name'))
                            <div class="form-control-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('description'))? ' has-danger' : '' }}">
                        <label for="form__description">Description</label>
                        <textarea class="form-control" id="form__description" name="description" rows="3" value="{{ old('description') }}"></textarea>
                        @if($errors->has('description'))
                            <div class="form-control-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('num_riders'))? ' has-danger' : '' }}">
                        <label for="form__num_riders">Number of Riders</label>
                        <input type="number" class="form-control" id="form__num_riders" name="num_riders" value="{{ old('num_riders') }}">
                        @if($errors->has('num_riders'))
                            <div class="form-control-feedback">
                                {{ $errors->first('num_riders') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('departure_pcode'))? ' has-danger' : '' }}">
                        <label for="form__departure_pcode">Departure Postal Code</label>
                        <input type="text" class="form-control" id="form__departure_pcode" name="departure_pcode" value="{{ old('departure_pcode') }}">
                        @if($errors->has('departure_pcode'))
                            <div class="form-control-feedback">
                                {{ $errors->first('departure_pcode') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('destination_pcode'))? ' has-danger' : '' }}">
                        <label for="form__destination_pcode">Destination Postal Code</label>
                        <input type="te" class="form-control" id="form__destination_pcode" name="destination_pcode" value="{{ old('destination_pcode') }}">
                        @if($errors->has('destination_pcode'))
                            <div class="form-control-feedback">
                                {{ $errors->first('destination_pcode') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('departure_date'))? ' has-danger' : '' }}">
                        <label for="form__departure_date">First Departure Date</label>
                        <input type="te" class="form-control" id="form__departure_date" name="departure_date" value="{{ old('departure_date') }}">
                        @if($errors->has('departure_date'))
                            <div class="form-control-feedback">
                                {{ $errors->first('departure_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <legend>Trip Type</legend>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="type" value="1"> Local Trip
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="type" value="0"> Long Distance Trip
                        </label>
                    </div>
                    <div class="form-group">
                        <legend>One Time or Freqent</legend>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="one_time" value="1"> One Time
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="one_time" value="0"> Frequent
                        </label>
                    </div>
                    <div class="type-wrap">
                        <div class="freq-wrap">
                            <div class="form-group">
                                <legend>Frequency</legend>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_sun" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_sun" value="1"> Sunday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_mon" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_mon" value="1"> Monday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_tues" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_tues" value="1"> Tuesday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_wed" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_wed" value="1"> Wednesday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_thur" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_thur" value="1"> Thursday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_fri" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_fri" value="1"> Friday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_sat" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_sat" value="1"> Saturday
                                </label>
                            </div>
                        </div>
                        <div class="form-group{{ ($errors->has('time'))? ' has-danger' : '' }}">
                            <label for="form__time">Departure Time</label>
                            <input type="text" class="form-control" id="form__time" name="time" value="{{ old('time') }}">
                            @if($errors->has('time'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('time') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="type-wrap">
                        <div class="freq-wrap">
                            <div class="form-group">
                                <label for="">Frequency</label>
                                <select class="form-control" name="frequency">
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
                    </div>
                    <button class="btn btn-primary">Create Post!</button>
                </form>
            </div>
            <div class="col-md-4">
                <h3>Need Help?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aut consequuntur dolore eum, illo nihil placeat ratione similique? At delectus deserunt dignissimos dolorum ipsa itaque laborum nihil nobis sed tempore?</p>
            </div>
        </div>
    </div>

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