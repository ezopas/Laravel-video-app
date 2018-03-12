@extends('layouts.app')

@section('content')
    <script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
    @if(!Auth::guest())
        <a href="/posts" class="btn btn-default">Go Back</a>
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-primary pull-right">Edit</a>
        @endif
    @endif
    </div>
    <br>
    <div class="row container-fluid">
        <div class="col-md-8 col-sm-12">
            <video id="my-video" class="video-js vjs-16-9" controls preload="auto" style="width:100%;" poster="/storage/cover_images/{{$post->cover_image}}" data-setup='{"playbackRates": [0.75, 1, 1.25, 1.5, 2], "controls": true, "autoplay": true, "preload": "auto" }'>
                <source src="/storage/video/{{$post->source}}" type='video/mp4'>
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a web browser that
                    <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                </p>
            </video>
            <h1>{{$post->title}}</h1>

            <button type="button" class="btn btn-info btn-md pull-right" data-toggle="modal" data-target="#myModal">Share</button>

            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Share this video</h4>
                        </div>
                        <div class="modal-body">

                            <strong>Embed</strong>
                            <textarea class="form-control">&#x3C;iframe width=&#x22;560&#x22; height=&#x22;315&#x22; src=&#x22;{{ config('app.url') }}/embed/{{$post->id}}&#x22; frameborder=&#x22;0&#x22; allow=&#x22;encrypted-media&#x22; allowfullscreen&#x3E;&#x3C;/iframe&#x3E;</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <div>
                <p>{{$post->views }} views</p>
                <small>
                    Written on {{$post->created_at}}<br>
                    Published by <b>{{$post->user->name}}</b>
                </small>
                <div class="text-muted">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title text-center">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Description</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">{!!$post->description !!}</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-4 col-sm-12">
            @foreach($posts as $post)
                <a href="/posts/{{$post->id}}">
                    <div>
                        <div class="row">
                            <div class="col-sm-4">
                                <img src="/storage/cover_images/{{$post->cover_image}}" style="max-width: 100%">
                            </div>
                            <div class="col-sm-8">
                                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                                <small>Posted on {{$post->created_at}}  by {{$post->user->name}} | {{$post->views}} views</small>
                                <div>
                                    <p>{!!$post->description !!}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </a>

            @endforeach
        </div>
    </div>

@endsection