@extends('user.escrow.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/pages/page_log_reg_v1.css')}}
        {{HTML::style('/assets/asset_view/css/forestchange.css')}}
    @stop
    @section('body')
        <div class="breadcrumbs">
            <div class="container">
                <h1 class="pull-left">{{Lang::get('user.layout_escrow_login')}}</h1>
            </div><!--/container-->
        </div>
        <div class="registerBackground" style="min-height: 550px">
            <div class="container content">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <form class="reg-page" method="post" action="{{URL::route('user.escrow.doLogin')}}">
                            <div class="reg-header">
                                <h3>{{Lang::get('user.layout_login_header')}}</h3>
                            </div>
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
                            <div class="input-group margin-bottom-20">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="{{Lang::get('user.user_name_or_email')}}" class="form-control" name="username" >
                            </div>
                            <div class="input-group margin-bottom-20">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" placeholder="{{Lang::get('user.password')}}" class="form-control" name="userpassword">
                            </div>
                            <div class="row margin-bottom-20">
                                <div class="col-md-12" style="float: right">
                                    {{ Form::captcha(['id' => 'captcha1']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6">
                                    <button class="btn-u pull-right" type="submit">{{Lang::get('user.login')}}</button>
                                </div>
                            </div>
                             <hr>
                             <h4>{{Lang::get('user.forgot_your_password')}}</h4>
                             <p>{{Lang::get('user.no_worries')}}, <a class="color-green" href="{{URL::route('user.escrow.forgot')}}">{{Lang::get('user.escrow_click_here')}}</a> {{Lang::get('user.to_reset_your_password')}}</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{ Captcha::scriptWithCallback(['captcha1']) }}
    @stop
@stop