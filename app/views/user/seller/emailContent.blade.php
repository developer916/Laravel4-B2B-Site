@extends('user.seller.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/app.css')}}
        {{HTML::style('/assets/asset_view/plugins/font-awesome/css/font-awesome.min.css')}}
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 tab-v1 change-tab-v1">
                    <ul class="nav nav-tabs">
                        <li <?php if($slug == 'new') echo 'class="active"'; ?>>  <a href="{{URL::route('user.seller.email','new')}}" >{{Lang::get('user.new')}}</a></li>
                        <li <?php if($slug == 'all') echo 'class="active"'; ?>>  <a href="{{URL::route('user.seller.email','all')}}" >{{Lang::get('user.all')}}</a></li>
                        <li <?php if($slug == 'sent') echo 'class="active"'; ?>> <a href="{{URL::route('user.seller.email','sent')}}" >{{Lang::get('user.sent')}}</a></li>
                        <li <?php if($slug == 'inbox') echo 'class="active"'; ?>><a href="{{URL::route('user.seller.email','inbox')}}">{{Lang::get('user.inbox')}}</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12 emailContentBody">
                        <div class="row">
                            <div class="panel panel-default margin-bottom-40 change-panel">
                                <div class="panel-body">
                                    <div class="panel-group acc-v1" id="accordion-1">
                                        @foreach($email as $key =>$emailList)
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse<?php echo $key;?>">
                                                                <?php
                                                                    if($emailList->sender_id == Session::get('user_id')){ ?>
                                                                        {{Lang::get('user.me')}}, {{$emailList->recevier->username}}
                                                                <?php }else if($emailList->receiver_id == Session::get('user_id')){?>
                                                                        {{$emailList->sender->username}}, {{Lang::get('user.me')}}
                                                                <?php }
                                                                ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse<?php echo $key;?>" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                   <h4 style="color: rgb(26, 114, 229);font-weight: 700;">{{$emailList->subject}}</h4>
                                                                  {{$emailList->content}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                   </div>
                                   <div class="col-md-12">
                                        <form action="{{URL::route('user.seller.storeEmail')}}" method="post" class="form-horizontal reg-page">
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
                                            <div class="form-group">
                                                 <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label">{{Lang::get('user.to')}}</label>
                                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                                    <input type="text" class="form-control" id="inputEmail1" placeholder="Email" value="{{$buyerUserName}}" readonly style="border:0px!important">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                 <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> {{Lang::get('user.message_subject')}} :</label>
                                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                                    <textarea class="form-control" id="inputEmail1" placeholder="{{Lang::get('user.message_subject')}}"  rows="1" name="subject"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                 <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> {{Lang::get('user.message_content')}} :</label>
                                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                                    <textarea class="form-control" id="inputEmail1" placeholder="{{Lang::get('user.message_content')}}"  rows="10" name="content"></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="user_id" value="<?php echo ($buyerID+100000*1); ?>">
                                            <input type="hidden" name="parent" value="{{$parent}}">
                                            <input type="hidden" name="slug" value="{{$slug}}">
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-4 col-xs-offset- col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                                    <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.send')}}">
                                                    <a href="{{URL::route('user.seller.email',$slug)}}" class="btn-u btn-u-red" >{{Lang::get('user.cancel')}}</a>
                                                </div>
                                            </div>
                                        </form>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts-sub')
    @stop
@stop

