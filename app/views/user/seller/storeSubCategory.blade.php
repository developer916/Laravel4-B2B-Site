@extends('user.seller.storeLayout')
@section('custom-styles')
    {{HTML::style('/assets/asset_view/css/blocks.css')}}
    {{HTML::style('/assets/asset_view/css/style.css')}}
    {{ HTML::style('/assets/asset_view/css/video-js.css') }}
    {{ HTML::style('/assets/asset_view/css/video-js.min.css') }}
    {{ HTML::style('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}
    {{ HTML::style('/assets/asset_view/plugins/cube-portfolio/cubeportfolio/css/cubeportfolio.min.css') }}
    {{ HTML::style('/assets/asset_view/plugins/cube-portfolio/cubeportfolio/custom/custom-cubeportfolio.css') }}
@stop
@section('body')
    <?php use QuickDetails as QuickDetailsModel;?>
    <div class="container content">
        <div class="title-box-v2">
            <h2>{{$subcategory->category->categoryname}}</h2>
        </div>
        @include('user.seller.company.slider')
        <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
        <div class="row margin-bottom-20">
            {{--<a href="javascript:void(0)" class="btn-u btn-u-blue" onclick="onAddItemModal()" style="float:right"><i class="fa fa-plus"></i> {{Lang::get('user.add_item')}}</a>--}}
            <a href ="{{ URL::route('user.seller.productCreate', $subcategory->id)  }}" class="btn-u btn-u-blue" style="float:right" target=" _blank"><i class="fa fa-plus"></i> {{Lang::get('user.add_item')}}</a>
        </div>
        <?php }?>
        @include('user.seller.company.subCategory')
    </div>
    <?php if(Session::get('user_id') == ($user_id - 100000)) {?>

    <div class="modal fade" id="editItemModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                    <h4 id="myModalLabel1" class="modal-title">{{Lang::get('user.edit_product')}}</h4>
                </div>
                <div class="modal-body" id="EditItemModalBody">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addQuickDetailModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="z-index:10042" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                    <h4 id="myModalLabel1" class="modal-title">{{Lang::get('user.quick_button')}}</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
     </div>
    <div class="modal fade" id="addItemModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="z-index:1041;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                    <h4 id="myModalLabelItemModal" class="modal-title">{{Lang::get('user.add_item')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal" id="addCategoryFiledFormDiv">
                        <input type="hidden" name="category" value="{{$subcategory->category->id}}">
                        <input type="hidden" name="subcategory" value="{{$subcategory->id}}">
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

                            @if($key === 'product_name' || $key === 'meta' || $key==="min_order" || $key==="supply_ability" )
                                <div class="form-group">
                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">
                                        {{$value}}
                                        <span style="color: red">*</span>
                                    </label>
                                    <?php if($key === 'product_name' || $key === 'meta' ){?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="{{$value}}" class="form-control" name="{{$key}}">
                                    </div>
                                    <?php }else{ ?>
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <input type="text" placeholder="{{$value}}" class="form-control" name="{{$key}}">
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <select name="{{$key."unit"}}" class="form-control">
                                            <option value="">{{Lang::get('missing.Select_Unit')}}</option>
                                            @foreach($unit as $key_unit=>$value_unit)
                                                <option value="{{$value_unit->id}}">{{$value_unit->unitname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <?php }?>
                                </div>
                            @elseif($key === "quick_button")
                                <div class="form-group">
                                    <div class="col-md-10">
                                         <button class="btn-u btn-u-blue" style="float: right" onclick="onShowAddQuickDetail()">{{$value}}</button>
                                        <button class="btn-u btn-u-green" style="float:right;margin-right:10px" onclick="onAddNewQuickDetail()">{{Lang::get('user.new_quick_detail')}}</button>
                                    </div>
                                </div>
                            @elseif($key === "quick_div")
                                <div class="form-group" id="quickDiv">
                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">
                                        {{$value}}
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-horizontal" id="quickDivContent">
                                    </div>
                                </div>
                            @elseif($key === 'product_description')
                                <div class="form-group">
                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">
                                        {{$value}}
                                    </label>
                                    <div  class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea class="form-control" id="description" name="description" cols="50" rows="10"></textarea>
                                    </div>
                                </div>
                            @elseif($key ==='product_price1' || $key ==='product_price2' || $key ==='product_price3' )
                                <div class="form-group">
                                    <label class=" col-md-4 col-sm-4 col-xs-12 control-label">
                                        {{ $value }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <input type="text" placeholder="{{$value}}" class="form-control" name="{{$key}}">
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <select name="{{$key."currency"}}" class="form-control">
                                            <option value="">{{Lang::get('Select_Currency')}}</option>
                                            @foreach($currency as $key_currency=>$value_currency)
                                                <option value="{{$value_currency->id}}">{{$value_currency->currency_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif($key === "additional_category")
                                <div class="form-group" id="addtionalCategoryDiv">
                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">
                                        {{ Form::label($key, $value) }}
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="additionalCategory" class="form-control" onchange="onChangeAdditionalCategory()" id="additionalCategory">
                                            <option value = ""> -- {{Lang::get('missing.Select_Additional_Category')}} -- </option>
                                            @foreach($additionalCategories as $key_category =>$value_category)
                                                <option value="{{$value_category->id}}" >{{$value_category->categoryname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label class=" col-md-4 col-sm-4 col-xs-12 control-label">
                                        {{ Form::label($key, $value) }}
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="file_upload" id="imageUploadPost" style="display: inline-block">
                                        <input type="hidden" id="imagePrevDiv" value="previewNewsImageBuy" name="imagePrevDiv">
                                        <font style="color:red" class="normal">{{Lang::get('missing.multiple_image_upload')}}</font>
                                        <div id="spin1" style ="display:none;" style="margin-top: 15px"></div>
                                        <div id="previewNewsImage" class="previewMultiImage" >
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="form-group" id="size" style="display: none;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">
                                {{Lang::get('missing.Sizes')}}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p>{{Lang::get('missing.size_notification')}}</p>
                                <input type="text" class="form-control margin-bottom-10 changeSize" name="size[]" onchange="onChangeSizeList(this)" id="sizeInput">
                                <p>Example:  2T, 6X, 12, Small, X-Large, 18 months, 14 Tall, 28Wx32L</p>
                            </div>
                        </div>
                        <div class="form-group" id="color" style="display: none;">
                            <label class="col-md-4 col-sm-4 col-xs-12 control-label">
                                {{Lang::get('user.colors')}}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p>{{Lang::get('missing.The_color_of_the_item')}}</p>
                                <input type="text" class="form-control margin-bottom-10 changeSize" name="color[]"  onchange="onChangeColorList(this)" id="colorInput">
                                <p>Example:  Red, Navy Blue, Pink, Green</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                <button   class="btn-u btn-u-blue" type="button" onclick="onSubmitForm()"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>{{Lang::get('user.save')}}</button>
                                <button data-dismiss="modal" class="btn-u btn-u-default" type="button"><i class="fa fa-repeat" style="margin-right:4px"></i>{{Lang::get('user.cancel')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal" id="addQuickDetailFormDiv" style="display: none">
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
    <?php } ?>

    <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                    <h4 id="myModalLabel1" class="modal-title">{{Lang::get('user.company_profile') . " ". Lang::get('user.pictures')}}</h4>
                </div>
                <div class="modal-body">
                    <form action="{{URL::route('user.seller.companyChangePictures')}}" method="post" id="companyChangeForm">
                        <input type="file" name="file_upload" id="imageUploadPostBuy" style="display: inline-block">
                        <input type="hidden" name="company"  value = "{{$user_id}}">
                        <input type="hidden" id="imagePrevDiv" value="previewNewsImageBuy" name="imagePrevDiv">
                        <font style="color:red" class="normal">{{Lang::get('missing.multiple_image_upload')}}</font>
                        <div id="spin1" style ="display:none;" style="margin-top: 15px"></div>
                        <div id="previewNewsImageBuy" class="previewMultiImage" >
                            @foreach($userMakertingPicture as $productPictures)
                                <div class='img-wrap'>
                                    <img src = "{{HTTP_LOGO_PATH.$productPictures->picture_url}}">
                                    <input type='hidden' value='{{$productPictures->picture_url}}' name='image[]'>
                                    <div class='close-button'></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer" style="border:0px">
                            <button data-dismiss="modal" class="btn-u btn-u-default" type="button">{{Lang::get('user.close')}}</button>
                            <button class="btn-u" type= "button" onclick="onSubmitContent()">{{Lang::get('missing.Save_changes')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="row form-group" id="quick_detail_form_group_clone" style="display: none">
        <div class="col-md-4 col-sm-4 col-xs-4">
            <input type="text" name="label_select_question[]" class="form-control">
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <input type="text" name="quickDetails[]" class="form-control">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2">
            <button class="btn-u btn-u-red" onclick="onRemoveThisItem(this)">X</button>
        </div>
    </div>
    <?php } ?>
@stop
@section('custom-scripts')
    {{ HTML::script('/assets/asset_view/js/video.js') }}
    {{ HTML::script('/assets/asset_view/js/video.min.js') }}
    {{ HTML::script('/assets/asset_view/js/app.js') }}
    {{ HTML::script('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.pack.js') }}
    {{ HTML::script('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}
    {{ HTML::script('/assets/asset_view/js/plugins/fancy-box.js') }}
    {{ HTML::script('/assets/asset_view/js/plugins/owl-carousel.js') }}
    {{ HTML::script('/assets/assest_admin/js/spin.js') }}
    {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
    {{ HTML::script('/assets/asset_view/js/plugins/owl-carousel.js') }}
    {{ HTML::script('/assets/asset_view/plugins/cube-portfolio/cubeportfolio/js/jquery.cubeportfolio.min.js') }}
    {{ HTML::script('/assets/asset_view/js/plugins/cube-portfolio/cube-portfolio-4-fw-tx.js') }}

    <script type="text/javascript">
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
        function onChangeSizeList(obj){
            var value = $(obj).val();
            if(value == ""){
                $(obj).remove();
            }else{
                var disc = $(obj).next().val();
                if(disc == ""){
                    $(obj).after('<input type="text" class="form-control margin-bottom-10 changeSize" name="size[]" onchange="onChangeSizeList(this)" id="sizeInput">');
                }
            }
        }
        function onChangeColorList(obj){
            var value = $(obj).val();
            if(value == ""){
                $(obj).remove();
            }else{
                var disc = $(obj).next().val();
                if(disc == "") {
                    $(obj).after('<input type="text" class="form-control margin-bottom-10 changeSize" name="color[]"  onchange="onChangeColorList(this)" id="colorInput">');
                }
            }
        }
        jQuery(document).ready(function() {
            App.init();
            FancyBox.initFancybox();
            OwlCarousel.initOwlCarousel();
            <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
            $("#previewNewsImageBuy").find(".img-wrap").each(function(){
                        $(this).find(".close-button").click(function(){
                            $(this).parent().remove();
                        });
                    });
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
                var postUrl =' {{route("user.seller.companyChangePicture")}}';
                var imageUploadObj = $(this);
                var html =  "<form id='file_upload_form' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                imageUploadObj.wrap(html);
                $(this).parent().ajaxForm({
                    success: function(data) {
                        $("#spin1").css('display','none');
                        var cnt = imageUploadObj.closest("form#file_upload_form").contents();
                        imageUploadObj.closest("form#file_upload_form").replaceWith(cnt);
                        if(data.result == "success"){

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
            $("input#imageUploadPost").change( function(){
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
                var postUrl = '{{ route("user.seller.specificationPicture") }}';
                var imageUploadObj = $(this);
                var html =  "<form id='file_upload_form_image' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                imageUploadObj.wrap(html);
                $(this).parent().ajaxForm({
                    success: function(data) {
                        $("#spin1").css('display','none');
                        var cnt = imageUploadObj.closest("form#file_upload_form_image").contents();
                        imageUploadObj.closest("form#file_upload_form_image").replaceWith(cnt);
                        if(data.result == "success"){

                            var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+ data.url +"' name='image[]'><div class='close-button'></div></div>";
                            $("#previewNewsImage").append(htmlObj);
                            $("#previewNewsImage").find(".img-wrap").each(function(){
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
            $("input#imageUploadPostEdit").change( function(){
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
                var postUrl = '{{route("user.seller.specificationPicture")}}';
                var imageUploadObj = $(this);
                var html =  "<form id='file_upload_form_image_edit' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                imageUploadObj.wrap(html);
                $(this).parent().ajaxForm({
                    success: function(data) {
                        $("#spin1").css('display','none');
                        var cnt = imageUploadObj.closest("form#file_upload_form_image_edit").contents();
                        imageUploadObj.closest("form#file_upload_form_image_edit").replaceWith(cnt);
                        if(data.result == "success"){

                            var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+ data.url +"' name='image[]'><div class='close-button'></div></div>";
                            $("#previewNewsImageEdit").append(htmlObj);
                            $("#previewNewsImageEdit").find(".img-wrap").each(function(){
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
            <?php }?>
            });
        <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
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
        function onEditNewQuickDetail(){
            var obj_clone = $("#quick_detail_form_group_clone").clone();
            var size = $("#quickEditDivContent").find(".form-group").size();
            obj_clone.attr("id","spcificationDescriptionDiv"+size);
            obj_clone.show();
            if(size == 0){
                $("#quickEditDivContent").append(obj_clone);
            }else{
                $("#quickEditDivContent").find("div.form-group:last").after(obj_clone);
            }
        }
        function onRemoveThisItem(obj){
            $(obj).parents('div.form-group').eq(0).remove();
        }
        function onShowAddQuickDetail(){
            $("#addQuickDetailFormDiv").show();
            $("#addCategoryFiledFormDiv").hide();
            $("#alertDangerFadeIn").hide();
        }
        function onShowEditQuickDetail(){
            $("#editQuickDetailFormDiv").show();
            $("#editProductForm").hide();
            $("#alertEditDangerFadeIn").hide();
        }
        function onReturnSecondDiv(){
            $("#editQuickDetailFormDiv").hide();
            $("#editProductForm").show();
            $("#alertEditDangerFadeIn").hide();
        }
        function onReturnFirstDiv(){
            $("#addQuickDetailFormDiv").hide();
            $("#addCategoryFiledFormDiv").show();
            $("#alertDangerFadeIn").hide();
        }
        function onChangeEditQuickDetail(){
            $("#alertDangerFadeIn").hide();
            var selected = [];
            var key = 0;
            $('#editQuickDetailFormDiv input:checked').each(function() {
                selected[key] = $(this).attr('value');
                key++;
            });
            var selectLength = selected.length;
            if(selectLength == 0 ){
                $("#alertEditDangerFadeIn").show();
                return;
            }else{
                var i =0;
                var kk;
                for(i =0; i<selectLength; i++){
                    var kk =0;
                    $('#quickEditDivContent').find("div.form-group input[name='label_select_question[]']").each(function() {
                        if($(this).val() == selected[i]){
                            kk++;
                        }
                    });
                    if(kk == 0){
                        var questionDetail = '<div class="row form-group">'+ '<div class="col-md-4 col-sm-4 col-xs-4">'+'<input type="text" name="label_select_question[]" class="form-control" value="'+ selected[i] +'" style="border:0px!important;" disable>'+'</div>'+'<div class="col-md-6 col-sm-6 col-xs-6">'+'<input type="text" name="quickDetails[]" class="form-control">'+'</div>'+'<div class="col-md-2 col-sm-2 col-xs-2">' + '<button class="btn-u btn-u-red" onclick="onRemoveThisItem(this)">X</button>'+ '</div>'+'</div>' ;
                        $("#quickEditDivContent").append(questionDetail);
                    }

                }
            }
            onReturnSecondDiv();
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
                        var questionDetail = '<div class="row form-group">'+ '<div class="col-md-4 col-sm-4 col-xs-4">'+'<input type="text" name="label_select_question[]" class="form-control" value="'+ selected[i] +'" style="border:0px!important;" disable>'+'</div>'+'<div class="col-md-6 col-sm-6 col-xs-6">'+'<input type="text" name="quickDetails[]" class="form-control">'+'</div>'+'<div class="col-md-2 col-sm-2 col-xs-2">' + '<button class="btn-u btn-u-red" onclick="onRemoveThisItem(this)">X</button>'+ '</div>'+'</div>' ;
                        $("#quickDivContent").append(questionDetail);
                    }

                }
            }
            $("#addQuickDetailFormDiv").hide();
            $("#addCategoryFiledFormDiv").show();

        }
        function onChangeCompanyLogoPicture(company){
            $("#myModal").modal('show');
        }
        function onSubmitContent(){
            $("#companyChangeForm").ajaxForm({
                success:function(data){
                    $("#myModal").modal('hide');
                    if(data.result == "success"){
                        bootbox.alert("{{Lang::get('missing.your_company_picture_has_been_saved_successfully') }}");
                        window.location.reload();
                    }else{
                        window.location.reload();
                    }
                }
            }).submit();
        }
        function onSubmitForm(){

            var base_url = window.location.origin;
            var postUrl = '{{ route("user.seller.productStore") }}';
            var imageUploadObj = $("#addCategoryFiledFormDiv");
            var html =  "<form id='file_upload_product_store' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
            imageUploadObj.wrap(html);
            $("#addCategoryFiledFormDiv").parent().ajaxForm({
                success:function(data){
                    $("#addItemModel").modal('hide');
                    var cnt = imageUploadObj.closest("form#file_upload_product_store").contents();
                    imageUploadObj.closest("form#file_upload_product_store").replaceWith(cnt);
                    if(data.result == "success"){

                        bootbox.alert("{{Lang::get('missing.Your_product_has_been_saved_successfully')}}");
                        window.location.reload();
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
        function onSubmitEditForm(){
            var base_url = window.location.origin;
            var postUrl = '{{ route("user.seller.productStore") }}';
            var imageUploadObj = $("#editProductForm");
            var html =  "<form id='file_edit_upload_product_store' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
            imageUploadObj.wrap(html);
            $("#editProductForm").parent().ajaxForm({
                success:function(data){
                    $("#editItemModel").modal('hide');
                    var cnt = imageUploadObj.closest("form#file_edit_upload_product_store").contents();
                    imageUploadObj.closest("form#file_edit_upload_product_store").replaceWith(cnt);
                    if(data.result == "success"){

                        bootbox.alert("{{Lang::get('missing.Your_product_has_been_saved_successfully') }}");
                        window.location.reload();
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
        function onAddItemModal(){
            $("#addItemModel").modal('show');
        }
        function onEditProduct(id){
            var base_url = window.location.origin;
            $.ajax ({
                url: '{{route("user.seller.get.productlist")}}',
                type: 'POST',
                data: { id:id},
                cache: false,
                dataType: "json",
                success: function (data) {
                    if(data.result =="success"){
                        $("#EditItemModalBody").html(data.list);
                        $("#previewNewsImageEdit").find(".img-wrap").each(function(){
                            $(this).find(".close-button").click(function(){
                                $(this).parent().remove();
                            });
                        });
                        $("input#imageUploadPostEdit").change( function(){
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
                            var postUrl = base_url + '/seller/product/specificationPicture';
                            var imageUploadObj = $(this);
                            var html =  "<form id='file_upload_form_image_edit' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                            imageUploadObj.wrap(html);
                            $(this).parent().ajaxForm({
                                success: function(data) {
                                    $("#spin1").css('display','none');
                                    if(data.result == "success"){
                                        var cnt = imageUploadObj.closest("form#file_upload_form_image_edit").contents();
                                        imageUploadObj.closest("form#file_upload_form_image_edit").replaceWith(cnt);
                                        var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+ data.url +"' name='image[]'><div class='close-button'></div></div>";
                                        $("#previewNewsImageEdit").append(htmlObj);
                                        $("#previewNewsImageEdit").find(".img-wrap").each(function(){
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
                        $("#editItemModel").modal('show');
                    }
                }
            });
        }
        <?php }?>
    </script>
@stop
@stop