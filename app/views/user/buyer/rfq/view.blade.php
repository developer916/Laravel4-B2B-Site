@extends('user.buyer.layout')
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
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
                                        <div class="inline-group">
                                            <label class="radio"><input type="radio" name="rfq_type" onchange="onSellerChange()" value="standard"  <?php if($rfq->rfq_type =="standard") {echo "checked";}?>><i class="rounded-x"></i><p class="headerPetrob">{{Lang::get('user.standard')}}</p></label>
                                            <label class="radio"><input type="radio" name="rfq_type" onchange="onBuyerChange()" value="detailed"   <?php if($rfq->rfq_type =="detailed") {echo "checked";}?>><i class="rounded-x"></i><p class="headerPetrob">{{Lang::get('user.detailed')}}</p></label>
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
                                        <input type="text" name="product_name" class="form-control" placeholder="{{Lang::get('user.rfq_product_name')}}" value="{{$rfq->rfq_title}}" readonly>
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
                                        <textarea name="product_description" class="form-control" placeholder="{{Lang::get('user.rfq_product_description')}}" rows="5" readonly>{{$rfq->rfq_description}}</textarea>
                                    </section>
                                </div>
                                <?php  if($rfq->rfq_type == "detailed"){
                                $i=0;
                                $rfqSpecificationsContent = $rfq->rfqSpecifications;
                                if(count($rfqSpecificationsContent)>0){
                                foreach($rfq->rfqSpecifications as $value){?>
                                <div class="row" id="specificationDiv">
                                    <label class="col-md-4 col-sm-4 col-xs-12">{{Lang::get('user.specification_description')}}</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <textarea name="rfq_specificationdescription<?php echo $i;?>" class="form-control col-md-12" id="sepecial_description_textarea<?php echo $i;?>"><?php echo  $value->rfq_description?></textarea>
                                        <input type="hidden" value="{{$value->id}}" id="specification<?php echo $i;?>">
                                        <div class="row col-md-12 checkbox-inline " style="margin-top:10px;">
                                            <label class="checkbox">
                                                <input type="checkbox" id="allowAlternativeBuy<?php echo $i?>" style="margin-left:10px"  value="1" <?php if($value->rfq_alternative_ok == "1") {echo "checked";}?>><i></i><p class="headerPetrob">{{Lang::get('user.allow_alternative')}}</p>
                                            </label>
                                        </div>
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
                                <?php  $i++;}}} ?>
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
                                            @if(count($rfq->rfqFile)>0)
                                                @foreach($rfq->rfqFile as $value)
                                                    <div class='fileItemList'>
                                                        @if($value->file_type == "PDF")
                                                            <img src='<?php echo HTTP_PATH ?>/assets/assest_admin/images/pdf.jpg' class='fileItemPDF' >
                                                            <div class='fileHref'>
                                                                <a href='{{HTTP_LOGO_PATH.$value->file_url}}' target='_blank'><span class='fileName'>{{$value->file_name}}</span></a>
                                                                <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                                            </div>
                                                        @elseif($value->file_type == "DOC" || $value->file_type == "DOCX" )
                                                            <img src='<?php echo HTTP_PATH ?>/assets/assest_admin/images/word.jpg' class='fileItemPDF' >
                                                            <div class='fileHref'>
                                                                <a href='{{HTTP_LOGO_PATH.$value->file_url}}' target='_blank'><span class='fileName'>{{$value->file_name}}</span></a>
                                                                <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                                            </div>
                                                        @elseif($value->file_type == "TXT")
                                                            <img src='<?php echo HTTP_PATH ?>/assets/assest_admin/images/txt.jpg' class='fileItemPDF' >
                                                            <div class='fileHref'>
                                                                <a href='{{HTTP_LOGO_PATH.$value->file_url}}' target='_blank'><span class='fileName'>{{$value->file_name}}</span></a>
                                                                <input type='hidden' value='PDF' class='forestchange' id='forestchange'>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
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
                                        </label>
                                    </section>
                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                        <input type="text" name="item_price" class="form-control" placeholder="{{Lang::get('user.item_price')}}" value="{{$rfq->rfq_unitprice}}" readonly>
                                    </section>
                                    <section class="col-md-4 col-sm-4 col-xs-6">
                                        <input type="text" value = "@if($currencies) {{$currencies->currency_name}} @endif" class="form-control" readonly>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-4">
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
        });
    </script>
@stop
@stop
