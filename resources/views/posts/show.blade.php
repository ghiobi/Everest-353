@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-cell mdl-card mdl-cell--8-col mdl-shadow--2dp">
            <div class="mdl-card__supporting-text">
                <div>
                    {{ $post->name }}
                </div>
                <div class="">
                    {{ $post->description }}
                </div>
                <div>
                    Departure Postal Code: {{ $post->departure_pcode }}
                </div>
                <div>
                    Destination Postal Code: {{ $post->destination_pcode }}
                </div>
                <div>
                    Maximum number of riders: {{ $post->num_riders }}
                </div>
                <div>
                    Cost: {{ $post->cost }}
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-card mdl-cell--4-col mdl-shadow--2dp">
            <div class="mdl-card__supporting-text">
                @if($post->postable_type == \App\LocalTrip::class)
                    @if($post->one_time)
                        <div>
                            Date of departure: {{ $post->departure_date->toDateString() }}
                        </div>
                        <div>
                            Time of departure: {{ (new \Carbon\Carbon($post->postable->departure_time))->format('H:i') }}
                        </div>
                    @else
                    @endif
                @else
                    @if($post->one_time)

                    @else

                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--2dp">
            Post Comments
        </div>
    </div>
@endsection