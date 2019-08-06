@extends('user.layout')
     @section('custom-styles')
         {{HTML::style('/assets/asset_view/plugins/animate.css')}}
         {{HTML::style('/assets/asset_view/css/blocks.css')}}
         {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
         {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
         {{HTML::style('/assets/asset_view/css/forestChange.css')}}
     @stop
    @section('body')

        <div class="breadcrumbs">
            <div class="container">
                <ul class="pull-left breadcrumb">
                    <li><a href="{{route('user.home')}}">Home</a></li>
                    <li><a href="{{route('user.category')}}">All Categories</a></li>
                    <li> {{$selectedCategory->categoryname}}</li>
                    <li class="active"> <a href="{{route('user.category.sub',100000*1+$subCategoryID->id)}}">{{$subCategoryID->subcategoryname}}</a></li>
                </ul>
            </div>
        </div>
        <div class="container" style="margin-top: 40px;">

            <div class="row">
                <div class="col-md-3 col-sm-3" >
                    <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                       <?php $i=0;?>
                       @foreach($category as $categories)
                          <li class="list-group-item list-toggle <?php if($selectCategory==$categories->id) {echo "active";}?>">
                               <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse<?php echo $i;?>">{{$categories->categoryname}}</a>
                               <ul id="collapse<?php echo $i;?>" <?php if($selectCategory==$categories->id) {?> class="collapse in" aria-expanded="true" <?php }else{?>class="collapse"<?php }?>>
                                   <?php $subCategory = $categories->subCategories;?>
                                   @foreach($subCategory as $subCategories)
                                       <li class="<?php if($subCategories->id ==$selectSubCategory ){echo "active";} ?>">
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
                @foreach($helps as $help)
                    <div class="row margin-bottom-40">
                         <div class="shadow-wrapper">
                             <blockquote class="hero box-shadow shadow-effect-2">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
                                        <?php
                                            $productImage = $help->productpicture;
                                        ?>
										<a href="{{URL::route('user.showProduct',(100000*1+$help->id))}}">
                                        @if(count($productImage)>0)
                                        <img src="{{HTTP_LOGO_PATH.$productImage[0]->picture_url}}" class="imageUrl">
                                        @else
                                            <img src="/assets/asset_view/img/main/img1.jpg" class="imageUrl">
                                        @endif
										</a>
                                    </div>
                                    <div class="col-md-8 col-sm-8">
                                        <div class="row">
                                            <div class="col-md-12 margin-bottom-20">
                                                <a href="{{URL::route('user.showProduct',(100000*1+$help->id))}}" class="helpSize">{{$help->product_name}}</a>
                                            </div>
                                            <div class="col-md-12 margin-bottom-20">
                                                 <p>
                                                     {{$help->productCurrencyPrice1->currency_symbol.number_format($help->product_price1,2)." ". $help->productCurrencyPrice1->currency_name}}
                                                 </p>
                                                 <p>
                                                    {{Lang::get('user.min_order')}}
                                                    <?php echo $help->min_order." ".$help->minOrderUnit->unitname ;?>
                                                 </p>
                                                 <p>
                                                     {{Lang::get('user.supply_ability')}}
                                                     <?php echo $help->supply_ability." ".$help->supplyAbilityUnit->unitname ;?>
                                                  </p>
                                                  {{--<p>--}}
                                                    {{--{{Lang::get('user.meta')}}--}}
                                                    <?php // echo $help->meta ;?>
                                                  {{--</p>--}}
                                                <p>
                                                    <img src="{{HTTP_LOGO_PATH.$help->member->country->country_flag}}">
                                                    {{$help->member->country->country_name}}
                                                </p>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <a href="{{URL::route('user.contact',(100000*1+$help->user_id))}}" class="btn-u btn-u-orange" target="_blank"><i class=" fa fa-pencil-square-o"></i> {{Lang::get('user.contact_seller')}}</a>
                                                <a href = "{{URL::route('user.seller.store',(100000*1+$help->user_id))}}" class="btn-u btn-u-blue" target="_blank"><i class="fa fa-bars"></i> {{Lang::get('user.seller_store')}}</a>
                                                {{--<form action="{{URL::route('user.addCart')}}" method="post" style="display: inline-block;">--}}
                                                    {{--<input type="hidden" name="product_id" value="{{(100000*1+$help->id)}}">--}}
                                                    {{--<button type="submit" class="btn-u btn-u-green"><i class="fa fa-shopping-cart"></i> {{Lang::get('user.add_cart')}}</button>--}}
                                                {{--</form>--}}
                                                <a href="{{URL::route('user.showProduct',100000*1+$help->id)}}" class="btn-u btn-u-green"><i class="fa fa-shopping-cart"></i> {{Lang::get('user.add_cart')}}</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                             </blockquote>
                         </div>
                    </div>
                @endforeach
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            {{ $helps->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop
@stop
