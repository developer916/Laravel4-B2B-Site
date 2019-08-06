@extends('main')
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
    <?php $cart = $shoppingCartProduct->ShoppingCart; $product = $shoppingCartProduct->product;?>
    <div class="container content">
        <div class="row">
            <div class="col-md-12">
                <div class="row" style="border-bottom: 1px solid #D5D5D5;">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <img src="/assets/asset_view/img/332563ae50abec_Logo-01.jpg" class="invoiceImage">
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h1  class="invoiceTitle ">{{Lang::get('user.invoice')}}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row margin-bottom-30">
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <p class = "invoiceHeader" >{{Lang::get('user.invoiceHeader')}}</p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <div class="row" >
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <p class = "invoiceHeader1" >{{Lang::get('user.invoice_no')}}</p>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <p class = "invoiceHeader1" >{{$cart->invoice_number}}</p>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <p>{{Lang::get('user.date')}}</p>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <p>{{substr($shoppingCartProduct->created_at,0,10)}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buyer and Seller account Function -->
                <div class="row margin-bottom-30">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-6">
                                <h4 style="font-weight: 900">{{Lang::get('user.buyer')}}</h4>
                                <p>{{$buyer->firstname." ". $buyer->lastname}}</p>
                                <p>{{$buyer->street}}</p>
                                <p>{{$buyer->city.", ". $buyer->state.", ". $buyer->zipcode.", ". $buyerCountry->country_name}}</p>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-6">
                                <h4 style="font-weight: 900">{{Lang::get('user.seller')}}</h4>
                                <p>{{$seller->firstname." ". $seller->lastname}}</p>
                                <p>{{$seller->street}}</p>
                                <p>{{$seller->city.", ". $seller->state.", ". $seller->zipcode.", ". $sellerCountry->country_name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row margin-bottom-30">
                    <div class="col-md-12">
                        <table  class="invoiceTable">
                            <thead>
                            <tr class="invoiceTableHeaderTr">
                                <th style="width:20%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.product_image'))?></th>
                                <th style="width:10%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.quantity'))?></th>
                                <th style="width:10%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.product_size'))?></th>
                                <th style="width:10%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.color'))?></th>
                                @if($shoppingCartProduct->shipping_price !="")
                                <th style="width:15%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.product_title'))?></th>
                                <th style="width:10%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.shipping_price'))?></th>
                                @else
                                <th style="width:30%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.product_title'))?></th>
                                @endif
                                <th style="width:10%" class="invoiceTableHeaderTD">{{Lang::get('user.unit_price')}}</th>
                                <th style="width:20%" class="invoiceTableHeaderTD">{{Lang::get('user.line_total')}}</th>
                                {{--<th></th>--}}
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td  class="invoiceTableBodyTD"><img src="{{$shoppingCartProduct->image_url}}" style="width: 70%"></td>
                                    <td  class="invoiceTableBodyTD">{{$shoppingCartProduct->qty." ".$shoppingCartProduct->unit}}</td>
                                    <td  class="invoiceTableBodyTD">{{$shoppingCartProduct->size}}</td>
                                    <td  class="invoiceTableBodyTD">@if($shoppingCartProduct->color != "") {{$shoppingCartProduct->color}} @else {{"Any Colors"}}@endif</td>
                                    @if($shoppingCartProduct->shipping_price !="")
                                    <td  class="invoiceTableBodyTD">{{$product->product_name}}</td>
                                    <td  class="invoiceTableBodyTD"> {{$shoppingCartProduct->shipping_price , "USD"}}</td>
                                    @else
                                    <td  class="invoiceTableBodyTD">{{$product->product_name}}</td>
                                    @endif
                                    <td  class="invoiceTableBodyTD">{{$shoppingCartProduct->product_price."USD"}}</td>
                                    <td  class="invoiceTableBodyTD">{{$shoppingCartProduct->sub_total. "USD"}}</td>
                                </tr>
                                <tr>
                                    <td  class="invoiceTableBodyTD" style="height:40px">&nbsp;</td>
                                    <td  class="invoiceTableBodyTD">&nbsp;</td>
                                    <td  class="invoiceTableBodyTD">&nbsp;</td>
                                    <td  class="invoiceTableBodyTD">&nbsp;</td>
                                    @if($shoppingCartProduct->shipping_price !="")
                                        <td  class="invoiceTableBodyTD">&nbsp;</td>
                                        <td  class="invoiceTableBodyTD">&nbsp;</td>
                                    @else
                                        <td  class="invoiceTableBodyTD">&nbsp;</td>
                                    @endif
                                    <td  class="invoiceTableBodyTD">&nbsp;</td>
                                    <td  class="invoiceTableBodyTD">@if(Session::get('user_id') == $buyer->id )<?php  $escrow_fee = round( ($fee->fee/100)*$shoppingCartProduct->sub_total,2); echo $escrow_fee." USD"; ?> @else <?php $escrow_fee = 0;?>&nbsp;@endif</td>
                                </tr>
                                <tr>
                                    <td style="height:40px">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    @if($shoppingCartProduct->shipping_price !="")
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    <td style="text-align:right"><font style="font-weight:700; font-size:13px; text-align:right">{{Lang::get("missing.total")}}</font></td>
                                    <td class="invoiceTableBodyTD"><?php echo  ($escrow_fee+$shoppingCartProduct->sub_total)." (USD)"; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop