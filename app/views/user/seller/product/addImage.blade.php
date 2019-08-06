@extends('user.seller.layout')
    @section('custom-styles')
        {{ HTML::style('/assets/assest_admin/css/bootstrap-fileinput.css') }}
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 favoriteContentBody">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{URL::route('user.seller.productImageStore')}}" class="form-horizontal" id="addFileForm" method="POST">
                                <input type="hidden" name="productID" value="{{$product->id}}">
                                    <!-- main product -->
                                    <div class="form-group margin-bottom-30 margin-top-30">
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
                                                    <span class="fileinput-new btn-u btn-u-blue" id="select_image"> {{Lang::get('user.select_image')}} </span>
                                                    <span class="fileinput-exists btn-u bnt-u-blue"  id="change_image">{{Lang::get('user.change')}} </span>
                                                    <input type="file" name="file_upload" id="uploadMainImage">
                                                    </span>
                                                    <a href="javascript:void(0)" class="btn-u btn-u-red fileinput-exists display-inline-block" data-dismiss="fileinput" id="remove_image" onclick="onChangeRemove()">{{Lang::get('user.remove')}} </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            {{Lang::get('user.create_product_image_description')}}
                                        </div>
                                    </div>
                                <!-- main product -->
                                    <div class="form-group">
                                        <div class="col-md-12"><h4>{{ Lang::get('user.add_more_images_for_product') }}</h4></div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="file" name="file_upload" id="imageUploadPostBuy" style="display: inline-block">
                                            <input type="hidden" id="imagePrevDiv" value="previewNewsImageBuy" name="imagePrevDiv">
                                            <font style="color:red" class="normal">{{Lang::get('missing.multiple_image_upload')}}</font>
                                            <div id="previewNewsImageBuy" class="previewMultiImage" >
                                            </div>
                                        </div>
                                    </div>

                                <!-- additional categories-->
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
                                        <button onclick="onSaveForm()" class="btn-u btn-u-blue" type="button">{{ Lang::get('user.save')  }}</button>
                                        <a href="{{URL::route('user.seller.storeSubCategory', array(  Session::get('user_id')*1+100000, $product->subcategory_id ))}}" class="btn-u btn-u-red">{{ Lang::get('user.cancel') }}</a>
                                    </div>
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
        <script type="text/javascript">
            $(document).ready(function() {
                $("input#uploadMainImage").change(function () {
                    var postUrl = '{{ route("user.seller.specificationPicture") }}';
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
                var countSpecialList=0;
                $("input#imageUploadPostBuy").change( function(){
                    var postUrl = '{{ route("user.seller.specificationPicture") }}';
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
                        var postUrl = '{{route("user.seller.specificationPicture")}}';
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
                            bootbox.alert("{{Lang::get('missing.Product_Images_saved_successfully')}}");
                            window.location.href= data.url;
                        }

                    }
                }).submit();
            }
        </script>
    @stop