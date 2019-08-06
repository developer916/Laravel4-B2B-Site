@extends('admin.layout')
    @section('body')
    	<h3 class="page-title">Escrow Management</h3>
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
                </ul>
            </div>
            <div class="portlet-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#all" data-toggle="tab">All Escrows</a></li>
                    <li><a href="#pending" data-toggle="tab">Pending Escrows</a></li>
                    <li><a href="#escrow" data-toggle="tab">Progress Escrows</a></li>
                    <li><a href="#cancel" data-toggle="tab">Cancel Escrows</a></li>
                    <li><a href="#approved" data-toggle="tab">Approved Escrows</a></li>
                    <li><a href="#dispute" data-toggle="tab">Dispute Escrows</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="all">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-globe"></i> Escrow  Management
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <?php if (isset($alert)) { ?>
                                            <div class="alert alert-<?php echo $alert['type'];?> alert-dismissibl fade in">
                                                <button type="button" class="close" data-dismiss="alert">
                                                    <span aria-hiddenS="true">&times;</span>
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
                                                    <th>Escrow ID</th>
                                                    <th>Invoice Number</th>
                                                    <th>Item</th>
                                                    <th>Type</th>
                                                    <th>Price</th>
                                                    <th>Paid Price</th>
                                                    <th>Status</th>
                                                    <th class= "sorting_disabled">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allPayment as $key => $value)
                                                    <tr>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->escrow_id }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->invoice_number }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->item}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                <?php
                                                                    if($value->type == "credit") {
                                                                        echo "Credit Card";
                                                                    }else if($value->type == "wire"){
                                                                        echo "Wire Transfer";
                                                                    }else if($value->type == ""){
                                                                        echo "Electronic Check";
                                                                    }
                                                                ?>
                                                           </td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->price."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->total."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                @if($value->status == 1)
                                                                    Pending
                                                                @elseif($value->status == 2)
                                                                    Escrow
                                                                @elseif($value->status == 3)
                                                                    Dispute
                                                                @elseif($value->status == 4)
                                                                    Cancel
                                                                @elseif($value->status == 5)
                                                                    Approved
                                                                @endif
                                                           </td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                @if($value->confirm ==0)
                                                                    <a href="javascript:void(0)" class='btn btn-xs blue' onclick="onSubmitConfirm({{$value->id}})">Confirm</a>
                                                                @else
                                                                    <a href="javascript:void(0)" class='btn btn-xs blue' onclick="onSubmitConfirm({{$value->id}})">No Confirm</a>
                                                                @endif

                                                                <a href="javascript:void(0)" class="btn btn-xs green" onclick="OnEditPrice({{$value->id}})">Edit</a>
                                                                <a href="javascript:void(0)" class="btn btn-xs red"   onclick="onSendMessageModal({{$value->id}})">Send Message</a>
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
                    <div class="tab-pane fade" id="pending">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-globe"></i> Pending  Escrow  Management
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
                                                    <th>Escrow ID</th>
                                                    <th>Invoice Number</th>
                                                    <th>Item</th>
                                                    <th>Type</th>
                                                    <th>Price</th>
                                                    <th>Paid Price</th>
                                                    <th class= "sorting_disabled">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($waitingPayment as $key => $value)
                                                    <tr>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->escrow_id }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->invoice_number }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->item}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                               <?php
                                                                   if($value->type == "credit") {
                                                                       echo "Credit Card";
                                                                   }else if($value->type == "wire"){
                                                                       echo "Wire Transfer";
                                                                   }else if($value->type == ""){
                                                                       echo "Electronic Check";
                                                                   }
                                                               ?>
                                                          </td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->price."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->total."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                @if($value->confirm ==0)
                                                                    <a href="javascript:void(0)" class='btn btn-xs blue' onclick="onSubmitConfirm({{$value->id}})">Confirm</a>
                                                                @else
                                                                    <a href="javascript:void(0)" class='btn btn-xs blue' onclick="onSubmitConfirm({{$value->id}})">No Confirm</a>
                                                                @endif
                                                                <a href="javascript:void(0)" class="btn btn-xs green" onclick="OnEditPrice({{$value->id}})">Edit</a>
                                                                <a href="javascript:void(0)" class="btn btn-xs red"   onclick="onSendMessageModal({{$value->id}})">Send Message</a>
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
                    <div class="tab-pane fade" id="escrow">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-globe"></i> Progress Escrow  Management
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
                                                    <th>Escrow ID</th>
                                                    <th>Invoice Number</th>
                                                    <th>Item</th>
                                                    <th>Type</th>
                                                    <th>Price</th>
                                                    <th>Paid Price</th>
                                                    <th class= "sorting_disabled">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($escrowPayment as $key => $value)
                                                    <tr>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->escrow_id }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->invoice_number }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->item}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                              <?php
                                                                  if($value->type == "credit") {
                                                                      echo "Credit Card";
                                                                  }else if($value->type == "wire"){
                                                                      echo "Wire Transfer";
                                                                  }else if($value->type == ""){
                                                                      echo "Electronic Check";
                                                                  }
                                                              ?>
                                                         </td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->price."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->total."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                @if($value->confirm ==0)
                                                                    <a href="javascript:void(0)" class='btn btn-xs blue' onclick="onSubmitConfirm({{$value->id}})">Confirm</a>
                                                                @else
                                                                    <a href="javascript:void(0)" class='btn btn-xs blue' onclick="onSubmitConfirm({{$value->id}})">No Confirm</a>
                                                                @endif
                                                               <a href="javascript:void(0)" class="btn btn-xs green" onclick="OnEditPrice({{$value->id}})">Edit</a>
                                                               <a href="javascript:void(0)" class="btn btn-xs red"   onclick="onSendMessageModal({{$value->id}})">Send Message</a>
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
                    <div class="tab-pane fade" id="cancel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-globe"></i> Cancel Escrow  Management
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
                                                    <th>Escrow ID</th>
                                                    <th>Invoice Number</th>
                                                    <th>Item</th>
                                                    <th>Type</th>
                                                    <th>Price</th>
                                                    <th>Paid Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cancelPayment as $key => $value)
                                                    <tr>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->escrow_id }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->invoice_number }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->item}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                  <?php
                                                                      if($value->type == "credit") {
                                                                          echo "Credit Card";
                                                                      }else if($value->type == "wire"){
                                                                          echo "Wire Transfer";
                                                                      }else if($value->type == ""){
                                                                          echo "Electronic Check";
                                                                      }
                                                                  ?>
                                                             </td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->price."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->total."USD"}}</td>
                                                      </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="approved">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-globe"></i> Approved Escrow  Management
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
                                                    <th>Escrow ID</th>
                                                    <th>Invoice Number</th>
                                                    <th>Item</th>
                                                     <th>Type</th>
                                                    <th>Price</th>
                                                    <th>Paid Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($approvePayment as $key => $value)
                                                    <tr>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->escrow_id }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->invoice_number }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->item}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                  <?php
                                                                      if($value->type == "credit") {
                                                                          echo "Credit Card";
                                                                      }else if($value->type == "wire"){
                                                                          echo "Wire Transfer";
                                                                      }else if($value->type == ""){
                                                                          echo "Electronic Check";
                                                                      }
                                                                  ?>
                                                             </td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->price."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->total."USD"}}</td>
                                                      </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="dispute">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-globe"></i> Dispute Escrow  Management
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
                                                    <th>Escrow ID</th>
                                                    <th>Invoice Number</th>
                                                    <th>Item</th>
                                                     <th>Type</th>
                                                    <th>Price</th>
                                                    <th>Paid Price</th>
                                                    <th class= "sorting_disabled">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($disputePayment as $key => $value)
                                                    <tr>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->escrow_id }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{ $value->invoice_number }}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->item}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                  <?php
                                                                      if($value->type == "credit") {
                                                                          echo "Credit Card";
                                                                      }else if($value->type == "wire"){
                                                                          echo "Wire Transfer";
                                                                      }else if($value->type == ""){
                                                                          echo "Electronic Check";
                                                                      }
                                                                  ?>
                                                             </td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->price."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>{{$value->total."USD"}}</td>
                                                        <td @if($value->admin_active == 0) class="classBeActive" @endif>
                                                                @if($value->confirm ==2)
                                                                    <a href="javascript:void(0)" class='btn btn-xs blue' onclick="onDisputeConfirm({{$value->id}})">Disputed</a>
                                                                    <a href="{{URL::route('admin.escrow.dispute',$value->id)}}" class="btn btn-xs green">View Dispute Content</a>
                                                                @elseif($value->confirm ==3)
                                                                    <a href="javascript:void(0)" class='btn btn-xs blue' onclick="onDisputeConfirm({{$value->id}})">Solved</a>
                                                                    <a href="{{URL::route('admin.escrow.dispute',$value->id)}}" class="btn btn-xs green">View Dispute Content</a>
                                                                @endif
                                                                <a href="javascript:void(0)" class="btn btn-xs green" onclick="OnEditPrice({{$value->id}})">Edit</a>
                                                                <a href="javascript:void(0)" class="btn btn-xs red"   onclick="onSendMessageModal({{$value->id}})">Send Message</a>
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

             <div class="modal fade" id="onEditModalDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
                  <div class="modal-dialog">
                       <div class="modal-content modalChangeContent">
                           <div class="modal-header modalChangeHeader">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                               <h4 class="modal-title modalChangeTitle" id="myModalLabel">Edit Escrow Payment</h4>
                           </div>
                           <div class="modal-body" id="myModaltext">
                                <div class="row">
                                     <div class="col-md-12">
                                        <form action ="{{URL::route('admin.escrow.paymentEscrowEdit')}} " method ="post" class="form-horizontal" id="onEditModalContentDiv">
                                              <div class="form-group">
                                                 <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Invoice Number</label>
                                                   <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                       <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Invoice Number" value="" >
                                                   </div>
                                               </div>
                                              <div class="form-group">
                                                   <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Paid Price</label>
                                                     <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                         <input type="text" class="form-control" id="paid_price" name="paid_price" placeholder="Paid Price" value="" >
                                                     </div>
                                              </div>
                                              <input type="hidden" id="escrow_id" name="escrow_id" value="">
                                              <div class="form-group">
                                                 <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7 col-lg-offset-3 col-md-offset-4 col-xm-offset-4 col-xs-offset-5 text-right">
                                                      <a href="javascript:void(0)" class="btn blue" onclick="onEditSubmit()" id="edit">Edit</a>
                                                      <div id="spin2" style="display: none"></div>
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
                                         <form action ="{{URL::route('admin.escrow.sendUserEmailAddress')}} " method ="post" class="form-horizontal" id="onSendMessageModalContentDiv">
                                               <div class="form-group">
                                                  <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Email</label>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                        <input type="text" class="form-control" id="email_number" name="email_number" placeholder="Email" value="" readonly>
                                                    </div>
                                                </div>
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Message Title</label>--}}
                                                      {{--<div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">--}}
                                                          {{--<input type="text" class="form-control" name="title">--}}
                                                      {{--</div>--}}
                                               {{--</div>--}}
                                               {{--<div class="form-group">--}}
                                                    {{--<label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Message Content</label>--}}
                                                      {{--<div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">--}}
                                                          {{--<textarea name="message" class="form-control" rows="10"></textarea>--}}
                                                      {{--</div>--}}
                                               {{--</div>--}}
                                               <div class="form-group">
                                                    <label for="" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Message List</label>
                                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                                        <select name="content" class="form-control">
                                                            <option value="">-- -- </option>
                                                            @foreach($emailSend as $key=>$value)
                                                             <option value="{{$value->id}}">{{$value->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                               </div>
                                               <input type="hidden" id="escrow_id" name="escrow_id" value="">
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
            {{ HTML::script('/assets/assest_admin/js/spin.js') }}
    		<script type="text/javascript">
    			jQuery(document).ready(function() {
    				 initTable1();
    			});
    			function onSendMessageModal(id){
    			    var base_url = window.location.origin;
    			    $.ajax ({
                        url: base_url + '/admin/escrow/getUserEmailAddress',
                        type: 'POST',
                        data: {id : id},
                        cache: false,
                        dataType : "json",
                        success: function (data) {
                            if(data.result == "success"){
                                  $("#onMessageSendDiv").find("#email_number").val(data.content['useremail']);
                                  $("#onMessageSendDiv").find("#escrow_id").val(data.escrow_id);
                                  $("#onMessageSendDiv").modal('show');
                            }
                        }
                     });
    			}
    			function onSendMessage(){
    		    	  $("#spin3").css('display','block');
    		    	$("#onMessageSendDiv").find("#edit").hide();
                     var opts = {
                        lines: 7, // The number of lines to draw
                        length: 6, // The length of each line
                        width: 5, // The line thickness
                        radius: 8, // The radius of the inner circle
                        corners: 1, // Corner roundness (0..1)
                        rotate: 90, // The rotation offset
                        direction: 1, // 1: clockwise, -1: counterclockwise
                        color: '#000', // #rgb or #rrggbb or array of colors
                        speed: 0.7, // Rounds per second
                        trail: 60, // Afterglow percentage
                        shadow: false, // Whether to render a shadow
                        hwaccel: false, // Whether to use hardware acceleration
                        className: 'spinner', // The CSS class to assign to the spinner
                        zIndex: 2e9, // The z-index (defaults to 2000000000)
                        top: 'auto', // Top position relative to parent in px
                        left: 'auto' // Left position relative to parent in px
                      };
                      var target = document.getElementById('spin3');
                      var spinner = new Spinner(opts).spin(target);
                      $("#onSendMessageModalContentDiv").ajaxForm({
                            success:function(data){
                                 $("#spin3").hide();
                                 if(data.result == "success"){
                                    bootbox.alert("Message Sent Successfully.");
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
    			function OnEditPrice(id){
    			 var base_url = window.location.origin;
                     $.ajax ({
                        url: base_url + '/admin/escrow/getPaymentEscrowEdit',
                        type: 'POST',
                        data: {id : id},
                        cache: false,
                        dataType : "json",
                        success: function (data) {
                            if(data.result == "success"){
                                  $("#onEditModalDiv").find("#invoice_number").val(data.content['invoice_number']);
                                  $("#onEditModalDiv").find("#paid_price").val(data.content['total']);
                                  $("#onEditModalDiv").find("#escrow_id").val(data.content['id']);
                                  $("#onEditModalDiv").modal('show');
                            }
                        }
                     });
    			}
    			function onEditSubmit(){
    			     $("#spin2").css('display','block');
    			     $("#onEditModalDiv").find("#edit").hide();
                         var opts = {
                            lines: 7, // The number of lines to draw
                            length: 6, // The length of each line
                            width: 5, // The line thickness
                            radius: 8, // The radius of the inner circle
                            corners: 1, // Corner roundness (0..1)
                            rotate: 90, // The rotation offset
                            direction: 1, // 1: clockwise, -1: counterclockwise
                            color: '#000', // #rgb or #rrggbb or array of colors
                            speed: 0.7, // Rounds per second
                            trail: 60, // Afterglow percentage
                            shadow: false, // Whether to render a shadow
                            hwaccel: false, // Whether to use hardware acceleration
                            className: 'spinner', // The CSS class to assign to the spinner
                            zIndex: 2e9, // The z-index (defaults to 2000000000)
                            top: 'auto', // Top position relative to parent in px
                            left: 'auto' // Left position relative to parent in px
                          };
                          var target = document.getElementById('spin2');
                          var spinner = new Spinner(opts).spin(target);
                          $("#onEditModalContentDiv").ajaxForm({
                                success:function(data){
                                     $("#spin2").hide();
                                     if(data.result == "success"){
                                        bootbox.alert("Escrow payment saved successfully.");
                                        window.location.reload();
                                     }
                                 }
                          }).submit();
    			}
    			function onDelteConfirm( obj){
    				bootbox.confirm("Are you sure?", function(result) {

    					if ( result ) {

    						obj.submit();

    					}

    				});

    				return false;
    			}
    			function onSubmitConfirm(id){
    			   var base_url = window.location.origin;
                     $.ajax ({
                        url: base_url + '/admin/escrow/payments/confirm',
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