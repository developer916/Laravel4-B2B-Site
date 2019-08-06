@extends('user.seller.storeLayout')
      @section('custom-styles')
       {{HTML::style('/assets/asset_view/css/style.css')}}
       {{ HTML::style('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.css') }}
        {{ HTML::style('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}
        {{HTML::style('/assets/asset_view/css/blocks.css')}}
     @stop
    @section('body')
         <div class="breadcrumbs">
            <div class="container">
                <h1 class="pull-left">
                    <?php
                        echo ucfirst($companyProfile[0]->companyname)." ".Lang::get('user.layout_categories');
                    ?>
                </h1>
                 <ul class="pull-right breadcrumb">
                        <li><a href="{{URL::route('user.seller.store',$user_id)}}">{{Lang::get('user.layout_home')}}</a></li>
                        <li class="active"><a href="{{URL::route('user.seller.category',$user_id)}}"><?php echo ucfirst($companyProfile[0]->companyname)." ".Lang::get('user.layout_categories');?></a></li>
                    </ul>
            </div>
        </div>
        <div class="container content">
            <div class="row">
                <div  class="col-md-3 col-sm-3">
                  <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                    @foreach($subCategory as $key=>$subCategoryItem)
                         <li class="list-group-item">
                           <a href="{{URL::route('user.seller.sub',array($user_id,(100000*1+$subCategoryItem->subcategory_id)))}}">{{ucfirst($subCategoryItem->SubCategory->subcategoryname)}}</a>
                          </li>
                    @endforeach
                  </ul>
                </div>
                <div class="col-md-9 col-sm-9">
                    <div class="row news-v2 margin-bottom-40">
                        @foreach($helps as $key=> $listProductItem)
                            <div class="col-md-6 col-sm-6  sm-margin-bottom-30" style="margin-bottom: 30px">
                                <div class="news-v2-badge">
                                    <div class="carousel slide" data-ride="carousel" id="blog-carousel<?php echo $key;?>">
                                          <!-- Indicators -->
                                          <ol class="carousel-indicators">
                                            <?php for( $i=0; $i<count($product_picture[$key]); $i++){?>
                                              <li data-target="#blog-carousel<?php echo $key;?>" data-slide-to="<?php echo $i; ?>" class="<?php if($i==0){echo 'active';}?> rounded-x"></li>
                                              <?php }?>
                                          </ol>

                                          <!-- Wrapper for slides -->
                                        <div class="carousel-inner" role="listbox">
                                           <?php for( $i=0; $i<count($product_picture[$key]); $i++){?>
                                              <div class="item <?php if($i ==0) {echo 'active';}?>">
                                                  <img src="{{$product_picture[$key][$i]->picture_url}}" alt="" style="width: 100%;">
                                              </div>
                                           <?php }?>
                                          </div>
                                      </div>
                                </div>
                                <div class="news-v2-desc bg-color-light">
                                    <h3><a href="{{URL::route('user.category.product' ,(100000*1+$listProductItem->id))}}" target="_blank" style="font-weight: 700; text-transform: uppercase;">{{$listProductItem->product_name}}</a></h3>
                                    <div class="row">
                                        <div class="col-md-7 col-sm-7 col-xs-7">
                                            <p><b>{{Lang::get('user.min_order')}} </b>{{$listProductItem->min_order." ".$listProductItem->minOrderUnit->unitname }}</p>
                                            <p><b>{{Lang::get('user.supply_ability')}} </b>{{$listProductItem->supply_ability." ".$listProductItem->supplyAbilityUnit->unitname}}</p>
                                        </div>
                                        <div class="col-md-5 col-sm-5 col-xs-5">
                                         <a href="{{URL::route('user.category.product' ,(100000*1+$listProductItem->id))}}" class="btn-u btn-u-blue" target="_blank" class="sellerStoreProduct">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
            {{ HTML::script('/assets/asset_view/js/video.js') }}
            {{ HTML::script('/assets/asset_view/js/video.min.js') }}
            {{ HTML::script('/assets/asset_view/js/app.js') }}
            {{ HTML::script('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.pack.js') }}
            {{ HTML::script('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}
            {{ HTML::script('/assets/asset_view/js/plugins/fancy-box.js') }}
            {{ HTML::script('/assets/asset_view/js/plugins/owl-carousel.js') }}
            <script type="text/javascript">
                jQuery(document).ready(function() {
                        App.init();
                        FancyBox.initFancybox();
                        OwlCarousel.initOwlCarousel();
                    });
            </script>

        @stop
@stop