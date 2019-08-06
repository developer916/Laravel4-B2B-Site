@extends('main')
	@section('title')
		Purchasetree.com
	@stop
	@section('styles')
	    <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin'>
	    {{HTML::style('//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin')}}
        {{HTML::style('/assets/asset_view/plugins/bootstrap/css/bootstrap.min.css')}}
        {{HTML::style('/assets/asset_view/css/shop.style.css')}}
        {{HTML::style('/assets/asset_view/plugins/animate.css')}}
        {{HTML::style('/assets/asset_view/plugins/line-icons/line-icons.css')}}
        {{HTML::style('/assets/asset_view/plugins/font-awesome/css/font-awesome.min.css')}}
        {{HTML::style('/assets/asset_view/css/pages/page_log_reg_v2.css')}}
        {{HTML::style('/assets/asset_view/css/custom.css')}}
         {{HTML::style('/assets/asset_view/css/app.css')}}
	@stop
	@section('content')
	    <body>
        <!--=== Content Part ===-->
        <div class="container">
            <!--Reg Block-->
            <form method="post" action="{{URL::route('user.auth.forgotSend')}}">
                <div class="reg-block">
                    <div class="reg-block-header">
                        <h2>{{Lang::get('user.forgot_password')}}</h2>
                    </div>
                     @if ($errors->has())
                        <div class="alert alert-danger alert-dismissibl fade in">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                        @endif
                         <?php if (isset($alert)) { ?>
                            <div class="alert alert-<?php echo $alert['type'];?> alert-dismissibl fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <p>
                                    <?php echo $alert['msg'];?>
                                </p>
                            </div>
                        <?php } ?>
                     <div class="row ">
                        <div class="col-md-12 col-sm-12 text-right">
                            <a href="{{URL::route('user.auth.login')}}" class="color-green">{{Lang::get('user.login')}}</a>
                        </div>
                    </div>
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control" placeholder="{{Lang::get('user.email_address')}}" name="email">
                    </div>
                    <div class="row ">
                        <div class="col-md-4 col-sm-4 col-md-offset-8 col-sm-offset-8 margin-bottom-40 text-right">
                            <button type="submit" class="btn-u btn-block">{{Lang::get('user.send')}}</button>
                        </div>
                    </div>
                </div>
                <!--End Reg Block-->
            </form>
        </div><!--/container-->
        <!--=== End Content Part ===-->
	@stop
	@section ('scripts')
            {{ HTML::script('/assets/asset_view/plugins/jquery/jquery.min.js') }}
            {{ HTML::script('/assets/asset_view/plugins/jquery/jquery-migrate.min.js') }}
            {{ HTML::script('/assets/asset_view/plugins/bootstrap/js/bootstrap.min.js') }}
            {{ HTML::script('/assets/asset_view/plugins/back-to-top.js') }}
            {{ HTML::script('/assets/asset_view/plugins/backstretch/jquery.backstretch.min.js') }}
            {{ HTML::script('/assets/asset_view/js/custom.js') }}
            {{ HTML::script('/assets/asset_view/js/app.js') }}
            {{ HTML::script('/assets/asset_view/js/jquery.pwstrength.js') }}
            <script>
                jQuery(document).ready(function() {
                    App.init();
                 });
                $.backstretch([
                       "/assets/asset_view/img/bg/19.jpg",
                       "/assets/asset_view/img/bg/18.jpg",
                       ], {
                         fade: 1000,
                         duration: 7000
                });
            </script>
    	@stop
@stop