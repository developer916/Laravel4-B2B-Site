@extends('user.buyer.layout')
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1 " >
            <div class="row">
                <div class="col-md-12 orderContent margin-bottom-40" >
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 orderTitle">
                            <h4 class="margin-bottom-10" style="color: black; font-weight: 900;">{{$subTitle}}</h4>
                            <div class="row">
                                <div class="col-md-12 margin-bottom-20">
                                     <a href="{{URL::route('user.buyer.sub.escrow')}}" class="display_inline">
                                        <img src="/assets/images/escrow.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.escrow')}}</p>
                                    </a>
                                    <a href="{{URL::route('user.buyer.sub.sample')}}" class="display_inline">
                                        <img src="/assets/images/sample.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.sample')}}</p>
                                    </a>
                                    <a href="{{URL::route('user.buyer.sub.orders')}}" class="display_inline">
                                        <img src="/assets/images/orders.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.orders')}}</p>
                                    </a>
                                    <a href="{{URL::route('user.buyer.sub.inspection')}}" class="display_inline">
                                        <img src="/assets/images/inspection.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.inspection')}}</p>
                                    </a>
                                    <a href="{{URL::route('user.buyer.sub.shipping')}}" class="display_inline">
                                        <img src="/assets/images/shipping.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.shipping')}}</p>
                                    </a>
                                    <a href="{{URL::route('user.buyer.sub.mail')}}" class="display_inline">
                                        <img src="/assets/images/mail.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.mail')}}</p>
                                    </a>
                                    <a href="{{URL::route('user.buyer.sub.documents')}}" class="display_inline">
                                        <img src="/assets/images/document.jpg" class="orderItemSubList" >
                                        <p class="leftMenuSubItem">{{Lang::get('user.documents')}}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-md-12 orderContent" style="min-height: 200px;">
                    @if(count($escrowUser)>0)
                        <div class="row">
                            <div class="panel panel-default margin-bottom-40 change-panel border-radius10101010">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                          <table class="table table-striped">
                                               <thead>
                                                   <tr>
                                                       <th></th>
                                                       <th><p class="escrow-status">{{Lang::get('user.status')}}</p></th>
                                                       <th><p class="escrow-number">{{Lang::get('user.escrow_number')}}</p></th>
                                                       <th><p>{{Lang::get('user.total_due')}}</p></th>
                                                       <th><p class="escrow-number">{{Lang::get('user.escrow_amount')}}</p></th>
                                                       <th><p class="escrow-request-date">{{Lang::get('user.request_date')}}</p></th>
                                                       <th><p class="escrow-request-date">{{Lang::get('user.date_escrow')}}</p></th>
                                                       <th><p class="escrow-request-full-date">{{Lang::get('user.date_full_payment')}}</p></th>
                                                       <th><p class="escrow-request-date">{{Lang::get('user.date_cancel')}}</p></th>
                                                       <th><p class="escrow-request-date">{{Lang::get('user.date_dispute')}}</p></th>
                                                       <th><p class="escrow-approved-date">{{Lang::get('user.date_approved')}}</p></th>

                                                   </tr>
                                               </thead>
                                               <tbody>
                                                    @foreach($escrow as $key=>$value)
                                                        <tr>
                                                            <td>
                                                                <a href="{{URL::route('user.escrow.escrow',($value->escrow_id))}}" class="btn-u btn-u-orange" target="_blank"><i class="fa fa-comments-o"></i></a>
                                                            </td>
                                                            <td>
                                                                @if($value->status == "1")
                                                                    {{Lang::get('user.waiting_for_payment')}}
                                                                @elseif($value->status ==2)
                                                                    @if($value->confirm == 1)
                                                                        {{Lang::get('user.the_money_was_put_in_the_escrow')}}
                                                                    @elseif($value->confirm == 0)
                                                                        {{Lang::get('user.wait_admin_confirm_escrow')}}
                                                                    @endif
                                                                @elseif($value->status == 3)
                                                                    @if($value->confirm =="2")
                                                                        {{Lang::get('user.the_payment_was_disputed')}}
                                                                    @elseif($value->confirm =="3")
                                                                        {{Lang::get('user.dispute_solved')}}
                                                                    @endif
                                                                @elseif($value->status == 4)
                                                                    {{Lang::get('user.the_payment_was_canceled')}}
                                                                @elseif($value->status == 5)
                                                                    {{Lang::get('user.the_payment_was_approved')}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{$value->escrow_id}}
                                                            </td>
                                                            <td>
                                                                {{$value->price."(USD)"}}
                                                            </td>
                                                            <td>
                                                                {{$value->total."(USD)"}}
                                                            </td>
                                                            <td>
                                                                {{substr($value->created_at,0,10)}}
                                                            </td>
                                                            <td>
                                                                {{$value->escrowDate}}
                                                            </td>
                                                            <td>
                                                                {{$value->confirmDate}}
                                                            </td>
                                                            <td>
                                                                @if($value->status == 4)
                                                                    {{$value->cancelDate}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($value->status == 3)
                                                                    {{$value->disputeDate}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{$value->approvedDate}}
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                               </tbody>
                                          </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @stop
@stop