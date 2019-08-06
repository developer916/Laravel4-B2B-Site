@extends('admin.layout')
    @section('body')
        <h3 class="page-title">Dispute Contact Management</h3>
            <!-- page layout -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{URL::route('admin.dashboard')}}">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-pencil"></i>
                        <a href="{{URL::route('admin.escrow.payments')}}">Escrow Management</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-pencil"></i>
                        <a href="{{URL::route('admin.escrow.dispute',$disputeID)}}">Dispute Content Management</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                Escrow status For  {{$escrow->item}}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Item
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" value="{{$escrow->item}}" style="border:0px!important;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Escrow ID
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" value="{{$escrow->escrow_id}}" style="border:0px!important;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Selling Price
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" value="{{$reallyPrice.'USD'}}" style="border:0px!important;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Escrow Fee
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" value="{{$escrowFeePrice .'USD'}}" style="border:0px!important;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Total Price
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" value="{{$totalPrice .'USD'}}" style="border:0px!important;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Total Price
                                                </label>
                                                <div class="col-md-8">
                                                   <p class="form-control" style="border:0px!important;">
                                                       @if($escrow->status == 1)
                                                           {{Lang::get('user.waiting_for_payment')}}
                                                       @elseif($escrow->status == 2)
                                                           {{Lang::get('user.the_money_are_in_escrow')}}
                                                       @elseif($escrow->status == 3)
                                                           {{Lang::get('user.the_money_are_in_dispute')}}
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
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2>Buyer</h2>
                                            <?php $buyer = ($escrow->buyerMember);?>
                                              <div class="form-horizontal">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <p> Escrow - UserName:  {{$buyer->username}}</p>
                                                                <p> {{$buyer->userfullname}}</p>
                                                                <p> <?php echo $buyer->useraddress1; if(isset($buyer->useraddress2) && ($buyer->useraddress2 !="")) {echo ', '.$buyer->useraddress2;}?> </p>
                                                                <p>
                                                                    <?php
                                                                        echo $buyer->usercity .", ". $buyer->userstate .", ". $buyer->userzip;
                                                                    ?></p>
                                                                <p> {{$buyerCountry->country_name}}</p>
                                                                <p> Purchasetree - UserName: {{$buyerPurchasetree->username}}</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                              </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h2>Seller</h2>
                                            <?php $seller = ($escrow->sellerMember);?>
                                            <div class="form-horizontal">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <p> Escrow - UserName:  {{$seller->username}}</p>
                                                            <p> {{$seller->userfullname}}</p>
                                                            <p> <?php echo $seller->useraddress1; if(isset($seller->useraddress2) && ($seller->useraddress2 !="")) {echo ', '.$seller->useraddress2;}?> </p>
                                                            <p>
                                                                <?php
                                                                    echo $seller->usercity .", ". $seller->userstate .", ". $seller->userzip;
                                                                ?></p>
                                                            <p> {{$sellerCountry->country_name}}</p>
                                                            <p> Purchasetree - UserName: {{$sellerPurchasetree->username}}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h2 style="color: #6161DE; margin-bottom: 20px">Dispute Content</h2>
                                </div>
                            </div>
                           <div class="row text-center" style="margin-bottom: 20px">
                                <div class="col-md-1"> No </div>
                                <div class="col-md-2"> UserName </div>
                                <div class="col-md-3"> Title </div>
                                <div class="col-md-6">Content</div>
                           </div>
                           @foreach($disputeContent as $key=>$value)
                                <div class="row text-center margin-bottom-40" style="margin-bottom: 20px">
                                        <div class="col-md-1">{{$key+1}}</div>
                                        <div class="col-md-2"> <?php if($value->escrow_user_id == 0) {echo "admin";} else{echo $value->escrowUser->username;} ?> </div>
                                        <div class="col-md-3"> {{$value->title}} </div>
                                        <div class="col-md-6"> {{$value->content}} </div>
                                   </div>
                           @endforeach
                           <div class="row">
                                <div class="col-md-12 text-center">
                                    <a class="btn blue" href="javascript:void(0)" onclick="onSendMessageShow()">Send Message</a>
                                    @if($escrow->confirm ==2)
                                       <a href="javascript:void(0)" class='btn red' onclick="onDisputeConfirm({{$escrow->id}})">Disputed</a>
                                    @else
                                        <a href="javascript:void(0)" class='btn green' onclick="onDisputeConfirm({{$escrow->id}})">Solved</a>
                                    @endif
                                    <a class="btn red" href="{{URL::route('admin.escrow.payments')}}"> Cancel</a>
                                </div>
                           </div>
                    </div>
                </div>
            </div>
         </div>
            <div class="modal fade" id="onMessageSendDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
               <div class="modal-dialog">
                    <div class="modal-content modalChangeContent">
                        <div class="modal-header modalChangeHeader">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title modalChangeTitle" id="myModalLabel">Message Send</h4>
                        </div>
                        <div class="modal-body" id="myModaltext">
                             <div class="row">
                                  <div class="col-md-12">
                                     <form action ="{{URL::route('admin.escrow.sendDisputeEmail')}} " method ="post" class="form-horizontal" id="onSendMessageModalContentDiv">
                                           <div class="form-group">
                                                <label class="col-lg-3 col-md-4 col-xs-5 control-label">
                                                    To
                                                </label>
                                               <div class="col-lg-9 col-md-8 col-xs-7 ">
                                                <select name="userType" class="form-control" id="userType">
                                                    <option value="">Select User</option>
                                                    <option value="seller">Seller</option>
                                                     <option value="buyer">Buyer</option>
                                                     <option value="both">Buyer and Seller (both)</option>
                                                </select>
                                               </div>
                                           </div>
                                            <div class="form-group">
                                                <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Message Title</label>
                                                  <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                      <input type="text" class="form-control" name="title" id="title">
                                                  </div>
                                           </div>
                                           <div class="form-group">
                                                <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Message Content</label>
                                                  <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                      <textarea name="message" class="form-control" rows="10" id="message"></textarea>
                                                  </div>
                                           </div>
                                           <input type="hidden" id="escrow_id" name="escrow_id" value="{{$escrow->id}}">
                                           <div class="form-group">
                                              <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7 col-lg-offset-3 col-md-offset-4 col-xm-offset-4 col-xs-offset-5 text-right">
                                                   <a href="javascript:void(0)" class="btn blue" onclick="onSendMessage()" id="edit">Send</a>
                                                   <div id="spin3" style="display: none"></div>
                                                    <button type="button" class="btn red"  data-dismiss="modal">Cancel</button>
                                              </div>
                                           </div>
                                     </form>
                                  </div>
                             </div>
                        </div>
                    </div>
               </div>
          </div>
    @stop
    @section('custom-scripts')
        <script type="text/javascript">
            function onSendMessageShow(){
                $("#onMessageSendDiv").modal('show');
            }
            function onSendMessage(){
                   $("#onMessageSendDiv").find("#edit").hide();
                $("#onSendMessageModalContentDiv").ajaxForm({
                    success:function(data){
                        if(data.result == "success"){
                             $("#onMessageSendDiv").modal('hide');
                            $("#onSendMessageModalContentDiv").find('#userType').val('');
                            $("#onSendMessageModalContentDiv").find('#title').val('');
                            $("#onSendMessageModalContentDiv").find('#message').val('');
                            bootbox.alert("Your message has been sent successfully");
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
                                  $("#spin3").css('display','hide');
                                $("#onMessageSendDiv").find("#edit").show();
                                 bootbox.alert(errorList);
                        }
                    }
                }).submit();
            }
            function onDisputeConfirm(id){
                var base_url = window.location.origin;
                 $.ajax ({
                    url: base_url + '/admin/escrow/payments/disputeSolve',
                    type: 'POST',
                    data: {id : id},
                    cache: false,
                    dataType : "json",
                    success: function (data) {
                        if(data.result == "success"){
                            bootbox.alert(data.content);
                            window.location.reload();
                        }
                    }
                 });
            }
        </script>
    @stop
@stop