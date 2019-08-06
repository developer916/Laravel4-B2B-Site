@extends('user.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/blocks.css')}}
        @yield('custom-member-styles')
    @stop
    @section('body')
        <div class="breadcrumbs">
            <div class="container">
                <h1 class="pull-left">
                    <?php
                        echo Lang::get('user.layout_my_account');
                    ?>
                </h1>
                 <ul class="pull-right breadcrumb">
                        <li><a href="{{URL::route('user.member')}}">{{Lang::get('user.layout_my_account')}}</a></li>
                        @yield('list')
                    </ul>
            </div>
        </div>
        <div class="container content">
            <div class="row tab-v3 margin-bottom-40">
                <div class="col-md-3 col-sm-3">
                   <ul class="nav nav-pills nav-stacked">
                        <li <?php if($pageNo ==130) {echo 'class="active"';}?>><a href="{{URL::route('user.member')}}"><i class="fa fa-home"></i> {{Lang::get('user.layout_my_profile')}}</a></li>
                        <li <?php if($pageNo ==131) {echo 'class="active"';}?>><a href="{{URL::route('user.member.password')}}"><i class="fa fa-key"></i>  {{Lang::get('user.change_password')}}</a></li>
                        <li <?php if($pageNo ==132) {echo 'class="active"';}?>><a href="{{URL::route('user.member.company')}}"><i class="fa fa-bars"></i> {{Lang::get('user.company_profile')}}</a></li>
                        <li <?php if($pageNo ==133) {echo 'class="active"';} ?>><a href="{{URL::route('user.member.video')}}"><i class="fa  fa-file-video-o"></i> {{Lang::get('user.marketing_video')}}</a></li>
                        <li <?php if($pageNo ==134) {echo 'class="active"';} ?>><a href="{{URL::route('user.member.product')}}"><i class="fa  fa-file-image-o"></i> {{Lang::get('user.product_picture')}}</a></li>
                   </ul>
                </div>
                <div class="col-md-9 col-sm-9">
                    @yield('body-content')
                </div>
             </div>
        </div>
    @stop
    @section('custom-scripts')
        @yield('custom-member-scripts')
    @stop
@stop
