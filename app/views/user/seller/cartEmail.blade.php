@extends('user.seller.layout')
@section('custom-styles')
@stop
@section('body-right')
    <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
        <div class="row">
            <div class="col-md-12 orderContent margin-bottom-40" >
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 orderTitle">
            <?php
                        $list ='';
                        $list .='<div class="row">';
                        $list .='<div class="col-md-12">';
                        $list .='<div class="form-horizontal">';
                        if(count($cartMails)>0) {
                            $list .='<div class="row">
                                    <div class="panel panel-default margin-bottom-40 change-panel">
                                        <div class="panel-body">
                                            <div class="panel-group acc-v1" id="accordion-1">';
                            foreach ($cartMails as $key => $value) {
                                $list .='<div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">';
                                $list .='<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse'. $key.'">';
                                if($value->sender_id == Session::get('user_id')){
                                    $list .=Lang::get('user.me').' , '.$value->receiver->username;
                                }else{
                                    $list .=$value->sender->username.' , '.Lang::get('user.me');
                                }
                                $list .='</a>';
                                $list .='</h4>';
                                $list .='    </div>';
                                $list .='<div id="collapse'.$key.'" class="panel-collapse collapse">';
                                $list .='<div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 style="color: rgb(26, 114, 229);font-weight: 700;">'.$value->subject.'</h4>
                                                                                '.$value->message.'
                                                                        </div>
                                                                    </div>
                                                                </div>';
                                $list .='</div>';
                                $list .=' </div>';
                            }
                            $list .='</div>';

                            $list .='</div>';
                            $list .='</div>';
                            $list .='</div>';
                        }
                        $list .=' <div class="col-md-12">';
                        $list .='<form action="'.URL::route('user.seller.cart.postMail').'" method="post" class="form-horizontal reg-page" id="emailSendForm">';
                        $list .='<div class="form-group">
                                         <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label">'.Lang::get('user.to').'</label>
                                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                            <input type="text" class="form-control" id="inputEmail1" placeholder="Email" value="'.$buyer->username.'" readonly style="border:0px!important">
                                        </div>
                                    </div>';
                        $list .='<div class="form-group">
                                     <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> '.Lang::get('user.message_subject').' :</label>
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                        <textarea class="form-control" id="inputEmail1" placeholder="'.Lang::get('user.message_subject').'"  rows="1" name="subject"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                     <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> '.Lang::get('user.message_content').' :</label>
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                        <textarea class="form-control" id="inputEmail1" placeholder="'.Lang::get('user.message_content').'"  rows="10" name="content"></textarea>
                                    </div>
                                </div>';
                        $list .='<input type="hidden" name="user_id" value="'.(100000*1+$buyer->id).'">
                                         <input type="hidden" name="shoppingCartProductID" value="'.$id.'" >';
                        $list .='<div class="form-group">
                                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-4 col-xs-offset- col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                                <input type="button" class="btn-u btn-u-blue" value="'.Lang::get('user.send').'" onclick = "onSendFormButton()" id="semd">

                                                <a href="'.URL::route('user.seller.cart').'" class="btn-u btn-u-red" >'.Lang::get('user.cancel').'</a>
                                                <div id="spin"></div>
                                            </div>
                                        </div>';
                        $list .='</form>';
                        $list .='</div>';
                        $list .='</div>';
                        $list .='</div>';
                        $list .='</div>';
                        ?>
                     {{$list}}
                   </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('custom-scripts')
    <script type="text/javascript">
        function onSendFormButton(){
            $("#emailSendForm").ajaxForm({
                success:function(data){
                    if(data.result == "success"){
                        bootbox.alert("{{Lang::get('missing.message_sent_successfully')}}");
                        window.location.reload();
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
                        bootbox.alert(errorList);
                    }
                }
            }).submit();
        }
    </script>
@stop
