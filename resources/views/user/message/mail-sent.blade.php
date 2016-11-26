@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4">
                Mail Sent
            </h1>
            <p class="lead">Reply to your loved ones!</p>
        </div>
    </div>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/mail">Mail Inbox</a></li>
            <li class="breadcrumb-item active">Mail Sent</li>
            <li class="breadcrumb-item"><a href="/mail/compose">Compose Message</a></li>
        </ol>
        <table class="table">
            <thead>
            <tr>
                <th>Sender</th>
                <th>Message</th>
                <th>Actions</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @if(count($messages) > 0)
                @foreach($messages as $message)
                    <tr>
                        <td>
                            <img src="{{ $message->messageable->avatarUrl(30) }}" width=35" class="img-fluid rounded-circle" alt=""> {{ $message->messageable->fullName() }}
                        </td>
                        <td>
                            {{ $message->body }}
                        </td>
                        <td>
                            <a href="/mail/compose?recipient_id={{ $message->messageable->id }}" title="reply"><i class="fa fa-reply"></i></a>
                        </td>
                        <td>
                            {{$message->created_at->diffForHumans()}}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-xs-center">
                    <td colspan="4">
                        <div class="section">
                            <h4>Not creating enough love? <i class="fa fa-frown-o"></i></h4>
                            <p class="lead"><a href="/mail/compose">Start by sending a message!</a></p>
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection