@extends('admin.layout')
    @section('custom-styles')
        {{--{{ HTML::style('/assets/assest_admin/css/bootstrap-modal-bs3patch.css') }}--}}
        {{--{{ HTML::style('/assets/assest_admin/css/bootstrap-modal.css') }}--}}
    @endsection
	@section('body')
	<h3 class="page-title">Seller Confirm Management</h3>
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
                    <a href="{{URL::route('admin.members.sellerconfirm')}}">Seller Confirm Management</a>
                    <i class="fa fa-angle-right"></i>
                </li>
            </ul>
        </div>
	<div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Seller Confirm Management
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
                                <th>User Name</th>
                                <th>User Type</th>
                                <th> Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class= "sorting_disabled">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $key => $value)
                              <tr>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->username }}</td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif><?php if($value->usertype == "1") {echo "Seller";}elseif($value->usertype == "2") {echo "Buyer";} else{echo "Both";}?></td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif><?php echo $value->firstname ." ". $value->lastname;?></td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->email }}</td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                        <form  class="form-horizontal"  method="POST" action="{{URL::route('admin.members.status')}}">
                                            <input type="hidden" name="user_id" value="{{$value->id}}">
                                            <input type="hidden" name="status" value ="<?php if($value->status == 0){echo "InActive";}
                                                    else if($value->status == 1){echo "Active";}?>">
                                        <?php
                                            if($value->status == 0){
                                                echo '<button type="submit"><i class="fa fa-times-circle fontSize16" style="color:red;font-size:16px;"></i></button>';
                                            }else if($value->status==1){
                                                echo '<button type="submit"><i class="fa fa-check-circle fontSize16" style="color:#35aa47;font-size:16px;"></i></button>';
                                            }
                                        ?>
                                        </form>
                                   </td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                       <a class="btn btn-xs blue" data-toggle="modal" href="javascript:void(0)" onclick="onShowModal(<?php echo $value->id; ?>)">
                                            <i class='fa fa-bars'></i> View
                                        </a>
                                         <form action="{{ URL::route('admin.members.confirmSeller' , $value->id) }}" id="formTest" onsubmit = "return onSellerBootboxConfirm(this)" style="display:inline-block">
                                            <button type="submit" class="btn btn-xs green" id="js-a-delete" >
                                            <i class='fa  fa-meh-o'></i> Confirm</button>
                                        </form>
                                         <a class="btn btn-xs  purple" data-toggle="modal" href="javascript:void(0)" onclick="onSendMessageModal(<?php echo $value->id; ?>)">
                                            <i class='fa fa-comment'></i> Send Message</button>
                                        </a>
                                         <form action="{{ URL::route('admin.members.reject' , $value->id) }}" id="formTest" onsubmit = "return onDelteConfirm(this)" style="display:inline-block" method="post">
                                            <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                            <i class='fa  fa-mail-reply'></i> Reject</button>
                                         </form>
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

				</div>
				<div class="modal-footer">
				    <button type="button" class="btn blue" onclick="onChangeConfirm()">Confirm</button>
                    <button type="button" class="btn default"  data-dismiss="modal">Close</button>
                </div>
			</div>
		</div>
	</div>
	<div class="modal" id="sendMessage" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="sendMessageLabel">Send Message</h4>
                </div>
                <div class="modal-body" id="sendMessagetext">
                    <input type="hidden" name="userMessageID" value="" id="userMessageID">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                               <div class="col-md-12 col-sm-12 col-xs-12 ">
                                   <textarea  class="form-control" rows="10" placeholder="Message Content" id="messageContent"></textarea>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn blue" onclick="onModalSend()">Send</button>
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
	</div>
	@stop
    @section('custom-scripts')
        {{--{{ HTML::script('/assets/assest_admin/js/bootstrap-modalmanager.js') }}--}}
        {{--{{ HTML::script('/assets/assest_admin/js/bootstrap-modal.js') }}--}}
		<script type="text/javascript">
			jQuery(document).ready(function() {
				 initTable1();
			});
            function onSellerBootboxConfirm(obj){
                bootbox.confirm("Could you confirm it?", function(result) {
                    if ( result ) {
                        obj.submit();
                    }
                });
                return false;
            }
			function onDelteConfirm( obj){
				bootbox.confirm("Are you sure?", function(result) {
					if ( result ) {
						obj.submit();
					}
				});
				return false;
			}
			function onModalSend(){
			    $("#sendMessage").hide();
                var userMessageID = $("#userMessageID").val();
                var base_url = window.location.origin;
                var messageContent = $("#messageContent").val();
                if(messageContent == "") {
                    bootbox.confirm("Please insert message content.", function(result) {
                        if ( result ) {
                            window.location.reload();
                        }
                    });
                   return;
                }
                 $.ajax ({
                    url: base_url + '/admin/members/sendMessage',
                    type: 'POST',
                    data: {userMessageID: userMessageID, messageContent:messageContent},
                    cache: false,
                    dataType : "json",
                    success: function (data) {
                        if(data.result == "success"){
                           bootbox.alert("Message send successfully");
                           window.location.reload();
                        }
                    }
               });

			}
			function onSendMessageModal(id){
                $("#sendMessagetext").find("#userMessageID").eq(0).val(id);
			    var a = $("<a>")
                    .attr("href", "#sendMessage")
                    .attr("data-toggle","modal")
                    .appendTo("body");

                    a[0].click();

                    a.remove();
			}
			function onShowModal(id){
			    var base_url = window.location.origin;
                   $.ajax ({
                        url: base_url + '/admin/members/viewSeller',
                        type: 'POST',
                        data: {id: id},
                        cache: false,
                        dataType : "json",
                        success: function (data) {
                            if(data.result == "success"){
                                $("#myModaltext").html(data.list);
                                var a = $("<a>")
                                    .attr("href", "#myModal")
                                    .attr("data-toggle","modal")
                                    .appendTo("body");

                                	a[0].click();

                                	a.remove();
                            }
                        }
                   });
			    }
			    function onChangeConfirm(){
                    var userID = $("#myModaltext").find('#userID').val();
                    var base_url = window.location.origin;
                          $.ajax ({
                               url: base_url + '/admin/members/confirmSellerAjax',
                               type: 'POST',
                               data: {userID: userID},
                               cache: false,
                               dataType : "json",
                               success: function (data) {
                                   if(data.result == "success"){
                                        $("#myModal").hide();
                                       bootbox.alert("Seller Confirm successfully!");
                                       window.location.reload();
                                   }
                               }
                          });
			    }
		</script>
	@stop
@stop