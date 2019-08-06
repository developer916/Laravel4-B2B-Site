@extends('admin.layout')
    @section('custom-styles')
        {{ HTML::style('/assets/assest_admin/css/jquery.validate.password.css') }}
    @endsection
	@section('body')
		<h3 class="page-title">Add User Management</h3>
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
						<a href="{{URL::route('admin.members')}}">Users</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="{{URL::route('admin.members.create')}}">Add User</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								Add User
							</div>
						</div>
							<div class="portlet-body form">
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
							<form  class="form-horizontal" id="signupform" method="POST" action="{{URL::route('admin.members.store')}}" enctype="multipart/form-data">

                                <div class="form-body">
                                     @foreach ([
                                        'username' => 'User Name:',
                                        'password' => 'User Password:',
                                        'password_confirmation' => 'Confirm Password:',
                                        'email' => 'Email Address:',
                                        'usertype' =>'I am:',
                                        'firstname' => 'First Name:',
                                        'lastname' => 'Last Name:',
                                        'street' => 'Address:',
                                        'city' => 'City:',
                                        'state' => 'State:',
                                        'country' => 'Country:',
                                        'zipcode' => 'Zip Code:',
                                        'phonenumber' => 'Phone Number:',
                                        'workingnumber' => 'Working Number:',
                                        'companyname' => 'Company Name:',

                                        ]
                                         as $key=> $value)
                                        @if($key === 'country')
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                      {{ Form::select($key
                                                            ,array('' => '---Select Country --- ') +  $country->lists('country_name', 'id')
                                                            , null
                                                            , array('class' => 'form-control','name'=>'country_id')) }}
                                                </div>
                                           </div>
                                        @elseif($key === 'password')
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                     <div class="input-icon right">
                                                        <i class="fa"></i>
                                                            {{ Form::password('password', array('class'=>'form-control','placeholder'=>'User Password', 'id' => 'password')) }}
                                                     </div>
                                                 </div>
                                            </div>
                                        @elseif($key === 'password_confirmation')
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        {{ Form::password($key, array('class'=>'form-control','placeholder'=>'User Password')) }}
                                                    </div>
                                                 </div>
                                            </div>
                                        @elseif(($key === 'email'))
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="input-icon right">
                                                      <i class="fa"></i>
                                                        {{ Form::email($key, null, ['class' => 'form-control','placeholder'=>$value]) }}
                                                    </div>
                                                 </div>
                                            </div>
                                        @elseif(($key === 'usertype'))
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="radio-list">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="radiouser" id="optionsRadios1" value="s" onchange="onSellerChange()" checked> Seller
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="radiouser" id="optionsRadios2" value="b" onchange="onBuyerChange()"> Buyer
                                                        </label>
                                                         <label class="radio-inline">
                                                            <input type="radio" name="radiouser" id="optionsRadios2" value="k"  onchange="onSellerChange()"> Both
                                                        </label>
                                                    </div>
                                                 </div>
                                            </div>
                                        @elseif( $key ==="username")
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                                {{ Form::label($key, $value) }}
                                                <span style="color:red">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                   <div class="input-icon right">
                                                        <i class="fa"></i>
                                                    {{ Form::text($key, null, ['class' => 'form-control','placeholder'=>$value , 'id' => 'username']) }}
                                                   </div>
                                                </div>
                                            </div>
                                         @else
                                          <div class="form-group" id="countryname">
                                             <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                                {{ Form::label($key, $value) }}
                                                <?php
                                                    if($key === "firstname" || $key === "lastname" || $key === "street" || $key === "city"|| $key === "zipcode" || $key === "phonenumber"  ){
                                                        echo  '<span style="color:red">*</span>';
                                                    }
                                                ?>
                                             </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="input-icon right">
                                                	<i class="fa"></i>
                                                  {{ Form::text($key, null, ['class' => 'form-control','placeholder'=>$value]) }}
                                                </div>
                                              </div>
                                         </div>

                                        @endif
                                      @endforeach
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-7 col-md-5">
                                            <button   class="btn  blue" type="submit" ><i class="fa fa-check-circle-o" style="margin-right:4px"></i><span id="savelist">Continue</span></button>
                                            <a class="btn  green" href="{{URL::route('admin.members')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
						</div>
					</div>
				</div>
			</div>
	@stop
	@section('custom-scripts')


	    <script>
	        function onSellerChange(){
	            $("#savelist").text('Continue');
	        }
	        function onBuyerChange(){
	            $("#savelist").text('Save');
	        }
	        $(document).ready(function() {
                var handleValidation2 = function() {

                      var form2 = $('#signupform');
                      var error2 = $('.alert-danger', form2);
                      var success2 = $('.alert-success', form2);

                      form2.validate({
                          errorElement: 'span', //default input error message container
                          errorClass: 'help-block help-block-error', // default input error message class
                          focusInvalid: false, // do not focus the last invalid input
                          ignore: "",  // validate all fields including form hidden input
                          rules: {
                              username: {
                                  minlength: 2,
                                  required: true
                              },
                              password: {
                                  required: true
                              },
                              userconfirmpassword: {
                                    required: true,
                                    equalTo:"#password"
                                },
                              email: {
                                  required: true,
                                  email: true
                              },
                              firstname: {
                                  required: true
                              },
                              lastname: {
                                  required: true
                              },
                              street: {
                                  required: true
                              },
                               zipcode: {
                                  required: true
                               },
                               phonenumber: {
                                    required: true
                               },
                               street: {
                                    required: true
                               },
                               street: {
                                    required: true
                               },
                              country_id: {
                                  required: true
                              }
                          },

                          invalidHandler: function (event, validator) { //display error alert on form submit
                              success2.hide();
                              error2.show();
                              Metronic.scrollTo(error2, -200);
                          },

                          errorPlacement: function (error, element) { // render error placement for each input type
                              var icon = $(element).parent('.input-icon').children('i');
                              icon.removeClass('fa-check').addClass("fa-warning");
                              icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                          },

                          highlight: function (element) { // hightlight error inputs
                              $(element)
                                  .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
                          },

                          unhighlight: function (element) { // revert the change done by hightlight

                          },

                          success: function (label, element) {
                              var icon = $(element).parent('.input-icon').children('i');
                              $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                              icon.removeClass("fa-warning").addClass("fa-check");
                          },

                          submitHandler: function (form) {
                              success2.show();
                              error2.hide();
                              form[0].submit(); // submit the form
                          }
                      });
                  }
              handleValidation2();
	        });

	    </script>
	@stop
@stop
