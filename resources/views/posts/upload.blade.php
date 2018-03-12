@extends('layouts.app')

@section('content')
    <script>
        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile() {
            var file = _("file1").files[0];
            // alert(file.name+" | "+file.size+" | "+file.type);
            var formdata = new FormData();
            formdata.append("file1", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "file_upload_parser.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
            //use file_upload_parser.php from above url
            ajax.send(formdata);
        }

        function progressHandler(event) {
            _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBar").value = Math.round(percent);
            _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandler(event) {
            _("status").innerHTML = event.target.responseText;
            _("progressBar").value = 0; //wil clear progress bar after successful upload
        }

        function errorHandler(event) {
            _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
        }
    </script>

    <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
    <h3 id="status"></h3>
    <p id="loaded_n_total"></p>


    <h1>Uload video</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
        <div class="form-group">
            <label>Upload video</label>
            {{Form::file('source', ['accept' => 'video/*', 'required' => 'required', 'id' => 'fileUploader', 'onchange' => 'uploadFile()', 'id' => 'file1'])}}
        </div>
        <div class="form-group">
            <label>Upload image</label>
            {{Form::file('cover_image', ['accept' => 'image/*', 'required' => 'required'])}}
        </div>
        <div class="form-group">
            <label>Video title</label>
            {{Form::text('title', '', ['class' => 'form-controll', 'placeholder' => 'Enter video title', 'required' => 'required'])}}
        </div>
        <div class="form-group">
            <label>Description</label>
            {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'required' => 'required'])}}
        </div>
        {{--<div class="form-group">--}}
            {{--<label>Password</label>--}}
            {{--{{Form::password('password', ['class' => 'form-controll'])}}--}}
            {{--<small><i>If no password - leave empty</i></small>--}}
        {{--</div>--}}

        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection