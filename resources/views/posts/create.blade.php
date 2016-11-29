@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>Create a post!</h1>
            <p class="lead">Remember you must have a valid license number.</p>
        </div>
    </div>
    <div class="container section">
        <div class="row">
            <div class="col-md-8">
                @if(! empty(Auth::user()->license_num))
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <form action="/post" method="post">
                    {{ csrf_field() }}
                    <div class="form-group{{ ($errors->has('name'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__name">Name</label>
                        <input type="text" class="form-control" id="form__name" name="name" value="{{ old('name') }}" required maxlength="255">
                        @if($errors->has('name'))
                            <div class="form-control-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('description'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__description">Description</label>
                        <textarea class="form-control" id="form__description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                            <div class="form-control-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('num_riders'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__num_riders">Number of Riders</label>
                        <input type="number" class="form-control" id="form__num_riders" name="num_riders" value="{{ old('num_riders') }}" required min="0">
                        @if($errors->has('num_riders'))
                            <div class="form-control-feedback">
                                {{ $errors->first('num_riders') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('departure_pcode'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__departure_pcode">Departure Postal Code</label>
                        <input type="text" class="form-control" id="form__departure_pcode" name="departure_pcode" value="{{ old('departure_pcode') }}" required maxlength="7" pattern="[A-z]\d[A-z]\s?\d[A-z]\d$">
                        <small class="form-control-feedback">
                            eg. A0A 1A1
                        </small>
                        @if($errors->has('departure_pcode'))
                            <div class="form-control-feedback">
                                {{ $errors->first('departure_pcode') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('destination_pcode'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__destination_pcode">Destination Postal Code</label>
                        <input type="text" class="form-control" id="form__destination_pcode" name="destination_pcode" value="{{ old('destination_pcode') }}" required maxlength="7" pattern="^[A-z]\d[A-z]\s?\d[A-z]\d$">
                        <small class="form-control-feedback">
                            eg. A0A 1A1
                        </small>
                        @if($errors->has('destination_pcode'))
                            <div class="form-control-feedback">
                                {{ $errors->first('destination_pcode') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <legend>Trip Type</legend>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="type" value="1" {{ (old('type') == 1 || old('type') == null)? 'checked' : '' }}> Local Trip
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="type" value="0" {{ (old('type') == 0 && old('one_time') != null)? 'checked' : '' }}> Long Distance Trip
                        </label>
                    </div>
                    <div class="form-group">
                        <legend>One Time or Frequent</legend>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="one_time" value="1" {{ (old('one_time') == 1 || old('one_time') == null)? 'checked' : '' }}> One Time
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="one_time" value="0" {{ (old('one_time') == 0 && old('one_time') != null)? 'checked' : '' }}> Frequent
                        </label>
                    </div>
                    <div class="form-group onet-wrap{{ ($errors->has('departure_date'))? ' has-danger' : '' }}{{ (old('one_time') == 1 || old('one_time') == null)? ' active' : '' }}">
                        <label class="form-control-label" for="form__departure_date">Departure Date</label>
                        <input type="date" class="form-control form-reset" id="form__departure_date" name="departure_date" value="{{ old('departure_date') }}">
                        @if($errors->has('departure_date'))
                            <div class="form-control-feedback">
                                {{ $errors->first('departure_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="type-wrap{{ (old('type') == 1 || old('type') == null)? ' active' : '' }}">
                        <div class="freq-wrap{{ (old('one_time') == 0 && old('one_time') != null)? ' active' : '' }}">
                            <div class="form-group">
                                <legend>Frequency</legend>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_sun" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_sun" value="1" {{ old('every_sun')? 'checked': ''}}> Sunday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_mon" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_mon" value="1" {{ old('every_mon')? 'checked': ''}}> Monday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_tues" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_tues" value="1" {{ old('every_tues')? 'checked': ''}}> Tuesday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_wed" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_wed" value="1" {{ old('every_wed')? 'checked': ''}}> Wednesday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_thur" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_thur" value="1" {{ old('every_thur')? 'checked': ''}}> Thursday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_fri" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_fri" value="1" {{ old('every_fri')? 'checked': ''}}> Friday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_sat" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_sat" value="1" {{ old('every_sat')? 'checked': ''}}> Saturday
                                </label>
                            </div>
                        </div>
                        <div class="form-group{{ ($errors->has('time'))? ' has-danger' : '' }}">
                            <label for="form__time">Departure Time</label>
                            <input type="time" class="form-control form-reset" id="form__time" name="time" value="{{ old('time') }}">
                            @if($errors->has('time'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('time') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="type-wrap{{ (old('type') == 0 && old('one_time') != null)? ' active' : '' }}">
                        <div class="freq-wrap{{ (old('one_time') == 0 && old('one_time') != null)? ' active' : '' }}">
                            <div class="form-group">
                                <label for="">Frequency</label>
                                <select class="form-control" name="frequency">
                                    <option value="0" {{ (old('frequency') == 0)? 'selected' : '' }}>Every Sunday</option>
                                    <option value="1" {{ (old('frequency') == 1)? 'selected' : '' }}>Every Monday</option>
                                    <option value="2" {{ (old('frequency') == 2)? 'selected' : '' }}>Every Tuesday</option>
                                    <option value="3" {{ (old('frequency') == 3)? 'selected' : '' }}>Every Wednesday</option>
                                    <option value="4" {{ (old('frequency') == 4)? 'selected' : '' }}>Every Thursday</option>
                                    <option value="5" {{ (old('frequency') == 5)? 'selected' : '' }}>Every Friday</option>
                                    <option value="6" {{ (old('frequency') == 6)? 'selected' : '' }}>Every Saturday</option>
                                    <option value="7" {{ (old('frequency') == 7)? 'selected' : '' }}>Twice-Monthly</option>
                                    <option value="8" {{ (old('frequency') == 8)? 'selected' : '' }}>Monthly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Create Post!</button>
                </form>
                @else
                    <h3>Sorry!</h3>
                    <p class="lead">You must add a license number to your account before creating a post!</p>
                @endif
            </div>
            <div class="col-md-4">
                <h3>Need Help?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aut consequuntur dolore eum, illo nihil placeat ratione similique? At delectus deserunt dignissimos dolorum ipsa itaque laborum nihil nobis sed tempore?</p>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            var $type_selection = $('input[name="type"]');
            var $freq_selection = $('input[name="one_time"]');
            var $type_wrap = $('.type-wrap');
            var $freq_wrap = $('.freq-wrap');
            var $onet_wrap = $('.onet-wrap');
            var inputs = $('.form-reset');

            $type_selection.change(function(){
                var val = $(this).val();
                $('.type-wrap.active').removeClass('active');
                $type_wrap.eq(++val % 2).addClass('active');
                inputs.val('');
            });
            $freq_selection.change(function(){
                var val = $(this).val();
                $freq_wrap.find('input').val('');
                if(val == 1){
                    $freq_wrap.removeClass('active');
                    $onet_wrap.addClass('active');
                } else {
                    $freq_wrap.addClass('active');
                    $onet_wrap.removeClass('active');
                }
                inputs.val('');
            });
        });
    </script>

@endsection