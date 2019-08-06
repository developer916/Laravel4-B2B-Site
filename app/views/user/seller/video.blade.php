@extends('main')
    @section('styles')
        {{HTML::style('/assets/asset_view/css/style.css')}}
        {{ HTML::style('/assets/asset_view/css/video-js.css') }}
        {{ HTML::style('/assets/asset_view/css/forestChange.css') }}
    @stop
    @section('content')
        <video id="example_video_1" class="video-js vjs-default-skin bottom-40"
                    controls preload="none"  height="264" width="100%"
                    poster="/assets/logos/<?php echo $companyProfile[0]->marketingpicture; ?>"
                    data-setup="{}" style="width:100%; height: 100%;">
                    <source src="/assets/logos/<?php echo $companyProfile[0]->marketingvideo; ?>"
                    type='video/mp4' ></source>
                    <track kind="captions" src="/assets/asset_view/img/icons/video-play.png" srclang="en"
                            label="English" ></track>
        </video>
    @stop
    @section('scripts')
        {{ HTML::script('/assets/asset_view/js/video.js') }}
            {{ HTML::script('/assets/asset_view/js/video.min.js') }}
    @stop
@stop