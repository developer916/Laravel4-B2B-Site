@extends('admin.layout')
	@section('body')
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe"></i> Admin Profile Management
						</div>
					</div>
					<div class="portlet-body form">
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
						<form class="form-horizontal" role="form" method="post" action="{{ URL::route('admin.profilestore') }}" enctype="multipart/form-data" id="addClientForm">
							 <div class="form-body">
						 		<div class= "form-group">
										<label class="control-label col-md-3">Current Password</label>
										<div class="col-md-6">
											<input type="password" class="form-control" id="currentPassword"  name="currentPassword">
										</div>
									</div>
									<div class= "form-group">
										<label class="control-label col-md-3">New Password</label>
										<div class="col-md-6">
											<input type="password" class="form-control" id="newPassword"  name="newPassword">
										</div>
									</div>
									<div class= "form-group">
										<label class="control-label col-md-3">Re-type New Password</label>
										<div class="col-md-6">
											<input type="password" class="form-control" id="confirmNewPassword"  name="confirmNewPassword">
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-7 col-md-5">
											<button   class="btn  blue" type="submit" ><i class="fa fa-check-circle-o" style="margin-right:4px"></i>Save</button>
											<a class="btn  green" href="{{URL::route('admin.dashboard')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
										</div>
									</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@stop
@stop