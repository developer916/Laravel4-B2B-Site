@extends('admin.layout')
    @section('custom-styles')
       {{ HTML::style('/assets/assest_admin/css/jquery.fancybox.css') }}
       {{ HTML::style('/assets/assest_admin/css/gallery.css') }}
    @stop
	@section('body')
		<h3 class="page-title">View RFQ Management</h3>
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
						<a href="{{URL::route('admin.rfq.view',$rfq->id)}}">View RFQ</a>
					</li>)
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								View RFQ
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
                                <input type="hidden" name="rfq_id" value="{{$rfq->id}}">
                                <div class="form-body">
                                <!-- user type-->
                                    <div class="form-group">
                                        <label class="col-md-4 col-sm-4 col-xs-12 control-label"></label>
                                         <div class="col-md-4 col-sm-4 col-xs-12">
                                              <div class="radio-list">
                                                    <label class="radio-inline">
                                                        Standard <input type="radio" name="rfq_type" id="optionsRadios1" value="standard"  <?php if($rfq->rfq_type =="standard") {echo "checked";}?>>
                                                    </label>
                                                    <label class="radio-inline">
                                                        Detailed <input type="radio" name="rfq_type" id="optionsRadios2" value="detailed"  <?php if($rfq->rfq_type =="detailed") {echo "checked";}?>>
                                                    </label>
                                                </div>
                                         </div>
                                    </div>
                                 <!-- -->
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Product Name <span style="color:red">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="product_name" class="form-control" value="{{$rfq->rfq_title}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Product Description <span style="color:red">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="product_description" class="form-control">{{$rfq->rfq_description}}</textarea>
                                    </div>
                                </div>
                            <?php  if($rfq->rfq_type == "detailed"){
                                $i=0;
                                foreach($rfq->rfqSpecifications as $value){?>
                                 <div class="form-group" id="specificationDiv">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Specification Description</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="rfq_specificationdescription<?php echo $i;?>" class="form-control col-md-12" id="sepecial_description_textarea<?php echo $i;?>"><?php echo  $value->rfq_description?></textarea>
                                        <input type="hidden" value="{{$value->id}}" id="specification<?php echo $i;?>">
                                        <div class="row col-md-12 checkbox-inline " style="margin-top:10px;">
                                            <span style="vertical-align:top"> Allow alternative</span>
                                            <label>
                                                <input type="checkbox" id="allowAlternativeBuy0" style="margin-left:10px"  value="1" <?php if($value->rfq_alternative_ok == "1") {echo "checked";}?>>
                                            </label>
                                        </div>
                                        <div class="row col-md-12" style="margin-top:10px;">
                                            <div id="previewNewsImageBuy<?php echo $i;?>" class="previewMultiImage">
                                                <?php
                                                    foreach ($value->specificationPicture as $value1){?>
                                                        <div class="img-wrap gallery-item">
                                                            <a data-rel="fancybox-button" title="Project Name" href="{{HTTP_LOGO_PATH.$value1->picture_url}}" class="fancybox-button">
                                                                <img alt="" src="{{HTTP_LOGO_PATH.$value1->picture_url}}" class="img-responsive">
                                                                <div class="zoomix"><i class="fa fa-search"></i></div>
                                                              </a>
                                                       </div>
                                                   <?php }
                                                ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                             <?php $i++; } ?>
                             <?php }?>

                                 <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Product Pictures</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                         <div id="previewNewsImageBuy" class="previewMultiImage" >
                                            @foreach($rfq->rfqImage as $value)
                                                 <div class="img-wrap gallery-item">
                                                   <a data-rel="fancybox-button" title="Project Name" href="{{HTTP_LOGO_PATH.$value->picture_url}}" class="fancybox-button">
                                                     <img alt="" src="{{HTTP_LOGO_PATH.$value->picture_url}}" class="img-responsive">
                                                     <div class="zoomix"><i class="fa fa-search"></i></div>
                                                   </a>
                                                   </div>
                                            @endforeach
                                         </div>
                                    </div>
                                </div>

                            <!-- document-->

                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Post Request Files</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div id="previewNewsFileBuy" class="previewMultiFile">
                                            @foreach($rfq->rfqFile as $value)
                                                <div class='fileItemList'>
                                                    @if($value->file_type == "PDF")
                                                        <img src='<?php echo HTTP_PATH ?>/assets/assest_admin/images/pdf.jpg' class='fileItemPDF' >
                                                        <div class='fileHref'>
                                                            <a href='{{$value->file_url}}' target='_blank'><span class='fileName'>{{$value->file_name}}</span></a>
                                                            <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                                        </div>
                                                        <div class="close-button"></div>
                                                    @elseif($value->file_type == "DOC" || $value->file_type == "DOCX" )
                                                        <img src='<?php echo HTTP_PATH ?>/assets/assest_admin/images/word.jpg' class='fileItemPDF' >
                                                        <div class='fileHref'>
                                                            <a href='{{$value->file_url}}' target='_blank'><span class='fileName'>{{$value->file_name}}</span></a>
                                                            <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                                        </div>
                                                        <div class="close-button"></div>
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
                                    </div>
                                </div>
                            <!-- purchase  quantity-->
                                    <div class="form-group">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Purchase Quantity <span style="color:red">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" name="purchase_quantity" class="form-control" value="{{$rfq->rfq_quantity}}">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <input type="text" value="{{$rfq->unit->unitname}}" class="form-control">
                                        </div>
                                    </div>
                            <!-- Item price -->
                                    <div class="form-group">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Item Price <span style="color:red">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" name="item_price" class="form-control" value="{{$rfq->rfq_unitprice}}">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                         <input type="text" value = "{{$currencies->currency_name}}" class="form-control">
                                        </div>
                                    </div>
                            <!-- end-->
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-7 col-md-5">
                                                <a class="btn  green" href="{{URL::route('admin.rfq')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Return</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
			            </div>
			        </div>
             </div>
        </div>

    @stop
	@section('custom-scripts')
        {{ HTML::script('/assets/assest_admin/js/jquery.fancybox.pack.js') }}
    @stop

@stop