@extends('admin.layout')
@section('body')
    <h3 class="page-title">Shopping Cart Lists Management</h3>
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
                <a href="{{URL::route('admin.shoppingCart.payment')}}">Shopping Cart Lists Management</a>
                <i class="fa fa-angle-right"></i>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Shopping Cart List Management
                    </div>
                    <div class="actions">
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
                    <div class="tab-v2 margin-bottom-40">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#alert-1" data-toggle="tab" aria-expanded="true">New</a></li>
                            <li class=""><a href="#alert-2" data-toggle="tab" aria-expanded="false">All</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="alert-1">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th class="table-checkbox">
                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                        </th>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th>User Name</th>
                                        <th>Total Price</th>
                                        <th>Payment Type</th>
                                        <th>Items</th>
                                        <th>Status</th>
                                        <th>Paid</th>
                                        <th class= "sorting_disabled">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($news as $key =>$cart)
                                        <tr>
                                            <td><input type="checkbox" class="checkboxes" value="{{$cart->id}}" id="chkClientID"></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{substr($cart->created_at,0,10)}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{$cart->invoice_number}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{$cart->member->username}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{"$ ".$cart->total}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{$cart->type}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{count($cart->shoppingCartItems)}} </a></td>
                                            <td>
                                                <a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}">
                                                @if($cart->status ==1)
                                                    created
                                                @elseif($cart->status ==2)
                                                    Escrow
                                                @endif
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}">
                                                @if($cart->paid == 1)
                                                    Paid
                                                @else
                                                    No Paid
                                                @endif
                                                </a>
                                            </td>
                                            <td style="width:40%;">
                                                <a href="{{URL::route('admin.shoppingCart.payment.confirm', $cart->id)}}" class="btn btn-xs green">
                                                    <i class="fa  fa-inbox"></i> Paid Confirm
                                                </a>
                                                <a href="{{ URL::route('admin.shoppingCart.payment.show',$cart->id)}}"  class='btn btn-xs blue'>
                                                    <i class='fa  fa-bars'></i> Show Detail
                                                </a>
                                                <form action="{{ URL::route('admin.shoppingCart.payment.delete' , $cart->id) }}" id="formTest" onsubmit = "return onDeleteConfirm(this)" style="display:inline-block">
                                                    <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                                        <i class='fa fa-trash-o'></i> Delete</button>
                                                </form>
                                                <a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}" class="btn btn-xs blue">
                                                    <i class="fa fa-inbox"></i>  Products
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                             </div>
                            <div class="tab-pane fade" id="alert-2">
                                <table class="table table-striped table-bordered table-hover" id="sample_2">
                                    <thead>
                                    <tr>
                                        <th class="table-checkbox">
                                            <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                                        </th>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th>User Name</th>
                                        <th>Total Price</th>
                                        <th>Payment Type</th>
                                        <th>Items</th>
                                        <th>Status</th>
                                        <th>Paid</th>
                                        <th class= "sorting_disabled">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($carts as $key =>$cart)
                                        <tr>
                                            <td><input type="checkbox" class="checkboxes" value="{{$cart->id}}" id="chkClientID"></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{substr($cart->created_at,0,10)}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{$cart->invoice_number}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{$cart->member->username}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{"$ ".$cart->total}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{$cart->type}} </a></td>
                                            <td><a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}"> {{count($cart->shoppingCartItems)}} </a></td>
                                            <td>
                                                <a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}">
                                                @if($cart->status ==1)
                                                    created
                                                @elseif($cart->status ==2)
                                                    Escrow
                                                @endif
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}">
                                                @if($cart->paid == 1)
                                                    Paid
                                                @else
                                                    No Paid
                                                @endif
                                                </a>
                                            </td>
                                            <td style="width:40%;">
                                                <a href="{{URL::route('admin.shoppingCart.payment.confirm', $cart->id)}}" class="btn btn-xs green">
                                                    <i class="fa  fa-inbox"></i> Paid Confirm
                                                </a>
                                                <a href="{{ URL::route('admin.shoppingCart.payment.show',$cart->id)}}"  class='btn btn-xs blue'>
                                                    <i class='fa  fa-bars'></i> Show Detail
                                                </a>
                                                <form action="{{ URL::route('admin.shoppingCart.payment.delete' , $cart->id) }}" id="formTest" onsubmit = "return onDeleteConfirm(this)" style="display:inline-block">
                                                    <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                                        <i class='fa fa-trash-o'></i> Delete</button>
                                                </form>
                                                <a href="{{URL::route('admin.shoppingCart.payment', $cart->id)}}" class="btn btn-xs blue">
                                                    <i class="fa fa-inbox"></i>  Products
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
            </div>
        </div>
    </div>
@stop
@section('custom-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            initTable1();
            initTable2();
        });
        function onDeleteConfirm( obj){
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
