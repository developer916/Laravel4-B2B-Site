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
                    <a href="{{URL::route('admin.members.manageSeller')}}">Manage Seller Members</a>
                    <i class="fa fa-angle-right"></i>
                </li>
            </ul>
        </div>
	<div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Manage Seller Members
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
                                <th> Name</th>
                                <th>Email</th>
                                <th class= "sorting_disabled">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $key => $value)
                              <tr>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->username }}</td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif><?php echo $value->firstname ." ". $value->lastname;?></td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif> {{ $value->email }}</td>
                                  <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                        <form action="{{ URL::route('admin.members.delete' , $value->id) }}" id="formTest" onsubmit = "return onDelteConfirm(this)" style="display:inline-block">
                                            <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                            <i class='fa fa-trash-o'></i> Delete</button>
                                        </form>
                                      <?php
                                          if($value->suspend == 1){?>
                                          <form  class="form-horizontal"  method="POST" action="{{URL::route('admin.members.suspend')}}" style="display:inline-block">
                                              <input type="hidden" name="user_id" value="{{$value->id}}">
                                              <input type="hidden" name="suspended" value="{{$value->suspend }}">
                                              <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                              <i class='fa fa-times-circle'></i> Suspend</button>
                                           </form>
                                      <?php  }else{?>
                                          <form  class="form-horizontal"  method="POST" action="{{URL::route('admin.members.suspend')}}" style="display:inline-block">
                                              <input type="hidden" name="user_id" value="{{$value->id}}">
                                              <input type="hidden" name="suspended" value="{{$value->suspend }}">
                                              <button type="submit" class="btn btn-xs blue" id="js-a-delete" >
                                              <i class='fa fa-check-circle'></i> Not Suspend</button>
                                          </form>
                                      <?php   }
                                      ?>
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
                                   <textarea  class="form-control" rows="10" placeholder="Message Content"></textarea>
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
			function onDelteConfirm( obj){
				bootbox.confirm("Are you sure?", function(result) {
					if ( result ) {
						obj.submit();
					}
				});
				return false;
			}
			function onModalSend(){

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