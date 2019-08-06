@extends('user.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/pages/page_log_reg_v1.css')}}
    @stop
    @section('body')
        <div class="container content margin-bottom-40">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-2 col-xs-12">
                    <form action="{{URL::route('user.contact.userMessage')}}" method="post" class="form-horizontal reg-page">
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
                                <input type="text" class="form-control" id="inputEmail1" placeholder="Email" value="{{$member->username}}" readonly style="border:0px!important">
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
                        <input type="hidden" name="user_id" value="{{$user_id}}">
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-4 col-xs-offset- col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.send')}}">
                                <input type="button" class="btn-u btn-u-red" value="{{Lang::get('user.cancel')}}" onclick ="onCancelTab()">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        <script type="text/javascript">
            function onCancelTab(){
                window.close();
            }
        </script>
    @stop
@stop