@extends('user.layout')
@section('custom-styles')
    {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
    {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
    <link rel="stylesheet" href="/assets/asset_view/shop-ui/plugins/jquery-steps/css/custom-jquery.steps.css">
    <style>
        .sky-form .progress {
            float:none!important;
        }
        .sky-form .state-error input, .sky-form .state-error select, .sky-form .state-error select + i, .sky-form .state-error textarea, .sky-form .radio.state-error i, .sky-form .checkbox.state-error i, .sky-form .toggle.state-error i, .sky-form .toggle.state-error input:checked + i {
            margin-bottom:0px!important;
        }

        .sky-form .state-error + em {
            margin-bottom: 20px!important;
        }
        .sky-form {
            border:0px!important;
        }
    </style>
@stop
@section('body')
    <?php $total_value = 0;?>
    <div class="content-md margin-bottom-30">
        <div class="container">
            @if ($errors->has())
                <div class="alert alert-danger alert-dismissibl fade in">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            <form class="shopping-cart" action="{{URL::route('user.addCart.saveCart')}}" id="shoppingCartForm" method="POST">
                <div>
                    <div class="header-tags">
                        <div class="overflow-h">
                            <h2>{{trans('cart.shopping_cart')}}</h2>
                            <p>{{trans('cart.shopping_cart_description')}}</p>
                            <i class="rounded-x fa fa-check"></i>
                        </div>
                    </div>
                    <section>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>{{trans('cart.Product')}}</th>
                                    <th>{{trans('cart.Price')}} </th>
                                    <th>{{trans('cart.Qty')}} </th>
                                    <th>{{trans('cart.Total')}} </th>
                                </tr>
                                </thead>
                                <tbody id="prodctTbody">
                                    @foreach($contents as $key_content =>$value_content)
                                        <tr id="productTr{{$value_content->options->indexID}}">
                                            <td class="product-in-table">
                                                @if($value_content->options->url != "")
                                                    <img src="{{$value_content->options->url}}" class=" img-responsiveaddCart_product_img" >
                                                @else
                                                    <img src="/assets/asset_view/img/main/img1.jpg" class=" img-responsiveaddCart_product_img">
                                                @endif
                                                <div class="product-it-in">
                                                    <h3 style="margin-bottom: 0px">
                                                        <a href="{{URL::route('user.showProduct',($value_content->id))}}">
                                                            {{$value_content->name." "}}
                                                            @if($value_content->options->color !="")
                                                                , {{$value_content->options->color." "}}
                                                            @endif
                                                            @if($value_content->options->size !="")
                                                                , {{strtoupper($value_content->options->size)}}
                                                            @endif
                                                        </a>
                                                    </h3>
                                                    @if($value_content->options->shipping_method !="")
                                                        <p id="shipping{{$value_content->options->indexID}}">
                                                            {{$value_content->options->shipping_method}}
                                                            @if($value_content->options->shipping_price !="")
                                                                {{"$".$value_content->options->shipping_price ." ". "USD"}}
                                                            @endif
                                                            @if($value_content->options->shipping_method == "Cargo Shipping")
                                                                <a href="javascript:void(0)" onclick="onShowCargo()"><i class="fa   fa-question-circle font-red"></i> </a>
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td id="priceContent{{$value_content->options->indexID}}">
                                                &nbsp;{{" $" .number_format($value_content->price,2)."USD"}}
                                                <br>
                                                @if($value_content->options->shipping_price !="")
                                                    +{{"$".number_format($value_content->options->shipping_price,2) ." ". "USD"}}
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" value="{{$value_content->qty}}" class="" style="width:75px;" onchange="onChangeUpdate({{$value_content->options->indexID}})" id="qty{{$value_content->options->indexID}}">
                                                @if($value_content->options->unit !="")
                                                    {{$value_content->options->unit}}
                                                @endif
                                                <input type="hidden" value="{{$key_content}}" id="rowID{{$value_content->options->indexID}}">
                                                <input type="hidden" value="{{$value_content->id}}" id="productID{{$value_content->options->indexID}}">
                                            </td>
                                            <td id="sub{{$value_content->options->indexID}}">
                                                @if( $value_content->subtotal)
                                                    <?php
                                                    $subTotalPrice = ($value_content->qty*round($value_content->price,2));
                                                    $total_value = $total_value+$subTotalPrice;
                                                    $subTotalShipping =0;
                                                    if($value_content->options->shipping_price !=""){
                                                        $subTotalShipping = round($value_content->options->shipping_price,2)*$value_content->qty;
                                                        $total_value = $total_value+$subTotalShipping;
                                                    }
                                                    $subTotal = $subTotalPrice+$subTotalShipping;
                                                    echo "$".number_format(round($subTotal,2),2)." USD";
                                                    ?>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn-u btn-u-red" onclick="onRemove('{{ $value_content->options->indexID }}')">X</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <div class="header-tags">
                        <div class="overflow-h">
                            <h2>{{trans('cart.billing_info')}}</h2>
                            <p>{{trans('cart.shipping_and_address_info')}}</p>
                            <i class="rounded-x fa fa-home"></i>
                        </div>
                    </div>
                    <section class="billing-info">
                        <div class="row">
                            <div class="col-md-6 md-margin-bottom-40">
                                <h2 class="title-type">{{trans('cart.billing_address')}}</h2>
                                <p>&nbsp;</p>
                                <div class="billing-info-inputs checkbox-list">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            {{Form::text('billing_firstname',Input::old('billing_firstname'),['class' =>'form-control required','placeholder'=>trans('cart.first_name') ,'id' =>'billing_firstname' ])}}
                                            {{Form::email('billing_email',Input::old('billing_email'),['class' =>'form-control required email','placeholder'=>trans('cart.email'),'id' =>'billing_email' ])}}
                                        </div>
                                        <div class="col-sm-6">
                                            {{Form::text('billing_lastname',Input::old('billing_lastname'),['class' =>'form-control required','placeholder'=>trans('cart.last_name') ,'id' =>'billing_lastname' ])}}
                                            {{Form::text('billing_phone',Input::old('billing_phone'),['class' =>'form-control required','placeholder'=>trans('cart.phone') ,'id' =>'billing_phone' ])}}
                                        </div>
                                    </div>
                                    {{Form::text('billing_address1',Input::old('billing_address1'),['class' =>'form-control required','placeholder'=>trans('cart.address_line_1') ,'id' =>'billing_address1'])}}
                                    {{Form::text('billing_address2',Input::old('billing_address2'),['class' =>'form-control','placeholder'=>trans('cart.address_line_2') ,'id' =>'billing_address2' ])}}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            {{Form::text('billing_city',Input::old('billing_city'),['class' =>'form-control required','placeholder'=>trans('cart.city') ,'id' =>'billing_city' ])}}
                                        </div>
                                        <div class="col-sm-2">
                                            {{Form::text('billing_state',Input::old('billing_state'),['class' =>'form-control required','placeholder'=>trans('cart.state'),'maxlength'=>'2','id' =>'billing_state' ]) }}
                                        </div>
                                        <div class="col-sm-4">
                                            {{Form::text('billing_zip',Input::old('billing_zip'),['class' =>'form-control required','placeholder'=>trans('cart.zip_postal_code') ,'id' =>'billing_zip'])}}
                                        </div>
                                    </div>
                                    {{ Form::select('billing_country', [ '' => trans('cart.select_country')] +  $countries->lists('country_name','id') ,array(223,Input::old('billing-country')), ['class' => 'form-control required' ,'id' =>'billing_country']) }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h2 class="title-type">{{trans('cart.shipping_address')}}</h2>
                                <p style="margin-left: 20px;"><input type="checkbox" value="1" name="same_as_billing_info" onchange="onChangeSameBillingInfo()" id="sameAsBillingInfo"> {{trans('cart.same_as_billing_info')}} </p>
                                <div class="billing-info-inputs checkbox-list">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            {{Form::text('shipping_firstname',Input::old('shipping_firstname'),['class' =>'form-control required','placeholder'=>trans('cart.first_name') ,'id' =>'shipping_firstname' ])}}
                                            {{Form::email('shipping_email',Input::old('shipping_email'),['class' =>'form-control required email','placeholder'=>trans('cart.email') ,'id' =>'shipping_email' ])}}

                                        </div>
                                        <div class="col-sm-6">
                                            {{Form::text('shipping_lastname',Input::old('shipping_lastname'),['class' =>'form-control required','placeholder'=>trans('cart.last_name') ,'id' =>'shipping_lastname'])}}
                                            {{Form::text('shipping_phone',Input::old('shipping_phone'),['class' =>'form-control required','placeholder'=>trans('cart.phone') ,'id' =>'shipping_phone'])}}
                                        </div>
                                    </div>
                                    {{Form::text('shipping_address1',Input::old('shipping_address1'),['class' =>'form-control required','placeholder'=>trans('cart.address_line_1'),'id' =>'shipping_address1' ])}}
                                    {{Form::text('shipping_address2',Input::old('shipping_address2'),['class' =>'form-control ','placeholder'=>trans('cart.address_line_2') ,'id' =>'shipping_address2'])}}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            {{Form::text('shipping_city',Input::old('shipping_city'),['class' =>'form-control required','placeholder'=>trans('cart.city'),'id' =>'shipping_city' ])}}
                                        </div>
                                        <div class="col-sm-2">
                                            {{Form::text('shipping_state',Input::old('shipping_state'),['class' =>'form-control required','placeholder'=>trans('cart.state'),'maxlength'=>'2' ,'id' =>'shipping_state'])}}
                                        </div>
                                        <div class="col-sm-4">
                                            {{Form::text('shipping_zip',Input::old('shipping_zip'),['class' =>'form-control required','placeholder'=>trans('cart.zip_postal_code'),'id' =>'shipping_zip' ])}}
                                        </div>
                                    </div>
                                    {{ Form::select('shipping_country', [ '' => trans('cart.select_country')] +  $countries->lists('country_name','id') ,array(223,Input::old('billing-country')), ['class' => 'form-control required','id' =>'shipping_country']) }}
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="header-tags">
                        <div class="overflow-h">
                            <h2>{{trans('cart.escrow_payment')}}</h2>
                            <p>{{trans('cart.select_payment_method')}}</p>
                            <i class="rounded-x fa fa-credit-card"></i>
                        </div>
                    </div>
                    <section>
                        <div class="row">
                            <div class="col-md-6 md-margin-bottom-50">
                                <h2 class="title-type">{{trans('cart.choose_a_payment_method')}}</h2>
                                <!-- Accordion -->
                                <div class="sky-form" style="border:0px!important">
                                    <div class="row">
                                        <div class=" col-md-12 col-xs-12 col-sm-12">
                                            <label class="radio" @if($total_value > 500) style="display:none" @endif id="creditCard"><input type="radio" name="type" checked value="credit"><i class="rounded-x"></i>{{Lang::get('user.credit_card')}}</label>
                                            <label class="radio"><input type="radio" name="type" value="check"><i class="rounded-x"></i>{{Lang::get('user.electronic_check')}}</label>
                                            <label class="radio"  ><input type="radio" name="type" value="wire"><i class="rounded-x"></i>{{Lang::get('user.wire_transfer')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Accordion -->
                            </div>

                            <div class="col-md-6">
                                <h2 class="title-type">{{Lang::get("cart.Frequently_asked_questions")}}</h2>
                                <!-- Accordion -->
                                <div class="accordion-v2 plus-toggle">
                                    <div class="panel-group" id="accordion-v2">
                                        @foreach($descriptions as $key_description =>$value_description)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion-v2" href="#collapseOne-{{$key_description}}">
                                                        {{$value_description->title}}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne-{{$key_description}}" class="panel-collapse collapse @if($key_description==0) in @endif">
                                                <div class="panel-body">
                                                    {{nl2br($value_description->description)}}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- End Accordion -->
                            </div>
                        </div>
                    </section>


                    <div class="modal fade" id="addCategoryModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                                    <h4 class="modal-title" id="myModalLabel"> {{Lang::get('user.cargo_help_text')}}</h4>
                                </div>
                                <div class="modal-body">
                                    <p class="margin-bottom-40"> {{Lang::get('user.cargo_text')}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $subtotal_value = round($total_value,2);
                        $escrowFee = round($total_value*($escrow_fee/100),2);
                        $total_value = round($total_value,2) +$escrowFee;

                    ?>
                    <div class="coupon-code">
                        <div class="row margin-bottom-30">
                            <div class="col-sm-3 col-sm-offset-9">
                                <ul class="list-inline total-result">
                                    <li>
                                        <h4>{{trans('cart.Subtotal')}}:</h4>
                                        <div class="total-result-in">
                                            <span id="subTotalValue">$ {{number_format($subtotal_value,2)."  USD"}}</span>
                                            <input type="hidden" name="input_subTotalValue" value=" {{number_format($subtotal_value,2)}}" id="input_subTotalValue">
                                        </div>
                                    </li>
                                    <li>
                                        <h4>{{trans('cart.escrow_fee')}}:</h4>
                                        <div class="total-result-in">
                                            <span class="text-right" id="escrowPrice">$ {{number_format($escrowFee,2). " USD"}}</span>
                                            <input type="hidden" name="input_escrowPrice" value=" {{number_format($escrowFee,2)}}" id="input_escrowPrice">
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="total-price">
                                        <h4>{{trans('cart.Total')}}:</h4>
                                        <div class="total-result-in">
                                            <span id="totalPrice">$ {{number_format($total_value,2)." USD"}}</span>
                                            <input type="hidden" name="input_totalPrice" value=" {{number_format($total_value,2)}}" id="input_totalPrice">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-sm-offset-9">
                                <p> {{Lang::get('cart.By_placing_your_order')}} <a href="javascript:void(0)" onclick="onShowPrivacy()">{{Lang::get('cart.Privacy_notice')}}</a> {{Lang::get('missing.and')}} <a href="javascript:void(0)" onclick="onShowConditions()">{{Lang::get('cart.Conditions_of_use')}}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!--/end container-->
    </div>
    <div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog"  style="min-height: 1600px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                    <h4 class="modal-title" id="myModalLabel"> {{Lang::get('cart.sign_in_or_join_free_now')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" >
                            <ul class="nav nav-tabs">
                                <li class="active" ><a href="#alert-1" data-toggle="tab">{{trans('user.sign_in')}}</a></li>
                                <li ><a href="#alert-2" data-toggle="tab">{{trans('user.sign_up')}}</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in  active" id="alert-1">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1" style="margin-top: 30px;" id="signInFromDiv">
                                            <form action="{{URL::route('user.addCart.userLogin')}}" method="POST" id="loginForm">
                                                <div class="input-group margin-bottom-20">
                                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                    <input type="text" class="form-control" placeholder="{{Lang::get('user.user_name_or_email')}}" name="username">
                                                </div>
                                                <div class="row ">
                                                    <div class="col-md-12 col-sm-12 text-right">
                                                        <a href="{{URL::route('user.auth.forgot')}}" class="color-green">{{Lang::get('user.forgot_password')}}</a>
                                                    </div>
                                                </div>
                                                <div class="input-group margin-bottom-20">
                                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                    <input type="password" class="form-control" placeholder="{{Lang::get('user.password')}}" name="password">
                                                </div>
                                                <div class="input-group" style="">
                                                    <div class="col-md-8 col-md-offset-2 col-xs-10 col-xs-offset-1">
                                                        {{ Form::captcha(['id' => 'captcha1']) }}
                                                    </div>

                                                </div>
                                                <div class="row ">
                                                    <div class="col-md-12 margin-bottom-40" style="margin-top: 20px">
                                                        <button type="button" class="btn-u btn-block" onclick="onClickLogin()">{{Lang::get('user.login')}}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in " id="alert-2">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1" style="margin-top: 30px;" id="signUpFromDiv" >
                                            <form class="reg-page sky-form" method="post" action="{{URL::route('user.addCart.userSignUp')}}" id="sky-form">
                                                <h2 class="createRegisterItem">{{Lang::get('user.member_information')}}
                                                    <span class="createRegisterItemRight">--------------------------------------------</span>
                                                </h2>
                                                <fieldset>
                                                    <div class="row">
                                                        <section>
                                                            <label>{{Lang::get('user.user_name')}} <span class="color-red">*</span></label>
                                                            <input type="text" class="form-control margin-bottom-20" name="username" id="username" placeholder="{{Lang::get('user.user_name')}}" >
                                                        </section>
                                                    </div>
                                                    <div class="row">
                                                        <section>
                                                            <label>{{Lang::get('user.password')}} <span class="color-red">*</span>
                                                                <br> ( {{Lang::get('user.password_rules')}} ) </label>
                                                            <input type="password" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.password')}}" name="userpassword" id="password">
                                                            <div id="messages"></div>
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.confirm_password')}} <span class="color-red">*</span></label>
                                                            <input type="password" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.confirm_password')}}" name="confirmpassword">
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.email_address')}} <span class="color-red">*</span></label>
                                                            <input type="email" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.email_address')}}" name="email">
                                                        </section>
                                                    </div>
                                                    {{--<div class="row">--}}
                                                    {{--<section>--}}
                                                    {{--<div class="inline-group">--}}
                                                    {{--<label class="radio" style="padding-left: 0px"> {{Lang::get('user.i_am')}} : <span class="color-red">*</span> </label>--}}
                                                    {{--<label class="radio"><input type="radio" name="usertype" value="s"><i class="rounded-x"></i>{{Lang::get('user.seller')}}</label>--}}
                                                    {{--<label class="radio"><input type="radio" name="usertype" value="b"><i class="rounded-x"></i>{{Lang::get('user.buyer')}}</label>--}}
                                                    {{--<label class="radio"><input type="radio" name="usertype" value="k"><i class="rounded-x"></i>{{Lang::get('user.both')}}</label>--}}
                                                    {{--</div>--}}
                                                    {{--</section>--}}
                                                    {{--</div>--}}
                                                </fieldset>
                                                <h2 class="createRegisterItem">{{Lang::get('user.add_your_contact')}}
                                                    <span class="createRegisterItemRight">---------------------------------------</span>
                                                </h2>
                                                <fieldset>
                                                    <div class="row">
                                                        <section>
                                                            <label>{{Lang::get('user.first_name')}} <span class="color-red">*</span></label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.first_name')}}" name="firstname">
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.last_name')}} <span class="color-red">*</span></label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.last_name')}}" name="lastname">
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.address')}} <span class="color-red">*</span></label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.address')}}" name="address">
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.city')}} <span class="color-red">*</span></label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.city')}}" name="city">
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.state')}}</label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.state')}}" name="state">
                                                        </section>
                                                        <section>
                                                            <label class="select">{{Lang::get('user.country')}} <span class="color-red">*</span></label>
                                                            <select name="country" class="form-control margin-bottom-20">
                                                                <option value="" selected disabled> -- {{Lang::get('missing.Select_Country')}} -- </option>
                                                                @foreach($country as $countries)
                                                                    @if($countries->country_name == "USA")
                                                                        <option value="{{$countries->id}}" selected>{{$countries->country_name}}</option>
                                                                    @else
                                                                        <option value="{{$countries->id}}">{{$countries->country_name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <i></i>
                                                            </label>
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.zip_code')}} <span class="color-red">*</span></label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.zip_code')}}" name="zipcode">
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.phone_number')}} <span class="color-red">*</span></label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.phone_number')}}" name="phone_number">
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.working_number')}} </label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.working_number')}}" name="working_number">
                                                        </section>
                                                        <section>
                                                            <label>{{Lang::get('user.company_name')}} </label>
                                                            <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.company_name')}} " name="company_name">
                                                        </section>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-md-12" style="float: right">
                                                        {{ Form::captcha(['id' => 'captcha2']) }}
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="row" style="margin-top: 20px">
                                                        <div class="col col-8">
                                                            <label class="checkbox state-success" >
                                                                <input type="checkbox" name="checkbox">
                                                                I read <a href="page_terms.html" class="color-green" style="color: #18ba9b">{{Lang::get('user.terms_and_conditions')}}</a>
                                                            </label>
                                                        </div>
                                                        <div class="col col-4 text-right">
                                                            <button class="btn-u" type="button" onClick ="onClickSignUp()"><span id="savelist">{{Lang::get('user.sign_up')}}</span></button>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                            {{ Captcha::scriptWithCallback(['captcha1', 'captcha2']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="placeOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                    <h4 class="modal-title" id="myModalLabel"> {{Lang::get('missing.Description')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>{{Lang::get('missing.Your_order_has_been_placed_and_is_pending_your_escrow_payment_to_clear')}}</p>
                        </div>
                        <div class="col-md-12">
                            <p><span style="color:red">{{Lang::get('missing.Note')}}:</span>  {{Lang::get('missing.depending_on_your_payment')}}</p>
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick="OnSendForm()">{{Lang::get('missing.Ok')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="privacyConditionsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                    <h4 class="modal-title" id="privacyConditionsLabel"></h4>
                </div>
                <div class="modal-body" id="privacyConditionsModalBody">
                </div>
            </div>
        </div>
    </div>

@stop
@section('custom-scripts')
    <script src="/assets/asset_view/shop-ui/plugins/jquery-steps/build/jquery.steps.js"></script>
    <script src="/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js"></script>
    <script src="/assets/asset_view/js/custom.js"></script>
    <script src="/assets/asset_view/shop-ui/js/shop.app.js"></script>
    <script src="/assets/asset_view/shop-ui/js/forms/page_login.js"></script>
    {{--<script src="/assets/asset_view/shop-ui/js/plugins/stepWizard.js"></script>--}}
    {{ HTML::script('/assets/asset_view/js/forms/checkout.js') }}
    <script src="/assets/asset_view/shop-ui/js/forms/product-quantity.js"></script>
    {{ HTML::script('/assets/asset_view/js/jquery.pwstrength.js') }}
    <script>
        jQuery(document).ready(function() {
            App.init();
            Login.initLogin();
            App.initScrollBar();
            StepWizard.initStepWizard();
            loginCheckList();
            var indexValue = "";
            CheckoutForm.initCheckoutForm();
            var options = {
                onKeyUp: function (evt) {
                    $(evt.target).pwstrength("outputErrorList");
                }
            };
            $('#password').pwstrength(options);
        });
    </script>
    <script type="text/javascript">
        function onShowPrivacy(){
            var base_url = window.location.origin;
            $.ajax ({
                url: '{{route("user.buyer.cart.privacyConditions")}}',
                type: 'POST',
                data: {'flag':'privacy'},
                cache: false,
                dataType: "json",
                success: function (data) {
                    $("#privacyConditionsLabel").html(data.title);
                    $("#privacyConditionsModalBody").html(data.content);
                    $("#privacyConditionsModal").modal('show');
                }
            });
        }

        function onShowConditions(){
            var base_url = window.location.origin;
            $.ajax ({
                url: '{{ route("user.buyer.cart.privacyConditions") }}',
                type: 'POST',
                data: {'flag':'conditions'},
                cache: false,
                dataType: "json",
                success: function (data) {
                    $("#privacyConditionsLabel").html(data.title);
                    $("#privacyConditionsModalBody").html(data.content);
                    $("#privacyConditionsModal").modal('show');
                }
            });
        }
        function loginCheckList(){
            var base_url = window.location.origin;
            $.ajax ({
                url: '{{route("user.addCart.getUserStatus")}}',
                type: 'POST',
                data: {},
                cache: false,
                dataType: "json",
                success: function (data) {
                    indexValue = data.index;
                }
            });
        }
        function onChangeUpdate(id){
            var base_url = window.location.origin;
            var qty = $("#qty"+id).val();
            var row = $("#rowID"+id).val();
            var productID = $("#productID"+id).val();
            $.ajax ({
                url: '{{route("user.addCart.changeCart")}}',
                type: 'POST',
                data: {id:id,   qty :qty,row:row,productID:productID},
                cache: false,
                dataType: "json",
                success: function (data) {
                    if(data.result =="success"){
                        var subID = data.id;
                        $("#totalPrice").html(data.total);
                        $("#escrowPrice").html(data.escrowFee);
                        $("#subTotalValue").html(data.reallySubTotalValue);
                        $("#shipping"+data.indexID).html(data.shippingText);
                        $("#sub"+data.indexID).html(data.list);
                        $("#priceContent"+data.indexID).html(data.subPrice);
                        $("#input_subTotalValue").val(data.inputReallySubTotalValue);
                        $("#input_escrowPrice").val(data.inputEscrowFee);
                        $("#input_totalPrice").val(data.inputReallyTotalValue);
                        if(data.indexCheck ==  1){
                            $("#creditCard").hide();
                        }else{
                            $("#creditCard").show();
                        }
                    }else if(data.result == "failed"){
                        $("#qty"+data.indexID).val(data.qty);
                        $("#sub"+data.indexID).html(data.reallyTotal);
                        $("#priceContent"+data.indexID).html(data.subPrice);
                        bootbox.alert(data.list);
                    }
                }
            });
        }
        function onRemove(id){
            var base_url = window.location.origin;
            var row = $("#rowID"+id).val();
            var productID = $("#productID"+id).val();
            $.ajax ({
                url: '{{route("user.addCart.removeCart")}}',
                type: 'POST',
                data: {id:id,row:row,productID:productID},
                cache: false,
                dataType: "json",
                success: function (data) {
                    if(data.result =="success"){
                        $("#prodctTbody").find("#productTr"+data.id).remove();
                        $("#totalPrice").html(data.total);
                        $("#escrowPrice").html(data.escrowFee);
                        $("#subTotalValue").html(data.subTotal);
                        $("#input_subTotalValue").val(data.inputReallySubTotalValue);
                        $("#input_escrowPrice").val(data.inputEscrowFee);
                        $("#input_totalPrice").val(data.inputReallyTotalValue);
                        if(data.indexCheck ==  1){
                            $("#creditCard").hide();
                        }else{
                            $("#creditCard").show();
                        }
                        bootbox.alert(data.list);
                    }
                }
            });
        }
        function onShowCargo(){
            $("#addCategoryModel").modal('show');
        }

        function onClickSignUp(){
           $("#sky-form").ajaxForm({
               success:function(data){
                   if(data.result=="success"){
                       bootbox.alert(data.message);
                       $("#signInModal").modal('hide');
                   }else if(data.result == "failed"){
                       var arr = data.error;
                       var errorList = '';
                       $.each(arr, function(index, value)
                       {
                           if (value.length != 0)
                           {
                               errorList = errorList + value;
                           }
                       });
                       $("#spin").css('display','hide');
                       $("#onMessageSendDiv").find("#semd").show();
                       bootbox.alert(errorList);
                   }
               }
           }).submit();
        }
        function onClickLogin(){
            $("#loginForm").ajaxForm({
                success:function(data){
                    if(data.result == "success"){
                        if(data.loginCheck ==1){

                            indexValue = 1;
                            bootbox.alert(data.message);
                            $("#signInModal").modal('hide');

                        }else{
                            bootbox.alert(data.message);
                        }
                    }else if(data.result == "failed"){
                        var arr = data.error;
                        var errorList = '';
                        $.each(arr, function(index, value)
                        {
                            if (value.length != 0)
                            {
                                errorList = errorList + value;
                            }
                        });
                        $("#spin").css('display','hide');
                        $("#onMessageSendDiv").find("#semd").show();
                        bootbox.alert(errorList);

                    }
                }
            }).submit();
        }
        function onChangeSameBillingInfo(){
            if ($('#sameAsBillingInfo').is(':checked')) {
                $("#shipping_firstname").val($("#billing_firstname").val());
                $("#shipping_email").val($("#billing_email").val());
                $("#shipping_address1").val($("#billing_address1").val());
                $("#shipping_address2").val($("#billing_address2").val());
                $("#shipping_lastname").val($("#billing_lastname").val());
                $("#shipping_phone").val($("#billing_phone").val());
                $("#shipping_city").val($("#billing_city").val());
                $("#shipping_state").val($("#billing_state").val());
                $("#shipping_zip").val($("#billing_zip").val());
                $("#shipping_country").val($("#billing_country").val());

            }else{
                $("#shipping_firstname").val("");
                $("#shipping_email").val("");
                $("#shipping_address1").val("");
                $("#shipping_address2").val("");
                $("#shipping_lastname").val("");
                $("#shipping_phone").val("");
                $("#shipping_country").val("");
            }
        }


        function OnSendForm(){

            $("#placeOrderModal").modal('hide');
             $("#shoppingCartForm").submit();
        }
        var StepWizard = function () {

            return {

                initStepWizard: function () {
                    var form = $(".shopping-cart");
                    form.validate({
                        errorPlacement: function errorPlacement(error, element) { element.before(error); },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });
                    form.children("div").steps({
                        headerTag: ".header-tags",
                        bodyTag: "section",
                        transitionEffect: "fade",
                        onStepChanging: function (event, currentIndex, newIndex) {
                            // Allways allow previous action even if the current form is not valid!
                            if(currentIndex ==0 && newIndex == 1){
                                if(indexValue ==0){
                                    $("#signInModal").find("input").each(function(){
                                        $(this).val("");
                                    });
                                    $("#signInModal").modal('show');
                                    return;
                                }
                            }

                            if (currentIndex > newIndex)
                            {
                                return true;
                            }
                            form.validate().settings.ignore = ":disabled,:hidden";
                            return form.valid();
                        },
                        onFinishing: function (event, currentIndex) {
                            form.validate().settings.ignore = ":disabled";
                            return form.valid();
                        },
                        onFinished: function (event, currentIndex) {
                           // $("#shoppingCartForm").submit();
                            $("#placeOrderModal").modal('show');
                        }
                    });
                },

            };
        }();

    </script>
@stop