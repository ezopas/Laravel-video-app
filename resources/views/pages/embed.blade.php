<style>
    *{
        margin: 0;
        padding: 0;
    }
</style>
<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
<video id="my-video" class="video-js vjs-16-9" controls style="width:100%;" poster="/storage/cover_images/{{$post->cover_image}}" data-setup='{"playbackRates": [0.75, 1, 1.25, 1.5, 2], "controls": true, "autoplay": false, "preload": "auto" }'>
    <source src="/storage/video/{{$post->source}}" type='video/mp4'>
    <p class="vjs-no-js">
        To view this video please enable JavaScript, and consider upgrading to a web browser that
        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
</video>