@extends('layouts.app')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-card__title padding-bottom--0">
            <h1 class="mdl-card__title-text">Compose Message</h1>
        </div>
        <div class="mdl-card__supporting-text padding-top--0">
            <p>
                @include('components.success-notification')
            </p>
            <form role="form" method="POST" action="{{ url('/mail') }}">
                {{ csrf_field() }}

                {{-- Drop down list of all users except ourself, if recipient is set, select it by default --}}
                <select name="recipient_id">
                    @foreach ($all_users as $user)

                        @if ($user->id == Auth::user()->id)
                            @continue
                        @endif
                        <option value="{{$user->id}}"
                                @if ($recipient != null && $user->id == $recipient->id)
                                    selected
                                @endif
                        >
                            {{$user->first_name}} {{$user->last_name}}
                        </option>
                    @endforeach
                </select>


                @include('components.input-textarea', [
                        'name' => 'body',
                        'label' => 'Body',
                        'errors' => $errors
                ])
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Send
                </button>
            </form>
        </div>
    </div>
@endsection