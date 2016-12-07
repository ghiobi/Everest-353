@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>A Conversation with...</h1>
            <p class="lead">
                @foreach($conversation->users as $user)
                    @if($loop->last)
                        {{ $user->fullName() }}
                    @else
                        {{ $user->fullName() }},
                    @endif
                @endforeach
            </p>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-text">
                <div id="chat-box">

                </div>
            </div>
            <div class="card-footer">
                <form action="/conversation/{{ $conversation->id }}/set" method="post" id="chat-form">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <textarea name="body" id="chat-textarea" rows="3" class="form-control"
                                  placeholder="Drop a message..." minlength="1"></textarea>
                        <span class="input-group-btn">
                            <button class="btn btn-primary h-100">Send!</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            var $chat_box = $('#chat-box');

            var $form = $('#chat-form');
            var $textarea = $('#chat-textarea');

            var $users = JSON.parse('{!! json_encode($users) !!}');

            var no_message = '<div class="section text-xs-center"> <h4>No group messages? <i class="fa fa-frown-o"></i></h4> <p class="lead mb-0">Get to know each other!</p> </div>';

            var message_html = function (user, message) {
                return '<div class="media" style="margin-bottom: 10px;"><a class="media-left" href="/user/' + message.sender_id + '"><img class="media-object rounded-circle" src="' + user.avatar + '" width="45"> </a> <div class="media-body"> <h4 class="media-heading" style="font-size: 14px">' + user.name + ' <small class="text-muted">' + message.created_at + '(UTC)</small></h4> ' + message.body + ' </div></div>';
            };

            var run = function () {
                $.ajax('/conversation/{{ $conversation->id }}/get', {
                    method: 'get',
                    success: function (data) {
                        var messages = data.conversation.messages;
                        if (messages.length == 0) {
                            $chat_box.html(no_message);
                        } else {
                            $chat_box.empty();
                            var chat_string = '';
                            for (var i = 0; i < messages.length; i++) {
                                var user = $users[messages[i].sender_id];
                                chat_string += message_html(user, messages[i]);
                            }
                            $chat_box.html(chat_string);
                        }
                    }
                })
            };
            run();
            setInterval(run, 1000);

            $form.submit(function (event) {
                event.preventDefault();
                $.ajax('/conversation/{{ $conversation->id }}/set', {
                    method: 'POST',
                    data: {body: $textarea.val()},
                    success: function (data) {
                        if (data.status == 'ok') {
                            $textarea.val('');
                        }
                    }
                });
            });

        });
    </script>
@endsection