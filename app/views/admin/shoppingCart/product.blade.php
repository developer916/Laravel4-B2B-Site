@extends('admin.layout')
    @section('body')
        <h3 class="page-title">Shopping Cart Product Lists Management</h3>
        <!-- page layout -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{URL::route('admin.dashboard')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <i class="fa fa-pencil"></i>
                    <a href="{{URL::route('admin.shoppingCart.payment')}}">Shopping Cart Lists Management</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <i class="fa fa-pencil"></i>
                    <a href="{{URL::route('admin.shoppingCart.payment',$cart->id)}}">Shopping Cart Product Lists Management</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i> Shopping Cart Product Lists Management
                        </div>
                    </div>
                    <div class="portlet-body">
                        @foreach($cartProducts as $key =>$cartProduct)
                            <div class="row margin-bottom-30">
                                <div class="col-md-3 col-sm-3 col-xs-4">
                                    <img src="{{$cartProduct->image_url}}" class="" style="width: 100%">
                                </div>
                                <div class="col-md-9  col-sm-9 col-xs-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>
                                                <?php $cartProductDetail = $cartProduct ->product;?>
                                                {{$cartProductDetail->product_name}}
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12 col-sm-4">
                                            <p><span style="color:red">Small</span>  {{$cartProduct->size}}</p>
                                            <p><span style="color:red">Color</span>  {{$cartProduct->color}}</p>
                                            <p><span style="color:red">Qty</span>    {{$cartProduct->qty.$cartProduct->unit}}</p>
                                            @if($cartProduct->shipping_price !="")
                                                <p><span style="color:red">Shipping Price: </span> {{$cartProduct->shipping_price." $"}}</p>
                                            @endif
                                            <p><span style="color: red">Product Total Price: </span> {{$cartProduct->sub_total . " $" }} </p>
                                            <p><span style="color: red">Escrow Fee: </span> {{round($cartProduct->sub_total*$fee,2) . " $" }}</p>
                                            <p><span style="color: red">Sub Total: </span> {{round($cartProduct->sub_total*(1+$fee),2)." $"}}</p>
                                            <h2><span style="color: red">Status :</span>
                                                @if($cartProduct->status == 2)
                                                    Product pending
                                                @elseif($cartProduct->status == 3)
                                                    Send Product
                                                @elseif($cartProduct->status == 4)
                                                    Seller Send Product
                                                @elseif($cartProduct->status == 5)
                                                    Buyer Get Product
                                                @elseif($cartProduct->status == 6)
                                                    Buyer Confirmed
                                                @elseif($cartProduct->status == 7)
                                                    Payment cancelled
                                                @elseif($cartProduct->status == 8)
                                                    Payment disputed
                                                @elseif($cartProduct->status == 9)
                                                    Payment Released
                                                @elseif($cartProduct->status == 10)
                                                    Admin send funds to seller
                                                @endif
                                            </h2>

                                        </div>
                                        <div class="col-md-4 col-xs-12 col-sm-6">
                                            <h4>Seller</h4>
                                            <?php $seller = $cartProduct->product->member;?>
                                            <p>{{$seller->firstname." ". $seller->lastname}}</p>
                                            <p>{{$seller->street}}</p>
                                            <p>
                                                {{$seller->city }} ,
                                                @if($seller->state != "") {{$seller->state}} @endif
                                                {{$seller->zipcode}}
                                            </p>
                                            <p>{{$seller->country->country_name}}</p>
                                        </div>
                                        <div class="col-md-4 col-xs-12 col-sm-6">
                                            <h4>Buyer</h4>
                                            <?php $buyer = $cart->member;?>
                                            <p>{{$buyer->firstname." ". $buyer->lastname}}</p>
                                            <p>{{$buyer->street}}</p>
                                            <p>
                                                {{$buyer->city }} ,
                                                @if($buyer->state != "") {{$buyer->state}} @endif
                                                {{$buyer->zipcode}}
                                            </p>
                                            <p>{{$buyer->country->country_name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-4 col-md-offset-3 col-sm-4 col-sm-offset-3 col-xs-6 col-xs-offset-4">
                                <p><span style="color:red;">Sub Total Price  :</span>  {{$cart->subTotal ." $"}}</p>
                                <p><span style="color:red;">Escrow Fee :</span>  {{$cart->escrowFee ." $"}}</p>
                                <p><span style="color: red">Total Price :</span>  {{$cart->total ." $"}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop
@stop
