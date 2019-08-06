@extends('admin.layout')
@section('body')
    <h3 class="page-title">Product Lists Management</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box light" style="padding: 12px 20px 15px 20px!important;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Shopping Cart Product Lists
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="row margin-bottom-20">
                                <div class="col-md-6">
                                    <p>Product</p>
                                </div>
                                <div class="col-md-2">
                                    <p>Price</p>
                                </div>
                                <div class="col-md-2">
                                    <p>QTY</p>
                                </div>
                                <div class="col-md-2">
                                    <p>Total</p>
                                </div>
                            </div>
                            <?php $cartProducts = $cart->shoppingCartItems;?>
                            @foreach($cartProducts as $key =>$cartProduct)
                                <div class="row margin-bottom-20">
                                    <div class="col-md-6">
                                        <a href="{{URL::route('user.showProduct',100000*1+$cartProduct->product_id)}}">
                                            <img src="{{$cartProduct->image_url}}" style="width:60px;">
                                            {{$cartProduct->Product->product_name}},
                                            {{$cartProduct->color}},
                                            {{$cartProduct->size}}
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <p>{{"$ ".$cartProduct->product_price}}</p>
                                        @if($cartProduct->shipping_price !="")
                                            + {{"$ ".$cartProduct->shipping_price}}
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <p>{{$cartProduct->qty}}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p>{{"$ ".$cartProduct->sub_total}}</p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{URL::route('admin.shoppingCart.payment')}}" class="btn blue" style="float: right">Back to Payment page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop