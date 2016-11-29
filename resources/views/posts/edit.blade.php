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
                <form action="/post/{{ $post->id }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('patch')  }}
                    <div class="form-group{{ ($errors->has('name'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__name">Name</label>
                        <input type="text" class="form-control" id="form__name" name="name" value="{{ $post->name }}" required minlength="1" maxlength="255">
                        @if($errors->has('name'))
                            <div class="form-control-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('description'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__description">Description</label>
                        <textarea class="form-control" id="form__description" name="description" rows="3" required minlength="1">{{ $post->description }}</textarea>
                        @if($errors->has('description'))
                            <div class="form-control-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('num_riders'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__num_riders">Number of Riders</label>
                        <input type="number" class="form-control" id="form__num_riders" name="num_riders" value="{{ $post->num_riders }}" required min="1">
                        @if($errors->has('num_riders'))
                            <div class="form-control-feedback">
                                {{ $errors->first('num_riders') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ ($errors->has('departure_pcode'))? ' has-danger' : '' }}">
                        <label class="form-control-label" for="form__departure_pcode">Departure Postal Code</label>
                        <input type="text" class="form-control" id="form__departure_pcode" name="departure_pcode" value="{{ $post->departure_pcode }}" required pattern="^[A-z]\d[A-z]\s?\d[A-z]\d$">
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
                        <input type="text" class="form-control" id="form__destination_pcode" name="destination_pcode" value="{{ $post->destination_pcode }}" required pattern="^[A-z]\d[A-z]\s?\d[A-z]\d$">
                        <small class="form-control-feedback">
                            eg. A0A 1A1
                        </small>
                        @if($errors->has('destination_pcode'))
                            <div class="form-control-feedback">
                                {{ $errors->first('destination_pcode') }}
                            </div>
                        @endif
                    </div>
                    @if($post->one_time)
                        <div class="form-group{{ ($errors->has('departure_date'))? ' has-danger' : '' }}">
                            <label class="form-control-label" for="form__departure_date">First Departure Date</label>
                            <input type="date" class="form-control" id="form__departure_date" name="departure_date" value="{{ $post->departure_date->format('Y-m-d') }}" required>
                            @if($errors->has('departure_date'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('departure_date') }}
                                </div>
                            @endif
                        </div>
                    @endif
                    @if($post->postable_type)
                        @if(! $post->one_time)
                            <div class="form-group">
                                <legend>Frequency</legend>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_sun" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_sun" value="1" {{ ($post->postable->freqency[0] == 1)? 'checked': ''}}> Sunday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_mon" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_mon" value="1" {{ ($post->postable->freqency[1] == 1)? 'checked': ''}}> Monday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_tues" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_tues" value="1" {{ ($post->postable->freqency[2] == 1)? 'checked': ''}}> Tuesday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_wed" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_wed" value="1" {{ ($post->postable->freqency[3] == 1)? 'checked': ''}}> Wednesday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_thur" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_thur" value="1" {{ ($post->postable->freqency[4] == 1)? 'checked': ''}}> Thursday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_fri" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_fri" value="1" {{ ($post->postable->freqency[5] == 1)? 'checked': ''}}> Friday
                                </label>
                                <label class="form-check-inline">
                                    <input type="hidden" name="every_sat" value="0">
                                    <input class="form-check-input" type="checkbox" name="every_sat" value="1" {{ ($post->postable->freqency[6] == 1)? 'checked': ''}}> Saturday
                                </label>
                            </div>
                        @endif
                        <div class="form-group{{ ($errors->has('time'))? ' has-danger' : '' }}">
                            <label for="form__time">Departure Time</label>
                            <input type="time" class="form-control" id="form__time" name="time" value="{{ $post->postable->departure_time }}">
                            @if($errors->has('time'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('time') }}
                                </div>
                            @endif
                        </div>
                    @else
                        @if(! $post->one_time)
                            <div class="form-group">
                                <label for="">Frequency</label>
                                <select class="form-control" name="frequency">
                                    <option value="0" {{ ($post->postable->frequency == 0)? 'selected' : ''}}>Every Sunday</option>
                                    <option value="1" {{ ($post->postable->frequency == 1)? 'selected' : ''}}>Every Monday</option>
                                    <option value="2" {{ ($post->postable->frequency == 2)? 'selected' : ''}}>Every Tuesday</option>
                                    <option value="3" {{ ($post->postable->frequency == 3)? 'selected' : ''}}>Every Wednesday</option>
                                    <option value="4" {{ ($post->postable->frequency == 4)? 'selected' : ''}}>Every Thursday</option>
                                    <option value="5" {{ ($post->postable->frequency == 5)? 'selected' : ''}}>Every Friday</option>
                                    <option value="6" {{ ($post->postable->frequency == 6)? 'selected' : ''}}>Every Saturday</option>
                                    <option value="7" {{ ($post->postable->frequency == 7)? 'selected' : ''}}>Twice-Monthly</option>
                                    <option value="8" {{ ($post->postable->frequency == 8)? 'selected' : ''}}>Monthly</option>
                                </select>
                            </div>
                        @endif
                    @endif
                    <button class="btn btn-primary" type="submit">Update Post!</button>
                </form>
            </div>
            <div class="col-md-4">
                <h3>Need Help?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aut consequuntur dolore eum, illo nihil placeat ratione similique? At delectus deserunt dignissimos dolorum ipsa itaque laborum nihil nobis sed tempore?</p>
            </div>
        </div>
    </div>
@endsection