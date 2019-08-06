@extends('admin.layout')
	@section('body')
	<h3 class="page-title">Sample RFQ  Management</h3>
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
                    <a href="{{URL::route('admin.samplerfq')}}">Sample RFQ Management</a>
                    <i class="fa fa-angle-right"></i>
                </li>
            </ul>
        </div>
	<div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Sample RFQ Management
                    </div>
                </div>
                <div class="portlet-body">
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
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th class="table-checkbox">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                </th>
                                <th>Buyer UserName</th>
                                <th>Seller UserName</th>
                                <th>Total Price</th>
                                <th>Payment Invoice</th>
                                <th>Transaction ID</th>
                                <th class= "sorting_disabled">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sampleRFQs as $key=>$sampleRFQ)
                                <tr>
                                    <td @if($sampleRFQ->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$sampleRFQ->id}}" id="chkClientID"></td>
                                    <td @if($sampleRFQ->admin_active == 0) class="classBeActive" @endif>{{$sampleRFQ->buyerMember->username}}</td>
                                    <td @if($sampleRFQ->admin_active == 0) class="classBeActive" @endif>{{$sampleRFQ->sellerMember->username}}</td>
                                    <td @if($sampleRFQ->admin_active == 0) class="classBeActive" @endif>{{round($sampleRFQ->quoteSample[0]->totalprice,1)."USD"}}</td>
                                    <td @if($sampleRFQ->admin_active == 0) class="classBeActive" @endif>{{$sampleRFQ->sampleBuyerCard[0]->invoice_number}}</td>
                                    <td @if($sampleRFQ->admin_active == 0) class="classBeActive" @endif>{{$sampleRFQ->sampleBuyerCard[0]->transaction_id}}</td>
                                    <td @if($sampleRFQ->admin_active == 0) class="classBeActive" @endif>
                                        <?php if ($sampleRFQ->status == 4){?>
                                        <form action="{{ URL::route('admin.samplerfq.approve' , $sampleRFQ->id) }}" id="formTest" onsubmit = "return onDelteConfirm(this)" style="display:inline-block">
                                            <button type="submit" class="btn btn-xs blue" id="js-a-delete" >
                                           <i class='fa fa-times-circle'></i> Approve</button>
                                        </form>
                                        <?php } else if($sampleRFQ->status == 5) {?>
                                           <a href="javascript:void(0)" class="btn btn-xs red"><i class='fa fa-times-circle'></i> Approved</a>
                                        <?php } ?>
                                        <a href="javascript:void(0)" class="btn btn-xs red" onclick="onSendMessage(<?php echo $sampleRFQ->id ?>)">
                                            <i class="icon-envelope-open"></i> Message
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal " id="myModal" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
       		<div class="modal-dialog">
       			<div class="modal-content">
       				<div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
       					<h4 class="modal-title" id="myModalLabel">Seller Information</h4>
       				</div>
       				<div class="modal-body" id="myModaltext">
                        <form class="form-horizontal" id="SendModalDiv" action="{{URL::route('admin.samplerfq.message')}}" method="post">
                            <div class="form-body" style="margin-bottom: 20px;">
                                <div class="form-group">
                                    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">
                                       To User: <span style="color: red">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <select name="usertype" class="form-control">
                                            <option value="seller">Seller</option>
                                            <option value="buyer">Buyer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">
                                       Message: <span style="color: red">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <textarea class="form-control" rows="10" name="message"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions" style="margin-bottom: 30px; text-align: right;margin-right: 10px">
                                <a href="javascript:void(0)" class="btn blue" onclick="onSendMessageToUsers()">Send</a>
                                <button type="button" class="btn default"  data-dismiss="modal">Close</button>
                            </div>
                            <input type="hidden" name="quote_id" id="QuoteID">
                        </form>
       				</div>
       			</div>
       		</div>
       	</div>
	@stop
    @section('custom-scripts')
        {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
		<script type="text/javascript">
			jQuery(document).ready(function() {
				 initTable1();
			});
			function onDelteConfirm( obj){
				bootbox.confirm("Are you sure?", function(result) {
					if ( result ) {

						obj.submit();

					}
				});

				return false;
			}
			function onSendMessage(QuoteID){
			    $("#QuoteID").val(QuoteID);
			    var a = $("<a>")
                    .attr("href", "#myModal")
                    .attr("data-toggle","modal")
                    .appendTo("body");

                    a[0].click();

                    a.remove();
			}
			function onSendMessageToUsers(){
               $("#SendModalDiv").ajaxForm({
                    success: function(data) {
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