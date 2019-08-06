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
                    <div class="row">
                        <div class="panel panel-default margin-bottom-40 change-panel border-radius10101010">
                            <div class="panel-body">
                                <div class="table-responsive">
                                      <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                     <th style="width: 40px;"></th>
                                                    <th><p class="sample-product_title">{{Lang::get('user.product_title')}}</p></th>
                                                    <th><p class="sample-sample-price">{{Lang::get('user.seller_name')}}</p></th>
                                                    <th><p class="escrow-status">{{Lang::get('user.status')}}</p></th>
                                                    <th><p>{{Lang::get('user.amount')}}</p></th>
                                                    <th><p class="sample-sample-price">{{Lang::get('user.price')}}</p></th>
                                                    <th><p class="escrow-request-date">{{Lang::get('user.invoice_number')}}</p></th>
                                                    <th><p class="escrow-request-date">{{Lang::get('user.request_date')}}</p></th>
                                                    <th><p class="escrow-approved-date">{{Lang::get('user.tracking_number')}}</p></th>
                                                    <th><p class="escrow-request-date">{{Lang::get('user.track_date')}}</p></th>

                                              </tr>
                                          </thead>
                                          <tbody>
                                            @foreach($quoteSample as $key =>$value)
                                                <tr>
                                                    <?php  $quote = $value->quote;?>
                                                    <td><a href="{{URL::route('user.buyer.quoteShow',(100000*1+$quote->id))}}" class="btn-u btn-u-orange" target="_blank"><i class="fa fa-comments-o"></i></a></td>
                                                    <td>{{$value->rfq->rfq_title}}</td>
                                                    <td>{{$value->sellerMember->username}}</td>
                                                    <td>
                                                        <?php
                                                            $content = '';
                                                            if($quote->status == 1){
                                                                $content .=Lang::get('user.pending');
                                                            }else if($quote->status == 2){
                                                                $content .=Lang::get('user.request_sample');
                                                            }else if($quote->status == 3 ){
                                                                $content .=Lang::get('user.request_payment');
                                                            }else if($quote->status == 4 ){
                                                                $content .=Lang::get('user.wait_admin_confirm');
                                                            }else if($quote->status == 5){
                                                                $content .=Lang::get('user.admin_confirmed');
                                                            }else if($quote->status == 6){
                                                                $content .=Lang::get('user.seller_send_product');
                                                            }
                                                            echo $content;
                                                        ?>

                                                    </td>
                                                    <td>{{$value->sampleamount}}</td>
                                                    <td>
                                                        @if($quote->sample_price !="")
                                                             <?php

                                                              echo $quote->sample_price.($quote->SampleCurrency->currency_name) ;
                                                             ?>
                                                        @else
                                                            <?php
                                                              echo $quote->price.($quote->Currency->currency_name) ;
                                                             ?>
                                                        @endif
                                                    </td>
                                                    <td>{{$value->invoicenumber}}</td>
                                                    <td>{{substr($value->created_at,0,10)}}</td>
                                                    <td>{{$value->tracking_number1}}</td>
                                                    <td></td>


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
@stop