@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>Posts</h1>
            <p class="lead">Manage Posts</p>
        </div>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Types
                    </th>
                    <th>
                        Comments Count
                    </th>
                    <th>
                        Start Postal Code
                    </th>
                    <th>
                        End Postal Code
                    </th>
                    <th>
                        Created At
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
            @if(count($posts) > 0)
                @foreach($posts as $post)
                    <tr>
                        <td>
                            <a href="/post/{{ $post->id }}">{{ $post->name }}</a>
                        </td>
                        <td>
                            <div class="tag tag-default tag-trip">{{ ($post->postable_type == \App\LocalTrip::class)? 'Local' : 'Long Distance'}}</div>
                            <div class="tag tag-info">{{ ($post->one_time)? 'One Time' : 'Frequent'}}</div>
                        </td>
                        <td>
                            {{ count($post->messages) }}
                        </td>
                        <td>
                            {{ $post->departure_pcode }}
                        </td>
                        <td>
                            {{ $post->destination_pcode }}
                        </td>
                        <td>
                            {{ $post->created_at }}
                        </td>
                        <td>
                            <a href="/post/{{ $post->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="delete d-inline btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Delete</a>
                            <form action="/post/{{$post->id}}/" method="post" style="display: none">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-xs-center">
                    <td colspan="6">
                        <div class="section">
                            <h4>No Posts... <i class="fa fa-frown-o"></i></h4>
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection