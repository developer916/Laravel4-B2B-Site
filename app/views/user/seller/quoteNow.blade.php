@extends('user.seller.layout')
    @section('custom-styles')
             {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
             {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
             {{HTML::style('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.css')}}
        @stop
    @section('body-right')
          <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
                <div class="row">
                    <div class="col-md-12 favoriteContentBody">
                         <div class="panel margin-bottom-40 change-panel">
                             <div class="panel-body">
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
                                 <div class=" form-horizontal sky-form" id="addCategoryFiledForm" style="border:0px">
                                      <fieldset>
                                         <div class="row">
                                              <section class="col-md-4 col-sm-4 col-xs-12">
                                                  <label class="control-label">
                                                      {{Lang::get('user.post_type')}}
                                                      <span style="color: red">*</span>
                                                  </label>
                                              </section>
                                              <section class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" name="product_name" class="form-control" readonly placeholder="{{Lang::get('user.rfq_product_name')}}" value="{{$rfq->rfq_type}}" style="border:0px!important;">
                                             </section>
                                         </div>
                                          <div class="row">
                                              <section class="col-md-4 col-sm-4 col-xs-12">
                                                  <label class="control-label">
                                                      {{Lang::get('user.rfq_product_name')}}
                                                      <span style="color: red">*</span>
                                                  </label>
                                              </section>
                                              <section class="col-md-8 col-sm-8 col-xs-12">
                                                  <input type="text" name="product_name" class="form-control" readonly placeholder="{{Lang::get('user.rfq_product_name')}}" value="{{$rfq->rfq_title}}">
                                               </section>
                                          </div>
                                          <div class="row">
                                              <section class="col-md-4 col-sm-4 col-xs-12">
                                                  <label class="control-label">
                                                      {{Lang::get('user.rfq_product_description')}}
                                                      <span style="color: red">*</span>
                                                  </label>
                                              </section>
                                              <section class="col-md-8 col-sm-8 col-xs-12">
                                                  <textarea name="product_description" class="form-control" readonly  placeholder="{{Lang::get('user.rfq_product_description')}}" rows="5">{{$rfq->rfq_description}}</textarea>
                                               </section>
                                          </div>
                                          <?php  if($rfq->rfq_type == "detailed"){
                                              $i=0;
                                              foreach($rfq->rfqSpecifications as $value){?>
                                                  <div class="row" id="specificationDiv">
                                                       <label class="col-md-4 col-sm-4 col-xs-12">{{Lang::get('user.specification_description')}}</label>
                                                       <div class="col-md-8 col-sm-8 col-xs-12">
                                                          <textarea name="rfq_specificationdescription<?php echo $i;?>" class="form-control col-md-12 margin-bottom-10" id="sepecial_description_textarea<?php echo $i;?>" <?php if($value->rfq_alternative_ok == "0"){echo "readonly";}?> style="<?php if($value->rfq_alternative_ok == "0"){echo "color:green";}?>"><?php echo  $value->rfq_description?></textarea>
                                                          <input type="hidden" value="{{$value->id}}" id="specification<?php echo $i;?>" name="specificationID<?php echo $i;?>">
                                                           <section style="margin-top:10px;">
                                                               <div id="previewNewsImageBuy<?php echo $i?>" class="previewMultiImage">
                                                                  <?php
                                                                      foreach ($value->specificationPicture as $value1){?>
                                                                          <div class="img-wrap gallery-item">
                                                                           <a href="{{HTTP_LOGO_PATH.$value1->picture_url}}" rel="gallery1" class="fancybox img-hover-v1">
                                                                              <span><img class="img-responsive" src="{{HTTP_LOGO_PATH.$value1->picture_url}}" alt=""></span>
                                                                            </a>
                                                                         </div>
                                                                     <?php }
                                                                  ?>
                                                               </div>

                                                           </section>
                                                        </div>
                                                  </div>
                                                <?php  $i++;}} ?>
                                                <div class="row">
                                                    <section class="col-md-4 col-sm-4 col-xs-12">
                                                        <label class="control-label">
                                                            {{Lang::get('user.rfq_product_pictures')}}
                                                            <span style="color: red">*</span>
                                                        </label>
                                                    </section>
                                                     <section class="col-md-8 col-sm-8 col-xs-12">
                                                         <div id="previewNewsImageBuy" class="previewMultiImage" >
                                                             @foreach($rfq->rfqImage as $value)
                                                                <div class="img-wrap gallery-item">
                                                                 <a href="{{HTTP_LOGO_PATH.$value->picture_url}}" rel="gallery1" class="fancybox img-hover-v1">
                                                                    <span><img class="img-responsive" src="{{HTTP_LOGO_PATH.$value->picture_url}}" alt=""></span>
                                                                  </a>

                                                               </div>
                                                            @endforeach
                                                         </div>
                                                     </section>
                                                </div>
                                                <div class="row">
                                                    <section class="col-md-4 col-sm-4 col-xs-12">
                                                        <label class="control-label">
                                                            {{Lang::get('user.rfq_request_file')}}
                                                        </label>
                                                    </section>
                                                    <section class="col-md-8 col-sm-8 col-xs-12">
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
                                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                                        <label class="control-label">
                                                            {{Lang::get('user.purchase_quantity')}}
                                                            <span style="color: red">*</span>
                                                        </label>
                                                    </section>
                                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                                        <input type="text" name="purchase_quantity" class="form-control" placeholder="{{Lang::get('user.purchase_quantity')}}" value="{{$rfq->rfq_quantity}}" readonly>
                                                    </section>
                                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                                          <input type="text" value="{{$rfq->unit->unitname}}" class="form-control" readonly>
                                                    </section>
                                                </div>
                                                <div class="row extra-margin-bottom-20">
                                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                                        <label class="control-label">
                                                            {{Lang::get('user.item_price')}}
                                                            <span style="color: red">*</span>
                                                        </label>
                                                    </section>
                                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                                        <input type="text" name="item_price" class="form-control" placeholder="{{Lang::get('user.item_price')}}" value="{{$rfq->rfq_unitprice}}" readonly>
                                                    </section>
                                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                                         <input type="text" value = "{{$currencies->currency_name}}" class="form-control" readonly>
                                                    </section>
                                                </div>
                                      </fieldset>
                                      <fieldset id="sellerContent">
                                        <input type="hidden" name="rfq_id" value="{{$rfq_id}}">
                                        <!-- seller quantity-->
                                            <div class="row">
                                               <section class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label">
                                                        {{Lang::get('user.seller_quantity')}}
                                                        <span style="color: red">*</span>
                                                    </label>
                                               </section>
                                               <section class="col-md-4 col-sm-4 col-xs-6">
                                                    <input type="text" name="seller_quantity" class="form-control" placeholder="{{Lang::get('user.seller_quantity')}}">
                                               </section>
                                               <section class="col-md-4 col-sm-4 col-xs-6">
                                                    <select name="seller_unit" class="form-control">
                                                         @foreach($units as $key=>$unit)
                                                            <option value="{{$unit->id}}">{{$unit->unitname}}</option>
                                                         @endforeach
                                                    </select>
                                               </section>
                                            </div>
                                        <!-- seller price-->
                                           <div class="row">
                                              <section class="col-md-4 col-sm-4 col-xs-12">
                                                   <label class="control-label">
                                                       {{Lang::get('user.seller_price')}}
                                                       <span style="color: red">*</span>
                                                   </label>
                                              </section>
                                              <section class="col-md-4 col-sm-4 col-xs-6">
                                                   <input type="text" name="seller_price" class="form-control" placeholder="{{Lang::get('user.seller_price')}}">
                                              </section>
                                              <section class="col-md-4 col-sm-4 col-xs-6">
                                                   {{ Form::select('currency'
                                                    ,array('' => 'Select Currency ') +  $currencies->lists('currency_name', 'id')
                                                    , null
                                                    , array('class' => 'form-control','name'=>'seller_currency')) }}
                                              </section>
                                           </div>
                                           <div class="row">
                                              <section class="col-md-4 col-sm-4 col-xs-12">
                                                   <label class="control-label">
                                                       {{Lang::get('user.sample_price')}}
                                                   </label>
                                              </section>
                                              <section class="col-md-4 col-sm-4 col-xs-6">
                                                  <input type="text" name="sample_price" class="form-control" placeholder="{{Lang::get('user.sample_price')}}" id="sample_price">
                                              </section>
                                              <section class="col-md-4 col-sm-4 col-xs-6">
                                                     {{ Form::select('currency'
                                                      ,array('' => 'Select Currency ') +  $currencies->lists('currency_name', 'id')
                                                      , null
                                                      , array('class' => 'form-control','name'=>'sample_currency', 'id' =>'sample_currency')) }}
                                                </section>
                                           </div>
                                           <div class="row">
                                                <section class="col-md-4 col-sm-4 col-xs-12">
                                                       <label class="control-label">
                                                           {{Lang::get('user.seller_pictures')}}
                                                       </label>
                                                </section>
                                                <section class="col-md-8 col-sm-8 col-xs-12">
                                                    <form action="{{URL::route('user.seller.specificationPicutre')}}" id="post_buyer_imageForm" method="post"  enctype="multipart/form-data" class="specificationPictureForm">
                                                         <input type="file" name="file_upload" id="imageUploadPostBuy" style="display: inline-block">
                                                         <input type="hidden" name="imagePrevDiv" value="previewNewsImageSeller"  id="imagePrevDiv">
                                                          <span style="color:red; font-size:10px;" class="normal">{{Lang::get('user.rfq_mulitple_image_upload')}}</span>
                                                         <div id="previewNewsImageSeller" class="previewMultiImage" >
                                                         </div>
                                                     </form>
                                                </section>
                                           </div>
                                           <div class="row">
                                                <section class="col-md-4 col-sm-4 col-xs-12">
                                                       <label class="control-label">
                                                           {{Lang::get('user.seller_description')}}
                                                       </label>
                                                </section>
                                                <section class="col-md-8 col-sm-8 col-xs-12">
                                                    <textarea class="form-control" name="seller_description" placeholder="{{Lang::get('user.seller_description')}}" rows="5"></textarea>
                                                </section>
                                           </div>
                                           <div class="row" id="noteToBuyer">
                                                <section class="col-md-4 col-sm-4 col-xs-12">
                                                   <label class="control-label">
                                                       {{Lang::get('user.note_to_buyer')}}
                                                   </label>
                                                </section>
                                                <section class="col-md-8 col-sm-8 col-xs-12">
                                                    <textarea class="form-control" name="noteToText0" placeholder="{{Lang::get('user.note_to_buyer')}}" rows="5" id="noteToText0"></textarea>
                                                </section>
                                           </div>
                                           <div class="row extra-margin-bottom-20" id="addSpecificationDiv">
                                               <div class="col-md-4 col-md-offset-8 col-sm-4 col-sm-offset-8 col-xs-6 col-xs-offset-3">
                                                   <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick="addSpecificationDiv()" style="float: right">{{Lang::get('user.add')}}</a>
                                               </div>
                                           </div>

                                            <div class="row">
                                                <section class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                                    <a class="btn-u btn-u-blue" href="javascript:void(0)" onclick="onSaveSubmit(this)"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>{{Lang::get('user.save')}}</a>
                                                    <a class="btn-u btn-u-red" href="{{URL::route('user.seller.loginRfq')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>{{Lang::get('user.cancel')}}</a>
                                                </section>
                                            </div>
                                      </fieldset>
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
            <div class="row" id="noteToBuyerClone" style="display: none">
                <section class="col-md-4 col-sm-4 col-xs-12">
                   <label class="control-label">
                       {{Lang::get('user.note_to_buyer')}}
                   </label>
                </section>
                <section class="col-md-8 col-sm-8 col-xs-12">
                    <textarea class="form-control" name="noteToText" placeholder="{{Lang::get('user.note_to_buyer')}}" rows="5" id="noteToText"></textarea>
                </section>
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
            <script type="text/javascript">
                $( document ).ready(function() {
                      App.init();
                      FancyBox.initFancybox();
                      $("input#imageUploadPostBuy").change( function(){
                            var imageUploadObj = $(this);
                            $(this).parent().ajaxForm({
                                success: function(data) {
                                 if(data.result == "success"){
                                    var targetId ='#' + imageUploadObj.parent("form").find("#imagePrevDiv").val();
                                    var htmlObj = "<div class='img-wrap'>" + data.content + "<div class='close-button'></div></div>";
                                    $(targetId).append(htmlObj);
                                    $("#previewNewsImageSeller").find(".img-wrap").each(function(){
                                        $(this).find(".close-button").click(function(){
                                            $(this).parent().remove();
                                        });
                                    });
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
                       });
                });
                function addSpecificationDiv(){
                    var countResultText= $("#sellerContent").find("div#noteToBuyer").size();
                    var obj = $("#noteToBuyerClone").clone();
                    obj.find("textarea").attr("id","noteToText"+countResultText);
                    obj.find("textarea").attr("name","noteToText"+countResultText);
                    obj.attr("id","noteToBuyer");
                    obj.show();
                    $("#sellerContent").find("div#noteToBuyer:last").after(obj);
                }
                function onSaveSubmit(obj){
                    if($("#sample_currency").val() == "" && $("#sample_price").val() !="") {
                        bootbox.alert("{{Lang::get('missing.Please_select_sample_currency')}}");
                        return;
                    }
                    var countResultDiv =  $("#addCategoryFiledForm").find("div#specificationDiv").size();
                    $("div#addCategoryFiledForm").append('<input type="hidden" value="'+countResultDiv+'" name="count_specification" class="forestappend">');
                    var countResultDiv =  $("#addCategoryFiledForm").find("div#noteToBuyer").size();
                    $("div#addCategoryFiledForm").append('<input type="hidden" value="'+countResultDiv+'" name="count_notetobuyer" class="forestappend">');
                    var productpicture = new Array();
                    var imageIndex =0;
                    $("#previewNewsImageSeller").find(".img-wrap").each(function(){
                            productpicture[imageIndex] = $(this).find("img").attr("src");
                            $("div#addCategoryFiledForm").append('<input type="hidden" value="'+productpicture[imageIndex]+'" name="images[]" class="forestappend">');
                            imageIndex ++;
                    });
                    var fileObj =$(obj).parents().find("div#addCategoryFiledForm").eq(0);
                    var base_url = window.location.origin;
                    var postUrl = '{{route("user.seller.quoteStore")}}';
                    var html =  "<form id='file_upload_form' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                    fileObj.wrap(html);
                    fileObj.parent('form#file_upload_form').ajaxForm({
                        success: function(data) {
                          var cnt = fileObj.closest("form#file_upload_form").contents();
                            fileObj.closest("form#file_upload_form").replaceWith(cnt);
                            if(data.result == "failed"){
                                $("div#addCategoryFiledForm").find("input.forestappend").remove();
                                var arr = data.error;
                                var errorList = '';
                                   $.each(arr, function(index, value)
                                   {
                                       if (value.length != 0)
                                       {
                                           errorList = errorList + value+"<br>";
                                       }
                                   });
                                bootbox.alert(errorList);
                            }
                            else if(data.result == "success"){
                                bootbox.alert("{{Lang::get('missing.Quote_saved_successfully')}}");
                                window.location.href= "{{URL::route('user.seller.loginRfq')}}";
                            }
                        }
                    }).submit();
                }
            </script>
         @stop
@stop