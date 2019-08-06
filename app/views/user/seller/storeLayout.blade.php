@extends('main')
    @section('title')
        Purchasetree.com
    @stop
    @section('styles')
        {{HTML::style('//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/bootstrap/css/bootstrap.min.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/css/shop.style.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/css/headers/header-v5.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/css/footers/footer-v4.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/animate.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/line-icons/line-icons.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/font-awesome/css/font-awesome.min.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/scrollbar/css/jquery.mCustomScrollbar.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/owl-carousel/owl-carousel/owl.carousel.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/revolution-slider/rs-plugin/css/settings.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/css/custom.css')}}
        {{HTML::style('/assets/asset_view/css/forestChange.css')}}
    @stop
    @section('content')
        <body class="header-fixed">
             <div class="wrapper">
                 <div class="header-v5 header-static">
                     <!-- Topbar v3 -->
                    <div class="topbar-v3">
                        <div class="search-open">
                            <div class="container">
                                <input type="text" class="form-control" placeholder="Search">
                                <div class="search-close"><i class="icon-close"></i></div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- Topbar Navigation -->
                                    <ul class="left-topbar">
                                        <li>
                                            <a>{{Lang::get('missing.current_lang')}}</a>
                                            <ul class="language">
                                                <li @if(Session::get('locale') == "en" ) class="active" @endif>
                                                    <a href="{{URL:: route('user.lang',"en")}}">{{Lang::get('missing.english_lang')}} @if(Session::get('locale') == "en" ) <i class="fa fa-check"></i> @endif</a>
                                                </li>
                                                <li @if(Session::get('locale') == "spn" )class="active" @endif >
                                                    <a href="{{URL:: route('user.lang',"spn")}}">{{Lang::get('missing.spanish_lang')}} @if(Session::get('locale') == "spn" ) <i class="fa fa-check"></i> @endif</a>
                                                </li>
                                                <li @if(Session::get('locale') == "rus" )class="active" @endif >
                                                    <a href="{{URL:: route('user.lang',"rus")}}">{{Lang::get('missing.russian_lang')}}) @if(Session::get('locale') == "rus" ) <i class="fa fa-check"></i> @endif</a>
                                                </li>
                                                <li @if(Session::get('locale') == "grm" )class="active" @endif>
                                                    <a href="{{URL:: route('user.lang',"grm")}}">{{Lang::get('missing.german_lang')}} @if(Session::get('locale') == "grm" ) <i class="fa fa-check"></i> @endif</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul><!--/end left-topbar-->
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-inline right-topbar pull-right">
                                        <?php if (Session::has('user_id')) {?>
                                        <li>
                                            <a href="{{URL::route('user.member')}}">{{Lang::get('user.layout_my_account')}}</a>
                                        </li>
                                        <?php }?>

                                        <li>
                                            <?php if (Session::has('user_id')) {?>
                                           <a href="{{URL::route('user.auth.doLogout')}}">{{Lang::get('user.layout_logout')}}</a>
                                            <?php }else{?>
                                             <a href="{{URL::route('user.auth.login')}}">{{Lang::get('user.layout_login')}}</a> | <a href="{{URL::route('user.auth.register')}}">{{Lang::get('user.register')}}</a>
                                            <?php }?>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div><!--/container-->
                    </div>
                    <!-- End Topbar v3 -->
                   <div class="navbar navbar-default mega-menu" role="navigation">
                       <div class="container">
                           <!-- Brand and toggle get grouped for better mobile display -->
                           <div class="navbar-header">
                               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                                   <span class="sr-only">Toggle navigation</span>
                                   <span class="icon-bar"></span>
                                   <span class="icon-bar"></span>
                                   <span class="icon-bar"></span>
                               </button>
                               <a class="navbar-brand" href="{{URL::route('user.home')}}" style="padding-top:0px">
                                   <img id="logo-header" src="/assets/asset_view/img/bg/logo.jpg" alt="Logo" style="width: 185px; height: 75px">
                               </a>
                           </div>

                           <!-- Collect the nav links, forms, and other content for toggling -->
                           <div class="collapse navbar-collapse navbar-responsive-collapse">
                               <!-- Shopping Cart -->
                               <ul class="list-inline shop-badge badge-lists badge-icons pull-right">
                                   <li>
                                       <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                       {{--<span class="badge badge-sea rounded-x">3</span>--}}

                                   </li>
                               </ul>
                               <!-- End Shopping Cart -->

                               <ul class="nav navbar-nav">
                                     <li class="<?php if($pageNo == 120){echo 'active';} ?>"><a href="{{URL::route('user.seller.store',$user_id)}}">{{Lang::get('user.layout_home')}}</a></li>
                                     <li class="<?php if($pageNo == 121){echo 'active';} ?>"><a href="{{URL::route('user.seller.category',$user_id)}}">{{Lang::get('user.layout_product_categories')}}</a></li>
                                     <li class="<?php if($pageNo == 122){echo 'active';} ?>"><a href="{{URL::route('user.seller.profile',$user_id)}}">{{Lang::get('user.company_profile')}}</a></li>
                                     <li class="<?php if($pageNo == 129){echo 'active';} ?>"><a href="{{URL::route('user.seller.store.contact',$user_id)}}">{{Lang::get('user.layout_contact')}}</a></li>
                                     <li class="<?php if($pageNo == 1){echo 'active';} ?>"><a href="{{URL::route('user.home')}}">{{Lang::get('user.layout_main')}}</a></li>
                               </ul>
                               <!-- End Nav Menu -->
                           </div>
                       </div>
                   </div>
                 </div>
                  @yield('body')
                  <!--<div class="container content margin-bottom-40">
                    <div class="row margin-bottom-40">
                        <div class="col-md-7 col-sm-7 col-md-offset-5 col-sm-offset-5" style="border:2px solid #ddd">
                              <h4>Email to this Seller</h4>
                              <div class="row ">
                                 <form class="col-md-12 form-horizontal" action="{{URL::route('user.seller.send')}}" method="post">
                                      <div class="form-group">
                                            <label for="inputEmail1" class="col-lg-2 col-md-2 col-sm-3 col-xs-3 control-label">{{Lang::get('user.to')}}</label>
                                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">
                                                <input type="text" value="{{$userProfile->firstname . " ". $userProfile->lastname}}" class="form-control" style=" border:0px!important">
                                            </div>
                                       </div>
                                       <div class="form-group">
                                            <label for="inputEmail1" class="col-lg-2 col-md-2 col-sm-3 col-xs-3 control-label">{{Lang::get('user.message')}}</label>
                                            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">
                                                <textarea class="form-control" name="message" rows="10"></textarea>
                                            </div>
                                       </div>
                                       <input type="hidden" name="user_id" value="{{$user_id}}">
                                       <div class="form-group">
                                           <div class="col-lg-offset-2 col-lg-10 col-md-offset-2 col-md-10 col-sm-9 col-sm-offset-3 col-xs-9 col-xs-offset-3">
                                               <button type="submit" class="btn-u btn-u-green">{{Lang::get('user.send')}}</button>
                                           </div>
                                       </div>
                                 </form>
                              </div>
                        </div>
                    </div>
                  </div>-->
             </div>
             <div class="contact-us-div"><a href="{{URL::route('user.contact.contact')}}" class="contact-us-div-a"><i class="fa fa-comments-o"></i> Contact US</a> </div>
        </body>
    @stop
   @section ('scripts')
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/jquery/jquery.min.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/jquery/jquery-migrate.min.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/bootstrap/js/bootstrap.min.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/back-to-top.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/smoothScroll.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/jquery.parallax.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/js/custom.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/js/shop.app.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/js/plugins/owl-carousel.js') }}
           {{ HTML::script('/assets/asset_view/shop-ui/js/plugins/revolution-slider.js') }}
           {{ HTML::script('/assets/assest_admin/js/bootbox.js') }}
           <script>
               jQuery(document).ready(function() {
                   App.init();
                   App.initScrollBar();
                   App.initParallaxBg();
                   OwlCarousel.initOwlCarousel();
                   RevolutionSlider.initRSfullWidth();
           });
           </script>
   	@stop
@stop