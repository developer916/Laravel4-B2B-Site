@extends('admin.layout')
@section('custom-styles')
    {{ HTML::style('/assets/assest_admin/css/jquery.validate.password.css') }}
    {{ HTML::style('/assets/assest_admin/css/bootstrap-select.min.css') }}
    {{ HTML::style('/assets/assest_admin/css/select2.css') }}
    {{ HTML::style('/assets/assest_admin/css/multi-select.css') }}
    {{ HTML::style('/assets/assest_admin/css/components.css') }}
    {{ HTML::style('/assets/assest_admin/css/bootstrap-fileinput.css') }}

@endsection
@section('body')
    <h3 class="page-title">Add Product Management</h3>
    <!-- page layout -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <i class="fa fa-pencil"></i>
                <a href="{{URL::route('admin.post')}}">Products Management</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{URL::route('admin.post.add',$product->id)}}">Add Product Image</a>
            </li>

        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{URL::route('admin.post.imageStore')}}" role="form" class="form-horizontal" id="addFileForm" method="POST">
                <input type="hidden" name="productID" value="{{$product->id}}">
                <div class="form-group margin-bottom-30">
                    <div class="col-md-4 col-sm-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" id="imageUrl"/>
                                <input type="hidden" value="" name="mainUrl" id="mainUrl">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                            </div>
                            <div class="margin-bottom-30">
                                <span class="btn default btn-file">
                                <span class="fileinput-new" id="select_image"> Select image </span>
                                <span class="fileinput-exists"  id="change_image">Change </span>
                                <input type="file" name="file_upload" id="uploadMainImage">
                                </span>
                                <a href="javascript:void(0)" class="btn default fileinput-exists display-inline-block" data-dismiss="fileinput" id="remove_image" onclick="onChangeRemove()">Remove </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <p>
                            Product images style guideline
                        </p>
                        Listings that are missing a main image will not appear in search or browse until you fix the listing. <br>
                        Choose images that are clear, information-rich, and attractive.
                        <br>
                        Images must meet the following requirements:
                        <ul>
                            <li>Products must fill at least 85% of the image. Images must show only the product that is for sale, with few or no props and with no logos, watermarks, or inset images. Images may only contain text that is a part of the product.</li>
                            <li>Main images must have a pure white background, must be a photo (not a drawing), and must not contain excluded accessories. </li>
                            <li>Images must be at least 1000 pixels on the longest side and at least 500 pixels on the shortest side to be zoom-able.</li>
                            <li>Images must not exceed 10000 pixels on the longest side.</li>
                            <li>JPEG is the preferred image format, but you also may use TIFF and GIF files. </li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12"><h4>Add More Images for product</h4></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        {{--<form action="{{URL::route('admin.post.specificationPicutre')}}" id="post_buyer_imageForm" method="post"  enctype="multipart/form-data" class="specificationPictureForm">--}}
                        <input type="file" name="file_upload" id="imageUploadPostBuy" style="display: inline-block">
                        <input type="hidden" id="imagePrevDiv" value="previewNewsImageBuy" name="imagePrevDiv">
                        <font style="color:red" class="normal">Multiple Image Upload</font>
                        <div id="previewNewsImageBuy" class="previewMultiImage" >
                        </div>
                        {{--</form>--}}
                    </div>
                </div>
                @if(count($productAdditionalCategory)>0)
                    <input type="hidden" value = "{{count($productAdditionalCategory)}}" id="countAdditionalCategory" name="countAdditionalCategory">
                    @foreach($productAdditionalCategory as $key=>$value)
                        <div class="form-group margin-bottom-30">
                            <div class="col-md-12 margin-bottom-20">
                                <h2>{{$value->values}}</h2>
                            </div>
                            <div class="col-md-12">
                                <input type="file" name="file_upload"  style="display:inline-block" id="fileupload" >
                                <input type="hidden" name="imagePrevDiv" value="previewNewsImageBuy{{$key}}"  id="imagePrevDiv">
                                <font style="color:red" class="normal">Multiple Image Upload</font>
                                <div id="previewNewsImageBuy{{$key}}" class="previewMultiImage">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="form-group margin-bottom-40">
                    <div class="col-md-12" style="text-align: center">
                        <button onclick="onSaveForm()" class="btn blue" type="button">Save</button>
                        <a href="{{URL::route('admin.post')}}" class="btn red">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
@section('custom-scripts')
    {{ HTML::script('/assets/assest_admin/js/select2.min.js') }}
    {{ HTML::script('/assets/assest_admin/js/jquery.multi-select.js') }}
    {{ HTML::script('/assets/assest_admin/js/bootstrap-select.min.js') }}
    {{ HTML::script('/assets/assest_admin/js/components-dropdowns.js') }}
    {{ HTML::script('/assets/assest_admin/js/spin.js') }}
    {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
    <script type="text/javascript">
        $(document).ready(function() {
            var countSpecialList=0;
            $("input#uploadMainImage").change(function () {
                var base_url = window.location.origin;
                var postUrl = base_url + '/admin/listing/post/specificationPicutre';
                var imageUploadObj = $(this);
                var html = "<form id='file_upload_form' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                imageUploadObj.wrap(html);
                $(this).parent().ajaxForm({
                    success: function (data) {
                        var cnt = imageUploadObj.closest("form#file_upload_form").contents();
                        imageUploadObj.closest("form#file_upload_form").replaceWith(cnt);
                        if (data.result == "success") {
                            $("#imageUrl").attr("src", data.image_url);
                            $("#mainUrl").val(data.url);
                            $("#select_image").hide();
                            $("#change_image").show();
                            $("#remove_image").css('display', 'inline-block');
                        } else if (data.result == "failed") {
                            var arr = data.error;
                            var errorList = '';
                            $.each(arr, function (index, value) {
                                if (value.length != 0) {
                                    errorList = errorList + value;
                                }
                            });
                            $("#mainUrl").val();
                            bootbox.alert(errorList);
                        }
                    }
                }).submit();
            });
            $("input#imageUploadPostBuy").change( function(){
                var base_url = window.location.origin;
                var postUrl = base_url + '/admin/listing/post/specificationPicutre';
                var imageUploadObj = $(this);
                var html =  "<form id='file_upload_form' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                imageUploadObj.wrap(html);
                $(this).parent().ajaxForm({
                    success: function(data) {
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
            $("input#fileupload").each(function() {
                var specificationImageUploadObj = $(this);
                specificationImageUploadObj.unbind('change').bind('change', function(){
                    var base_url = window.location.origin;
                    var postUrl = base_url + '/admin/listing/post/specificationPicutre';
                    var html =  "<form id='file_upload_form' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                    specificationImageUploadObj.wrap(html);
                    $(this).parent().ajaxForm({
                        success: function(data) {
                            var cnt = specificationImageUploadObj.closest("form#file_upload_form").contents();
                                specificationImageUploadObj.closest("form#file_upload_form").replaceWith(cnt);
                            if(data.result == "success"){
                                var targetId ='#' + specificationImageUploadObj.parent().find("#imagePrevDiv").val();
                                var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+ data.url+"'>"+ "<div class='close-button'></div></div>";
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
        });

        function onChangeRemove(){
            $("#imageUrl").attr("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
            $("#mainUrl").val("");
            $("#change_image").hide();
            $("#select_image").show();
            $("#remove_image").hide();

        }


        function onSaveForm(){
            var countAdditionalCategory  = $("#countAdditionalCategory").val();
            specification_descrition_pictures = [];
            if(countAdditionalCategory != 0){
                for(var i=0; i<countAdditionalCategory; i++){
                     specification_descrition_pictures[i]=[];
                    var imageIndex =0;
                    $("#previewNewsImageBuy"+i).find(".img-wrap").each(function(){
                        specification_descrition_pictures[i][imageIndex] = $(this).find("input").val();
                        imageIndex ++;
                    });
                    $("#addFileForm").append('<input type="hidden" value="'+specification_descrition_pictures[i]+'" name="specification_descrition_pictures[]" class="forestappend">');
                }

            }
            main_pictures = [];
            var imageIndex =0;
            $("#previewNewsImageBuy").find(".img-wrap").each(function(){
                main_pictures[imageIndex] = $(this).find("input").val();
                imageIndex ++;
            });
            $("#addFileForm").append('<input type="hidden" value="'+main_pictures+'" name="main_pictures[]" class="forestappend">');

            $("#addFileForm").ajaxForm({
                success: function(data) {
                    if(data.result == "failed"){
                        $("div#addFileForm").find("input.forestappend").remove();
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
                        bootbox.alert("Product Images saved successfully");
                        window.location.href= "{{URL::route('admin.post')}}";
                    }

                }
            }).submit();
        }
    </script>
@stop
@stop