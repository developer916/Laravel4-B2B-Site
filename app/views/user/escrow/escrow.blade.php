@extends('user.escrow.layout')
    @section('custom-styles')
    {{HTML::style('/assets/asset_view/css/forestchange.css')}}
    {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
    {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
    @stop
    @section('body')
         <div class="container content">
            <div class="col-md-12 text-center margin-bottom-30">
                <h2>{{Lang::get('user.purchasetree_escrow')}}</h2>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="alert alert-success min-height-250">
                        <div class="row">
                            <div class="form-horizontal col-md-12" id="escrowPay">
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                        <h4 class="fontSize15">{{Lang::get('user.item')}}</h4>
                                    </label>
                                    <div class="col-md-8">
                                        <input class="form-control changeFormControl" value="{{$escrow->item}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                        <h4 class="fontSize15">{{Lang::get('user.escrow_id')}}</h4>
                                    </label>
                                    <div class="col-md-8">
                                        <input class="form-control changeFormControl" value="{{$escrow->escrow_id}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                        <h4 class="fontSize15">{{Lang::get('user.selling_price')}}</h4>
                                    </label>
                                    <div class="col-md-8">
                                        <input class="form-control changeFormControl" value="{{$reallyPrice."(USD)"}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                        <h4 class="fontSize15">{{Lang::get('user.escrow_fee')}}</h4>
                                    </label>
                                    <div class="col-md-8">
                                        <input class="form-control changeFormControl" value="{{$ecrowFeePrice."(USD)"}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                        <h4 class="fontSize15">{{Lang::get('user.total_due')}}</h4>
                                    </label>
                                    <div class="col-md-8">
                                        <input class="form-control changeFormControl" value="{{$totalPrice."(USD)"}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                        <h4 class="fontSize15">{{Lang::get('user.status')}}</h4>
                                    </label>
                                    <div class="col-md-8">
                                        <p class="form-control changeFormControl">
                                            @if($escrow->status == 1)
                                                {{Lang::get('user.waiting_for_payment')}}
                                            @elseif($escrow->status == 2)
                                                {{Lang::get('user.the_money_are_in_escrow')}}
                                            @elseif($escrow->status == 3)
                                                     @if($escrow->confirm =="2")
                                                        {{Lang::get('user.the_money_are_in_dispute')}}
                                                    @elseif($escrow->confirm== "3")
                                                        {{Lang::get('user.dispute_solved')}}
                                                    @endif
                                            @elseif($escrow->status == 4)
                                                {{Lang::get('user.the_payment_was_canceled')}}
                                            @elseif($escrow->status == 5)
                                                {{Lang::get('user.approving')}}
                                            @endif</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="alert alert-info min-height-250">
                         <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <h4 class="caption-subject escrow-index-success-header margin-bottom-20">{{Lang::get('user.buyer')}}</h4>
                                <p>{{$buyerMember->userfullname}}</p>
                                <p>
                                    @if($buyerMember->useraddress1)
                                        {{$buyerMember->useraddress1}}
                                    @elseif($buyerMember->useraddress2)
                                        {{$buyerMember->useraddress2}}
                                    @endif
                                </p>
                                <p>
                                    {{$buyerMember->usercity .", ". $buyerMember->userstate .", ". $buyerMember->userzip}}
                                </p>
                                <p> {{$buyerCountry->country_name}}</p>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <h4 class="caption-subject escrow-index-success-header margin-bottom-20">{{Lang::get('user.seller')}}</h4>
                                <p>{{$sellerMember->userfullname}}</p>
                                <p>
                                    @if($sellerMember->useraddress1)
                                        {{$sellerMember->useraddress1}}
                                    @elseif($sellerMember->useraddress2)
                                        {{$sellerMember->useraddress2}}
                                    @endif
                                </p>
                                <p>
                                    {{$sellerMember->usercity .", ". $sellerMember->userstate .", ". $sellerMember->userzip}}
                                </p>
                                <p> {{$sellerCountry->country_name}}</p>
                            </div>
                         </div>

                    </div>
                </div>
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
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="alert alert-success min-height-120">
                        <h4>{{Lang::get('user.seller') . " ". Lang::get('user.instructions')}}</h4>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @if($escrow->status == 1)
                                    {{Lang::get('user.waiting_for_payment')}}
                                @elseif($escrow->status ==2)
                                    @if($escrow->confirm == 1)
                                        {{Lang::get('user.the_money_was_put_in_the_escrow')}} <br>
                                        @if($userMemberCheck == "seller")
                                        {{Lang::get('user.now_you_can_give_the_item')}} <br>
                                         <div class="row" style="padding: 10px">
                                             <form action="{{URL::route('user.escrow.cancel')}}" method="post" style="display: inline-block" onsubmit = "return onSendApproved(this)" >
                                                 <input type="hidden" name="escrow_id" value="{{100000*1+$escrow->id}}">
                                                 <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.cancel_payment')}}" >
                                              </form>
                                            <a href="javascript:void(0)" class="btn-u btn-u-red" onclick="dispute_content()">{{Lang::get('user.dispute_payment')}}</a>
                                         </div>
                                         @endif
                                    @elseif($escrow->confirm == 0)
                                        {{Lang::get('user.wait_admin_confirm_escrow')}}
                                    @endif
                                @elseif($escrow->status == 3)
                                    @if($escrow->confirm =="2")
                                       {{Lang::get('user.the_money_are_in_dispute')}}
                                        @if($userMemberCheck == "seller")
                                           {{Lang::get('user.please_send_your_reason_to_admin')}} <br>
                                           <a href="javascript:void(0)" onclick="dispute_content()">{{Lang::get('user.dispute_content')}}</a>
                                           @endif
                                   @elseif($escrow->confirm== "3")
                                       {{Lang::get('user.dispute_solved')}} <br>
                                        @if($userMemberCheck == "seller")
                                        <div class="row" style="padding: 10px">
                                            <form action="{{URL::route('user.escrow.cancel')}}" method="post" style="display: inline-block" onsubmit = "return onSendApproved(this)" >
                                                <input type="hidden" name="escrow_id" value="{{100000*1+$escrow->id}}">
                                                <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.cancel_payment')}}" >
                                             </form>
                                           <a href="javascript:void(0)" class="btn-u btn-u-red" onclick="dispute_content()">{{Lang::get('user.dispute_payment')}}</a>
                                        </div>
                                        @endif
                                   @endif
                                @elseif($escrow->status == 4)
                                    {{Lang::get('user.the_payment_was_canceled')}}
                                @elseif($escrow->status == 5)
                                    {{Lang::get('user.the_payment_was_approved')}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="alert alert-info min-height-120">
                        <h4>{{Lang::get('user.buyer') . " ". Lang::get('user.instructions')}}</h4>
                        @if($escrow->status == 1)
                             <div class="row">
                                 <div class="col-md-12 text-right">
                                     @if($totalPrice <= 500)
                                          <a href="javascript:void(0)" class="btn-u btn-u-green" onclick="onLargePayResult()"> {{Lang::get('user.pay_now')}}</a>
                                     @else
                                         <a href="javascript:void(0)" class="btn-u btn-u-green" onclick="onLargePayResult()">{{Lang::get('user.pay_now')}}</a>
                                     @endif
                                 </div>
                             </div>
                        @else
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    @if($escrow->status == 1)
                                        {{Lang::get('user.waiting_for_payment')}}
                                    @elseif($escrow->status ==2)
                                        @if($escrow->confirm == 1)
                                            {{Lang::get('user.the_money_was_put_in_the_escrow')}} <br>
                                            @if($userMemberCheck == "buyer")
                                            {{Lang::get('user.after_you_get_item')}} <br>
                                            <div class="row" style="padding: 10px">
                                             <form action="{{URL::route('user.escrow.approved')}}" method="post" style="display: inline-block" onsubmit = "return onSendApproved(this)" >
                                                <input type="hidden" name="escrow_id" value="{{100000*1+$escrow->id}}">
                                                <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.approve_payment')}}" >
                                             </form>
                                             <a href="javascript:void(0)" class="btn-u btn-u-red" class="btn-u btn-u-red" onclick="dispute_content()">{{Lang::get('user.dispute_payment')}}</a>
                                             </div>
                                            @endif
                                        @elseif($escrow->confirm == 0)
                                            {{Lang::get('user.wait_admin_confirm_escrow')}}
                                        @endif
                                    @elseif($escrow->status == 3)
                                        @if($escrow->confirm =="2")
                                            {{Lang::get('user.the_payment_was_disputed')}} <br>
                                            @if($userMemberCheck == "buyer")
                                            {{Lang::get('user.please_send_your_reason_to_admin')}} <br>
                                            <a href="javascript:void(0)" onclick="dispute_content()">{{Lang::get('user.dispute_content')}}</a>
                                            @endif
                                        @elseif($escrow->confirm =="3")
                                            {{Lang::get('user.dispute_solved')}} <br>
                                             @if($userMemberCheck == "buyer")
                                                <div class="row" style="padding: 10px">
                                                     <form action="{{URL::route('user.escrow.approved')}}" method="post" style="display: inline-block" onsubmit = "return onSendApproved(this)" >
                                                        <input type="hidden" name="escrow_id" value="{{100000*1+$escrow->id}}">
                                                        <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.approve_payment')}}" >
                                                     </form>
                                                     <a href="javascript:void(0)" class="btn-u btn-u-red" onclick="dispute_content()">{{Lang::get('user.dispute_payment')}}</a>
                                                 </div>
                                             @endif
                                        @endif
                                    @elseif($escrow->status == 4)
                                        {{Lang::get('user.the_payment_was_canceled')}}
                                    @elseif($escrow->status == 5)
                                        {{Lang::get('user.the_payment_was_approved')}}
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
         <?php if($escrow->status == 1) { ?>
         <div class="modal fade bs-example-modal-sm"  id="payNowFirstDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                  <div class="modal-content modalChangeContent">
                      <div class="modal-header modalChangeHeader">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                          <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.escrow_pay_first_tab_header')}}</h4>
                      </div>
                      <div class="modal-body" id="myModaltext">
                           <div class="sky-form" style="border:0px!important">
                                <div class="row">
                                    <div class=" col-md-12 col-xs-12 col-sm-12">
                                       <?php if($totalPrice <=500){ ?>
                                        <label class="radio"><input type="radio" name="type" checked value="credit"><i class="rounded-x"></i>{{Lang::get('user.credit_card')}}</label>
                                        <label class="radio"><input type="radio" name="type" value="check"><i class="rounded-x"></i>{{Lang::get('user.electronic_check')}}</label>
                                        <label class="radio"><input type="radio" name="type" value="wire"><i class="rounded-x"></i>{{Lang::get('user.wire_transfer')}}</label>
                                       <?php }else {?>
                                           <label class="radio"><input type="radio" name="type" value="check" checked><i class="rounded-x"></i>{{Lang::get('user.electronic_check')}}</label>
                                           <label class="radio"><input type="radio" name="type" value="wire"><i class="rounded-x"></i>{{Lang::get('user.wire_transfer')}}</label>
                                       <?php } ?>
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="modal-footer">
                            <a type="button" class="btn-u btn-u-primary" onclick="continueFirstStep()">{{Lang::get('user.continue')}}</a>
                            <button type="button" class="btn-u btn-u-default" data-dismiss="modal">{{Lang::get('user.close')}}</button>
                      </div>
                  </div>
            </div>
         </div>
         <div class="modal fade" id="onPayWireTransfer" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true" style="z-index:1042">
             <div class="modal-dialog">
                   <div class="modal-content modalChangeContent">
                       <div class="modal-header modalChangeHeader">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.payment_form')}}</h4>
                       </div>
                       <div class="modal-body" id="myModaltext">
                            <div class="row">
                                <div class="col-md-12">
                                        <form class="form-horizontal" method="post" action="{{URL::route('user.escrow.wirePayNow')}}" id="onWirePayNowCotentDiv">
                                            <h4 class="text-center">{{Lang::get('user.wire_transfer_information')}}</h4>
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9 text-right">
                                                    <a href="{{URL::route('user.escrow.wirePrintButton', array($quote_id,100000*1+$escrow->id))}}" class="btn-u" target="_blank">{{Lang::get('user.print')}}</a>
                                                    <button type="button" class="btn-u btn-u-default" data-dismiss="modal">{{Lang::get('user.close')}}</button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3 col-md-3 col-sm-3 control-label">{{Lang::get('user.company')}}</label>
                                                <div class="col-lg-9 col-md-9 col-sm-9">
                                                    <p class="form-control escrow_wire_transfer_company_list">
                                                       {{Lang::get('user.company_information_for_wire_transfer1')}} <br>
                                                       {{Lang::get('user.company_information_for_wire_transfer2')}} <br>
                                                       {{Lang::get('user.company_information_for_wire_transfer3')}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3 col-md-3 col-sm-3 control-label">{{Lang::get('user.company_routing_name')}}</label>
                                                <div class="col-lg-9 col-md-9 col-sm-9">
                                                    <p class="form-control escrow_wire_transfer_company_list">
                                                       {{Lang::get('user.company_routing_value')}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-3 col-md-3 col-sm-3 control-label">{{Lang::get('user.company_account_name')}}</label>
                                                <div class="col-lg-9 col-md-9 col-sm-9">
                                                    <p class="form-control escrow_wire_transfer_company_list">
                                                       {{Lang::get('user.company_account_value')}}
                                                    </p>
                                                </div>
                                            </div>
                                           <div class="form-group">
                                               <label for="inputPassword1" class="col-lg-3 col-md-3 col-sm-3 control-label">{{Lang::get('user.invoice_number')}}</label>
                                               <div class="col-lg-9 col-md-9 col-sm-9">
                                                    <p class="form-control escrow_wire_transfer_company_list">
                                                        {{$accept[0]->invoice_number}}
                                                    </p>
                                               </div>
                                           </div>
                                            <div class="form-group">
                                                <label class="col-lg-3 col-md-3 col-sm-3 control-label">{{Lang::get('user.wire_transfer_Amount')}}</label>
                                                <div class="col-lg-9 col-md-9 col-sm-9">
                                                    <p class="form-control escrow_wire_transfer_company_list">
                                                       {{$totalPrice}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail1" class="col-lg-3 col-md-3 col-sm-3 control-label">{{Lang::get('user.wire_transfer_bank')}}</label>
                                                <div class="col-lg-9 col-md-9 col-sm-9">
                                                    <p class="form-control escrow_wire_transfer_company_list">
                                                        JPMorgan Chase Bank NA
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                                    <input type="hidden" name="quote_id" value="{{$quote_id}}">
                                                    <input type="hidden" name="escrow_id" value="{{$escrow->escrow_id}}">
                                                </div>
                                            </div>
                                            <h4 class="text-center"> {{Lang::get('user.instruction_for_payment')}}</h4>
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                                    {{Lang::get('user.full_payment_is_required')}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                                    {{Lang::get('user.include_your_invoice_number')}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                                    {{Lang::get('user.send_us_your_wire')}}<br>
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                        {{Escrow_Email}} <br>
                                                        {{Escrow_Fax}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group margin-bottom-20">
                                                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                                    {{Lang::get('user.allow_hours_for_your_escrow')}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9 text-right">
                                                    <a href="{{URL::route('user.escrow.wirePrintButton', array($quote_id,100000*1+$escrow->id))}}" class="btn-u" target="_blank">{{Lang::get('user.print')}}</a>
                                                    <button type="button" class="btn-u btn-u-default" data-dismiss="modal">{{Lang::get('user.close')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                </div>
                            </div>
                       </div>
                   </div>
             </div>
          </div>
         <?php } ?>

         <?php if($totalPrice <=500 && $escrow->status == 1) { ?>
         <div class="modal fade" id="payNowQuoteDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
                 <div class="modal-dialog">
                      <div class="modal-content modalChangeContent">
                          <div class="modal-header modalChangeHeader">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.payment_form')}}</h4>
                          </div>
                          <div class="modal-body" id="myModaltext">
                             <div class="row">
                                 <div class="col-md-12">
                                     <form class="form-horizontal" id="onPayNowCotentDiv" method="post" action="{{URL::route('user.escrow.samplePayNow')}}">
                                         <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.card_no')}}</label>
                                             <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                                 <input type="text" class="form-control" id="inputEmail1" name="card_no" placeholder="{{Lang::get('user.card_no')}}">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.exp_month')}}</label>
                                             <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                                 <input type="text" class="form-control" id="inputEmail1" name="exp_month" placeholder="{{Lang::get('user.exp_month')}}">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.exp_year')}}</label>
                                             <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                                 <input type="text" class="form-control" id="inputEmail1" name="exp_year" placeholder="{{Lang::get('user.exp_year')}}">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.total')}}</label>
                                              <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                                 <input type="text" class="form-control" id="inputEmail1" name="total" readonly value="{{round($totalPrice,2)}}USD">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.address')}}</label>
                                             <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                                 <input type="text" class="form-control" id="inputEmail1" name="address" placeholder="{{Lang::get('user.address')}}">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.zip_code')}}</label>
                                             <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                                 <input type="text" class="form-control" id="inputEmail1" name="zipCode" placeholder="{{Lang::get('user.zip_code')}}">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.email')}}</label>
                                             <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                                 <input type="text" class="form-control" id="inputEmail1" name="email" placeholder="{{Lang::get('user.email')}}">
                                             </div>
                                         </div>
                                         <div class="form-group margin-bottom-20">
                                           <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.cvv2')}}</label>
                                             <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                                 <input type="text" class="form-control" id="inputEmail1" name="cvv2" placeholder="{{Lang::get('user.cvv2')}}">
                                             </div>
                                         </div>
                                         <input type="hidden" name="quote_id" value="{{$quote_id}}">
                                         <input type="hidden" name="escrow_id" value="{{$escrow->escrow_id}}">
                                         <div class="form-group margin-bottom-40">
                                             <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8 col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-xs-offset-4">
                                                 <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick = "OnPayNowModalSend()" id="paynowSubmit">{{Lang::get('user.pay_now')}}</a>
                                                 <div id="spin" style="display: none"></div>
                                                 <button type="button" class="btn-u btn-u-red"  data-dismiss="modal">{{Lang::get('user.cancel')}}</button>
                                             </div>
                                         </div>
                                     </form>
                                 </div>
                             </div>
                          </div>
                      </div>
                 </div>
           </div>
         <?php } elseif($totalPrice <=500 && $escrow->status == 1) { ?>
            
         <?php }?>
          <div class="modal fade" id="disputeDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
              <div class="modal-dialog">
                   <div class="modal-content modalChangeContent">
                       <div class="modal-header modalChangeHeader">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.do_you_want_dispute_about_escrow_payment')}}</h4>
                       </div>
                       <div class="modal-body" id="myModaltext">
                          <div class="row">
                               <div class="col-md-12">
                                     <form class="form-horizontal" id="onSendDisputeContentDiv" method="post" action="{{URL::route('user.escrow.disputeDiv')}}">
                                        <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">{{Lang::get('user.escrow_id')}}</label>
                                             <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                 <input type="text" class="form-control" id="inputEmail1" name="escrow_id" placeholder="{{Lang::get('user.escrow_id')}}" value="{{$escrow->escrow_id}}" readonly>
                                             </div>
                                         </div>
                                        <div class="form-group">
                                           <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">{{Lang::get('user.dispute_title')}}</label>
                                             <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                 <input type="text" class="form-control" id="inputEmail1" name="dispute_title" placeholder="{{Lang::get('user.dispute_title')}}" >
                                             </div>
                                         </div>
                                         <div class="form-group">
                                            <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">{{Lang::get('user.dispute_content')}}</label>
                                              <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                  <textarea class="form-control"  name="dispute_content" placeholder="{{Lang::get('user.dispute_content')}}" rows="10" ></textarea>
                                              </div>
                                          </div>
                                          <input type="hidden" name="escrow_dispute_id" value="{{100000*1+$escrow->id}}">
                                          <div class="form-group margin-bottom-40">
                                               <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7 col-lg-offset-3 col-md-offset-4 col-sm-offset-4 col-xs-offset-5">
                                                   <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick = "onSendDisputeContent()" id="disputeSubmit">{{Lang::get('user.submit')}}</a>
                                                   <div id="spin2" style="display: none"></div>
                                                   <button type="button" class="btn-u btn-u-red"  data-dismiss="modal">{{Lang::get('user.cancel')}}</button>
                                               </div>
                                           </div>
                                     </form>
                               </div>
                          </div>
                       </div>
                   </div>
              </div>
          </div>
           <div class="modal fade" id="electronicDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                     <div class="modal-content modalChangeContent">
                         <div class="modal-header modalChangeHeader">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                             <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.electronic_title')}}</h4>
                         </div>
                         <div class="modal-body" id="myModaltext">
                            <div class="row">
                                 <div class="col-md-12">
                                       <?php
                                        if(count($electronic)>0){echo $electronic[0]->content;}
                                       ?>
                                 </div>
                                 <div class="col-md-12 text-right">
                                     <a href="https://seamlesschex.com/checkout/QwuCNYYK4WggECMSZ4gmdEDFcLhHlzuONpg//0" class="btn-u btn-u-primary" >{{Lang::get('user.continue')}}</a>
                                      <button type="button" class="btn-u btn-u-default" data-dismiss="modal">{{Lang::get('user.close')}}</button>
                                 </div>
                            </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        {{ HTML::script('/assets/assest_admin/js/spin.js') }}
         <script type="text/javascript">
            function onSendApproved(obj){
                bootbox.confirm("Are you sure?", function(result) {
                    if ( result ) {

                        obj.submit();

                    }

                });

                return false;
            }
            function onLargePayResult(){
                $("#payNowFirstDiv").modal('show');
                //$("#onPayWireTransfer").modal('show');
            }
            function dispute_content(){
                $("#disputeDiv").modal('show');
            }
            function continueFirstStep(){
                var selectType = $("input[type='radio']:checked").val();
               // $("#payNowFirstDiv").modal('hide');
                if(selectType == "credit"){
                    onPayNow();
                }else if(selectType =="wire"){
                    onPayWire();
                }else if(selectType == "check"){
                    $("#electronicDiv").modal('show');
                }
            }
            function onPayWire(){
                $("#onPayWireTransfer").modal('show');
            }
            function onPayNow(){
                var a = $("<a>")
                   .attr("href", "#payNowQuoteDiv")
                   .attr("data-toggle","modal")
                   .appendTo("body");

                   a[0].click();

                   a.remove();
           }
           function onSendDisputeContent(){
                $("#spin2").css('display','block');
               $("#disputeSubmit").hide();
                var opts = {
                   lines: 7, // The number of lines to draw
                   length: 6, // The length of each line
                   width: 5, // The line thickness
                   radius: 8, // The radius of the inner circle
                   corners: 1, // Corner roundness (0..1)
                   rotate: 90, // The rotation offset
                   direction: 1, // 1: clockwise, -1: counterclockwise
                   color: '#000', // #rgb or #rrggbb or array of colors
                   speed: 0.7, // Rounds per second
                   trail: 60, // Afterglow percentage
                   shadow: false, // Whether to render a shadow
                   hwaccel: false, // Whether to use hardware acceleration
                   className: 'spinner', // The CSS class to assign to the spinner
                   zIndex: 2e9, // The z-index (defaults to 2000000000)
                   top: 'auto', // Top position relative to parent in px
                   left: 'auto' // Left position relative to parent in px
                 };
                 var target = document.getElementById('spin2');
                 var spinner = new Spinner(opts).spin(target);
                 $("#onSendDisputeContentDiv").ajaxForm({
                      success:function(data){
                               $("#spin2").hide();
                                $("#disputeSubmit").show();
                          if(data.result == "success"){
                               bootbox.alert(data.message);
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
           function onWirePayNow(){
                $("#spin1").css('display','block');
                $("#wireSendButton").hide();
                 var opts = {
                    lines: 7, // The number of lines to draw
                    length: 6, // The length of each line
                    width: 5, // The line thickness
                    radius: 8, // The radius of the inner circle
                    corners: 1, // Corner roundness (0..1)
                    rotate: 90, // The rotation offset
                    direction: 1, // 1: clockwise, -1: counterclockwise
                    color: '#000', // #rgb or #rrggbb or array of colors
                    speed: 0.7, // Rounds per second
                    trail: 60, // Afterglow percentage
                    shadow: false, // Whether to render a shadow
                    hwaccel: false, // Whether to use hardware acceleration
                    className: 'spinner', // The CSS class to assign to the spinner
                    zIndex: 2e9, // The z-index (defaults to 2000000000)
                    top: 'auto', // Top position relative to parent in px
                    left: 'auto' // Left position relative to parent in px
                  };
                  var target = document.getElementById('spin1');
                  var spinner = new Spinner(opts).spin(target);
                   $('#onWirePayNowCotentDiv').ajaxForm({
                        success:function(data){
                                 $("#spin1").hide();
                                  $("#wireSendButton").show();
                            if(data.result == "success"){
                                 bootbox.alert(data.message);
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
           function OnPayNowModalSend(){
                  $("#spin").css('display','block');
                  $("#paynowSubmit").hide();
                  var opts = {
                    lines: 7, // The number of lines to draw
                    length: 6, // The length of each line
                    width: 5, // The line thickness
                    radius: 8, // The radius of the inner circle
                    corners: 1, // Corner roundness (0..1)
                    rotate: 90, // The rotation offset
                    direction: 1, // 1: clockwise, -1: counterclockwise
                    color: '#000', // #rgb or #rrggbb or array of colors
                    speed: 0.7, // Rounds per second
                    trail: 60, // Afterglow percentage
                    shadow: false, // Whether to render a shadow
                    hwaccel: false, // Whether to use hardware acceleration
                    className: 'spinner', // The CSS class to assign to the spinner
                    zIndex: 2e9, // The z-index (defaults to 2000000000)
                    top: 'auto', // Top position relative to parent in px
                    left: 'auto' // Left position relative to parent in px
                  };
                  var target = document.getElementById('spin');
                  var spinner = new Spinner(opts).spin(target);
                   $('#onPayNowCotentDiv').ajaxForm({
                      success:function(data){
                               $("#spin").hide();
                                $("#paynowSubmit").show();
                          if(data.result == "success"){
                               bootbox.alert(data.message);
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
@stop