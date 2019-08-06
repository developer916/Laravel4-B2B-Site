@extends('main')
	@section('title')
		{{Lang::get('user.layout_purchasetree_escrow')}}
	@stop
    @section('styles')
      <link rel="shortcut icon" href="favicon.ico">
      {{HTML::style('//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin')}}
      {{HTML::style('/assets/asset_view/plugins/bootstrap/css/bootstrap.min.css')}}
      {{HTML::style('/assets/asset_view/css/style.css')}}
      {{HTML::style('/assets/asset_view/css/headers/header-default.css')}}
      {{HTML::style('/assets/asset_view/css/footers/footer-v1.css')}}
      {{HTML::style('/assets/asset_view/plugins/animate.css')}}
      {{HTML::style('/assets/asset_view/plugins/line-icons/line-icons.css')}}
      {{HTML::style('/assets/asset_view/plugins/font-awesome/css/font-awesome.min.css')}}
      {{HTML::style('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.css')}}
      {{HTML::style('/assets/asset_view/plugins/revolution-slider/rs-plugin/css/settings.css')}}
      {{HTML::style('/assets/asset_view/css/custom.css')}}

    @stop
	@section('content')
        <body>

        <div class="wrapper">
            <div class="header">
                <div class="container">
                    <!-- Logo -->
                    <a class="logo" href="{{URL::route('user.home')}}" style="float: left;">
                        <img src="/assets/assest_admin/img/332563ae50abec_Logo-01.jpg" alt="Logo" style="width: 185px; height: 50px">
                    </a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">
                    <div class="container">
                        <ul class="nav navbar-nav">
                            <?php if(Session::get('escrow_user_id')) {?>
                            <li class="<?php if($pageNo == 250) {echo 'active';}?>"><a href="{{URL::route('user.escrow.index')}}">{{Lang::get('user.layout_home')}}</a></li>
                            <li class="@if($pageNo == 256) active @endif">
                                <a href="{{URL::route('user.escrow.shoppingCart')}}">{{Lang::get('cart.shopping_cart')}}</a>
                            </li>
                            <?php } else{ ?>
                            <li class="<?php if($pageNo == 251) {echo 'active';}?>"><a href="{{URL::route('user.escrow.login')}}">{{Lang::get('user.layout_login')}}</a></li>
                            <li class="<?php if($pageNo == 252) {echo 'active';}?>"><a href="{{URL::route('user.escrow.register')}}">{{Lang::get('user.register')}}</a></li>
                            <?php } ?>
                            <li class="<?php if($pageNo == 253) {echo 'active';}?>"><a href="{{URL::route('user.escrow.register')}}">{{Lang::get('user.layout_help')}}</a></li>
                           <?php if(Session::get('escrow_user_id')){ ?>
                            <li class="<?php if($pageNo == 255) {echo 'active';}?>"><a href="{{URL::route('user.escrow.doLogout')}}">{{Lang::get('user.layout_logout')}}</a></li>
                            <?php } ?>
                            <li class="<?php if($pageNo == 254) {echo 'active';}?>"><a href="{{URL::route('user.home')}}">{{Lang::get('user.layout_main')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @yield('body')
        </div>
    </body>
    @stop
    @section ('scripts')
            {{ HTML::script('/assets/asset_view/plugins/jquery/jquery.min.js') }}
            {{ HTML::script('/assets/asset_view/plugins/jquery/jquery-migrate.min.js') }}
            {{ HTML::script('/assets/asset_view/plugins/bootstrap/js/bootstrap.min.js') }}
            {{ HTML::script('/assets/asset_view/plugins/back-to-top.js') }}
            {{ HTML::script('/assets/asset_view/plugins/smoothScroll.js') }}
            {{ HTML::script('/assets/asset_view/plugins/jquery.parallax.js') }}
            {{ HTML::script('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}
            {{ HTML::script('/assets/asset_view/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js') }}
            {{ HTML::script('/assets/asset_view/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js') }}
            {{ HTML::script('/assets/asset_view/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js') }}
            {{ HTML::script('/assets/asset_view/js/custom.js') }}
            {{ HTML::script('/assets/asset_view/js/app.js') }}
            {{ HTML::script('/assets/asset_view/js/plugins/owl-carousel.js') }}
            {{ HTML::script('/assets/asset_view/js/plugins/revolution-slider.js') }}
            {{ HTML::script('/assets/assest_admin/js/bootbox.js') }}
             {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    App.init();
                    OwlCarousel.initOwlCarousel();
                    RevolutionSlider.initRSfullWidth();
                });
            </script>

    @stop
@stop

