@extends('admin.layout')
  @section('body')
      <?php use GetCurrency as GetCurrencyModel;?>
      <div class="row">
          <div class="col-md-12">
              <div class="portlet light">
                  <div class="portlet-body">

                     <div class="row margin-bottom-30">
                         <div class="col-md-12">
                             <h2>Search Result for {{$searchQuery}}</h2>
                         </div>
                     </div>
                      <!-- search Result-->
                      <div class="row">
                          <div class="col-md-12">
                              @if($searchQuery != "invoice")
                                  <div class="table-responsive">
                                      <table class="table table-striped table-bordered table-hover" id="sample_1">
                                          <thead>
                                             <tr>
                                                 @if($searchQuery == "rfq")
                                                     <th class="table-checkbox">
                                                         <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                     </th>
                                                     <th>User Name</th>
                                                     <th>Product Title</th>
                                                     <th>Product Description</th>
                                                     <th>Action</th>
                                                 @elseif($searchQuery == "quote")
                                                     <th class="table-checkbox">
                                                         <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                     </th>
                                                     <th>RFQ Title</th>
                                                     <th>Seller Description</th>
                                                     <th>Action</th>
                                                 @elseif($searchQuery == "company")
                                                     <th class="table-checkbox">
                                                         <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                     </th>
                                                     <th>User Name</th>
                                                     <th>User Type</th>
                                                     <th>Name</th>
                                                     <th>Email</th>
                                                     <th>Status</th>
                                                     <th>Action</th>
                                                 @elseif($searchQuery == "product")
                                                     <th class="table-checkbox">
                                                         <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                     </th>
                                                     <th> User Name</th>
                                                     <th> Product Name</th>
                                                     <th> Product Meta</th>
                                                     <th> Created </th>
                                                     <th class= "sorting_disabled">ACTION</th>
                                                 @endif
                                             </tr>
                                          </thead>
                                          <tbody>
                                              @if($searchQuery == "rfq")
                                                  @foreach($searchResult as $key =>$value)
                                                      <tr>
                                                         <td><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                          <td>{{ $value->member->username }}</td>
                                                          <td>{{ $value->rfq_title }}</td>
                                                          <td>
                                                              <?php
                                                              $length = strlen( $value->rfq_description);
                                                              if($length >40){
                                                                  echo substr($value->rfq_description,0,40)."....";
                                                              }else{
                                                                  echo $value->rfq_description;
                                                              }
                                                              ?>
                                                          </td>
                                                          <td>
                                                              <a href="{{ URL::route('admin.rfq.view',$value->id)}}"  class='btn btn-xs green'>
                                                                  <i class='fa fa-bars'></i> View
                                                              </a>
                                                              <a href="{{ URL::route('admin.rfq.edit',$value->id)}}"  class='btn btn-xs blue'>
                                                                  <i class='fa fa-edit'></i>Edit
                                                              </a>

                                                              <form action="{{ URL::route('admin.rfq.delete' , $value->id) }}" id="formTest" onsubmit = "return onDeleteConfirm(this)" style="display:inline-block">
                                                                  <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                                                      <i class='fa fa-trash-o'></i> Delete</button>
                                                              </form>
                                                          </td>
                                                      </tr>
                                                  @endforeach
                                              @elseif($searchQuery  == "quote")
                                                  @foreach($searchResult as $key =>$value)
                                                      <tr>
                                                          <td><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                          <td>{{$value->rfq->rfq_title}}</td>
                                                          <td>
                                                              <?php
                                                                $length = strlen($value->seller_product);
                                                                if($length >100){
                                                                    echo substr($value->seller_product,0,100).".....";
                                                                }else{
                                                                    echo $value->seller_product;
                                                                }
                                                              ?>
                                                          </td>
                                                          <td><a href="{{URL::route('user.seller.editQuoteNow',($value->id+100000))}}" class="btn btn-xs green" target="_blank"><i class="fa fa-bars"></i> </a></td>
                                                      </tr>
                                                  @endforeach
                                              @elseif($searchQuery == "product")
                                                  @foreach($searchResult as $key => $value)
                                                      <tr>
                                                          <td><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                          <td>{{ $value->member->username }}</td>
                                                          <td>{{ $value->product_name }}</td>
                                                          <td>{{ $value->meta }}</td>
                                                          <td>{{ substr($value->created_at,0,10) }}</td>
                                                          <td>
                                                              <a class="btn btn-xs green" href = "{{URL::route('admin.post.view', $value->id)}}">
                                                                  <i class='fa fa-bars'></i> View
                                                              </a>
                                                              <a href="{{ URL::route('admin.post.edit',$value->id)}}"  class='btn btn-xs blue'>
                                                                  <i class='fa fa-edit'></i>Edit
                                                              </a>
                                                              <form action="{{ URL::route('admin.post.delete' , $value->id) }}" id="formTest" onsubmit = "return onDelteConfirm(this)" style="display:inline-block">
                                                                  <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                                                      <i class='fa fa-trash-o'></i> Delete</button>
                                                              </form>

                                                          </td>
                                                      </tr>
                                                  @endforeach
                                              @elseif($searchQuery == "company")
                                                  @foreach($searchResult as $key=>$value_company)
                                                      <?php $value = ($value_company->member);?>
                                                      <tr>
                                                          <td><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                          <td>{{ $value->username }}</td>
                                                          <td><?php if($value->usertype == "1") {echo "Seller";}elseif($value->usertype == "2") {echo "Buyer";} else{echo "Both";}?></td>
                                                          <td><?php echo $value->firstname ." ". $value->lastname;?></td>
                                                          <td>{{ $value->email }}</td>
                                                          <td>
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
                                                          <td>
                                                              <a class="btn btn-xs green" data-toggle="modal" href="javascript:void(0)" onclick="onShowModal(<?php echo $value->id; ?>)">
                                                                  <i class='fa fa-bars'></i> View
                                                              </a>
                                                              <a href="{{ URL::route('admin.members.edit',$value->id)}}"  class='btn btn-xs blue'>
                                                                  <i class='fa fa-edit'></i>Edit
                                                              </a>
                                                              <form action="{{ URL::route('admin.members.delete' , $value->id) }}" id="formTest" onsubmit = "return onDeleteConfirm(this)" style="display:inline-block">
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
                                                  @include('admin.members.indexModal')
                                              @endif
                                          </tbody>
                                      </table>
                                  </div>
                              @else
                                  @if(count($searchResult) >0)
                                      <h4>Sample Invoices</h4>
                                      <div class="table-responsive margin-bottom-30">
                                          <table class="table table-striped table-bordered table-hover">
                                              <thead>
                                                <tr>
                                                    <th class="table-checkbox">
                                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                    </th>
                                                    <th>RFQ Title</th>
                                                    <th>Buyer Name</th>
                                                    <th>Seller Name</th>
                                                    <th>Invoice Number</th>
                                                    <th>Shipping Price</th>
                                                    <th>Sample Price</th>
                                                    <th>Buyer Invoice</th>
                                                    <th>Seller Invoice</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                 @foreach($searchResult as $key =>$value)
                                                     <tr>
                                                         <td><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                         <td>{{$value->rfq->rfq_title}}</td>
                                                         <td>{{$value->sellerMember->username}}</td>
                                                         <td>{{$value->buyerMember->username}}</td>
                                                         <td>{{$value->invoicenumber}}</td>
                                                         <td>{{$value->shippingprice. $value->shippingcurrency}}</td>
                                                         <td>
                                                             <?php
                                                                $sampleAmount = $value->quote->sample_price * $value->sampleamount;
                                                                $sampleUnit = $value->quote->SampleCurrency->currency_name;
                                                                $currencySampleAmount = GetCurrencyModel::getCurrencyFunction(strtoupper($sampleUnit),$sampleAmount);
                                                             ?>
                                                             {{$sampleAmount." ". $sampleUnit }}</td>
                                                        <td>{{round((($value->shippingprice+$currencySampleAmount)*$fee),1)." USD" }}</td>
                                                         <td>{{round(($value->shippingprice*$fee+$currencySampleAmount),1)." USD" }}</td>
                                                     </tr>
                                                 @endforeach
                                              </tbody>
                                          </table>
                                      </div>
                                  @endif
                                  @if(count($searchResult1)>0)
                                      <h4>Accept Invoices</h4>
                                      <div class="table-responsive margin-bottom-30">
                                          <table class="table table-striped table-bordered table-hover">
                                              <thead>
                                              <tr>
                                                  <th class="table-checkbox">
                                                      <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                  </th>
                                                  <th>RFQ Title</th>
                                                  <th>Buyer Name</th>
                                                  <th>Seller Name</th>
                                                  <th>Invoice Number</th>
                                                  <th>Shipping Price</th>
                                                  <th>Price</th>
                                                  <th>Buyer Invoice</th>
                                                  <th>Seller Invoice</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                 @foreach($searchResult1 as $key => $value)
                                                     <td><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                                     <td>{{$value->rfq->rfq_title}}</td>
                                                     <td>{{$value->sellerMember->username}}</td>
                                                     <td>{{$value->buyerMember->username}}</td>
                                                     <td>{{$value->invoice_number}}</td>
                                                     <td></td>
                                                     <td></td>
                                                     <td></td>
                                                     <td></td>
                                                 @endforeach
                                              </tbody>
                                          </table>
                                      </div>
                                  @endif
                              @endif

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
        });
        function onDeleteConfirm(obj){
            bootbox.confirm("Are you sure?", function(result) {

                if ( result ) {

                    obj.submit();

                }

            });

            return false;
        }
    </script>
@stop