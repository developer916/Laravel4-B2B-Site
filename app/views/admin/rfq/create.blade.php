@extends('admin.layout')
	@section('body')
		<h3 class="page-title">Add RFQ Management</h3>
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
						<a href="{{URL::route('admin.rfq')}}">RFQ Management</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="{{URL::route('admin.rfq.create')}}">Add RFQ</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								Add RFQ
							</div>
						</div>
							<div class="portlet-body form">
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
							<div  class="form-horizontal" id="addCategoryFiledForm">
							    <div class="form-body">
							    <!-- user type-->
							        <div class="form-group">
							            <label class="col-md-4 col-sm-4 col-xs-12 control-label"></label>
							             <div class="col-md-4 col-sm-4 col-xs-12">
                                              <div class="radio-list">
                                                    <label class="radio-inline">
                                                        Standard <input type="radio" name="rfq_type" id="optionsRadios1" value="standard" onchange="onSellerChange()" checked>
                                                    </label>
                                                    <label class="radio-inline">
                                                        Detailed <input type="radio" name="rfq_type" id="optionsRadios2" value="detailed" onchange="onBuyerChange()">
                                                    </label>
                                                </div>
							             </div>
							        </div>
							        <div class="form-group">
							            <label class="col-md-3 col-sm-3 col-xs-12 control-label">Product Name <span style="color:red">*</span></label>
							            <div class="col-md-6 col-sm-6 col-xs-12">
							                <input type="text" name="product_name" class="form-control">
							            </div>
							        </div>
							        <div class="form-group">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Product Description <span style="color:red">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="product_description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <!-- specification-->
                                    <div class="form-group" id="specificationDiv" style=" display: none">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Specification Description</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="rfq_specificationdescription0" class="form-control col-md-12" id="sepecial_description_textarea0"></textarea>
                                            <div class="row col-md-12 checkbox-inline " style="margin-top:10px;">
                                                <span style="vertical-align:top"> Allow alternative</span>
                                                <label>
                                                    <input type="checkbox" id="allowAlternativeBuy0" style="margin-left:10px"  value="1">
                                                </label>
                                            </div>
                                            <div class="row col-md-12" style="margin-top:10px;">
                                                <form action="{{URL::route('admin.rfq.specificationPicutre')}}" id="post_buyer_imageForm" method="post"  enctype="multipart/form-data" class="specificationPictureForm">
                                                    <input type="file" name="file_upload"  style="display:inline-block" id="fileupload" >
                                                    <input type="hidden" name="imagePrevDiv" value="previewNewsImageBuy0"  id="imagePrevDiv">
                                                     <font style="color:red" class="normal">Multiple Image Upload</font>
                                                    <div id="previewNewsImageBuy0" class="previewMultiImage">
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- end-->
                                    <div class="form-group" id="addSpecificationDiv" style=" display: none">
                                        <div class="col-md-4 col-md-offset-8 col-sm-4 col-sm-offset-8 col-xs-6 col-xs-offset-3">
                                            <a href="javascript:void(0)" class="btn blue" onclick="addSpecificationDiv()">Add</a>
                                        </div>
                                    </div>
							    <div class="form-group">
							        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Product Pictures</label>
							        <div class="col-md-6 col-sm-6 col-xs-12">
							             <form action="{{URL::route('admin.rfq.specificationPicutre')}}" id="post_buyer_imageForm" method="post"  enctype="multipart/form-data" class="specificationPictureForm">
                                             <input type="file" name="file_upload" id="imageUploadPostBuy" style="display: inline-block">
                                             <input type="hidden" id="imagePrevDiv" value="previewNewsImageBuy" name="imagePrevDiv">
                                              <font style="color:red" class="normal">Multiple Image Upload</font>
                                             <div id="previewNewsImageBuy" class="previewMultiImage" >
                                             </div>
                                         </form>
							        </div>
							    </div>
							    <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Post Request Files</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <form action="{{URL::route('admin.rfq.file')}}" id="post_buyer_pdf_Form" method="post" enctype="multipart/form-data" >
                                            <input type="file" name="file" id="pdfFileUploadPostBuy" style="display: inline-block"  >
                                            <input type="hidden" id="imagePrevDiv" value="previewNewsFileBuy" name="imagePrevDiv">
                                            <font style="color:red" class="normal">(PDF,DOC,TEXT)</font>
                                            <div id="previewNewsFileBuy" class="previewMultiFile">
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Purchase Quantity <span style="color:red">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" name="purchase_quantity" class="form-control">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <select name="quantity_unit" class="form-control">
                                            @foreach($units as $key => $unit)
                                                <option value ={{$unit->id}}>{{$unit->unitname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Item Price <span style="color:red">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" name="item_price" class="form-control">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                    {{ Form::select('currency'
                                        ,array('' => '---Select Currency --- ') +  $currencies->lists('currency_name', 'id')
                                        , null
                                        , array('class' => 'form-control','name'=>'currency')) }}

                                    </div>
                                </div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-7 col-md-5">
											<button   class="btn  blue" type="button"  onclick="onSaveRFQ(this)"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>Save</button>
											<a class="btn  green" href="{{URL::route('admin.rfq')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="form-group" id="specificationDivClone" style="display: none" >
                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Specification Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="rfq_specificationdescription" class="form-control col-md-12"></textarea>
                    <div class="row col-md-12 checkbox-inline " style="margin-top:10px;">
                        <span style="vertical-align:top"> Allow alternative</span>
                        <label>
                            <input type="checkbox" id="allowAlternativeBuy" style="margin-left:10px"  value="1">
                        </label>
                    </div>
                    <div class="row col-md-12" style="margin-top:10px;">
                       <div class="row col-md-12" style="margin-top:10px;">
                           <form action="{{URL::route('admin.rfq.specificationPicutre')}}" id="post_buyer_imageForm" method="post"  enctype="multipart/form-data" class="specificationPictureForm">
                                <input type="file" name="file_upload"  style="display:inline-block" id="fileupload" >
                               <input type="hidden" name="imagePrevDiv" value="previewNewsImageBuy"  id="imagePrevDiv">
                                <font style="color:red" class="normal">Multiple Image Upload</font>
                               <div id="previewNewsImageBuy" class="previewMultiImage">
                               </div>
                           </form>

                       </div>
                    </div>
                </div>
            </div>

	@stop
	@section('custom-scripts')
	    {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
	    <script type="text/javascript">
            function onSellerChange(){
                $("#addCategoryFiledForm").find("div#specificationDiv").hide();
                $("#addCategoryFiledForm").find("div#addSpecificationDiv").hide();
            }
            function onBuyerChange(){
                $("#addCategoryFiledForm").find("div#specificationDiv").show();
                $("#addCategoryFiledForm").find("div#addSpecificationDiv").show();

            }
            function onSaveRFQ(obj){
                var productpicture = new Array();
                var productfile = new Array();
                var imageIndex =0;
                var RFQ_Type = $("input:radio[name=rfq_type]:checked").val();
                $("#previewNewsImageBuy").find(".img-wrap").each(function(){
                		//productpicture[imageIndex] = $(this).find("img").attr("src");
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
                    var base_url = window.location.origin;
                    var postUrl = base_url + '/admin/listing/rfq/store';
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
                                bootbox.alert("RFQ saved successfully");
                                window.location.href= "{{URL::route('admin.rfq')}}";
                            }

                        }
                     }).submit();
            }

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
            	$("input#allowAlternativeBuy"+contentSize).uniform();

            	$("input#fileupload").each(function() {
                    $(this).unbind('change').bind('change', function(){
                        var specificationImageUploadObj = $(this);
                        $(this).parent().ajaxForm({
                            success: function(data) {
                                var targetId ='#' + specificationImageUploadObj.parent().find("#imagePrevDiv").val();
                                var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+ data.url+"'>"+ "<div class='close-button'></div></div>";
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
            $( document ).ready(function() {
                var countSpecialList=0;
               $("input#fileupload").each(function() {
                    var specificationImageUploadObj = $(this);
                    specificationImageUploadObj.unbind('change').bind('change', function(){
                        $(this).parent().ajaxForm({
                            success: function(data) {
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
               $("input#imageUploadPostBuy").change( function(){
                    var imageUploadObj = $(this);
                    $(this).parent().ajaxForm({
                        success: function(data) {
                         if(data.result == "success"){
                            var targetId ='#' + imageUploadObj.parent("form").find("#imagePrevDiv").val();
                            var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='"+ data.url+"'>" +"<div class='close-button'></div></div>";
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
                            var htmlObj = "<div class='fileItemList'>"+data.content+"<div class='close-button'></div></div>";
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
	    </script>
	@stop
@stop
