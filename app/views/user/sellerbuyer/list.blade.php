@extends('user.layout')
    @section('custom-styles')
       {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
       {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
       {{HTML::style('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.css')}}
        {{ HTML::style('/assets/assest_admin/css/jquery.fancybox.css') }}
       {{ HTML::style('/assets/assest_admin/css/gallery.css') }}
    @stop
    @section('body')
    <div class="container content margin-bottom-40">
        <div class="row">
            <div class="col-md-12">
                  <div class=" form-horizontal sky-form" id="addCategoryFiledForm" style="border:0px">
                      <fieldset>
                          <div class="row">
                               <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
                                    <div class="inline-group">
                                           <label class="radio"><input type="radio" name="rfq_type"  value="standard"  <?php if($rfq->rfq_type =="standard") {echo "checked";} else{"disable";}?>><i class="rounded-x"></i><p class="headerPetrob">{{Lang::get('user.standard')}}</p></label>
                                           <label class="radio"><input type="radio" name="rfq_type"  value="detailed"   <?php if($rfq->rfq_type =="detailed") {echo "checked";}else{"disable";}?>><i class="rounded-x"></i><p class="headerPetrob">{{Lang::get('user.detailed')}}</p></label>
                                    </div>
                               </div>
                          </div>
                      </fieldset>
                      <fieldset>
                          <div class="row">
                              <section class="col-md-3 col-sm-3col-xs-12">
                                  <label class="control-label display-block-important">
                                      {{Lang::get('user.rfq_product_name')}}
                                      <span style="color: red">*</span>
                                  </label>
                              </section>
                              <section class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="product_name" class="form-control border-none-important" placeholder="{{Lang::get('user.rfq_product_name')}}" value="{{$rfq->rfq_title}}">
                               </section>
                          </div>
                          <div class="row">
                              <section class="col-md-3 col-sm-3 col-xs-12">
                                  <label class="control-label display-block-important">
                                      {{Lang::get('user.rfq_product_description')}}
                                      <span style="color: red">*</span>
                                  </label>
                              </section>
                              <section class="col-md-6 col-sm-6 col-xs-12">
                                  <textarea name="product_description" class="form-control border-none-important" placeholder="{{Lang::get('user.rfq_product_description')}}" rows="5">{{$rfq->rfq_description}}</textarea>
                               </section>
                          </div>
                          <?php  if($rfq->rfq_type == "detailed"){
                          $i=0;
                          foreach($rfq->rfqSpecifications as $value){?>
                              <div class="row" id="specificationDiv">
                                   <section class="col-md-3 col-sm-3 col-xs-12 ">
                                        <label class="control-label display-block-important">
                                            {{Lang::get('user.specification_description')}}
                                        </label>
                                   </section>
                                   <section class="col-md-6 col-sm-6 col-xs-12">
                                      <textarea name="rfq_specificationdescription<?php echo $i;?>" class="form-control col-md-12 border-none-important" id="sepecial_description_textarea<?php echo $i;?>"><?php echo  $value->rfq_description?></textarea>
                                      <div class="row col-md-12 checkbox-inline " style="margin-top:10px;">
                                          <label class="checkbox">
                                              <input type="checkbox" id="allowAlternativeBuy<?php echo $i?>" style="margin-left:10px"  <?php if($value->rfq_alternative_ok == "1") {echo "checked";}?>><i></i><p class="headerPetrob">{{Lang::get('user.allow_alternative')}}</p>
                                          </label>
                                      </div>
                                       <section style="margin-top:10px;">

                                               <div id="previewNewsImageBuy<?php echo $i?>" class="previewMultiImage">
                                                  <?php
                                                      foreach ($value->specificationPicture as $value1){?>
                                                         <div class="img-wrap gallery-item">
                                                                 <a  href="{{$value1->picture_url}}" class="fancybox img-hover-v1" rel="gallery2">
                                                                     <img alt="" src="{{$value1->picture_url}}" class="img-responsive">
                                                                     <div class="zoomix"><i class="fa fa-search"></i></div>
                                                                   </a>
                                                            </div>
                                                     <?php }
                                                  ?>
                                               </div>

                                       </section>
                                </section>
                                </div>
                            <?php  $i++;} } ?>
                           <div class="row">
                              <section class="col-md-3 col-sm-3 col-xs-12 ">
                                   <label class="control-label display-block-important">
                                       {{Lang::get('user.rfq_product_pictures')}}
                                   </label>
                              </section>
                               <section class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="previewNewsImageBuy" class="previewMultiImage" >
                                       @foreach($rfq->rfqImage as $value)
                                            <div class="img-wrap gallery-item">
                                              <a  href="{{$value->picture_url}}" class="fancybox img-hover-v1" rel="gallery2">
                                                <img alt="" src="{{$value->picture_url}}" class="img-responsive">
                                                <div class="zoomix"><i class="fa fa-search"></i></div>
                                              </a>
                                              </div>
                                       @endforeach
                                    </div>
                               </section>
                           </div>
                           <div class="row">
                                 <section class="col-md-3 col-sm-3 col-xs-12 ">
                                      <label class="control-label display-block-important">
                                          {{Lang::get('user.rfq_request_file')}}
                                      </label>
                                 </section>
                                 <section class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="previewNewsFileBuy" class="previewMultiFile">
                                        @foreach($rfq->rfqFile as $value)
                                            <div class='fileItemList'>
                                                @if($value->file_type == "PDF")
                                                    <img src='<?php echo HTTP_PATH ?>/assets/assest_admin/images/pdf.jpg' class='fileItemPDF' >
                                                    <div class='fileHref'>
                                                        <a href='{{$value->file_url}}' target='_blank'><span class='fileName'>{{$value->file_name}}</span></a>
                                                        <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                                    </div>
                                                @elseif($value->file_type == "DOC" || $value->file_type == "DOCX" )
                                                    <img src='<?php echo HTTP_PATH ?>/assets/assest_admin/images/word.jpg' class='fileItemPDF' >
                                                    <div class='fileHref'>
                                                        <a href='{{$value->file_url}}' target='_blank'><span class='fileName'>{{$value->file_name}}</span></a>
                                                        <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                                    </div>
                                                @elseif($value->file_type == "TXT")
                                                    <img src='<?php echo HTTP_PATH ?>/assets/assest_admin/images/txt.jpg' class='fileItemPDF' >
                                                    <div class='fileHref'>
                                                        <a href='{{$value->file_url}}' target='_blank'><span class='fileName'>{{$value->file_name}}</span></a>
                                                        <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                 </section>
                           </div>
                           <div class="row">
                               <section class="col-md-3 col-sm-3 col-xs-12">
                                   <label class="control-label display-block-important">
                                       {{Lang::get('user.purchase_quantity')}}
                                       <span style="color: red">*</span>
                                   </label>
                               </section>
                               <section class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" name="purchase_quantity" class="form-control border-none-important" placeholder="{{Lang::get('user.purchase_quantity')}}" value="{{$rfq->rfq_quantity." ".$rfq->unit->unitname}}">
                               </section>
                           </div>
                           <div class="row">
                                <section class="col-md-3 col-sm-3 col-xs-12">
                                     <label class="control-label display-block-important">
                                       {{Lang::get('user.item_price')}}
                                     </label>
                                </section>
                                <section class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="item_price" class="form-control border-none-important" value="{{$rfq->rfq_unitprice." ".$currencies->currency_name}}">
                                </section>
                           </div>
                            <div class="row">
                               <section class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                   @if(Session::get('user_type') != 2)
                                        <a   class="btn-u btn-u-blue" href="{{URL::route('user.seller.quoteNow',(100000*1+$rfq->id))}}"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>{{Lang::get('user.quote_now')}}</a>
                                   @endif
                                   <a class="btn-u btn-u-red" href="{{URL::route('user.home')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>{{Lang::get('user.go_to_home')}}</a>
                               </section>
                           </div>
                       </fieldset>
                   </div>
             </div>
         </div>
    </div>

    @stop
    @section('custom-scripts')
        {{ HTML::script('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.pack.js') }}
        {{ HTML::script('/assets/asset_view/js/plugins/fancy-box.js') }}
        <script type="text/javascript">
            jQuery(document).ready(function() {
                App.init();
                FancyBox.initFancybox();
            });
         </script>
    @stop
@stop