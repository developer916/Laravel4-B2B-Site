@extends('user.layout');
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
         {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
         {{HTML::style('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.css')}}
    @stop
    @section('body')

        <div class="container content">
         <div class=" col-md-12 rightMenu favoriteContentBody">
            <div class="row">
                <div class="col-md-12" style="text-align: center; margin-top: 20px">
                    <h3 class="quoteQuoteHeader">{{Lang::get('missing.quote_page')}}</h3>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <img src="/assets/asset_view/img/332563ae50abec_Logo-01.jpg">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 margin-bottom-20">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h4 style="color:red" class="margin-bottom-20">{{Lang::get('user.seller_information')}}</h4>
                            <div class="row">
                                <div class="col-md-5 col-sm-6 col-xs-6">{{Lang::get('user.user_name')}}</div>
                                <div class="col-md-7 col-sm-6 col-xs-6"><p>{{$quote->sellerMember->username}}</p></div>
                            </div>
                            <div class="row ">
                                <div class="col-md-5 col-sm-6 col-xs-6">{{Lang::get('user.quantity')}}</div>
                                <div class="col-md-7 col-sm-6 col-xs-6">
                                    <p>{{$quote->quantity}}
                                    @foreach($units as $key=>$unit)
                                        <?php if($unit->id == $quote->unit){ ?>
                                            {{$unit->unitname}}
                                        <?php }?>
                                    @endforeach
                                    </p>
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-md-5 col-sm-6 col-xs-6">{{Lang::get('user.seller_price')}}</div>
                                <div class="col-md-7 col-sm-6 col-xs-6">
                                   <p> {{round($quote->price*$verticalFee,1)}}
                                    @foreach($currencies as $key=>$currency)
                                        @if($currency->id == $quote->price_currency)
                                            {{$currency->currency_name}}
                                        @endif
                                     @endforeach
                                     </p>
                                </div>
                            </div>
                            <?php if(isset($quote->sample_price)){?>
                                <div class="row ">
                                    <div class="col-md-5 col-sm-6 col-xs-6">{{Lang::get('user.sample_price')}}</div>
                                    <div class="col-md-7 col-sm-6 col-xs-6">
                                       <p> {{round($quote->sample_price*$verticalFee,1)}}
                                        @foreach($currencies as $key=>$currency)
                                            @if($currency->id == $quote->sample_price_currency)
                                                {{$currency->currency_name}}
                                            @endif
                                         @endforeach
                                        </p>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                              <h4 style="color:red" class="margin-bottom-20">{{Lang::get('user.post_content')}}</h4>
                               <div class="row">
                                  <div class="col-md-4 col-sm-5 col-xs-6">{{Lang::get('user.post_type')}}</div>
                                  <div class="col-md-7 col-sm-6 col-xs-6"><p>{{$rfq->rfq_type}}</p> </div>
                               </div>
                               <div class="row">
                                     <div class="col-md-4 col-sm-5 col-xs-6">{{Lang::get('user.rfq_product_name')}}</div>
                                     <div class="col-md-7 col-sm-6 col-xs-6"><p>{{$rfq->rfq_title}}</p> </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-4 col-sm-5 col-xs-6">{{Lang::get('user.purchase_quantity')}}</div>
                                   <div class="col-md-7 col-sm-6 col-xs-6"><p>{{$rfq->rfq_quantity}} {{$rfq->unit->unitname}}</p> </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-4 col-sm-5 col-xs-6">{{Lang::get('user.item_price')}}</div>
                                 <div class="col-md-7 col-sm-6 col-xs-6"><p>{{$rfq->rfq_unitprice}} {{$rfqCurrencies->currency_name}}</p> </div>
                              </div>
                              <div class="row">
                                   <div class="col-md-4 col-sm-5 col-xs-6">{{Lang::get('user.posted_date')}}</div>
                                   <div class="col-md-7 col-sm-6 col-xs-6"><p>{{substr($rfq->created_at,0,10)}}</p> </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 margin-bottom-20">
                    <div class="row margin-bottom-20">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h4 style="color: red; " class="margin-bottom-10">{{Lang::get('user.seller_description')}}</h4>
                            <p>{{$quote->seller_product}}</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h4 style="color: red;" class="margin-bottom-10">{{Lang::get('user.rfq_product_description')}}</h4>
                            <p>{{$rfq->rfq_description}}</p>
                        </div>
                    </div>

                    <?php  if($rfq->rfq_type == "detailed"){?>
                    <div class="row margin-bottom-20" >
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h4 style="color: red;" class="margin-bottom-10">{{Lang::get('user.seller')." ".Lang::get('user.specification_description')}}</h4>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                             <h4 style="color: red;" class="margin-bottom-10">{{Lang::get('user.buyer')." ". Lang::get('user.specification_description')}}</h4>
                        </div>
                    </div>
                    <?php }
                        if($rfq->rfq_type == "detailed"){
                        for($i=0; $i<count($rfqSpecificationDescription); $i++){ ?>
                    <div class="row margin-bottom-10" >
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if($rfqSpecificationDescription[$i]->rfq_alternative_ok == 0)
                                <p style="color: green;"> {{ $rfqSpecificationDescription[$i]->rfq_description}} </p>
                            @else
                                <p> {{ $rfqSpecificationDescription[$i]->rfq_description}} </p>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            @if($rfqSpecificationDescription[$i]->rfq_alternative_ok == 0)
                                <p style="color: green;"> {{$quoteSpecificationDescription[$i]->specification}} </p>
                            @else
                                <p> {{ $quoteSpecificationDescription[$i]->specification}} </p>
                            @endif
                        </div>
                    </div>
                    <?php } }?>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="row margin-bottom-20">
                                <div class="col-md-12">
                                    <h4 style="color: red;" class="margin-bottom-20">{{Lang::get('user.note_to_buyer')}}</h4>
                                     <?php if(count($quoteNote)>0) {
                                           for($i = 0; $i<count($quoteNote); $i++){ ?>
                                            <p>{{$quoteNote[$i]->note}}</p>
                                     <?php } } ?>
                                </div>

                             </div>
                             <div class="row margin-bottom-20">
                                <div class="col-md-12">
                                    <h4 style="color: red;" class="margin-bottom-20">{{Lang::get('user.seller_pictures')}}</h4>
                                    <div class="row">
                                        <div class="col-md-12 previewMultiImage">
                                            @foreach($quotePic as $value)
                                                  <div class="img-wrap gallery-item">
                                                   <a href="{{HTTP_LOGO_PATH.$value->picture_url}}" rel="gallery1" class="fancybox img-hover-v1">
                                                      <span><img class="img-responsive" src="{{HTTP_LOGO_PATH.$value->picture_url}}" alt=""></span>
                                                    </a>
                                                 </div>
                                              @endforeach
                                        </div>
                                    </div>
                                </div>
                             </div>
                         </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-40" style="text-align: center">
                        <a href="javascript:void(0)" class="btn-u btn-u-blue"   style="margin-top: 20px" onclick = "onSaveAccept({{100000*1+$quote->id}})">{{Lang::get('user.accept')}}</a>
                        <?php if($quote->status == 1){?>
                            <form action="{{URL::route('user.buyer.sampleStore')}}" method="post" style="margin-top: 20px; display: inline-block" id="addFormSend">
                                <input type="hidden" name="quote_id" value="{{100000*1+$quote->id}}">
                                <input type="hidden" name="sample_amount" id="sample_amount">
                                <input type ="button" class="btn-u btn-u btn-u-green" value="{{Lang::get('user.request_sample')}}" onclick="onSampleRequest()">
                            </form>
                        <?php } else if($quote->status == 3) {?>
                            <a href="javascript:voide(0)" class="btn-u btn-u-green" onclick="onPayNow()"> {{Lang::get('user.pay_now')}}</a>
                        <?php }  if($quote->status == 3 || $quote->status == 4 ) {?>
                            <a href="{{URL::route('user.invoice',(100000*1+$quote->id))}}" class=" btn-u btn-u-dark-blue" target="_blank" style="color:white"> {{Lang::get('user.invoice')}}</a>
                        <?php }?>
                        <a href="javascript:void(0)" class="btn-u btn-u-orange" style="margin-top: 20px"  onclick="reQuoteSend()">{{Lang::get('user.re_quote')}}</a>
                        <a href="{{URL::route('user.buyer.emailShow',array((100000*1+$quote->id),(100000*1+$rfq->id)))}}" class="btn-u" style="margin-top: 20px" target="_blank">{{Lang::get('user.contact_seller')}}</a>
                        <a href="javascript:void(0)" class="btn-u btn-u-red" style="margin-top: 20px" onclick ="onDecline(<?php echo (100000*1+$quote->id); ?>)">{{Lang::get('user.decline')}}</a>
                        <a href="{{URL::route('user.buyer.rfq')}}" class="btn-u btn-u-dark-blue">{{Lang::get('user.return_rfq')}}</a>
                     </div>
                </div>
            </div>
         </div>
     </div>






      <div class="modal fade" id="acceptDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
         <div class="modal-dialog">
              <div class="modal-content modalChangeContent">
                  <div class="modal-header modalChangeHeader">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.accept_now')}}</h4>
                  </div>
                  <div class="modal-body" id="myModaltext">
                      <div class="row">
                          <div class="col-md-12">
                              <form class="form-horizontal" id="acceptDivForm" method="post" action="{{URL::route('user.buyer.rfqAccept')}}">
                                  <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">
                                            {{Lang::get('user.address')}}
                                            <span style="color:red">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                            <input type="text" class="form-control" id="inputEmail1" name="address" placeholder="{{Lang::get('user.address')}}" value="<?php if($quoteAcceptCheck == 1) {echo $quoteAccept[0]->buyer_address;}else{echo $quoteAccept[0]['street'];}?> ">
                                        </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">
                                            {{Lang::get('user.city')}}
                                            <span style="color:red">*</span>
                                      </label>
                                     <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                          <input type="text" class="form-control" id="inputEmail1" name="city" placeholder="{{Lang::get('user.city')}}"  value="<?php if($quoteAcceptCheck == 1) {echo $quoteAccept[0]->buyer_city;}else{echo $quoteAccept[0]['city'];} ?>">
                                      </div>
                                 </div>
                                  <div class="form-group">
                                       <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">{{Lang::get('user.state')}}</label>
                                       <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                           <input type="text" class="form-control" id="inputEmail1" name="state" placeholder="{{Lang::get('user.state')}}" value="<?php if($quoteAcceptCheck == 1) {echo $quoteAccept[0]->buyer_state;}else{echo $quoteAccept[0]['state'];}?>">
                                       </div>
                                  </div>
                                  <div class="form-group">
                                     <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">
                                        {{Lang::get('user.zip_code')}}
                                        <span style="color:red">*</span>
                                     </label>
                                     <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                         <input type="text" class="form-control" id="inputEmail1" name="zipcode" placeholder="{{Lang::get('user.zip_code')}}" value="<?php if($quoteAcceptCheck == 1) {echo $quoteAccept[0]->buyer_zip;}else{echo $quoteAccept[0]['zipcode'];}?>">
                                     </div>
                                </div>
                                <div class="form-group margin-bottom-30">
                                     <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">
                                        {{Lang::get('user.country')}}
                                        <span style="color:red">*</span>
                                     </label>
                                     <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                         <select class="form-control" name="country_id">
                                              @foreach($country as $countryItem)
                                                @if($quoteAcceptCheck == 1)
                                                    @if($quoteAccept[0]['buyer_country'] == $countryItem->id)
                                                        <option value="{{$countryItem->id}}" selected>{{$countryItem->country_name}}</option>
                                                    @else
                                                        <option value="{{$countryItem->id}}">{{$countryItem->country_name}}</option>
                                                    @endif

                                                @else
                                                    @if($quoteAccept[0]['country_id'] == $countryItem->id)
                                                        <option value="{{$countryItem->id}}" selected>{{$countryItem->country_name}}</option>
                                                    @else
                                                        <option value="{{$countryItem->id}}">{{$countryItem->country_name}}</option>
                                                    @endif
                                                @endif
                                              @endforeach
                                         </select>
                                     </div>
                                </div>
                                <input type="hidden" name="quote_id" value="{{100000*1+$quote->id}}">
                                <div class="form-group">
                                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7 col-lg-offset-3 col-md-offset-4 col-sm-offset-4 col-xs-offset-5">
                                        <input type="button" value="{{Lang::get('user.accept')}}" class="btn-u btn-u-blue" onclick="onSendAccept()" id="submitAccept">
                                        <div id="spin1" style="display: none"></div>
                                        <button type="button" class="btn-u btn-u-red"  data-dismiss="modal">{{Lang::get('user.cancel')}}</button>
                                    </div>
                                </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
         </div>
      </div>
     <div class="modal fade" id="payNowQuoteDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
             <div class="modal-content modalChangeContent">
                 <div class="modal-header modalChangeHeader">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.payment_form')}}</h4>
                 </div>
                 <div class="modal-body" id="myModaltext">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" id="onPayNowCotentDiv" method="post" action="{{URL::route('user.buyer.samplePayNow')}}">
                                <div class="form-group">
                                  <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.card_no')}}</label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="card_no" placeholder="{{Lang::get('user.card_no')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.exp_month')}}</label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="exp_month" placeholder="{{Lang::get('user.exp_month')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.exp_year')}}</label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="exp_year" placeholder="{{Lang::get('user.exp_year')}}">
                                    </div>
                                </div>
                                <?php if(isset($quoteSample) && $quote->status == 3)  {?>
                                <div class="form-group">
                                  <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.total')}}</label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="total" readonly value="{{round($quoteSample->totalprice,1)}}USD">
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                  <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.address')}}</label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="address" placeholder="{{Lang::get('user.address')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.zip_code')}}</label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="zipCode" placeholder="{{Lang::get('user.zip_code')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.email')}}</label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="email" placeholder="{{Lang::get('user.email')}}">
                                    </div>
                                </div>
                                <div class="form-group margin-bottom-20">
                                  <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.cvv2')}}</label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="cvv2" placeholder="{{Lang::get('user.cvv2')}}">
                                    </div>
                                </div>
                                <input type="hidden" name="quote_id" value="{{$quote->id+100000*1}}">
                                <div class="form-group margin-bottom-40">
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8 col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-xs-offset-4">
                                        <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick = "OnPayNowModalSend()" id="paynowSubmit">{{Lang::get('user.pay_now')}}</a>
                                        <div id="spin" style="display: none"></div>
                                        <button type="button" class="btn-u btn-u-red"  data-dismiss="modal">{{Lang::get('user.cancel')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                 </div>
             </div>
        </div>
     </div>

     </div>
     <div class="modal fade" id="sendReQuoteDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content modalChangeContent">
                 <div class="modal-header modalChangeHeader">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.re_quote')}}</h4>
                 </div>
                 <div class="modal-body" id="myModaltext">
                     <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" id="panelBodyContent" method="post" action="{{URL::route('user.buyer.rfqStoreEmail1')}}">
                                <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.seller')}}</label>
                                        <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                            <input type="text" class="form-control" id="inputEmail1"  readonly value="{{$seller->username}}">
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.message_subject')}}<span style="color: red">*</span> </label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <input type="text" class="form-control" id="inputEmail1" name="subject" placeholder="{{Lang::get('user.message_subject')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                     <label for="inputEmail1" class="col-lg-2 col-md-3 col-sm-3 col-xs-4 control-label">{{Lang::get('user.message_content')}} <span style="color:red">*</span> </label>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                                        <textarea class="form-control" id="inputEmail1" placeholder="{{Lang::get('user.message_content')}}"  rows="10" name="content"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="<?php echo ($seller->id+100000*1); ?>">
                                <input type="hidden" name="rfq_id" value="<?php echo ($rfq->id+100000*1);?>" >
                                <input type="hidden" name="quote_id" value="<?php echo ($quote->id+100000*1);?>" >
                                <div class="form-group" style="text-align: right; margin-right: 0px">
                                    <input type="button" class="btn-u btn-u-blue" value="{{Lang::get('user.send')}}" onclick ="onSendMessageToSeller()">
                                    <button type="button" class="btn-u btn-u-red"  data-dismiss="modal">{{Lang::get('user.cancel')}}</button>
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
         {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js') }}
        {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') }}
        {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') }}
        {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.maskedinput.min.js') }}
        {{ HTML::script('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.pack.js') }}
        {{ HTML::script('/assets/asset_view/js/plugins/fancy-box.js') }}
        {{ HTML::script('/assets/asset_view/js/app.js') }}
        {{ HTML::script('/assets/asset_view/js/plugins/fancy-box.js') }}
        {{ HTML::script('/assets/assest_admin/js/spin.js') }}
        <script type="text/javascript">
            $( document ).ready(function() {
                  App.init();
                  FancyBox.initFancybox();
           });
           function OnPayNowModalSend(){
               $("#spin").css('display','block');
               $("#paynowSubmit").hide();
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
               var target = document.getElementById('spin');
               var spinner = new Spinner(opts).spin(target);
                $('#onPayNowCotentDiv').ajaxForm({
                   success:function(data){
                            $("#spin").hide();
                             $("#paynowSubmit").show();
                       if(data.result == "success"){
                            bootbox.alert(data.message);
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
                             bootbox.alert(errorList);
                       }
                   }
                }).submit();
           }
           function onPayNow(){
                var a = $("<a>")
                   .attr("href", "#payNowQuoteDiv")
                   .attr("data-toggle","modal")
                   .appendTo("body");

                   a[0].click();

                   a.remove();
           }
           function onDecline(QuoteID){

                $.ajax ({
                    url:' {{ route("user.buyer.decline") }}',
                    type: 'POST',
                    data: {QuoteID:QuoteID},
                    cache: false,
                    dataType : "json",
                    success: function (data) {
                        if(data.result == "success"){
                            bootbox.alert(data.message);
                            window.location.href = data.url;
                        }
                    }
                });
           }
           function onSaveAccept(id){
              var a = $("<a>")
                 .attr("href", "#acceptDiv")
                 .attr("data-toggle","modal")
                 .appendTo("body");

                 a[0].click();

                 a.remove();

           }
           function onSendAccept(){
                  $("#spin1").css('display','block');
                  $("#submitAccept").hide();
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
                  var target = document.getElementById('spin1');
                  var spinner = new Spinner(opts).spin(target);
                   $('#acceptDivForm').ajaxForm({
                       success:function(data){
                                $("#spin1").hide();
                                 $("#submitAccept").show();
                           if(data.result == "success"){
//                                bootbox.alert(data.message);
                                window.location.href=data.url;
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
                                 bootbox.alert(errorList);
                           }
                       }
                    }).submit();
           }
           function reQuoteSend(){
                var a = $("<a>")
                    .attr("href", "#sendReQuoteDiv")
                    .attr("data-toggle","modal")
                    .appendTo("body");

                    a[0].click();

                    a.remove();
           }

           function onSampleRequest(){
                bootbox.prompt("Please insert sample request amount:",function(result){
			        if(result != "" && result != null ) {
			            if(IsNumeric(result) == true){
			                $('#sample_amount').eq(0).val(result);
                            $('#addFormSend').ajaxForm({
                                success:function(data){
                                    if(data.result == "success"){
                                         bootbox.alert(data.message);
                                         window.location.reload();
                                    }else if(data.result == "error"){
                                        var arr = data.error;
                                         var errorList = '';
                                        $.each(arr, function(index, value)
                                        {
                                            if (value.length != 0)
                                            {
                                                errorList = errorList + value;
                                            }
                                        });
                                         bootbox.alert(errorList);
                                    }
                                }
                            }).submit();
			            }else{
			            bootbox.alert("Please insert correct number");
			        }

			        }
			     });
           }
           function IsNumeric(num) {
           	    return (num >=0);
           	}
           function onSendMessageToSeller(){
                $("#panelBodyContent").ajaxForm({
                  success: function(data) {
                    if(data.result == "success"){
                        bootbox.alert(data.error);
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
                         bootbox.alert(errorList);
                  }
                  }
                }).submit();
           }
        </script>
    @stop
@stop