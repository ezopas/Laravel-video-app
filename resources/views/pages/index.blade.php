@extends('layouts.app')
@section('content')
    <h1>Welcome to {{config('app.name')}}</h1>
    <h3 class="text-muted">Newest added video:</h3>
    <div class="row">
        @foreach($posts as $post)
            <div class="col-sm-2">
                <a href="/posts/{{$post->id}}" style="color: #23241f;">
                    <img src="/storage/cover_images/{{$post->cover_image}}" style="max-width: 100%">
                    <strong>{{$post->title}}</strong>
                    <small>
                        <p>By {{$post->user->name}}</p>
                        <p>{{$post->views}} views | Posted on {{$post->created_at}}</p>
                    </small>

                </a>
            </div>
        @endforeach
    </div>
    <hr>
    <h3 class="text-muted">Most viewed video:</h3>
    <div class="row">
        @foreach($views as $view)
            <div class="col-sm-2">
                <a href="/posts/{{$view->id}}" style="color: #23241f;">
                    <img src="/storage/cover_images/{{$view->cover_image}}" style="max-width: 100%">
                    <strong>{{$view->title}}</strong>
                    <small>
                        <p>By {{$view->user->name}}</p>
                        <p>{{$view->views}} views | Posted on {{$view->created_at}}</p>
                    </small>

                </a>
            </div>
        @endforeach
    </div>
@endsection
