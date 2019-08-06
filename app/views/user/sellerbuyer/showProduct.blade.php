@extends('user.layout')
    @section('custom-styles')
        {{HTML::style('assets/asset_view/shop-ui/css/shop.style.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/master-slider/quick-start/masterslider/style/masterslider.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/master-slider/quick-start/masterslider/skins/default/style.css')}}
        {{HTML::style('/zoom/magiczoomplus.css')}}
        {{HTML::style('/zoom/change_magiczoomplus.css')}}
    @stop
    @section('body')
        <div class="container content shop-product change-shop-product">
            <div class="row margin-bottom-20">
                @if(count($productPicture)>0)
                    @if($main == 0)
                    <div class="col-md-6 md-margin-bottom-50" style="display:inline-block; text-align: center">
                        <a id="Zoom-1" class="MagicZoom" href="{{HTTP_LOGO_PATH.$productPicture[0]->picture_url}}">
                            <img src="{{HTTP_LOGO_PATH.$productPicture[0]->picture_url}}?scale.height=400"  id="imageList">
                        </a>
                        <div class="selectors">
                            @foreach($productPicture as $key_productpicture =>$value_productpicture )
                            <a data-zoom-id="Zoom-1" href="{{HTTP_LOGO_PATH.$value_productpicture->picture_url}}"
                                    data-image="{{HTTP_LOGO_PATH.$value_productpicture->picture_url}}?scale.height=400" class="mz-thumb">
                                <img srcset="{{HTTP_LOGO_PATH.$value_productpicture->picture_url}}?scale.width=112 2x" src="{{HTTP_LOGO_PATH.$value_productpicture->picture_url}}?scale.width=56"/>
                            </a>
                            @endforeach
                        </div>
                    </div>
                   @else
                        <div class="col-md-6 md-margin-bottom-50" style="display:inline-block; text-align: center">
                            <a id="Zoom-1" class="MagicZoom" href="{{HTTP_LOGO_PATH.$productPicture[0]->image_url}}">
                                <img src="{{HTTP_LOGO_PATH.$productPicture[0]->image_url}}?scale.height=400"  id="imageList">
                            </a>
                            <div class="selectors">
                                @foreach($productPicture as $key_productpicture =>$value_productpicture )
                                    <a data-zoom-id="Zoom-1" href="{{HTTP_LOGO_PATH.$value_productpicture->image_url}}"
                                       data-image="{{HTTP_LOGO_PATH.$value_productpicture->image_url}}?scale.height=400" class="mz-thumb">
                                        <img srcset="{{HTTP_LOGO_PATH.$value_productpicture->image_url}}?scale.width=112 2x" src="{{HTTP_LOGO_PATH.$value_productpicture->image_url}}?scale.width=56"/>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                   @endif
                @else
                    <div class="col-md-6 col-sm-6 col-xs-12 md-margin-bottom-50">
                        <img src="/assets/asset_view/img/main/img1.jpg" class="" style="width: 100%">
                    </div>
                @endif
                    <div class="col-md-6">
                        @include('user.sellerbuyer.product')
                    </div>
            </div>

            <div class="row margin-bottom-40">
                <div class="col-md-12 ">
                    <div class="tab-v2">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#highlights-1" data-toggle="tab">{{Lang::get('user.product_description')}}</a></li>
                            <li><a href="#highlights-2" data-toggle="tab">{{Lang::get('user.company_profile')}}</a></li>
                            <?php
                            $countQuickDetails = count($quickDetails);
                            if($countQuickDetails>0) {?>
                            <li><a href="#highlights-3" data-toggle="tab">{{Lang::get('user.quick_details')}}</a></li>
                            <?php }?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active margin-bottom-40" id="highlights-1" style=" margin-top: 20px;" >
                               <p>{{$helps->product_description}}</p>
                            </div>
                            <div class="tab-pane fade margin-bottom-40" id="highlights-2" style=" margin-top: 20px;">
                                <div class="row ">
                                    <div class="col-md-12 margin-bottom-20">
                                        {{$companyProfile[0]->companydescription}}
                                    </div>
                                    <div class="col-md-12 margin-bottom-40">
                                        <h4 style="font-weight: 900" class="margin-bottom-20">{{Lang::get('user.basic_information')}}</h4>
                                        <div class="col-md-12">
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.company_name')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$companyProfile[0]->companyname}}
                                                </div>
                                            </div>
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.business_type')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$business_type->businesstype}}
                                                </div>
                                            </div>
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.main_product_focus')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$productfocus->productfocus}}
                                                </div>
                                            </div>
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.number_of_employees')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$employees->employees}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 style="font-weight: 900"  class="margin-bottom-20">{{Lang::get('user.factory_information')}}</h4>
                                        <div class="col-md-12">
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.year_establish')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$companyProfile[0]->companyyear}}
                                                </div>
                                            </div>
                                            <?php if(isset($companyProfile[0]->ceoownername)){?>
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.ceo_name')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$companyProfile[0]->ceoownername}}
                                                </div>
                                            </div>
                                            <?php }?>
                                            <?php if(isset($companyProfile[0]->factorysize)){?>
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.factory_size')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$factorysize->factorysize}}
                                                </div>
                                            </div>
                                            <?php }?>
                                            <?php if(isset($companyProfile[0]->factorylocation)){?>
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.factory_location')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$companyProfile[0]->factorylocation}}
                                                </div>
                                            </div>
                                            <?php }?>
                                            <?php if(isset($companyProfile[0]->qa_qc)){?>
                                            <div class="row margin-bottom-10">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    {{Lang::get('user.qa_qc')}}
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    {{$companyProfile[0]->qa_qc}}
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php if($countQuickDetails>0) {?>
                            <div class="tab-pane fade margin-bottom-40" id="highlights-3">
                                <div class="row" style="margin-bottom:20px; margin-top: 20px;">
                                    <div class="col-md-12">
                                        <?php
                                        for($ik =0; $ik<$countQuickDetails; $ik++){
                                        if($ik %2==0){ ?>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <p>{{$quickDetails[$ik]->categoryname}} : {{$quickDetails[$ik]->categorycontent}}</p>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="col-md-6 col-sm-6">
                                                <p>{{$quickDetails[$ik]->categoryname}} : {{$quickDetails[$ik]->categorycontent}}</p>
                                            </div>
                                        </div>
                                        <?php    } }?>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addCategoryModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                        <h4 class="modal-title" id="myModalLabel"> {{Lang::get('user.cargo_help_text')}}</h4>
                    </div>
                    <div class="modal-body">
                        <p class="margin-bottom-40"> {{Lang::get('user.cargo_text')}} </p>
                    </div>
                </div>
            </div>
        </div>
    @stop
@section('custom-scripts')
    {{ HTML::script('/assets/asset_view/shop-ui/plugins/master-slider/quick-start/masterslider/masterslider.min.js') }}
    {{ HTML::script('/assets/asset_view/shop-ui/plugins/master-slider/quick-start/masterslider/jquery.easing.min.js') }}
    {{ HTML::script('/assets/asset_view/shop-ui/js/plugins/master-slider.js') }}
    {{ HTML::script('/assets/asset_view/shop-ui/js/forms/product-quantity.js') }}
    {{ HTML::script('/zoom/magiczoomplus.js') }}
    {{ HTML::script('/zoom/change_magiczoomplus.js') }}

    <script>
        jQuery(document).ready(function() {
            MasterSliderShowcase2.initMasterSliderShowcase2();
        });
    </script>
@stop
@stop