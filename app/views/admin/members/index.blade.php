@extends('admin.layout')
	@section('body')
	<h3 class="page-title">Users Management</h3>
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
                    <a href="{{URL::route('admin.members')}}">Users Management</a>
                    <i class="fa fa-angle-right"></i>
                </li>
            </ul>
        </div>
	<div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Users Management
                    </div>
                    <div class="actions">
                        <a id="sample_editable_1_new" class="btn btn-default btn-sm" href='{{ URL::route('admin.members.create')}}' style="margin-right:10px">
                                Add New <i class="fa fa-plus"></i>
                        </a>
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
                                         <a class="btn btn-xs green" data-toggle="modal" href="javascript:void(0)" onclick="onShowModal(<?php echo $value->id; ?>)">
                                             <i class='fa fa-bars'></i> View
                                         </a>
                                        <a href="{{ URL::route('admin.members.edit',$value->id)}}"  class='btn btn-xs blue'>
                                            <i class='fa fa-edit'></i>Edit
                                        </a>
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
    @include('admin.members.indexModal')
	@stop
    @section('custom-scripts')
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
		</script>
	@stop
@stop