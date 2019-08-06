@extends('user.escrow.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/pages/page_log_reg_v1.css')}}
        {{HTML::style('/assets/asset_view/css/forestchange.css')}}
    @stop
    @section('body')
        <div class="breadcrumbs">
            <div class="container">
                <h1 class="pull-left">{{Lang::get('user.registration')}}</h1>
            </div><!--/container-->
        </div>
        <div class="registerBackground">
             <div class="container content">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                            <form class="reg-page" method="post" action="{{URL::route('user.escrow.registerStore')}}">

                                <div class="reg-header">
                                    <h2>{{Lang::get('user.Register_a_new_account')}}</h2>
                                    <p>Already Signed Up? Click <a href="{{URL::route('user.escrow.login')}}" class="color-green">Sign In</a> to login your account.</p>
                                </div>
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
                                <h3 class="margin-bottom-20">{{Lang::get('user.purchasetree_information')}}</h3>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>{{Lang::get('user.user_name_or_email')}}<span class="color-red">*</span></label>
                                        <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.user_name_or_email')}}" name="purchaseName">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{Lang::get('user.password')}} <span class="color-red">*</span></label>
                                        <input type="password" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.password')}}" name="purchasePassword">
                                    </div>
                                </div>
                                 <hr>
                                 <h3 class="margin-bottom-20">{{Lang::get('user.add_your_contact')}}</h3>
                                 <label>{{Lang::get('user.user_name')}} <span class="color-red">*</span></label>
                                 <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.user_name')}}" name="username">

                                 <div class="row margin-bottom-20">
                                     <div class="col-sm-6">
                                         <label>{{Lang::get('user.password')}}<span class="color-red">*</span></label>
                                         <input type="password" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.password')}}" name="password">
                                     </div>
                                     <div class="col-sm-6">
                                         <label>{{Lang::get('user.confirm_password')}} <span class="color-red">*</span></label>
                                         <input type="password" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.confirm_password')}}" name="password_confirmation">
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-6">
                                         <label>{{Lang::get('user.full_name')}}</label>
                                         <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.full_name')}}" name="fullname">
                                     </div>
                                     <div class="col-sm-6">
                                        <label>{{Lang::get('user.email')}}<span class="color-red">*</span> </label>
                                        <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.email')}}" name="useremail">
                                     </div>
                                 </div>
                                 <label>{{Lang::get('user.business_name')}}</label>
                                 <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.business_name')}}" name="businessname">

                                 <div class="row">
                                      <div class="col-sm-6">
                                          <label>{{Lang::get('user.address1')}}</label>
                                          <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.address1')}}" name="address1">
                                      </div>
                                      <div class="col-sm-6">
                                         <label>{{Lang::get('user.address2')}} </label>
                                         <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.address2')}}" name="address2">
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-6">
                                          <label>{{Lang::get('user.city')}}</label>
                                          <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.city')}}" name="city">
                                      </div>
                                      <div class="col-sm-6">
                                         <label>{{Lang::get('user.state_province')}} </label>
                                         <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.state_province')}}" name="state">
                                      </div>
                                  </div>
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <label>{{Lang::get('user.postal_code')}}</label>
                                        <input type="text" class="form-control margin-bottom-20" placeholder="{{Lang::get('user.postal_code')}}" name="postcode">
                                    </div>
                                    <div class="col-sm-6">
                                       <label>{{Lang::get('user.country')}} </label>
                                       <select name="country" class="form-control margin-bottom-20">
                                            @foreach($country as $key=>$coun)
                                                <option value="{{$coun->id}}">{{$coun->country_name}}</option>
                                            @endforeach
                                       </select>
                                    </div>
                                </div>
                                <label>{{Lang::get('user.how_would_you')}}</label>
                                <select name="payment" class="form-control margin-bottom-20" >
                                     <option value="mail">Regular Mail</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="overnight">Overnight Mail (U.S. Only)</option>
                                    <option value="air">Air Mail (International)</option>
                                </select>
                                <div class="row margin-bottom-40">
                                    <div class="col-md-12" style="float: right">
                                        {{ Form::captcha(['id' => 'captcha1']) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center">
                                        <input type="submit" class="btn-u" value="{{Lang::get('user.create_my_account')}}">
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
             </div>
        </div>
        {{ Captcha::scriptWithCallback(['captcha1']) }}
    @stop
@stop