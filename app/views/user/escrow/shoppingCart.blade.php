@extends('user.escrow.layout')
@section('custom-styles')
    {{HTML::style('/assets/asset_view/css/forestchange.css')}}
@stop
@section('body')
    <div class="container content">
        <div class="col-md-12 text-center margin-bottom-30">
            <h2>{{Lang::get('cart.purchasetree_shopping_cart_escrow')}}</h2>
        </div>
        <div class="col-md-12">
            <div class="row">
                @if(Session::get('user_type') ==2)
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <h4>{{Lang::get('user.items_you_are_buying')}}</h4>
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
                                    <td>
                                        {{Lang::get('user.escrow_id')}}
                                    </td>
                                    <td>
                                        {{Lang::get('user.item')}}
                                    </td>
                                    <td>
                                        {{Lang::get('user.status')}}
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($carts as $key =>$cart)
                                    @if($cart->buyer_id == Session::get('user_id'))
                                        <tr>
                                            <td> <a href="{{URL::route('user.escrow.escrow',array($cart->invoice_number,1))}}">{{$cart->invoice_number}}</a></td>
                                            <td>
                                                <?php $cartProducts = $cart->shoppingCartItems;?>
                                                {{count($cartProducts)}}
                                            </td>
                                            <td>
                                                @if($cart->status ==2)
                                                    {{Lang::get('user.the_money_are_in_escrow')}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="col-md-6">
                        <div class="alert alert-success">
                            <h4>{{Lang::get('user.items_you_are_selling')}}</h4>
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
                                    <td>
                                        {{Lang::get('user.escrow_id')}}
                                    </td>
                                    <td>
                                        {{Lang::get('user.item')}}
                                    </td>
                                    <td>
                                        {{Lang::get('user.status')}}
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $key =>$cart)
                                        @if($cart->buyer_id != Session::get('user_id'))
                                            <?php
                                            $cartProducts = $cart->shoppingCartItems;
                                            $countProduct =0;
                                            ?>
                                            @foreach($cartProducts as $key_cartProduct =>$cartProduct)
                                                @if($cartProduct->seller_id = $cart->buyer_id)
                                                    <tr>
                                                        <td> <a href="{{URL::route('user.escrow.escrow',array($cart->invoice_number,1,$cartProduct->id))}}">{{$cart->invoice_number}}</a></td>
                                                        <td> 1 </td>
                                                        <td>
                                                            @if($cart->status ==2)
                                                                {{Lang::get('user.the_money_are_in_escrow')}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <h4>{{Lang::get('user.items_you_are_buying')}}</h4>
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
                                    <td>
                                        {{Lang::get('user.escrow_id')}}
                                    </td>
                                    <td>
                                        {{Lang::get('user.item')}}
                                    </td>
                                    <td>
                                        {{Lang::get('user.status')}}
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $key=>$cart)
                                        @if($cart->buyer_id == Session::get('user_id'))
                                            <tr>
                                                <td> <a href="{{URL::route('user.escrow.escrow',array($cart->invoice_number,1))}}">{{$cart->invoice_number}}</a></td>
                                            </tr>
                                            <td>
                                                <?php $cartProducts = $cart->shoppingCartItems;?>
                                                {{count($cartProducts)}}
                                            </td>
                                            <td>
                                                @if($cart->status ==2)
                                                    {{Lang::get('user.the_money_are_in_escrow')}}
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
