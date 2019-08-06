@extends('user.escrow.layout')
@section('custom-styles')
    {{HTML::style('/assets/asset_view/css/forestchange.css')}}
@stop
@section('body')
    <div class="container content">
        <div class="col-md-12 text-center margin-bottom-30">
            <h2>{{Lang::get('cart.purchasetree_shopping_cart_escrow')}}</h2>
            <p>{{$cart->invoice_number}}</p>
        </div>
        <div class="col-md-12">
            @if($escrowID == 0)
                <?php $cartProducts = $cart->shoppingCartItems; ?>
                @if(count($cartProducts)>0)
                    @foreach($cartProducts as $key =>$cartProduct)
                        <div class="row margin-bottom-40">
                            <div class="col-md-2 col-sm-2 col-xs-4">
                                <img src="{{$cartProduct->image_url}}" class="image-responsive" style="width: 100%">
                            </div>
                            <div class="col-md-4 col-sm-4 ">
                                <p><span style="color:red">{{Lang::get("user.rfq_product_name")}}: </span> {{$cartProduct->product->product_name}}</p>
                                <p><span style="color:red">{{Lang::get("user.product_size")}}: </span> {{$cartProduct->size}}</p>
                                <p><span style="color:red">{{Lang::get('user.color')}}: </span> {{$cartProduct->color}}</p>
                                <p><span style="color:red">{{Lang::get('missing.qty')}}: </span> {{$cartProduct->qty." ".$cartProduct->unit}}</p>
                                <p><span style="color:red">{{Lang::get(('cart.Price'))}}: </span> {{$cartProduct->product_price." $"}}</p>
                                @if($cartProduct->shipping_price !="")
                                    <p><span style="color:red">{{Lang::get('cart.shipping_price')}}: </span> {{$cartProduct->shipping_price." $"}}</p>
                                @endif
                                <p><span style="color: red">{{Lang::get('cart.Product_Total_Price')}}: </span> {{$cartProduct->sub_total . " $" }} </p>
                                <p><span style="color: red">{{Lang::get('cart.escrow_fee')}}: </span> {{round($cartProduct->sub_total*$fee,2) . " $" }}</p>
                                <p><span style="color: red">{{Lang::get('cart.shopping_sub_total')}}: </span> {{round($cartProduct->sub_total*(1+$fee),2)." $"}}</p>
                                <p><span style="color: red">{{Lang::get('user.status')}} :</span>
                                    @if($cartProduct->status == 2)
                                        {{Lang::get('missing.Product_pending')}}
                                    @elseif($cartProduct->status == 3)
                                        {{Lang::get('missing.Send_Product')}}
                                    @elseif($cartProduct->status == 4)
                                        {{Lang::get('missing.Seller_Send_Product')}}
                                    @elseif($cartProduct->status == 5)
                                        {{Lang::get('missing.Buyer_Get_Product')}}
                                    @elseif($cartProduct->status == 6)
                                        {{Lang::get('missing.Buyer_Confirmed')}}
                                    @elseif($cartProduct->status == 7)
                                        {{Lang::get('missing.Payment_cancelled')}}
                                    @elseif($cartProduct->status == 8)
                                        {{Lang::get('missing.Payment_disputed')}}
                                    @elseif($cartProduct->status == 9)
                                        {{Lang::get('missing.Payment_Released')}}
                                    @elseif($cartProduct->status == 10)
                                        {{Lang::get('missing.Admin_send_funds_to_seller')}}
                                    @elseif($cartProduct->status == 11)
                                        {{Lang::get('missing.Agreement_Dispute')}}
                                    @elseif($cartProduct->status == 12)
                                        {{Lang::get('missing.Escalation_Dispute')}}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <h4>Seller</h4>
                                        <?php $user = $cartProduct->product->member;?>
                                        <p>{{$user->firstname." ". $user->lastname}}</p>
                                        <p>{{$user->street}}</p>
                                        <p>
                                            {{$user->city }} ,
                                            @if($user->state != "") {{$user->state}} @endif
                                            {{$user->zipcode}}
                                        </p>
                                        <p>{{$user->country->country_name}}</p>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($cart->status == 2)
                                            @if(Session::get('user_id') == $cart->buyer_id)
                                                @if($cartProduct->status == 5)
                                                    <a href="javascript:void(0)" class="btn-u btn-u-blue" style="float: right; margin-left:10px;" onclick="onReleasePayment('{{100000*1 + $cartProduct->id}}')" >{{Lang::get('missing.Release_Payment')}}</a>
                                                    <a href="javascript:void(0)" class="btn-u btn-u-green" style="float: right; margin-left:10px;" onclick="onDisputePayment('{{100000*1 + $cartProduct->id}}')" >{{Lang::get('missing.Dispute_Payment')}}</a>
                                                @elseif($cartProduct->status < 5)
                                                    <a href="javascript:void(0)" class="btn-u btn-u-red" style="float: right">{{Lang::get('missing.Cancel_Payment')}}</a>
                                                @elseif($cartProduct->status == 8)
                                                    <a href ="{{URL::route('user.escrow.shoppingCartDispute', ($cartProduct->id + 100000*1))}}" class ="btn-u btn-u-blue" style="float: right; margin-left:10px;">{{Lang::get('missing.Dispute_Page')}}</a>
                                                @endif
                                            @elseif($user->id == $cart->buyer_id)
                                                {{Lang::get('user.the_money_was_put_in_the_escrow')}} <br>
                                                <a href="javascript:void(0)" class="btn-u btn-u-red">{{Lang::get('user.cancel_payment')}}</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="row margin-bottom-40">
                        <div class="col-md-4 col-md-offset-2">
                            <p><span style="color:red;">Sub Total Price  :</span>  {{$cart->subTotal ." $"}}</p>
                            <p><span style="color:red;">Escrow Fee :</span>  {{$cart->escrowFee ." $"}}</p>
                            <p><span style="color: red">Total Price :</span>  {{$cart->total ." $"}}</p>
                        </div>
                    </div>
                @endif
            @else
                <div class="row margin-bottom-40">
                    <div class="col-md-2 col-sm-2 col-xs-4">
                        <img src="{{$cartProductList->image_url}}" class="image-responsive" style="width: 100%">
                    </div>
                    <div class="col-md-4">
                        <p><span style="color:red">Product Name: </span> {{$cartProductList->product->product_name}}</p>
                        <p><span style="color:red">Size: </span> {{$cartProductList->size}}</p>
                        <p><span style="color:red">Color: </span> {{$cartProductList->color}}</p>
                        <p><span style="color:red">Qty: </span> {{$cartProductList->qty." ".$cartProductList->unit}}</p>
                        <p><span style="color:red">Price: </span> {{$cartProductList->product_price." $"}}</p>
                        @if($cartProductList->shipping_price !="")
                            <p><span style="color:red">Shipping Price: </span> {{$cartProductList->shipping_price." $"}}</p>
                        @endif
                        <p><span style="color: red">Sub Total</span> {{$cartProductList->sub_total . " $" }} </p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <h4>Seller</h4>
                                <?php $user = $cartProductList->product->member;?>
                                <p>{{$user->firstname." ". $user->lastname}}</p>
                                <p>{{$user->street}}</p>
                                <p>
                                    {{$user->city }} ,
                                    @if($user->state != "") {{$user->state}} @endif
                                    {{$user->zipcode}}
                                </p>
                                <p>{{$user->country->country_name}}</p>
                            </div>
                            <div class="col-md-6 col-sm-6">
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
                <div class="row margin-bottom-40">
                    <div class="col-md-4 col-md-offset-2 col-sm-4 col-sm-offset-2 col-xs-5">
                        <p><span style="color:red">SubTotal Price: </span>  {{$cartProductList->sub_total . " $" }} </p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-7">
                        @if($cart->status ==2)
                            {{Lang::get('user.the_money_was_put_in_the_escrow')}} <br>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script type="text/javascript">
        function onReleasePayment(shoppingCartProductID){
            bootbox.confirm({
                message: "{{Lang::get('missing.are_you_sure')}}?",
                buttons: {
                    confirm: {
                        label: '{{Lang::get("user.yes")}}',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: '{{Lang::get("user.no")}}',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result == true){
                        $.ajax ({
                            url: "{{route('user.escrow.shoppingCartRelease')}}",
                            type: 'POST',
                            data: {id : shoppingCartProductID},
                            cache: false,
                            dataType : "json",
                            success: function (data) {
                                if(data.result == "success"){
                                    bootbox.alert("You has been release escrow to  seller.");
                                    window.location.reload();
                                }
                            }
                        });
                    }
                }
            });
        }


        function onDisputePayment(shoppingCartProductID){
            bootbox.confirm({
                message: "{{Lang::get('missing.are_you_sure')}}?",
                buttons: {
                    confirm: {
                        label: '{{Lang::get("user.yes")}}',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: '{{Lang::get("user.no")}}',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result == true){
                        $.ajax ({
                            url: "{{route('user.escrow.shoppingCartDisputePost')}}",
                            type: 'POST',
                            data: {id : shoppingCartProductID},
                            cache: false,
                            dataType : "json",
                            success: function (data) {
                                if(data.result == "success"){
                                    bootbox.alert("You has been dispute escrow.");
                                    var base_url = window.location.origin;
                                    window.location.href=base_url+"/escrow/shoppingCartDispute"+data.cart_id;
                                }
                            }
                        });
                    }
                }
            });
        }
    </script>
@stop