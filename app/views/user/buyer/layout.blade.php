@extends('user.layout')

    @section('body')
        <div class="container content margin-bottom-40">
            <div class="row dashboardDivRow  margin-bottom-40">
                <div class="col-md-12">
                    <h4 class="buyerHeader margin-bottom-10">{{Lang::get('user.buyer_dashboard')}}</h4>
                </div>
                <div class="col-md-12">
                    <div class="col-md-2 text-center">
                        <h2 class="buyerHeaderRed margin-bottom-10">{{$title}}</h2>
                    </div>
                </div>
                <div class="col-md-12  margin-bottom-40">
                    <div class="col-md-2 text-center col-sm-2 ">
                        <div class="row">
                            <div class="col-md-12 leftMenu">
                                <div class="row">
                                    @if(Session::get('user_type') != 1)
                                    <div class="col-md-12">
                                        <a href="{{URL::route('user.buyer.email','new')}}" class="display_inline padding-top-10 <?php if($subPageNo == 2) {echo "selectOrderItem"; }?>">
                                            <img src="/assets/images/email.jpg">
                                            <p class="leftMenuSub">{{Lang::get('user.email')}}({{$emailCount}})</p>

                                        </a>
                                    </div>

                                    <div class="col-md-12">
                                        <a href="{{URL::route('user.buyer.favorite')}}" class="display_inline padding-top-10 <?php if($subPageNo == 3) {echo "selectOrderItem"; }?>">
                                            <img src="/assets/images/favorite.jpg">
                                            <p class="leftMenuSub">{{Lang::get('user.favorite')}}</p>
                                        </a>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="{{URL::route('user.buyer.dashboard')}}" class="display_inline padding-top-10 <?php if($subPageNo == 1) {echo "selectOrderItem"; }?>" >
                                            <img src="/assets/images/order.jpg">
                                            <p class="leftMenuSub">{{Lang::get('user.my_orders')}}</p>
                                        </a>
                                    </div>
                                    @endif
                                    <div class="col-md-12">
                                        <a href="{{URL::route('user.buyer.cart')}}" class="display_inline padding-top-10  <?php if($subPageNo == 5) {echo "selectOrderItem"; }?>">
                                            <img src="/assets/images/cart.jpg">
                                            <p class="leftMenuSub">{{Lang::get('user.shopping_cart_seller')}}</p>
                                        </a>
                                    </div>
                                    @if(Session::get('user_type') != 1)
                                    <div class="col-md-12 margin-bottom-20">
                                        <a href="{{URL::route('user.buyer.rfq')}}" class="display_inline padding-top-10 <?php if($subPageNo == 4) {echo "selectOrderItem"; }?>">
                                            <img src="/assets/images/rfq.jpg">
                                            <p class="leftMenuSub">{{Lang::get('user.buyer_rfq')}}</p>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @yield('body-right')
                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        @yield('custom-scripts-sub')
    @stop
@stop
