@extends('admin.layout')
    @section('custom-styles')
       {{HTML::style('//www.jqueryscript.net/css/jquerysctipttop.css')}}
       {{ HTML::style('/assets/assest_admin/css/reset.css') }}
       {{HTML::style('/zoom/magiczoomplus.css')}}
       {{HTML::style('/zoom/change_magiczoomplus.css')}}
       <style>
            .picZoomer-pic {
              width: 100%!important;
            }
            .picZoomer-pic-wp{
               width: 100%!important;
            }
       </style>
    @endsection
	@section('body')
        <?php $productShipping = $product->productShipping;  if(count($productShipping)>0) {$productShipping = $productShipping[0];} ?>
		<h3 class="page-title">View Product Management</h3>
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
						<a href="{{URL::route('admin.post.view', $product->id)}}">View Product</a>
					</li>
				</ul>
			</div>
            <div class="row" >
                <div class="col-md-12" style="background-color: white; padding-top:40px; ">
                    <div class="col-md-4 col-sm-4">
                        @if($main ==0)
                            @include('admin.post.mainProductImage')
                        @else
                            @include('admin.post.additionalProductImage')
                        @endif
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <h1 style="font-weight: bold;">{{$product->product_name}}</h1>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <lable class="col-md-4 col-sm-4 col-xs-4">Category:</lable>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    <p><?php echo $product->category->categoryname."->".$product->subcategory->subcategoryname; ?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                 <lable class="col-md-4 col-sm-4 col-xs-4">Min Order:</lable>
                                                 <div class="col-md-8 col-sm-8 col-xs-8">
                                                     <p><?php echo $product->min_order." ". $product->minOrderUnit->unitname; ?></p>
                                                 </div>
                                            </div>
                                            <div class="form-group">
                                                 <lable class="col-md-4 col-sm-4 col-xs-4">Supply Ability:</lable>
                                                 <div class="col-md-8 col-sm-8 col-xs-8">
                                                     <p><?php echo $product->supply_ability." ". $product->supplyAbilityUnit->unitname; ?></p>
                                                 </div>
                                            </div>
                                            <div class="form-group">
                                                <lable class="col-md-4 col-sm-4 col-xs-4">Price for 1~99:</lable>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    <p class="margin-bottom-20">
                                                        <?php echo $product->product_price1." ".$price1_unit->currency_name; ?>
                                                    </p>
                                                    @if(count($productShipping)>0)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                        Shipping Type
                                                                    </lable>
                                                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                                                        @if($productShipping->shipping_type1 == 1)
                                                                            Normal
                                                                        @elseif($productShipping->shipping_type1 == 2)
                                                                            Free Shipping
                                                                        @else
                                                                            Cargo
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($productShipping->shipping_type1 == 1 || $productShipping->shipping_type1 == 3)
                                                            <div class="col-md-12">
                                                                @if($productShipping->shipping_type1 == 1)
                                                                    <div class="form-group">
                                                                        <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                            Flat Rate
                                                                        </lable>
                                                                        <div class="col-md-8 col-sm-8 col-xs-8">
                                                                             {{$productShipping->flat_rate1}} {{$productShipping->flatRate1->currency_name}}
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    {{Lang::get('user.cargo_text')}}
                                                                @endif
                                                            </div>
                                                            @endif
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                        Estimated Time
                                                                    </lable>
                                                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                                                        {{$productShipping->estimated_time1}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <lable class="col-md-4 col-sm-4 col-xs-4">Price for 100~499:</lable>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    <p class="margin-bottom-20"><?php
                                                        echo $product->product_price2." ".$price2_unit->currency_name; ?></p>
                                                    @if(count($productShipping)>0)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                        Shipping Type
                                                                    </lable>
                                                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                                                        @if($productShipping->shipping_type2 == 1)
                                                                            Normal
                                                                        @elseif($productShipping->shipping_type2 == 2)
                                                                            Free Shipping
                                                                        @else
                                                                            Cargo
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($productShipping->shipping_type2 == 1 || $productShipping->shipping_type2 == 3)
                                                                <div class="col-md-12">
                                                                    @if($productShipping->shipping_type2 == 1)
                                                                        <div class="form-group">
                                                                            <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                                Flat Rate
                                                                            </lable>
                                                                            <div class="col-md-8 col-sm-8 col-xs-8">
                                                                                {{$productShipping->flat_rate2}} {{$productShipping->flatRate2->currency_name}}
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        {{Lang::get('user.cargo_text')}}
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                        Estimated Time
                                                                    </lable>
                                                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                                                        {{$productShipping->estimated_time2}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <lable class="col-md-4 col-sm-4 col-xs-4">Price for 500~1000:</lable>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    <p class="margin-bottom-20">
                                                        <?php
                                                           echo $product->product_price3." ".$price3_unit->currency_name; ?></p>

                                                    @if(count($productShipping)>0)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                        Shipping Type
                                                                    </lable>
                                                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                                                        @if($productShipping->shipping_type3 == 1)
                                                                            Normal
                                                                        @elseif($productShipping->shipping_type3 == 2)
                                                                            Free Shipping
                                                                        @else
                                                                            Cargo
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($productShipping->shipping_type3 == 1 || $productShipping->shipping_type3 == 3)
                                                                <div class="col-md-12">
                                                                    @if($productShipping->shipping_type3 == 1)
                                                                        <div class="form-group">
                                                                            <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                                Flat Rate
                                                                            </lable>
                                                                            <div class="col-md-8 col-sm-8 col-xs-8">
                                                                                {{$productShipping->flat_rate3}} {{$productShipping->flatRate3->currency_name}}
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <p class="margin-bottom-20">{{Lang::get('user.cargo_text')}}</p>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <lable class="col-md-4 col-sm-4 col-xs-4">
                                                                        Estimated Time
                                                                    </lable>
                                                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                                                        {{$productShipping->estimated_time3 }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(count($productAdditionalCategorySize)>0)
                                                <div class="form-group">
                                                    <lable class="col-md-4 col-sm-4 col-xs-4">Size:</lable>
                                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                                        <select name="" class="form-control">
                                                            <option value="">Select Size</option>
                                                            @foreach($productAdditionalCategorySize as $key=>$value)
                                                                <option value="{{$value->id}}">{{$value->values}}</option>
                                                            @endforeach
                                                        </select>
                                                     </div>
                                                </div>
                                            @endif
                                            @if(count($productAdditionalCategoryColor)>0)
                                                <div class="form-group" style="margin-bottom: 20px">
                                                    <lable class="col-md-4 col-sm-4 col-xs-4">Color:</lable>
                                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                                        <span id="colorList">
                                                            @if($main == 1)
                                                               {{$productAdditionalCategory->values}}
                                                            @else
                                                                @foreach($productAdditionalCategoryColor as $key_productAdditionalCategoryColor =>$value_productAdditionalCategoryColor)
                                                                    @if($key_productAdditionalCategoryColor == 0)
                                                                        {{$value_productAdditionalCategoryColor->values}}
                                                                    @else
                                                                        {{"/".$value_productAdditionalCategoryColor->values}}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                     </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-5 col-sm-5 col-xs-5 col-md-offset-4 col-sm-offset-4 col-xs-offset-5">
                                                        @foreach($productAdditionalCategoryColor as $key =>$value)
                                                            <?php
                                                            $productAdditionalImage = $value->productAdditionalCategoryImage;
                                                            ?>
                                                            @if(count($productAdditionalImage)>0)
                                                                <a href="{{URL::route('admin.post.view',array($product->id,$value->id))}}">
                                                                    @if($main == 1 && $id == $value->id)
                                                                        <img src="{{HTTP_LOGO_PATH.$productAdditionalImage[0]->image_url}}" class="additionalImage" style="border: 1px solid red;">
                                                                    @else
                                                                        <img src="{{HTTP_LOGO_PATH.$productAdditionalImage[0]->image_url}}" class="additionalImage">
                                                                    @endif
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                           
                                            {{--<div class="form-group">--}}
                                                {{--<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2 col-sm-offset-2" style="text-align: center">--}}
                                                    {{--@if($main !=0)--}}
                                                        {{--<a class="btn  green" href="{{URL::route('admin.post.view',$product->id)}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Main Product Images</a>--}}
                                                    {{--@endif--}}
                                                    {{--<a class="btn  red" href="{{URL::route('admin.post')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
            	</div>
                <div class="col-md-12" style="padding-bottom: 40px;margin-bottom: 30px;background-color:white;">
                    <div class="tabbable tabs-left">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_6_1" data-toggle="tab">
                                    Product Details </a>
                            </li>
                            @if($product->user_id != 1)
                            <li>
                                <a href="#tab_6_2" data-toggle="tab">
                                    Company Profile </a>
                            </li>
                            @endif
                            <?php
                            $countQuickDetails = count($quickDetails); if($countQuickDetails>0) {?>
                            <li>
                                <a href="#tab_6_3" data-toggle="tab">
                                    Quick Details </a>
                            </li>
                            <?php }?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_6_1">
                                <p style="margin-top: 30px;">
                                        {{$product->product_description;}}
                                </p>
                            </div>
                            @if($product->user_id != 1)
                            <div class="tab-pane fade" id="tab_6_2">
                                <div class="row">
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
                            @endif
                            <?php if($countQuickDetails>0) {?>
                            <div class="tab-pane fade" id="tab_6_3">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 30px;">
                                        <?php
                                        for($ik =0; $ik<$countQuickDetails; $ik++){
                                        if($ik %2==0){ ?>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <p style="margin-bottom: 20px">{{$quickDetails[$ik]->categoryname}} : {{$quickDetails[$ik]->categorycontent}}</p>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="col-md-6 col-sm-6">
                                                <p style="margin-bottom: 20px">{{$quickDetails[$ik]->categoryname}} : {{$quickDetails[$ik]->categorycontent}}</p>
                                            </div>
                                        </div>
                                        <?php    } }?>
                                    </div>
                                </div>

                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

	@stop
	@section('custom-scripts')
        {{ HTML::script('/zoom/magiczoomplus.js') }}
        {{ HTML::script('/zoom/change_magiczoomplus.js') }}

	@stop
@stop