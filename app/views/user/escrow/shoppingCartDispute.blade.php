@extends('user.escrow.layout')
@section('custom-styles')

@stop
@section('body')
    <div class="container content">
        <div class="col-md-12 text-center margin-bottom-30">
            <h2>{{Lang::get('cart.purchasetree_shopping_cart_dispute')}}</h2>
        </div>
        <div class="col-md-12 margin-bottom-40">
            <div class="alert alert-success">
                <h4>{{Lang::get('cart.dispute_lists')}}</h4>
                <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <td>
                            {{Lang::get('user.escrow_id')}}
                        </td>
                        <td>
                            {{Lang::get('cart.seller_name')}}
                        </td>
                        <td>
                            {{Lang::get('cart.buyer_name')}}
                        </td>

                        <td>
                            {{Lang::get('cart.product_name')}}
                        </td>
                        <td>
                            {{Lang::get('cart.Qty')}}
                        </td>
                        <td>
                            {{Lang::get('cart.Price')}}
                        </td>
                        <td>
                            {{Lang::get('cart.Product_Total_Price')}}
                        </td>
                        <td>
                            {{Lang::get('cart.escrow_fee')}}
                        </td>
                        <td>
                            {{Lang::get('cart.Total')}}
                        </td>
                        <td>
                            {{Lang::get('cart.status')}}
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php $cart = $cartProduct->ShoppingCart; $seller= $cartProduct->seller; $product = $cartProduct->product;?>
                            <td>{{$cart->invoice_number}}</td>
                            <td>{{$seller->username}}</td>
                            <td>{{$buyer->username}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>{{$cartProduct->qty.$cartProduct->unit}}</td>
                            <td> {{$cartProduct->product_price." $"}}
                                @if($cartProduct->shipping_price !="")
                                    <p><span style="color:red">Shipping Price: </span> {{$cartProduct->shipping_price." $"}}</p>
                                @endif
                            </td>
                            <td>{{$cartProduct->sub_total . " $" }}</td>
                            <td> {{round($cartProduct->sub_total*$fee,2) . " $" }}</td>
                            <td>{{round($cartProduct->sub_total*(1+$fee),2)." $"}}</td>
                            <td>@if($cartProduct->status == ShoppingCartProduct::STATUS_SHOPPINGCARTPRODUCT_DISPUTE)
                                    Buyer has been dispute
                                @elseif($cartProduct->status == ShoppingCartProduct::STATUS_SHOPPINGCARTPRODUCT_AGREEMENT)
                                    Agreement
                                @elseif($cartProduct->status == ShoppingCartProduct::STATUS_SHOPPINGCARTPRODUCT_ESCALATION)
                                    Escalation
                                @endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            @if(Session::get('user_id') == $cartProduct->buyer_id)
                @if($cartProduct->status == 8)
                    <div class="row margin-bottom-40">
                        <div class="col-md-3 col-md-offset-9 col-sm-4 col-sm-offset-4 col-xs-12" >
                            <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick="onAgreementMode()" style="margin-right: 10px">Agreement</a>
                            <a href="javascript:void(0)" class="btn-u btn-u-red " onclick="onEscalationMode()" style="margin-right: 10px">Escalation</a>
                        </div>
                    </div>
                @endif
            @endif
            <?php if (isset($alert)) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-<?php echo $alert['type'];?> alert-dismissibl fade in">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <p>
                            <?php echo $alert['msg'];?>
                        </p>
                    </div>
                </div>
            </div>

            <?php } ?>
            <div class="row">
                <div class="col-md-12 margin-bottom-20">
                    <h3>Dispute Messages</h3>
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <td>Sender Name</td>
                                <td>Receiver Name</td>
                                <td>Title</td>
                                <td>Content</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($disputeContents as $key => $disputeContent)
                                <tr>
                                    <td>{{$disputeContent->sender->username}}</td>
                                    <td>{{$disputeContent->receiver->username}}</td>
                                    <td>{{$disputeContent->title}}</td>
                                    <td>{{$disputeContent->content}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <h2 class="margin-bottom-40 text-center">{{ Lang::get('missing.send_message') }}</h2>
                    <form action="{{URL::route('user.escrow.shoppingCartDisputeSendContent')}}" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> {{Lang::get('user.message_subject')}} :</label>
                            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                <textarea class="form-control" id="inputEmail1" placeholder="Subject" rows="1" name="subject"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-3 col-sm-4 col-md-4 col-xs-5 control-label"><span style="color:red">*</span> {{Lang::get('user.message_content')}} :</label>
                            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                <textarea class="form-control" id="inputEmail1" placeholder="Content" rows="10" name="content"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="cart_product_id" value="{{100000*1+ $cartProduct->id }}">
                        <input type="hidden" name="dispute_type" id="dispute_type">
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-4 col-xs-offset- col-lg-8 col-md-6 col-sm-6 col-xs-7">
                                <input type="submit" class="btn-u btn-u-blue" value="Send">
                                <a href="{{ URL::route('user.escrow.escrow', array($cart->invoice_number,1)) }}" class="btn-u btn-u-red">{{Lang::get('user.cancel')}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="agreementModeDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modalChangeContent">
                <div class="modal-header modalChangeHeader">
                    <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('missing.agreement')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="validationAgreementErrorDiv" style="display: none;">
                            <div class="alert alert-danger alert-dismissibl fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <p id="errorValidationP">
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form action="{{URL::route('user.escrow.shoppingCartDisputeAgreement')}}" method="post" class="form-horizontal" id="agreementFormDiv">
                                <div class="form-group margin-bottom-30">
                                    <label class="col-md-3 col-sm-4 col-xs-12 control-label">{{Lang::get('user.Message')}} <span style="color:red">*</span> </label>
                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <textarea class="form-control" id="inputEmail1" placeholder="Message" rows="10" name="message"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="cart_product_id" value="{{$cartProduct->id+100000*1}}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-8 col-xs-12 col-sm-5 col-sm-offset-7">
                                            <a href="javascript:void(0)" onclick="onAgreement()" class="btn-u btn-u-blue" style="margin-right:10px; margin-bottom: 20px;">{{Lang::get('user.send')}}</a>
                                            <a href="javascript:void(0)" onclick="onCancelAgreement()" class="btn-u btn-u-red" style="margin-right: 10px; margin-bottom: 20px;">{{Lang::get('user.cancel')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function onAgreementMode(){
            $("#validationAgreementErrorDiv").hide();
            $("#dispute_type").val('agreement');
            $("#agreementModeDiv").modal('show');
        }

        function onEscalationMode(){
            $("#validationAgreementErrorDiv").hide();
            $("#dispute_type").val('escalation');
            $("#agreementModeDiv").modal('show');
        }
        function onCancelAgreement(){
            $("#agreementModeDiv").modal('hide');
        }
        function onAgreement(){
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
                       $("#agreementFormDiv").ajaxForm({
                         success:function(data){
                            if(data.result == "success"){
                                bootbox.alert(data.message);
                                window.location.reload();
                            }else{
                                $("#errorValidationP").html(data.message);
                                $("#validationAgreementErrorDiv").show();
                            }
                         }
                       }).submit();
                    }
                }
            });
        }
    </script>
@stop