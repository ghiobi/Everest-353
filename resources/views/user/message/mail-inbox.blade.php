@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4">
                Mail Inbox
            </h1>
            <p class="lead">Get cracking with people!</p>
        </div>
    </div>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Mail Inbox</li>
            <li class="breadcrumb-item"><a href="/mail/sent">Mail Sent</a></li>
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
                                <img src="{{ $message->sender->avatarUrl(30) }}" width="35" class="img-fluid rounded-circle" alt=""> {{ $message->sender->fullName() }}
                            </td>
                            <td>
                                {{ $message->body }}
                            </td>
                            <td>
                                <a href="/mail/compose?recipient_id={{ $message->sender->id }}" title="reply"><i class="fa fa-reply"></i></a>
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
                                <h4>Have no message? <i class="fa fa-frown-o"></i></h4>
                                <p class="lead">Find a friend who can help you by finding a ride!</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection