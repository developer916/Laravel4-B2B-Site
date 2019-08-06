@extends('user.layout')
     @section('custom-styles')
         {{HTML::style('/assets/asset_view/plugins/animate.css')}}
         {{HTML::style('/assets/asset_view/css/blocks.css')}}
         {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
         {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
         {{HTML::style('/assets/asset_view/css/forestChange.css')}}
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
     @stop
    @section('body')
        <?php $productShipping = $helps->productShipping;  if(count($productShipping)>0) {$productShipping = $productShipping[0];} ?>
             <div class="breadcrumbs">
                <div class="container">
                    <h1 class="pull-left">
                     <?php echo ucfirst($helps->product_name); ?>
                    </h1>
                     <ul class="pull-right breadcrumb">
                        <li><a href="{{URL::route('user.home')}}">Home</a></li>
                        <li><a href="{{URL::route('user.category.sub',(100000*1+$helps->subcategory_id))}}"><?php echo ucfirst($helps->subCategory->subcategoryname); ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="container" style="margin-top: 40px;">
                <div class="row">
                   <div class="col-md-3 col-sm-3">
                       <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                           <?php $i=0;?>
                           @foreach($category as $categories)
                              <li class="list-group-item list-toggle <?php if($helps->category_id==$categories->id) {echo "active";}?>">
                                   <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse<?php echo $i;?>">{{$categories->categoryname}}</a>
                                   <ul id="collapse<?php echo $i;?>" <?php if($helps->category_id==$categories->id) {?> class="collapse in" aria-expanded="true" <?php }else{?>class="collapse"<?php }?>>
                                       <?php $subCategory = $categories->subCategories;?>
                                       @foreach($subCategory as $subCategories)
                                           <li class="<?php if($subCategories->id ==$helps->subcategory_id ){echo "active";} ?>">
                                               <a href="{{URL::route('user.category.sub',(100000*1+$subCategories->id))}}"><?php echo ucfirst($subCategories->subcategoryname); ?></a>
                                           </li>
                                       @endforeach
                                   </ul>
                              </li>
                              <?php $i++; ?>
                           @endforeach
                       </ul>
                   </div>
                    <div class="col-md-9 col-sm-9">
                         <div class="row margin-bottom-40">
                             <form action="{{URL::route('user.category.search')}}">
                                <div class="col-md-9 col-sm-9 col-xs-9" id="bloodhound">
                                    <input type="text" class="form-control" placeholder='{{Lang::get('user.what_you_are_looking_for')}}' id="helpSearchText" name="searchTitle">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3 helpSearchButtonDiv">
                                    <button class="btn-u btn-u-blue helpSearchButton"><i class="search fa fa-search search-button"></i> {{Lang::get('user.search_product')}}</button>
                                </div>
                            </form>
                        </div>
                        <div class="row margin-bottom-40">
                            <div class="col-md-4 col-sm-4">
                                @if($main ==0)
                                    @include('user.category.mainProductImage')
                                @else
                                    @include('user.category.additionalProductImage')
                                @endif
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="row margin-bottom-20">
                                    <div class="col-md-12 margin-bottom-40">
                                        <div class="portlet">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <h1 style="font-weight: bold;">{{$helps->product_name}}</h1>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.category')}}</lable>
                                                        <div class="col-md-8 col-sm-8 col-xs-8">
                                                            <p><?php echo ucfirst($helps->category->categoryname)."->".ucfirst($helps->subcategory->subcategoryname); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                         <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.min_order')}}</lable>
                                                         <div class="col-md-8 col-sm-8 col-xs-8">
                                                             <p><?php echo $helps->min_order." ". $helps->minOrderUnit->unitname; ?></p>
                                                         </div>
                                                    </div>
                                                    <div class="form-group">
                                                         <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.supply_ability')}}</lable>
                                                         <div class="col-md-4 col-sm-4 col-xs-4">
                                                             <p><?php echo $helps->supply_ability." ". $helps->supplyAbilityUnit->unitname; ?></p>
                                                         </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.price_1')}}</lable>
                                                        <div class="col-md-3 col-sm-3 col-xs-4">
                                                            <p>
                                                                <?php
                                                                echo $price1_unit->currency_symbol.number_format($helps->product_price1,2)." ".$price1_unit->currency_name; ?></p>
                                                        </div>
                                                        @if(count($productShipping)>0)
                                                        <div class="col-md-5 col-sm-5 col-xs-4">
                                                            @if($productShipping->shipping_type1 == 1)
                                                                <p> {{$productShipping->flatRate1->currency_symbol}} {{$productShipping->flat_rate1}} {{$productShipping->flatRate1->currency_name}} Shipping </p>
                                                            @elseif($productShipping->shipping_type1 == 2)
                                                                <p class="font-red">Free Shipping </p>
                                                            @else
                                                                <p>Cargo <a href="javascript:void(0)" onclick="onShowCargo()"><i class="fa   fa-question-circle font-red" ></i> </a></p>
                                                            @endif
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @if(count($productShipping)>0)
                                                        <div class="form-group">
                                                            <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.estimated_time')}}</lable>
                                                            <div class="col-md-8 col-sm-8 col-xs-8">
                                                               <p>{{$productShipping->estimated_time1}}</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <?php if(isset($helps->product_price2)){?>
                                                    <div class="form-group">
                                                        <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.price_2')}}</lable>
                                                        <div class="col-md-3 col-sm-3 col-xs-4">
                                                            <p>
                                                                <?php echo $price2_unit->currency_symbol. number_format($helps->product_price2,2)." ".$price2_unit->currency_name; ?>
                                                            </p>
                                                        </div>
                                                        @if(count($productShipping)>0)
                                                            <div class="col-md-5 col-sm-5 col-xs-4">
                                                                @if($productShipping->shipping_type2 == 1)
                                                                    <p> {{$productShipping->flatRate2->currency_symbol}} {{$productShipping->flat_rate2}} {{$productShipping->flatRate2->currency_name}} Shipping </p>
                                                                @elseif($productShipping->shipping_type2 == 2)
                                                                    <p class="font-red">Free Shipping </p>
                                                                @else
                                                                    <p>Cargo <a href="javascript:void(0)" onclick="onShowCargo()"><i class="fa   fa-question-circle font-red" ></i> </a></p>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <?php } ?>
                                                    @if(count($productShipping)>0)
                                                        <div class="form-group">
                                                            <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.estimated_time')}}</lable>
                                                            <div class="col-md-8 col-sm-8 col-xs-8">
                                                                <p>{{$productShipping->estimated_time2}}</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                   <?php  if(isset($helps->product_price3)){?>
                                                    <div class="form-group">
                                                        <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.price_3')}}</lable>
                                                        <div class="col-md-3 col-sm-3 col-xs-8">
                                                            <p><?php
                                                                echo $price3_unit->currency_symbol.number_format($helps->product_price3,2)." ".$price3_unit->currency_name; ?></p>
                                                        </div>
                                                        @if(count($productShipping)>0)
                                                            <div class="col-md-5 col-sm-5 col-xs-4">
                                                                @if($productShipping->shipping_type3 == 1)
                                                                    <p> {{$productShipping->flatRate3->currency_symbol}} {{$productShipping->flat_rate3}} {{$productShipping->flatRate3->currency_name}} Shipping </p>
                                                                @elseif($productShipping->shipping_type3 == 2)
                                                                    <p class="font-red">Free Shipping </p>
                                                                @else
                                                                    <p>Cargo <a href="javascript:void(0)" onclick="onShowCargo()"><i class="fa   fa-question-circle font-red" ></i> </a></p>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <?php }?>
                                                    @if(count($productShipping)>0)
                                                        <div class="form-group">
                                                            <lable class="col-md-4 col-sm-4 col-xs-4">{{Lang::get('user.estimated_time')}}</lable>
                                                            <div class="col-md-8 col-sm-8 col-xs-8">
                                                                <p>{{$productShipping->estimated_time3}}</p>
                                                            </div>
                                                        </div>
                                                    @endif
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
                                                                @if(count($productPicture)>0 && $main == 1)
                                                                    <a href="{{URL::route('user.category.product',$helps->id+100000*1)}}">
                                                                        <img src="{{HTTP_LOGO_PATH.$productPicture[0]->picture_url}}" class="additionalImage">
                                                                    </a>
                                                                @endif
                                                                @foreach($productAdditionalCategoryColor as $key =>$value)
                                                                    <?php
                                                                    $productAdditionalImage = $value->productAdditionalCategoryImage;
                                                                    ?>
                                                                    @if(count($productAdditionalImage)>0)
                                                                        <a href="{{URL::route('user.category.product',array($helps->id+100000*1,$value->id))}}">
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
                                                    <div clas="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href =" {{URL::route('user.contact',(100000*1+$helps->user_id))}}" class="btn-u btn-u-orange"> <i class=" fa fa-pencil-square-o"></i> {{Lang::get('user.contact_seller')}}</a>
                                                                <a href =" {{URL::route('user.seller.store',(100000*1+$helps->user_id))}}" class="btn-u btn-u-blue"><i class="fa fa-bars"></i> {{ Lang::get('user.seller_store') }}</a>
                                                                <a href="{{URL::route('user.showProduct',100000*1+$helps->id)}}" class="btn-u btn-u-green"><i class="fa fa-shopping-cart"></i> {{Lang::get('user.add_cart')}}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $countQuickDetails = count($quickDetails);
                        if($countQuickDetails>0) {?>
                        <div class="row" style="margin-bottom:20px">
                            <div class="col-md-12 margin-bottom-20">
                                <h2>{{Lang::get('user.quick_details')}}</h2>
                            </div>
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
                        <?php } ?>
                        <div class="row margin-bottom-40">
                            <div class="col-md-12 ">
                                 <div class="tab-v2">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#highlights-1" data-toggle="tab">{{Lang::get('user.product_description')}}</a></li>
                                        <li><a href="#highlights-2" data-toggle="tab">{{Lang::get('user.company_profile')}}</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active margin-bottom-40" id="highlights-1" >
                                           {{$helps->product_description}}
                                        </div>
                                        <div class="tab-pane fade margin-bottom-40" id="highlights-2">
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
                                    </div>
                                 </div>
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
        {{ HTML::script('/zoom/magiczoomplus.js') }}
        {{ HTML::script('/zoom/change_magiczoomplus.js') }}
        <script type="text/javascript">
            function onShowCargo(){
                $("#addCategoryModel").modal('show');
            }
        </script>
    @stop
@stop