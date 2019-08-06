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
                <!--=== Header v5 ===-->
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
                                <div class="col-sm-6 col-xs-6">
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
                                <div class="col-sm-6 col-xs-6">
                                    <ul class="list-inline left-topbar pull-right">
                                       <?php if(Session::has('user_id') && Session::get('user_type')  == 2){?>
                                            <li>
                                               <a href="javascript:void(0)" onclick = "OnBecomeSeller()">{{Lang::get('user.add_seller')}}</a>
                                            </li>
                                        <?php }?>
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

                    <!-- Navbar -->
                    <div class="navbar navbar-default mega-menu" role="navigation" >
                        <div class="container">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <button type="button" class="navbar-toggle navbar-toggle1 pull-left mar-left-10 hidden-sm hidden-md hidden-lg mobile-category-btn" onclick="slideMobileCategory()">
                                    <div class="categories-indicator-main">
                                        <div class="indicator">
                                            <div class="dot"></div>
                                            <div class="line"></div>
                                        </div>
                                        <div class="indicator">
                                            <div class="dot"></div>
                                            <div class="line"></div>
                                        </div>
                                        <div class="indicator">
                                            <div class="dot"></div>
                                            <div class="line"></div>
                                        </div>
                                    </div>
                                </button>
                                <a class="navbar-brand" href="{{URL::route('user.home')}}" style="padding-top:0px;">
                                    <img id="logo-header" src="/assets/assest_admin/img/332563ae50abec_Logo-01.jpg" alt="Logo" style="width: 185px; height: 75px">
                                </a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse navbar-responsive-collapse">
                                <!-- Shopping Cart -->
                                <ul class="list-inline shop-badge badge-lists badge-icons pull-right">
                                    <li>
                                        <a href="{{route('user.addCart.index')}}"><i class="fa fa-shopping-cart"></i></a>
                                        {{--<span class="badge badge-sea rounded-x">3</span>--}}

                                    </li>
                                </ul>
                                <ul class="nav navbar-nav">
                                    <!-- Pages -->
                                   <li class="<?php if($pageNo == 1) {echo 'active';}?>"><a href="{{URL::route('user.home')}}">{{Lang::get('user.layout_home')}}</a></li>

                                    <li class="dropdown <?php if($pageNo == 20 || $pageNo == 25) {echo 'active';}?>">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                                           {{Lang::get('user.layout_for_buyer')}}
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php
                                              if(Session::get('user_type') !=1){
                                            ?>
                                            <li class=" <?php if($pageNo == 20) {echo 'active';}?>"><a href="{{URL::route('user.category')}}">{{Lang::get('user.layout_categories')}}</a></li>
                                            <li><a href="">{{Lang::get('user.layout_get_quote')}}</a></li>
                                            <li><a href="{{URL::route('user.escrow.index')}}">{{Lang::get('user.layout_escrow')}}</a></li>
                                            <li class="<?php if($pageNo == 28) {echo 'active';}?>"><a href="{{URL::route('user.inspection')}}">{{Lang::get('user.layout_inspection')}}</a></li>
                                             <?php }    if (Session::has('user_id')) {?>
                                            <li class=" <?php if($pageNo == 25) {echo 'active';}?>"><a href="{{URL::route('user.buyer.dashboard')}}">{{Lang::get('user.layout_my_dashboard')}}</a></li>
                                             <?php }?>
                                        </ul>
                                    </li>
                                    <!-- End Pages -->

                                    <!-- Promotion -->
                                    <?php  if(Session::get('user_type') !=2){?>
                                    <li class="dropdown <?php if($pageNo == 20 || $pageNo == 35 || $pageNo == 33) {echo 'active';}?>">

                                        <a href="javascript:void(0);" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                                            {{Lang::get('user.layout_for_seller')}}
                                        </a>
                                        <ul class="dropdown-menu">
                                             <li class=" <?php if($pageNo == 20) {echo 'active';}?>"><a href="{{URL::route('user.category')}}">{{Lang::get('user.layout_categories')}}</a></li>
                                            <li class=" <?php if($pageNo == 33) {echo 'active';}?>"><a href="{{URL::route('user.seller.rfq')}}">{{Lang::get('user.layout_rfq_search')}}</a></li>
                                             <?php if (Session::has('user_id')) {?>
                                            <li class=" <?php if($pageNo == 35) {echo 'active';}?>"><a href="{{URL::route('user.seller.dashboard')}}">{{Lang::get('user.layout_my_dashboard')}}</a></li>
                                            <?php }?>
                                         </ul>
                                    </li>
                                    <?php }?>
                                    <!-- End Promotion -->
                                    <!-- Main Demo -->
                                    <li class="<?php if($pageNo == 10){echo 'active';} ?>"><a href="{{URL::route('user.help')}}">{{Lang::get('user.layout_help')}}</a></li>
                                    <!-- Main Demo -->
                                </ul>
                                <!-- End Nav Menu -->
                            </div>
                        </div>
                    </div>
                    <!-- End Navbar -->
                </div>
                <!--=== End Header v5 ===-->
                 @yield('body')
            </div>
            <div class="contact-us-div"><a href="{{URL::route('user.contact.contact')}}" class="contact-us-div-a"><i class="fa fa-comments-o"></i> Contact US</a> </div>

            <div class="modal fade" id="myModalSellerBecome" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modalChangeContent">
                        <div class="modal-header modalChangeHeader">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.are_you_sure_what_you_want')}}</h4>
                        </div>
                        <div class="modal-body" id="myModaltext">
                            <p>{{Lang::get('user.become_seller_list_1')}}</p>
                            <p>{{Lang::get('user.become_seller_list_2')}} <a href="{{URL::route('user.member.company')}}">{{Lang::get('user.click_here')}}</a></p>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <input type="radio" name="radio" value="s" <?php if(Session::get('user_type') =="1") {echo "checked";}?>> Seller &nbsp;&nbsp;
                                    <input type="radio" name="radio" value="c" <?php if(Session::get('user_type') =="2") {echo "checked";}?>>  Buyer  &nbsp;&nbsp;
                                    <input type="radio" name="radio" value="b" <?php if(Session::get('user_type') =="3") {echo "checked";}?>>  Both   &nbsp;&nbsp;
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-u btn-u-blue"  style="margin-right: 10px" onclick="OnSendBecomeSeller()">{{Lang::get('user.do_it_now')}}</button>
                            <button type="button" class="btn default"  data-dismiss="modal">{{Lang::get('user.do_it_later')}}</button>
                        </div>
                    </div>
                </div>
            </div>

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
        {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
        <script>
            jQuery(document).ready(function() {
                App.init();
                App.initScrollBar();
                App.initParallaxBg();
                OwlCarousel.initOwlCarousel();
                RevolutionSlider.initRSfullWidth();
        });
        function OnBecomeSeller(){
             var a = $("<a>")
                    .attr("href", "#myModalSellerBecome")
                    .attr("data-toggle","modal")
                    .appendTo("body");

                    a[0].click();

                    a.remove();
            }
         function OnSendBecomeSeller(){
            var user_type = ($('input[name=radio]:checked').val());
             var base_url = window.location.origin;
               $.ajax ({
                    url: '{{ route("user.member.confirm") }}',
                    type: 'POST',
                    data: {user_type : user_type},
                    cache: false,
                    dataType : "json",
                    success: function (data) {
                        $("#myModalSellerBecome").hide();
                        bootbox.alert(data);
                        window.location.reload();
                    }
               });
         }
        </script>
	@stop
@stop