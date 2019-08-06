@extends('admin.layout')
    @section('custom-scripts')
        <style>
            .radio{
                padding-top: 0px!important;
            }
        </style>
    @endsection
	@section('body')
        <?php use Admin as AdminModel;?>
		<div class= "row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-body">
							
							<div class="alert alert-success">
								<span class="caption-subject bold fontSize25" >
									Welcome
								</span>
								<br>
								<strong>Success!</strong> You can use admin panel for your action.
							</div>
					</div>
				</div>
			</div>
		</div>
        <div class= "row">
            <div class="col-md-12">
                <div class="portlet light">
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
                       <a href="{{URL::route('admin.dashboard.dump')}}">Create Database Backup</a>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
            <!-- Quick Search-->
		    <div class="col-md-4 col-sm-4 col-xs-12">
		        <div class="portlet light ">
		            <div class="portlet-title">
                         <div class="caption">
                            <i class="icon-share font-blue-steel hide"></i>
                            <span class="caption-subject font-blue-steel bold uppercase">Quick Search</span>
                        </div>
		            </div>
		            <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{URL::route('admin.dashboard.searchResult')}}" method="POST" class="form-horizontal">
                                    @foreach([
                                        'search' =>'Search Keyword',
                                        'show' => "Show",
                                        'search_in' =>"Search In",
                                        'category' =>"Category",

                                    ]as $key =>$value)
                                        <div class="form-group">
                                            <label class="col-md-4 col-sm-4 col-xs-12">
                                                {{$value}}
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                @if($key ==='search')
                                                    <input type="text" class="form-control" placeholder="{{$value}}" name="{{$key}}">
                                                @elseif($key === 'show')
                                                    <input type="radio" name="{{$key}}" value = '1' checked style="margin-left:0px; padding-top:0px"><span>All</span>  <br>
                                                @elseif($key ==='search_in')
                                                    <select name="{{$key}}" class="form-control">
                                                        <option value = "rfq">RFQ</option>
                                                        <option value = "quote">Quote</option>
                                                        <option value = "invoice">Invoice</option>
                                                        <option value = "product">Product</option>
                                                        <option value = "company">Company Profile</option>
                                                    </select>
                                                 @else
                                                    <select name="{{$key}}" class="form-control">
                                                        <option value =""> All Categories</option>
                                                        @foreach($categories as $key_category =>$value_category)
                                                            <option value="{{$value_category->id}}">{{$value_category->categoryname}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group " style="margin-bottom: 40px">
                                        <div class="col-md-offset-4 col-sm-offset-4 col-md-8 col-sm-8">
                                            <button class="btn blue" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
		            </div>
		        </div>
		    </div>
            <!-- Site Statistics-->
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-blue-steel hide"></i>
                            <span class="caption-subject font-blue-steel bold uppercase">Site Statistics</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Total Escrow
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" class="form-control" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Fedex
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" class="form-control" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Cargo
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" class="form-control" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Total Members
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <span class="form-control">{{count($countTotalMember)}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Total Sellers
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <span class="form-control">{{count($countSellerMember)}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Total Buyers
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <span class="form-control">{{count($countBuyerMember)}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Total Categories
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <span class="form-control">{{($countTotalCategory)}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Total Rfqs
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <span class="form-control">{{(count($Rfq))}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label">
                                            Total Rfqs
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <span class="form-control">{{($totalContracts)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-blue-steel hide"></i>
                            <span class="caption-subject font-blue-steel bold uppercase">Recent Statistics </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table  table-striped">
                                <thead>
                                    <tr>
                                        <th>Posted\Type</th>
                                        <th>Signups</th>
                                        <th>Pending Sellers</th>
                                        <th>New Product Listing</th>
                                        <th>New RFQ</th>
                                        <th>New Contract</th>
                                        <th>Store Purchases</th>
                                        <th>Awarding Freight Quote</th>
                                        <th>New ShoppingCart</th>
                                        <th>New Escrow</th>
                                        <th>Disputes</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 0; $i<4; $i++)
                                        <?php
                                            if($i ==0 ){$first = 0;}
                                            elseif($i == 1) {$first = 1;}
                                            elseif($i == 2) {$first = 7;}
                                            elseif($i == 3) {$first = 30;}
                                        ?>

                                    <tr>
                                        <td>@if($i ==0) Today @elseif($i == 1) Yesterday @elseif($i==2) 7 Days @elseif($i == 3) 30 Days @endif</td>
                                        <td><?php $accountMember =AdminModel::getSignUp($first);  ?> <a href ="{{URL::route('admin.members')}}" target="_blank">{{$accountMember}} </a></td>
                                        <td><?php $accountMember =AdminModel::getPending($first);  ?> <a href ="{{URL::route('admin.members.sellerconfirm')}}" target="_blank">{{$accountMember}} </a></td>
                                        <td><?php $accountMember =AdminModel::getNewProduct($first);  ?> <a href ="{{URL::route('admin.post')}}" target="_blank">{{$accountMember}} </a></td>
                                        <td><?php $accountMember =AdminModel::getNewRfq($first);   ?> <a href ="{{URL::route('admin.rfq')}}" target="_blank">{{$accountMember}} </a></td>
                                        <td><?php $accountMember =AdminModel::getContract($first);  echo $accountMember; ?> </td>
                                        <td></td>
                                        <td></td>
                                        <td><?php $accountMember = AdminModel::getNewShoppingCart($first); ?> <a href ="{{URL::route('admin.shoppingCart.payment')}}" target="_blank">{{$accountMember}} </a></td></td>
                                        <td><?php $accountMember = AdminModel::getNewEscrow($first); ?> <a href ="{{URL::route('admin.escrow.payments')}}" target="_blank">{{$accountMember}} </a></td>
                                        <td><?php $accountMember = AdminModel::getDisputeEscrow($first); ?> <a href ="{{URL::route('admin.escrow.payments')}}" target="_blank">{{$accountMember}} </a></td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	@stop
	
@stop