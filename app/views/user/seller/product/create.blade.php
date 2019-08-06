@extends('user.seller.layout')
     @section('custom-styles')
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
    @stop
    @section('body-right')
        <?php use QuickDetails as QuickDetailsModel;?>
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 favoriteContentBody">
                     <div class="panel  margin-bottom-40 change-panel">
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
                           <div class=" form-horizontal sky-form" id="addProductFiledForm" style="border:0px" enctype="multipart/form-data">
                               <input type="hidden" name="category" value="{{$subcategory->category->id}}">
                               <input type="hidden" name="subcategory" value="{{$subcategory->id}}">
                               <fieldset>
                                    @foreach ([
                                           'product_name' => Lang::get('user.rfq_product_name'),
                                            'product_description' => Lang::get('user.rfq_product_description'),
                                             'quick_div' => Lang::get('user.quick_details'),
                                            'quick_button' => Lang::get('user.quick_button'),
                                            'meta' => Lang::get('user.product_meta'),
                                           'product_price1' => Lang::get('user.product_price_1'),
                                           'product_price2' => Lang::get('user.product_price_2'),
                                           'product_price3' => Lang::get('user.product_price_3'),
                                           'min_order'=> Lang::get('user.product_min_order'),
                                           'supply_ability' =>Lang::get('user.product_supply_ability'),
                                           'additional_category' =>Lang::get('user.additional_category')] as $key=> $value)
                                        @if($key === "quick_button")
                                            <div class="row">
                                                <section class="col-md-12 col-sm-12 col-xs-12">
                                                    <button class="btn-u btn-u-blue" style="float: right" onclick="onShowAddQuickDetail()">{{$value}}</button>
                                                    <button class="btn-u btn-u-green" style="float:right;margin-right:10px" onclick="onAddNewQuickDetail()">{{Lang::get('user.blank_detail')}}</button>
                                                </section>
                                            </div>
                                       @elseif($key === "quick_div")
                                            <div class="row" id="quickDiv">
                                                <section class="col-md-4 col-sm-4 col-xs-12">
                                                    {{$value}}
                                                </section>
                                                <section class="col-md-8 col-sm-8 col-xs-12" id="quickDivContent">

                                                </section>
                                            </div>
                                       @elseif($key === "additional_category")
                                           <div class="form-group" id="addtionalCategoryDiv">
                                               <label class="col-md-4 col-sm-4 col-xs-12">
                                                   {{ Form::label($key, $value) }}
                                               </label>
                                               <div class="col-md-8 col-sm-8 col-xs-12">
                                                   <select name="additionalCategory" class="form-control" onchange="onChangeAdditionalCategory()" id="additionalCategory">
                                                       <option value = ""> -- Select Additional Category -- </option>
                                                       @foreach($additionalCategories as $key_category =>$value_category)
                                                           <option value="{{$value_category->id}}" >{{$value_category->categoryname}}</option>
                                                       @endforeach
                                                   </select>
                                               </div>
                                           </div>
                                       @elseif($key ==="price_freight")
                                            <div class="form-group" id="prices">
                                                <label class="col-md-4 col-sm-4 col-xs-12">
                                                    {{ Form::label($key, $value) }}
                                                </label>
                                            </div>
                                        @elseif($key === 'product_name' || $key === 'meta' || $key==="min_order" || $key==="supply_ability" )
                                            <div class="row">
                                                <section class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label">
                                                         {{ Form::label($key, $value) }}
                                                         <?php if($key == 'product_name' || $key == 'meta' || $key==="min_order" || $key==="supply_ability") {?>
                                                        <span style="color: red">*</span>
                                                        <?php } ?>
                                                    </label>
                                                </section>
                                                <?php if($key === 'product_name' || $key === 'meta' ){?>
                                                <section class="col-md-8 col-sm-8 col-xs-12">
                                                    {{ Form::text($key, null, ['class' => 'form-control','placeholder'=>$value]) }}
                                                 </section>
                                                 <?php }else{ ?>
                                                 <section class="col-md-4 col-sm-4 col-xs-6">
                                                     {{ Form::text($key, null, ['class' => 'form-control','placeholder'=>$value]) }}
                                                  </section>
                                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                                        {{ Form::select($key
                                                            ,array('' => ' --- Select Unit --- ') +  $unit->lists('unitname', 'id')
                                                            , null
                                                            , array('class' => 'form-control','name'=>$key.'unit')) }}
                                                     </section>
                                                 <?php } ?>
                                            </div>
                                        @elseif($key === 'product_description')
                                            <div class="row">
                                                <section class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label">
                                                         {{ Form::label($key, $value) }}
                                                    </label>
                                                </section>
                                                <section class="col-md-8 col-sm-8 col-xs-12">
                                                    <textarea class="form-control" id="description" name="description" cols="50" rows="10" placeholder="{{$value}}"></textarea>
                                                 </section>
                                            </div>
                                         @elseif($key ==='product_price1' || $key ==='product_price2' || $key ==='product_price3' )
                                            <div class="row">
                                                <section class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label">
                                                         {{ Form::label($key, $value) }}
                                                                <span style="color: red">*</span>
                                                    </label>
                                                </section>
                                                <section class="col-md-4 col-sm-4 col-xs-6">
                                                     {{ Form::text($key, null, ['class' => 'form-control','placeholder'=>$value]) }}
                                                 </section>
                                                 <section class="col-md-4 col-sm-4 col-xs-6">
                                                    {{ Form::select($key
                                                        ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                        , null
                                                        , array('class' => 'form-control','name'=>$key.'currency')) }}
                                                 </section>
                                            </div>
                                            <?php $checkPriceIndex = 0;?>
                                            @if($key === 'product_price1')
                                               <?php $checkPriceIndex = 1;?>
                                            @elseif($key ==='product_price2')
                                               <?php $checkPriceIndex = 2;?>
                                            @elseif($key ==='product_price3')
                                               <?php $checkPriceIndex = 3;?>
                                            @endif
                                            <div class="row">
                                                <section class="col-md-offset-4 col-sm-offset-4 col-md-8 col-sm-8 col-xs-12">
                                                     <div class="inline-group margin-bottom-30">
                                                         <label class="radio padding-top-0"><input type="radio" name="shipping{{$checkPriceIndex}}" checked="" value= "1" onchange="onChangeShipping(<?php echo $checkPriceIndex;?>,1)"><i class="rounded-x"></i><span>{{Lang::get('user.normal')}}</span></label>
                                                         <label class="radio padding-top-0"><input type="radio" name="shipping{{$checkPriceIndex}}" value= "2" onchange="onChangeShipping(<?php echo $checkPriceIndex;?>,2)"><i class="rounded-x"></i><span>{{Lang::get('user.free_shipping')}}</span></label>
                                                         <label class="radio padding-top-0"><input type="radio" name="shipping{{$checkPriceIndex}}" value= "3" onchange="onChangeShipping(<?php echo $checkPriceIndex;?>,3)"><i class="rounded-x"></i><span>{{Lang::get('user.cargo')}}</span></label>
                                                     </div>
                                                    <div class="row">
                                                        <div class="col-md-12 margin-bottom-20" id="flatRate{{$checkPriceIndex}}">
                                                            <div class="form-group ">
                                                                <label class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.flat_rate')}}</label>
                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <input type="text" class="form-control" name="flatRate{{$checkPriceIndex}}" placeholder="{{Lang::get('user.flat_rate')}}">
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    {{ Form::select($key
                                                                           ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                                           , null
                                                                           , array('class' => 'form-control','name'=>'flatRateCurrency'.$checkPriceIndex)) }}
                                                                </div>
                                                            </div>
                                                            <p>{{Lang::get('user.normal_text')}}</p>
                                                        </div>
                                                        <div class="col-md-12  margin-bottom-20" id="cargoDiv{{$checkPriceIndex}}" style="display: none">
                                                            <p>{{Lang::get('user.cargo_text')}}</p>
                                                        </div>
                                                        <div class="col-md-12 margin-bottom-20">
                                                            <div class="form-group">
                                                                <label class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.estimated_time')}}</label>
                                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                                    <input type="text" class="form-control" name="estimatedTime{{$checkPriceIndex}}" placeholder="eg: 1 week">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                         @else
                                            <div class="row margin-bottom-20">
                                                <section class="col-md-4 col-sm-4 col-xs-12">
                                                    <label class="control-label">
                                                         {{ Form::label($key, $value) }}
                                                    </label>
                                                </section>
                                                <section class="col-md-8 col-sm-8 col-xs-12">
                                                     <input type="file" name="file_upload" id="imageUploadPostBuy" style="display: inline-block">
                                                     <input type="hidden" id="imagePrevDiv" value="previewNewsImageBuy" name="imagePrevDiv">
                                                      <font style="color:red" class="normal">{{Lang::get('missing.multiple_image_upload')}}</font>
                                                      <div id="spin1" style ="display:none;" style="margin-top: 15px"></div>
                                                     <div id="previewNewsImageBuy" class="previewMultiImage" >
                                                     </div>
                                                </section>
                                            </div>
                                        @endif
                                    @endforeach
                                        <div class="form-group" id="size" style="display: none;">
                                            <label class="col-md-4 col-sm-4 col-xs-12 ">
                                                {{Lang::get('missing.Sizes')}}
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <p>{{Lang::get('missing.size_notification')}}</p>
                                                <input type="text" class="form-control margin-bottom-10 changeSize" name="size[]" onchange="onChangeSizeList(this)" id="sizeInput">
                                                <p>Example:  2T, 6X, 12, Small, X-Large, 18 months, 14 Tall, 28Wx32L</p>
                                            </div>
                                        </div>
                                        <div class="form-group" id="color" style="display: none;">
                                            <label class="col-md-4 col-sm-4 col-xs-12 ">
                                                {{Lang::get('user.colors')}}
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <p>{{Lang::get('missing.The_color_of_the_item')}}</p>
                                                <input type="text" class="form-control margin-bottom-10 changeSize" name="color[]"  onchange="onChangeColorList(this)" id="colorInput">
                                                <p>Example:  Red, Navy Blue, Pink, Green</p>
                                            </div>
                                        </div>
                                       <div class="row">
                                             <section class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                                <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick="onSaveProduct()"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>{{Lang::get('user.save')}}</a>
                                                <a class="btn-u btn-u-red" href="{{URL::route('user.seller.storeSubCategory', array(  Session::get('user_id')*1+100000, $subcategory->id ))}}"><i class="fa fa-repeat" style="margin-right:4px"></i>{{Lang::get('user.cancel')}}</a>
                                            </section>
                                       </div>
                                </fieldset>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
        <div class="row form-group" id="quick_detail_form_group_clone" style="display: none">
            <section class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" name="label_select_question[]" class="form-control">
            </section>
            <section class="col-md-6 col-sm-6 col-xs-6">
                <input type="text" name="quickDetails[]" class="form-control">
            </section>
            <section class="col-md-2 col-sm-2 col-xs-2">
                <button class="btn-u btn-u-red" onclick="onRemoveThisItem(this)">X</button>
            </section>
        </div>
        <div class="modal fade" id="addItemModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="z-index:1041;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                        <h4 id="myModalLabelItemModal" class="modal-title">{{Lang::get('user.add_item')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal" id="addQuickDetailFormDiv">
                            <div class="alert alert-danger fade in" style="display: none" id="alertDangerFadeIn">
                                {{Lang::get('user.please_check_quick_details')}}
                            </div>
                            @foreach($quickDetailsCategory as $key_category =>$value_category)
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h3><?php
                                            $category = QuickDetailsModel::getCategory($value_category->category_id);
                                            echo $category->categoryname;?>
                                        </h3>
                                    </div>
                                </div>
                                <?php
                                $lists = QuickDetailsModel::getAll($value_category->category_id);
                                ?>
                                @foreach($lists as $key_list =>$value_key)
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="checkbox" name="quick_details[]" value="{{ucfirst($value_key->quick_details_name);}}"> {{ucfirst($value_key->quick_details_name)}}
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                    <button   class="btn-u btn-u-blue" type="button" onclick="onChangeAddQuickDetail()"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>{{Lang::get('user.save')}}</button>
                                    <button   class="btn-u btn-u-default" type="button" onclick="onReturnFirstDiv()"><i class="fa fa-repeat" style="margin-right:4px"></i>{{Lang::get('user.cancel')}}</button>
                                </div>
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
        {{ HTML::script('/assets/asset_view/js/forms/checkout.js') }}
        {{ HTML::script('/assets/assest_admin/js/spin.js') }}
        {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
        <script type="text/javascript">
            /*****functions on change shipping method *****/
            function onChangeShipping(divID , id){
                if(id == 1){
                    $("#flatRate"+divID).show();
                    $("#cargoDiv"+divID).hide();
                }else if(id == 2){
                    $("#flatRate"+divID).hide();
                    $("#cargoDiv"+divID).hide();
                }else if(id == 3){
                    $("#flatRate"+divID).hide();
                    $("#cargoDiv"+divID).show();
                }
            }
            /*****Additional Category  start*****/
            function onChangeAdditionalCategory(){
                var id = $("#additionalCategory").val();
                if(id ==1){
                    $("#size").show();
                    $("#color").hide();
                }else if(id ==2){
                    $("#size").hide();
                    $("#color").show();
                }else if(id ==3){
                    $("#size").show();
                    $("#color").show();
                }else if(id == 0){
                    $("#size").hide();
                    $("#color").hide();
                }
            }
            function onChangeSizeList(obj) {
                var value = $(obj).val();
                if (value == "") {
                    $(obj).remove();
                } else {
                    var disc = $(obj).next();
                    if(disc.prop("tagName") != "INPUT") {
                        if (disc.val() == "") {
                            $(obj).after('<input type="text" class="form-control margin-bottom-10 changeSize" name="size[]" onchange="onChangeSizeList(this)" id="sizeInput">');
                        }
                    }
                }
            }
            function onChangeColorList(obj) {
                var value = $(obj).val();
                if (value == "") {
                    $(obj).remove();
                } else {
                    var disc = $(obj).next();
                    if(disc.prop("tagName") != "INPUT"){
                        if (disc.val() == "") {
                            $(obj).after('<input type="text" class="form-control margin-bottom-10 changeSize" name="color[]"  onchange="onChangeColorList(this)" id="colorInput">');
                        }
                    }

                }
            }
            function onAddNewQuickDetail(){
                var obj_clone = $("#quick_detail_form_group_clone").clone();
                var size = $("#quickDivContent").find(".form-group").size();
                obj_clone.attr("id","spcificationDescriptionDiv"+size);
                obj_clone.show();
                if(size == 0){
                    $("#quickDivContent").append(obj_clone);
                }else{
                    $("#quickDivContent").find("div.form-group:last").after(obj_clone);
                }
            }
            function onRemoveThisItem(obj){
                $(obj).parents('div.form-group').eq(0).remove();
            }

            function onShowAddQuickDetail(){
                $("#addItemModel").modal('show');
                $("#alertDangerFadeIn").hide();
            }
            function onReturnFirstDiv(){
                $("#addItemModel").modal('hide');
            }

            function onChangeAddQuickDetail(){
                $("#alertDangerFadeIn").hide();
                var selected = [];
                var key = 0;
                $('#addQuickDetailFormDiv input:checked').each(function() {
                    selected[key] = $(this).attr('value');
                    key++;
                });
                var selectLength = selected.length;
                if(selectLength == 0 ){
                    $("#alertDangerFadeIn").show();
                    return;
                }else{
                    var i =0;
                    var kk;
                    for(i =0; i<selectLength; i++){
                        var kk =0;
                        $('#quickDivContent').find("div.form-group input[name='label_select_question[]']").each(function() {
                            if($(this).val() == selected[i]){
                                kk++;
                            }
                        });
                        if(kk == 0){
                            var questionDetail = '<div class="row form-group">'+ '<section class="col-md-4 col-sm-4 col-xs-4">'+'<input type="text" name="label_select_question[]" class="form-control" value="'+ selected[i] +'" style="border:0px!important;" disable>'+'</section>'+'<section class="col-md-6 col-sm-6 col-xs-6">'+'<input type="text" name="quickDetails[]" class="form-control">'+'</section>'+'<section class="col-md-2 col-sm-2 col-xs-2">' + '<button class="btn-u btn-u-red" onclick="onRemoveThisItem(this)">X</button>'+ '</section>'+'</div>' ;
                            $("#quickDivContent").append(questionDetail);
                        }

                    }
                }
                $("#addItemModel").modal('hide');
            }


            function onSaveProduct(){
                var base_url = window.location.origin;
                var postUrl = ' {{ route("user.seller.productStore") }}';
                var imageUploadObj = $("#addProductFiledForm");
                var html =  "<form id='file_upload_product_store' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                imageUploadObj.wrap(html);
                $("#addProductFiledForm").parent().ajaxForm({
                    success:function(data){
                        var cnt = imageUploadObj.closest("form#file_upload_product_store").contents();
                        imageUploadObj.closest("form#file_upload_product_store").replaceWith(cnt);
                        if(data.result == "success"){
                            bootbox.alert("Your product has been saved successfully");
                            window.location.href = data.url;
                        }else{
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
            /*****Additional Category  end*****/
             $(document).ready(function() {
                    $("input#imageUploadPostBuy").change( function(){
                        $("#spin1").css('display','block');
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
                        var base_url = window.location.origin;
                        var postUrl = ' {{ route("user.seller.specificationPicture") }}';
                        var imageUploadObj = $(this);
                        var html =  "<form id='file_upload_form' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                         imageUploadObj.wrap(html);
                        $(this).parent().ajaxForm({
                            success: function(data) {
                            $("#spin1").css('display','none');
                             if(data.result == "success"){
                                var cnt = imageUploadObj.closest("form#file_upload_form").contents();
                                imageUploadObj.closest("form#file_upload_form").replaceWith(cnt);
                                var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+ data.url +"' name='image[]'><div class='close-button'></div></div>";
                                $("#previewNewsImageBuy").append(htmlObj);
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
                });
            function onChangeCategory(){
                $("#spin").css('display','block');
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
                    var categoryID = $("#category").val();
                    var base_url = window.location.origin;
                   $.ajax ({
                        url:' {{ route("user.seller.getSubcategory") }}',
                        type: 'POST',
                        data: {categoryID : categoryID},
                        cache: false,
                        dataType : "json",
                        success: function (data) {
                            $("#spin").css('display','none');
                           if(data.result =="success"){
                               $("#subcategory").find("option").remove();
                               $("#subcategory").append('<option value=""> --- {{Lang::get('missing.Select_Sub_Category')}} --- </option>');
                               if(data.subcategory.length>0){
                                    for(var i=0; i<data.subcategory.length; i++){
                                        $("#subcategory").append('<option value="'+data.subcategory[i]['id']+'">'+data.subcategory[i]['subcategoryname']+'</option>');
                                    }
                                }else{
                                    $("#subcategory").find("option").remove();
                                    $("#subcategory").append('<option value="">--- {{ Lang::get('missing.Select_Sub_Category') }} --- </option>');
                                }
                            }
                        }
                  });
            }

        </script>
    @stop
@stop