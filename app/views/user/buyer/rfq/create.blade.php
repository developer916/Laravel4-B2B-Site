@extends('user.buyer.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
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
                                         <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
                                              <div class="inline-group">
                                                     <label class="radio"><input type="radio" name="rfq_type" onchange="onSellerChange()" value="standard"  checked><i class="rounded-x"></i><p class="headerPetrob">{{Lang::get('user.standard')}}</p></label>
                                                     <label class="radio"><input type="radio" name="rfq_type" onchange="onBuyerChange()" value="detailed"><i class="rounded-x"></i><p class="headerPetrob">{{Lang::get('user.detailed')}}</p></label>
                                              </div>
                                         </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <section class="col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label">
                                                {{Lang::get('user.rfq_product_name')}}
                                                <span style="color: red">*</span>
                                            </label>
                                        </section>
                                        <section class="col-md-8 col-sm-8 col-xs-12">
                                            <input type="text" name="product_name" class="form-control" placeholder="{{Lang::get('user.rfq_product_name')}}">
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
                                            <textarea name="product_description" class="form-control" placeholder="{{Lang::get('user.rfq_product_description')}}" rows="5"></textarea>
                                         </section>
                                    </div>
                                    <!-- specification-->
                                    <div class="row" id="specificationDiv" style="display: none">
                                        <label class="col-md-4 col-sm-4 col-xs-12">{{Lang::get('user.specification_description')}}</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <textarea name="rfq_specificationdescription0" class="form-control col-md-12" id="sepecial_description_textarea0" placeholder="{{Lang::get('user.specification_description')}}"></textarea>
                                            <div class="row col-md-12 checkbox-inline " style="margin-top:10px;">
                                                <label class="checkbox">
                                                    <input type="checkbox" id="allowAlternativeBuy0" style="margin-left:10px"  value="1"><i></i><p class="headerPetrob">{{Lang::get('user.allow_alternative')}}</p>
                                                </label>
                                            </div>
                                            <section style="margin-top:10px;">
                                                <form action="{{URL::route('user.buyer.specificationPicutre')}}" id="post_buyer_imageForm" method="post"  enctype="multipart/form-data" class="specificationPictureForm">
                                                    <input type="file" name="file_upload"  style="display:inline-block" id="fileupload" >
                                                    <input type="hidden" name="imagePrevDiv" value="previewNewsImageBuy0"  id="imagePrevDiv">
                                                     <font style="color:red;font-size: 10px" class="normal">{{Lang::get('user.rfq_mulitple_image_upload')}}</font>
                                                    <div id="previewNewsImageBuy0" class="previewMultiImage">
                                                    </div>
                                                </form>

                                            </section>
                                        </div>
                                    </div>
                                    <!-- end-->
                                    <div class="row extra-margin-bottom-20" id="addSpecificationDiv" style="display: none">
                                        <div class="col-md-4 col-md-offset-8 col-sm-4 col-sm-offset-8 col-xs-6 col-xs-offset-3">
                                            <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick="addSpecificationDiv()" style="float: right">{{Lang::get('user.add')}}</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <section class="col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label">
                                                {{Lang::get('user.rfq_product_pictures')}}
                                                <span style="color: red">*</span>
                                            </label>
                                        </section>
                                         <section class="col-md-8 col-sm-8 col-xs-12">
                                            <form action="{{URL::route('user.buyer.specificationPicutre')}}" id="post_buyer_imageForm" method="post"  enctype="multipart/form-data" class="specificationPictureForm">
                                                 <input type="file" name="file_upload" id="imageUploadPostBuy" style="display: inline-block">
                                                 <input type="hidden" id="imagePrevDiv" value="previewNewsImageBuy" name="imagePrevDiv">
                                                  <font style="color:red; font-size:10px;" class="normal">{{Lang::get('user.rfq_mulitple_image_upload')}}</font>
                                                 <div id="previewNewsImageBuy" class="previewMultiImage" >
                                                 </div>
                                             </form>
                                         </section>
                                    </div>
                                    <div class="row">
                                        <section class="col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label">
                                                {{Lang::get('user.rfq_request_file')}}
                                            </label>
                                        </section>
                                        <section class="col-md-8 col-sm-8 col-xs-12">
                                            <form action="{{URL::route('user.buyer.file')}}" id="post_buyer_pdf_Form" method="post" enctype="multipart/form-data" class="specificationPictureForm">
                                                <input type="file" name="file" id="pdfFileUploadPostBuy" style="display: inline-block"  >
                                                <input type="hidden" id="imagePrevDiv" value="previewNewsFileBuy" name="imagePrevDiv">
                                                <font style="color:red;font-size: 10px" class="normal">{{Lang::get('user.rfq_pdf_doc_txt')}}</font>
                                                <div id="previewNewsFileBuy" class="previewMultiFile">
                                                </div>
                                            </form>
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
                                            <input type="text" name="purchase_quantity" class="form-control" placeholder="{{Lang::get('user.purchase_quantity')}}">
                                        </section>
                                        <section class="col-md-4 col-sm-4 col-xs-6">
                                              <select name="quantity_unit" class="form-control">
                                                    {{--<option  value="Kg">Kg</option>--}}
                                                    {{--<option  value="Piece">Piece</option>--}}
                                                    {{--<option  value="Dozen">Dozen</option>--}}
                                                    @foreach($units as $key=>$unit)
                                                        <option value="{{$unit->id}}">{{$unit->unitname}}</option>
                                                    @endforeach
                                                </select>
                                        </section>
                                    </div>
                                    <div class="row extra-margin-bottom-20">
                                        <section class="col-md-4 col-sm-4 col-xs-6">
                                            <label class="control-label">
                                                {{Lang::get('user.item_price')}}
                                            </label>
                                        </section>
                                        <section class="col-md-4 col-sm-4 col-xs-6">
                                            <input type="text" name="target_price" class="form-control" placeholder="{{Lang::get('user.item_price')}}">
                                        </section>
                                        <section class="col-md-4 col-sm-4 col-xs-6">
                                             {{ Form::select('currency'
                                             ,array('' => 'Select Currency ') +  $currencies->lists('currency_name', 'id')
                                             , null
                                             , array('class' => 'form-control','name'=>'currency')) }}
                                        </section>
                                    </div>
                                    <div class="row">
                                        <section class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                            <button   class="btn-u btn-u-blue" type="button"  onclick="onSaveRFQ(this)"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>{{Lang::get('user.save')}}</button>
                                            <a class="btn-u btn-u-red" href="{{URL::route('user.buyer.rfq')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>{{Lang::get('user.cancel')}}</a>
                                        </section>
                                    </div>
                                </fieldset>
                            </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
        <div class="row" id="specificationDivClone" style="display: none" >
            <label class="col-md-4 col-sm-4 col-xs-12">{{Lang::get('user.specification_description')}}</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <textarea name="rfq_specificationdescription" class="form-control col-md-12" placeholder="{{Lang::get('user.specification_description')}}"></textarea>
                <div class="row col-md-12 checkbox-inline " style="margin-top:10px;">
                   <label class="checkbox">
                       <input type="checkbox" id="allowAlternativeBuy" style="margin-left:10px"  value="1"><i></i><p class="headerPetrob">{{Lang::get('user.allow_alternative')}}</p>
                   </label>
                </div>
                <section style="margin-top:10px;">
                    <form action="{{URL::route('user.buyer.specificationPicutre')}}" id="post_buyer_imageForm" method="post"  enctype="multipart/form-data" class="specificationPictureForm">
                        <input type="file" name="file_upload"  style="display:inline-block" id="fileupload" >
                        <input type="hidden" name="imagePrevDiv" value="previewNewsImageBuy0"  id="imagePrevDiv">
                         <font style="color:red;font-size: 10px" class="normal">{{Lang::get('user.rfq_mulitple_image_upload')}}</font>
                        <div id="previewNewsImageBuy" class="previewMultiImage">
                        </div>
                    </form>
                </section>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js') }}
        {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') }}
        {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') }}
        {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.maskedinput.min.js') }}
        {{ HTML::script('/assets/asset_view/js/forms/checkout.js') }}
        <script>
            function onSellerChange(){
                $("#addCategoryFiledForm").find("div#specificationDiv").hide();
                $("#addCategoryFiledForm").find("div#addSpecificationDiv").hide();
            }
            function onBuyerChange(){
                $("#addCategoryFiledForm").find("div#specificationDiv").show();
                $("#addCategoryFiledForm").find("div#addSpecificationDiv").show();

            }
            function onSaveRFQ(obj){
                bootbox.confirm({
                    message: "{{Lang::get('missing.do_you_want_to_create_RFQ')}}",
                    buttons: {
                        confirm: {
                            label: '{{Lang::get('user.yes')}}',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: '{{Lang::get('user.no')}}',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result === false){
                            return;
                        }else{
                            var productpicture = new Array();
                            var productfile = new Array();
                            var imageIndex =0;
                            var RFQ_Type = $("input:radio[name=rfq_type]:checked").val();
                            $("#previewNewsImageBuy").find(".img-wrap").each(function(){
                                // productpicture[imageIndex] = $(this).find("img").attr("src");
                                productpicture[imageIndex] = $(this).find("input").val();
                                $("div#addCategoryFiledForm").append('<input type="hidden" value="'+productpicture[imageIndex]+'" name="images[]" class="forestappend">');
                                imageIndex ++;
                            });
                            var imageIndex1 =0;
                            $("#previewNewsFileBuy").find(".fileItemList").each(function(){
                                productfile[imageIndex1] = new Array();
                                productfile[imageIndex1][0] = $(this).find("input#files_list").val();
                                productfile[imageIndex1][1] = $(this).find("span.fileName").text();
                                productfile[imageIndex1][2] = $(this).find("input#forestchange").val();
                                $("div#addCategoryFiledForm").append('<input type="hidden" value="'+productfile[imageIndex1]+'" name="files[]" class="forestappend">');
                                imageIndex1++;
                            });

                            if(RFQ_Type == "detailed"){
                                var imageIndex = 0;
                                var specification_description = new Array();
                                var specification_descrition_pictures = new Array();
                                var specification_allowAlternative = new Array();
                                var countResultDiv = 0;
                                var countResultDiv =  $("#addCategoryFiledForm").find("div#specificationDiv").size();
                                for(var i=0; i<countResultDiv; i++){
                                    var contents=$("#sepecial_description_textarea"+i).val();
                                    specification_description[i] = contents;
                                    $("div#addCategoryFiledForm").append('<input type="hidden" value="'+specification_description[i]+'" name="specification_description[]" class="forestappend">');
                                    var valueAllowAlternative = $("#allowAlternativeBuy"+i+":checked").val();
                                    if(valueAllowAlternative == "1") {
                                        specification_allowAlternative[i] =1;
                                    }else{
                                        specification_allowAlternative[i] =0;
                                    }
                                    $("div#addCategoryFiledForm").append('<input type="hidden" value="'+specification_allowAlternative[i]+'" name="specification_allowAlternative[]" class="forestappend">');
                                    specification_descrition_pictures[i]=[];
                                    var imageIndex =0;
                                    $("#previewNewsImageBuy"+i).find(".img-wrap").each(function(){
                                        //specification_descrition_pictures[i][imageIndex] = $(this).find("img").attr("src");
                                        specification_descrition_pictures[i][imageIndex] = $(this).find("input").val();
                                        imageIndex ++;
                                    });
                                    $("div#addCategoryFiledForm").append('<input type="hidden" value="'+specification_descrition_pictures[i]+'" name="specification_descrition_pictures[]" class="forestappend">');
                                }
                            }
                            var fileObj =$(obj).parents().find("div#addCategoryFiledForm").eq(0);
                            var postUrl ='{{URL::route("user.buyer.store")}}';
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
                                        bootbox.alert("{{Lang::get('missing.RFQ_saved_successfully')}}");
                                        window.location.href= "{{URL::route('user.buyer.rfq')}}";
                                    }

                                }
                            }).submit();
                        }
                    }
                });
            }
             jQuery(document).ready(function() {
                   CheckoutForm.initCheckoutForm();
                   var countSpecialList=0;
                  $("input#fileupload").each(function() {

                       var specificationImageUploadObj = $(this);
                       specificationImageUploadObj.unbind('change').bind('change', function(){
                           $(this).parent().ajaxForm({
                               success: function(data) {
                                   if(data.result == "success"){
                                       var targetId ='#' + specificationImageUploadObj.parent().find("#imagePrevDiv").val();
                                       var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+data.url+"'>" + "<div class='close-button'></div></div>";
                                       $(targetId).append(htmlObj);
                                       $(targetId).find(".img-wrap").each(function(){
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
                       $("#previewNewsImageBuy"+countSpecialList).find("div.img-wrap").each(function(){
                           $(this).find("div.close-button").click(function(){
                               $(this).parent().remove();
                           });
                       });
                       countSpecialList++;
                  });
                  $("input#imageUploadPostBuy").change( function(){
                      var imageUploadObj = $(this);
                      $(this).parent().ajaxForm({
                          success: function(data) {
                           if(data.result == "success"){
                              var targetId ='#' + imageUploadObj.parent("form").find("#imagePrevDiv").val();
                              var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+data.url+"'>" +"<div class='close-button'></div></div>";
                              $(targetId).append(htmlObj);
                              $("#previewNewsImageBuy").find(".img-wrap").each(function(){
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
                 $("input#pdfFileUploadPostBuy").change(function(){
                    var fileUploadObj =$(this);
                    $(this).parent().ajaxForm({
                        success:function(data){
                            if(data.result =="success"){
                              var targetId ='#' + fileUploadObj.parent("form").find("#imagePrevDiv").val();
                              var htmlObj = "<div class='fileItemList'>"+data.content +"<div class='close-button'></div></div>";
                              $(targetId).append(htmlObj);
                              $("#previewNewsFileBuy").find("div.fileItemList").each(function(){
                                  $(this).find("div.close-button").click(function(){
                                      $(this).parent().remove();
                                  });
                              });
                            }else if(data.result=="failed"){
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
                    var contentSize = $("#addCategoryFiledForm").find("div#specificationDiv").size();
                    var obj = $("#specificationDivClone").clone();
                    obj.find("textarea").attr("id","sepecial_description_textarea"+contentSize);
                    obj.find("textarea").attr("name","rfq_specificationdescription"+contentSize);
                    obj.find("input#allowAlternativeBuy").attr("id","allowAlternativeBuy"+contentSize);
                      obj.find("input#imagePrevDiv").val("previewNewsImageBuy"+contentSize);
                    obj.find("div#previewNewsImageBuy").attr("id","previewNewsImageBuy"+contentSize);
                    obj.attr("id","specificationDiv");
                    obj.show();
                    $("#addCategoryFiledForm").find("div#specificationDiv:last").after(obj);


                    $("input#fileupload").each(function() {
                          $(this).unbind('change').bind('change', function(){
                              var specificationImageUploadObj = $(this);
                              $(this).parent().ajaxForm({
                                  success: function(data) {
                                      var targetId ='#' + specificationImageUploadObj.parent().find("#imagePrevDiv").val();
                                      var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+data.url+"'>"+ "<div class='close-button'></div></div>";
                                      $(targetId).append(htmlObj);

                                      $(targetId).find(".img-wrap").each(function(){
                                          $(this).find(".close-button").click(function(){
                                              $(this).parent().remove();
                                          });
                                      });
                                  }
                              }).submit();
                          });
                      });
                }
        </script>
    @stop
@stop