@extends('layouts.app')

@section('content')
    <h1>Edit video post</h1>
    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST'])!!}
    <div class="form-group">
        <label>Video title</label>
        {{Form::text('title', $post->title, ['class' => 'form-controll', 'placeholder' => 'Enter video title'])}}
    </div>
    <div class="form-group">
        <label>Description</label>
        {{Form::textarea('description', $post->description, ['id' => 'article-ckeditor', 'class' => 'form-control'])}}
    </div>
    {{--<div class="form-group">--}}
        {{--<label>Password</label>--}}
        {{--{{Form::password('password', ['class' => 'form-controll'])}}--}}
        {{--<small><i>If no password - leave empty</i></small>--}}
    {{--</div>--}}
    <div class="form-group">
        <label>Upload image</label>
        {{Form::file('cover_image', ['accept' => 'image/*'])}}
    </div>
    <div class="form-group">
        <label>Upload video:</label>
        <strong><em>{{$post->source}}</em></strong>
    </div>
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!!Form::close()!!}

    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection