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
        <div class="container content">
            <div class="title-box-v2">
                <?php if(isset($companyProfile[0]->companylogo)){?>
                    {{--<img src="{{HTTP_LOGO_PATH.'prxn9YK5SjDH4BYilZZY6FJW.jpg'}}">--}}
                <?php }?>
                <h2>{{$companyProfile[0]->companyname}}</h2>
            </div>
            @include('user.seller.company.slider')
            <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
             <div class="row margin-bottom-20">
                 <a href="javascript:void(0)" class="btn-u btn-u-blue" onclick="onShowCategoryAddModal()" style="float:right"><i class="fa fa-plus"></i> {{Lang::get('user.add_category')}}</a>
             </div>
            <?php }?>
             <input type="hidden" name="company" id="companyID" value="<?php echo $user_id?>">
            <?php if(count($userCategories) >0) { ?>
            <div class="row cube-portfolio margin-bottom-40">
                <div id="grid-container" class="cbp-l-grid-agency">
                @for($i=0; $i<count($userCategories); $i++)
                     <div class="cbp-item graphic">
                         <div class="cbp-caption margin-bottom-20 category_image_boxshadow">
                             <div class="cbp-caption-defaultWrap">
                                 <?php if($categoryPictures[$i] == "") {?>
                                    <img src="/assets/asset_view/img/main/img26.jpg" alt="">
                                 <?php }else{?>
                                     <img src="<?php echo HTTP_LOGO_PATH.$categoryPictures[$i]?>" alt="">
                                 <?php }?>
                             </div>
                             <div class="cbp-caption-activeWrap">
                                 <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
                                 <a href="javascript:void(0)" onclick="onChangeCompanyCategoryPicture(<?php echo $userCategories[$i]->id;?>)" title="{{Lang::get('user.Add_change_pic')}}">
                                     <img src = "<?php echo HTTP_PATH ?>/assets/media/images/camera.jpg" class="seller_store_add_picture_company">
                                 </a>
                                 <?php }?>
                                 <div class="cbp-l-caption-alignCenter">
                                     <a href="{{URL::Route('user.seller.storeCategory', array($user_id,$userCategories[$i]->id))}}" class="cbp-l-caption-body">
                                     </a>
                                 </div>
                             </div>
                         </div>
                         <div class="cbp-title-dark">
                             <div class="cbp-l-grid-agency-title"><?php echo $userCategories[$i]->categoryname;?></div>
                         </div>
                    </div>
                @endfor
                </div>
            </div>
            <?php }?>

        </div>
        <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
        <div class="modal fade" id="addCategoryModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                        <h4 id="myModalLabel1" class="modal-title">{{Lang::get('user.add_category')}}</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{URL::route('user.seller.categoryImageUpload')}}" method="post" class="form-horizontal margin-bottom-40" enctype="multipart/form-data" id="onSaveCategoryForm">
                            <input type="hidden" name="company" value="{{$user_id}}" id="onSaveCategoryForm_company">
                            <div class="form-group">
                                <label class="col-md-4 col-sm-4 col-xs-5 control-label">
                                    {{Lang::get('user.category')}}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <select class="form-control" name="category" id="category">
                                        <option value =''>Select Category</option>
                                        @for($i=0; $i<count($category); $i++)
                                            <?php $result =0;?>
                                            @for($j=0; $j<count($userCategories); $j++)
                                                @if($userCategories[$j]->id == $category[$i]->id)
                                                    <?php $result = 1; ?>
                                                @endif
                                            @endfor
                                            @if($result != 1)
                                               <option value="{{$category[$i]->id}}">{{$category[$i]->categoryname}}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-1">
                                    <div id="spin" style ="display:none; margin-top: 15px"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-sm-4 col-xs-5 control-label">
                                    {{Lang::get('user.category_image')}}
                                </label>
                                <div class="col-md-6 col-sm-5 col-xs-6">
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="button" onclick="onSaveCategoryImage()"  class="btn-u btn-u-blue" value="{{Lang::get('user.save')}}" style="float:right">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--- Change Category-->
        <div class="modal fade" id="addCategoryChangeModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                        <h4 id="myModalLabel1" class="modal-title">{{Lang::get('user.add_category')}}</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{URL::route('user.seller.categoryImageUpload')}}" method="post" class="form-horizontal margin-bottom-40" enctype="multipart/form-data" id="onSaveCategoryChangeForm">

                        </form>
                    </div>
                </div>
            </div>
        </div>
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
        <?php }?>
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
                        var postUrl = '{{route("user.seller.companyChangePicture")}}';
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

                 <?php }?>
               });
            <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
               function onChangeCompanyLogoPicture(company){
                 $("#myModal").modal('show');
                }
                function onSubmitContent(){
                    $("#companyChangeForm").ajaxForm({
                        success:function(data){
                            $("#myModal").modal('hide');
                            if(data.result == "success"){
                                bootbox.alert("{{Lang::get('missing.your_company_picture_has_been_saved_successfully')}}");
                                window.location.reload();
                            }else{
                                window.location.reload();
                            }
                        }
                    }).submit();
                }
                function onShowCategoryAddModal(){
                    $("#addCategoryModel").modal('show');
                }
                function onSaveCategoryImage(){
                    $("#onSaveCategoryForm").ajaxForm({
                        success:function(data){
                            $("#addCategoryModel").modal('hide');
                            if(data.result == "success"){
                                bootbox.alert("{{  Lang::get('missing.Your_category_picture_has_been_saved_successfully') }}");
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
                function onChangeCompanyCategoryPicture(id){
                    var companyID = $("#companyID").val();
                    var base_url = window.location.origin;
                    $.ajax ({
                        url: '{{ route("user.seller.categoryChange") }}',
                        type: 'POST',
                        data: {companyID: companyID, id:id},
                        cache: false,
                        dataType: "json",
                        success: function (data) {
                            if(data.result =="success"){
                                $("#onSaveCategoryChangeForm").html(data.list);
                                $("#addCategoryChangeModel").modal('show');
                            }
                        }
                    });
                }
                function onSaveCategoryChangeImage(){
                    $("#onSaveCategoryChangeForm").ajaxForm({
                        success:function(data){
                            $("#addCategoryChangeModel").modal('hide');
                            if(data.result == "success"){
                                bootbox.alert("{{ Lang::get('missing.Your_category_picture_has_been_saved_successfully') }}");
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
                var categoryID = $("#onSaveCategoryForm").find("#category").val();
                var company = $("#onSaveCategoryForm").find("#onSaveCategoryForm_company").val();
                var base_url = window.location.origin;
                $.ajax ({
                    url: '{{ route("user.seller.getCategory") }}',
                    type: 'POST',
                    data: {categoryID : categoryID , company : company},
                    cache: false,
                    dataType : "json",
                    success: function (data) {
                        $("#spin").css('display','none');
                        if(data.result =="success"){
                            $("#subcategory").find("option").remove();
                            $("#subcategory").html(data.subcategory);
                        }
                    }
                });
            }
            <?php }?>
            function onReadDiv(){
                $("#companyIntroduceDiv").toggle();
            }


        </script>

    @stop
@stop