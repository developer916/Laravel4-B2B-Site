@extends('main')
	@section('title')
		ADMIN|HOME
	@stop
	
	@section('styles')
		{{HTML::style('//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}}
		{{ HTML::style('/assets/assest_admin/css/font-awesome.min.css') }}
        {{ HTML::style('/assets/assest_admin/css/simple-line-icons.css') }}
		{{ HTML::style('/assets/assest_admin/css/simple-line-icons.min.css') }}
		{{ HTML::style('/assets/assest_admin/css/bootstrap.min.css') }}
		{{ HTML::style('/assets/assest_admin/css/uniform.default.css') }}
		{{ HTML::style('/assets/assest_admin/css/bootstrap-switch.min.css') }}
		{{ HTML::style('/assets/assest_admin/css/bootstrap-wysihtml5.css') }}
		{{ HTML::style('/assets/assest_admin/css/jquery.fancybox.css') }}
		{{ HTML::style('/assets/assest_admin/css/jquery.fileupload.css') }}
		{{ HTML::style('/assets/assest_admin/css/jquery.fileupload-ui.css') }}
		{{ HTML::style('/assets/assest_admin/css/blueimp-gallery.min.css') }}
		{{ HTML::style('/assets/assest_admin/css/inbox.css') }}
		{{ HTML::style('/assets/assest_admin/css/daterangepicker-bs3.css') }}
		{{ HTML::style('/assets/assest_admin/css/fullcalendar.min.css') }}
		{{ HTML::style('/assets/assest_admin/css/jqvmap.css') }}
		{{ HTML::style('/assets/assest_admin/css/tasks.css') }}
		{{ HTML::style('/assets/assest_admin/css/forestChange.css') }}
		{{ HTML::style('/assets/assest_admin/css/select2.css') }}
		{{ HTML::style('/assets/assest_admin/css/components.css') }}
		{{ HTML::style('/assets/assest_admin/css/plugins.css') }}
		{{ HTML::style('/assets/assest_admin/css/layout.css') }}
		{{ HTML::style('/assets/assest_admin/css/default.css') }}
		{{ HTML::style('/assets/assest_admin/css/custom.css') }}
		{{ HTML::style('/assets/assest_admin/css/dataTables.bootstrap.css') }}
		{{ HTML::style('/assets/assest_admin/css/forestChange.css') }}

	@stop		
	@section('content')
<body class="page-boxed page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo">
<!------------------------------------------- Header start  ---------------------------->
	<div class="page-header navbar navbar-fixed-top">
		<!-- BEGIN HEADER INNER -->
		<div class="page-header-inner">
			<!-- BEGIN PAGE TOP -->
			
				<div class = " page-logo" >
					<a href="overview.php" style="width:100%;" >
						<img src="/assets/assest_admin/img/75163ae50abec_Logo-01.jpg" alt="logo" class="logo-default" style="width:100%!important; margin:0px; height: 68px">
					</a>
					
				</div>
					<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
					</a>
			
			<div class="page-top">
				<!-- BEGIN HEADER SEARCH BOX -->
			
				<!-- BEGIN TOP NAVIGATION MENU -->
				<div class="top-menu">
					<ul class="nav navbar-nav pull-right">
						<!-- BEGIN NOTIFICATION DROPDOWN -->
						
						<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
						<li class="dropdown dropdown-user">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<img alt="" class="img-circle" src="/assets/assest_admin/img/User_Avatar-512.png"/>
								
							<span class="username username-hide-on-mobile loginTopColor">
								Account
							 </span>
							<i class="fa fa-angle-down loginTopColor"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-default loginTopColor">
								<li>
									<a href="{{URL::route('admin.profile')}}" class="loginTopColor">
									<i class="icon-user"></i> My Profile </a>
								</li>
								
								<li>
									<a href="{{URL::route('admin.auth.logout')}}" class="loginTopColor">
									<i class="icon-key"></i> Log Out </a>
								</li>
							</ul>
						</li>
						<!-- END USER LOGIN DROPDOWN -->
					</ul>
				</div>
				<!-- END TOP NAVIGATION MENU -->
			</div>
			<!-- END PAGE TOP -->
		</div>
		<!-- END HEADER INNER -->
	</div>
<!------------------------------------------- Header end  ---------------------------->
	<div class="clearfix"></div>
	<div class="page-container">
		<div class="page-sidebar-wrapper">
			<div class="page-sidebar navbar-collapse collapse">
                <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    <li class="start <?php if($pageNo == 1) {echo ' active';}?>">
                        <a href="{{ URL::route('admin.dashboard') }}">
                        <i class="fa fa-tachometer"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                        </a>
                    </li>
                   <li class="start <?php if($pageNo == 11 || $pageNo == 12 || $pageNo == 13 || $pageNo == 14 || $pageNo == 15 || $pageNo == 16 || $pageNo == 17 || $pageNo == 18 || $pageNo == 19) {echo ' active';}?>">
                        <a href="javascript:;">
                        <i class="icon-basket"></i>
                        <span class="title">Configuration</span>
                        <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="<?php if($pageNo ==11){echo 'active';}?>">
                                <a href="{{ URL::route('admin.country') }}">
                                <i class="icon-home"></i>
                                Country Management</a>
                            </li>
                            <li class="<?php if($pageNo ==12){echo 'active';}?>">
                                <a href="{{ URL::route('admin.factorysize') }}">
                                <i class="icon-basket"></i>
                                Factory Size </a>
                            </li>
                            <li class="<?php if($pageNo ==13){echo 'active';}?>">
                                <a href="{{ URL::route('admin.business') }}">
                                <i class="icon-tag"></i>
                                Business Type</a>
                            </li>
                            <li class="<?php if($pageNo ==14){echo 'active';}?>">
                                <a href="{{ URL:: route('admin.product') }}">
                                <i class="icon-handbag"></i>
                                Product Focus</a>
                            </li>
                            <li class="<?php if($pageNo ==15){echo 'active';}?>">
                                <a href="{{ URL:: route('admin.currency') }}">
                                <i class="fa fa-money"></i>
                                Currencies</a>
                            </li>
                            <li class="<?php if($pageNo == 16) {echo 'active';} ?>">
                                <a href="{{URL::route('admin.unit')}}">
                                    <i class="fa fa-building-o"></i>
                                    Unit
                                </a>
                            </li>
                            <li class="<?php if($pageNo == 17) {echo 'active';} ?>">
                                <a href="{{URL::route('admin.fee')}}">
                                    <i class="fa fa-usd"></i>
                                    Payment Fee
                                </a>
                            </li>
                            <li class="<?php if($pageNo == 18) {echo 'active';} ?>">
                                <a href="{{URL::route('admin.freight')}}">
                                    <i class="fa  fa-bars"></i>
                                    Freight Code
                                </a>
                            </li>
                            <li class="<?php if($pageNo == 19) {echo 'active';} ?>">
                                <a href="{{URL::route('admin.terms_conditions')}}">
                                    <i class="fa fa-list"></i>
                                    Terms and Conditions
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="start <?php if($pageNo == 21 || $pageNo == 22 ) {echo ' active';}?>">
                        <a href="javascript:;">
                       <i class="fa fa-pencil"></i>
                        <span class="title">Category Management</span>
                        <span class="arrow "></span>
                        </a>
                         <ul class="sub-menu">
                            <li class="<?php if($pageNo ==21){echo 'active';}?>">
                                <a href="{{ URL::route('admin.category') }}">
                                <i class="icon-home"></i>
                                Category Manage</a>
                            </li>
                            <li class="<?php if($pageNo ==22){echo 'active';}?>">
                                <a href="{{ URL::route('admin.subcategory') }}">
                                <i class="fa fa-list"></i>
                                SubCategory Manage</a>
                            </li>
                         </ul>
                    </li>
                    <li class="start <?php if($pageNo == 31 || $pageNo == 32 || $pageNo == 33) {echo ' active';}?>">
                        <a href="javascript:;">
                       <i class="fa fa-users"></i>
                        <span class="title">User Management</span>
                        <span class="arrow "></span>
                        </a>
                         <ul class="sub-menu">
                            <li class="<?php if($pageNo ==31){echo 'active';}?>">
                                <a href="{{ URL::route('admin.members') }}">
                                <i class="fa fa-user"></i>
                                  Manage Members</a>
                            </li>
                            <li class="<?php if($pageNo ==32){echo 'active';}?>">
                                <a href="{{ URL::route('admin.members.sellerconfirm') }}">
                                <i class="icon-handbag"></i>
                                 Seller Confirm</a>
                            </li>
                            <li class="<?php if($pageNo ==33){echo 'active';}?>">
                                <a href="{{ URL::route('admin.members.manageSeller') }}">
                                <i class="icon-basket"></i>
                                 Manage Seller</a>
                            </li>
                            <li class="<?php if($pageNo ==34){echo 'active';}?>">
                                <a href="{{ URL::route('admin.members.messageManagement') }}">
                                <i class="fa fa-comment"></i>
                                 Message Management</a>
                            </li>
                         </ul>
                    </li>
                   <li class="start <?php if($pageNo == 41 || $pageNo == 42 || $pageNo == 43) {echo ' active';}?>">
                        <a href="javascript:;">
                       <i class="fa fa-list"></i>
                        <span class="title">Listings</span>
                        <span class="arrow "></span>
                        </a>
                         <ul class="sub-menu">
                            <li class="<?php if($pageNo ==41){echo 'active';}?>">
                                <a href="{{ URL::route('admin.rfq') }}">
                                <i class="fa fa-recycle"></i>
                                  Manage RFQ</a>
                            </li>
                            <li class="<?php if($pageNo ==42){echo 'active';}?>">
                                <a href="{{ URL::route('admin.post') }}">
                                <i class="fa  fa-tasks"></i>
                                  Manage Product</a>
                            </li>
                             <li class="<?php if($pageNo == 44){echo 'active';}?>">
                                 <a href="{{ URL::route('admin.quick') }}">
                                     <i class="fa   fa-question"></i>
                                     Quick Details</a>
                             </li>
                            <li class="<?php if($pageNo ==43){echo 'active';}?>">
                                <a href="{{ URL::route('admin.samplerfq') }}">
                                <i class="fa fa-check"></i>
                                  RFQ Sample Payment</a>
                            </li>

                         </ul>
                    </li>
                   <li class="start <?php if($pageNo == 51) {echo 'active';}?>">
                        <a href="{{URL::route('admin.email')}}">
                            <i class="icon-envelope-open"></i>
                            <span class="title">Email Templates</span>
                         </a>
                    </li>
                   <li class="start <?php if($pageNo == 61 || $pageNo == 62) {echo 'active';}?>">
                      <a href="javascript:;">
                         <i class="fa fa-file-o"></i>
                        <span class="title">Help Management</span>
                        <span class="arrow "></span>
                      </a>
                      <ul class="sub-menu">
                         <li class="<?php if($pageNo ==61){echo 'active';}?>">
                            <a href="{{ URL::route('admin.helpCategory') }}">
                            <i class="fa icon-home"></i>
                             Help Category</a>
                        </li>
                        <li class="<?php if($pageNo ==62){echo 'active';}?>">
                            <a href="{{ URL::route('admin.helpSubCategory') }}">
                            <i class="fa fa-list"></i>
                             Help SubCategory</a>
                        </li>
                         <li class="<?php if($pageNo ==63){echo 'active';}?>">
                            <a href="{{ URL::route('admin.helpCreating') }}">
                            <i class="fa  fa-reorder"></i>
                             Create Help</a>
                        </li>
                      </ul>
                   </li>
                   <li class="start <?php if($pageNo == 71 || $pageNo == 72 || $pageNo == 73|| $pageNo == 74|| $pageNo == 75 || $pageNo == 76 || $pageNo == 77) {echo 'active';}?>">
                       <a href="javascript:;">
                          <i class="fa fa-money"></i>
                         <span class="title">Escrow Management</span>
                         <span class="arrow "></span>
                       </a>
                     <ul class="sub-menu">
                        <li class="<?php if($pageNo ==71){echo 'active';}?>">
                            <a href="{{ URL::route('admin.escrow.commission') }}">
                            <i class="fa icon-home"></i>
                             Commission</a>
                        </li>
                        <li class="<?php if($pageNo ==72){echo 'active';}?>">
                            <a href="{{ URL::route('admin.escrow.users') }}">
                            <i class="fa fa-users"></i>
                             Escrow Users</a>
                        </li>
                         <li class="<?php if($pageNo ==73){echo 'active';}?>">
                            <a href="{{ URL::route('admin.escrow.pages') }}">
                            <i class="fa  fa-tasks"></i>
                             Escrow Pages</a>
                        </li>
                        <li class="<?php if($pageNo ==75){echo 'active';}?>">
                             <a href="{{ URL::route('admin.escrow.electronic') }}">
                             <i class="fa fa-building"></i>
                             Electronic Setting</a>
                        </li>
                        <li class="<?php if($pageNo ==76){echo 'active';}?>">
                             <a href="{{ URL::route('admin.escrow.email') }}">
                             <i class="icon-envelope-open"></i>
                             Email Setting</a>
                        </li>
                        <li class="<?php if($pageNo ==74){echo 'active';}?>">
                             <a href="{{ URL::route('admin.escrow.payments') }}">
                             <i class="fa fa-usd"></i>
                             Escrow Payments</a>
                        </li>
                     </ul>
                   </li>
                   <li class="start <?php if($pageNo == 81 || $pageNo == 82 || $pageNo == 83) {echo 'active';}?>">
                      <a href="javascript:;">
                         <i class="fa fa-home"></i>
                        <span class="title">Home Management</span>
                        <span class="arrow "></span>
                      </a>
                      <ul class="sub-menu">
                         <li class="<?php if($pageNo ==81){echo 'active';}?>">
                            <a href="{{ URL::route('admin.home.bargain') }}">
                            <i class="fa icon-home"></i>
                             Bargain</a>
                         </li>
                      </ul>
                   </li>
                    <li class="start <?php if($pageNo == 91 || $pageNo == 92 || $pageNo == 93 || $pageNo == 94) {echo 'active';}?>">
                        <a href="javascript:;">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="title">Shopping Cart</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="<?php if($pageNo ==91){echo 'active';}?>">
                                <a href="{{ URL::route('admin.shoppingCart.description') }}">
                                    <i class="fa icon-home"></i>
                                    FAQ
                                </a>
                            </li>
                            <li class="<?php if($pageNo ==93){echo 'active';}?>">
                                <a href="{{ URL::route('admin.shoppingCart.conditions') }}">
                                    <i class="fa  fa-bars"></i>
                                    Conditions
                                </a>
                            </li>
                            <li class="<?php if($pageNo ==94){echo 'active';}?>">
                                <a href="{{ URL::route('admin.shoppingCart.privacy') }}">
                                    <i class="fa  fa-building-o"></i>
                                    Privacy
                                </a>
                            </li>
                            <li class="@if($pageNo == 92) active @endif">
                                <a href="{{URL::route('admin.shoppingCart.payment')}}">
                                    <i class="fa fa-money"></i>
                                    Payment
                                </a>
                            </li>
                        </ul>
                    </li>
                   <li>
                        &nbsp;
                   </li>
                </ul>
			</div>
		</div>
		<div class = "page-content-wrapper min-height-1000">
			<div class="page-content min-height-1000">
				@yield('body')
			</div>
		</div>
	</div>
<!------------------------------------------- body start  ---------------------------->
	
</body>
	@stop
	@section ('scripts')
 		 {{ HTML::script('/assets/assest_admin/js/jquery.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery-migrate.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery-ui-1.10.3.custom.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/bootstrap-hover-dropdown.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/bootstrap.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.slimscroll.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.blockui.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.uniform.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/bootstrap-switch.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.pulsate.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/moment.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/daterangepicker.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.easypiechart.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.sparkline.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.validate.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.backstretch.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/select2.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/metronic.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/layout.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/layout2/layout.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/layout2/demo.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/index.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/tasks.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.dataTables.min.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/dataTables.bootstrap.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/professions.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/bootbox.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
 		 {{ HTML::script('/assets/assest_admin/js/tinymce/js/tinymce/tinymce.min.js') }}

	 		<script type="text/javascript">
		 		jQuery(document).ready(function() {    
				   Metronic.init(); // init metronic core componets
				   Layout.init(); // init layout
				   Demo.init(); // init demo features 
				});
		 	</script>
 	@stop
 	
@stop