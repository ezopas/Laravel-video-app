@extends('layouts.app')

@section('content')

    <div class='progress' id="progress_div">
        <div class='progress-bar progress-bar-striped progress-bar-animated' id='bar'></div>
        <div class='percent text-center' id='percent' style="color: grey;">0%</div>
    </div>

    <div id='output_image'>

    </div>

    <h1>Upload video</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'myForm'])!!}
        <div class="form-group">
            <label>Upload video</label>
            {{Form::file('source', ['accept' => 'video/*', 'required' => 'required', 'id' => 'upload_file'])}}
        </div>
        <div class="form-group">
            <label>Upload image</label>
            {{Form::file('cover_image', ['accept' => 'image/*', 'required' => 'required'])}}
        </div>
        <div class="form-group">
            <label>Video title</label>
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Enter video title', 'required' => 'required'])}}
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

        {{Form::submit('Submit', ['class' => 'btn btn-primary', 'onclick' => "upload_image();"])}}
    {!! Form::close() !!}

    <script src="http://talkerscode.com/webtricks/demo/js/jquery.js"></script>
    <script src="http://talkerscode.com/webtricks/demo/js/jquery.form.js"></script>
    <script type="text/javascript">
        function upload_image()
        {
            var bar = $('#bar');
            var percent = $('#percent');
            $('#myForm').ajaxForm({
                beforeSubmit: function() {
                    document.getElementById("progress_div").style.display="block";
                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },

                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },

                success: function() {
                    var percentVal = '100%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },

                complete: function(xhr) {
                    if(xhr.responseText)
                    {
                        document.getElementById("output_image").innerHTML=xhr.responseText;
                    }
                }
            });
        }
    </script>
@endsection