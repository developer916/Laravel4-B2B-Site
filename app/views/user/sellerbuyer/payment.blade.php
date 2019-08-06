@extends('user.layout')
    @section('custom-styles')
        <link rel="stylesheet" href="/assets/asset_view/shop-ui/plugins/jquery-steps/css/custom-jquery.steps.css">
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
    @stop
    @section('body')
        <div class="container content">
            <div class="row margin-bottom-20">
                <div class="col-md-12 margin-bottom-20">
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
                    <h2 class="text-center">
                        @if($shoppingCart->type == "credit")
                            {{trans('cart.credit_payment')}}
                        @elseif($shoppingCart->type == "check")
                            {{trans('cart.credit_payment')}}

                        @endif
                    </h2>
                </div>
                <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                    @if($shoppingCart->type == "credit")
                        <form class="form-horizontal" action="{{URL::route('user.addCart.credit')}}" method="POST">
                            <input type="hidden" name="shoppingCart" value="{{$shoppingCart->id}}">
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.card_no')}}<span class="font-red">*</span></label>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail1" name="card_no" placeholder="{{Lang::get('user.card_no')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.exp_month')}}<span class="font-red">*</span></label>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail1" name="exp_month" placeholder="{{Lang::get('user.exp_month')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.exp_year')}}<span class="font-red">*</span></label>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail1" name="exp_year" placeholder="{{Lang::get('user.exp_year')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('cart.total')}}<span class="font-red">*</span></label>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail1" name="total" readonly value="{{$shoppingCart->total." USD"}}" id="paymentCreditTotalValue">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.address')}}<span class="font-red">*</span></label>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail1" name="address" placeholder="{{Lang::get('user.address')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.zip_code')}}<span class="font-red">*</span></label>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail1" name="zipCode" placeholder="{{Lang::get('user.zip_code')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.email')}}<span class="font-red">*</span></label>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail1" name="email" placeholder="{{Lang::get('user.email')}}">
                                </div>
                            </div>
                            <div class="form-group margin-bottom-40">
                                <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.cvv2')}}<span class="font-red">*</span></label>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                    <input type="text" class="form-control" id="inputEmail1" name="cvv2" placeholder="{{Lang::get('user.cvv2')}}">
                                </div>
                            </div>
                            <div class="form-group text-center margin-bottom-40">
                                <input type="submit" value="{{trans('cart.pay_now')}}" class="btn-u btn-u-blue">
                            </div>
                        </form>
                    @elseif($shoppingCart->type == "check")
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                        if(count($electronic)>0){echo $electronic[0]->content;}
                                    ?>
                                </div>
                                <div class="col-md-12 text-right">
                                    <a href="https://seamlesschex.com/checkout/QwuCNYYK4WggECMSZ4gmdEDFcLhHlzuONpg//0" class="btn-u btn-u-primary" >{{Lang::get('user.continue')}}</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="panel-body cus-form-horizontal">
                            @include('user.sellerbuyer.wiretransfer')
                            <div class="form-group margin-bottom-20">
                                <div class="col-md-12 text-center">
                                    <a href="javascript:void(0)" class="btn-u btn-u-green" onclick="onPrint()" style="background: black">{{Lang::get('missing.PRINT')}}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        {{HTML::script('/assets/asset_view/js/jquery.print.js')}}
        <script type="text/javascript">
            function onPrint(){
                $("#printDiv").print();
            }
        </script>
    @stop
@stop