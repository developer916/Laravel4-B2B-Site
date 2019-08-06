<div class="container ">
    @foreach($listSubCategory as $key =>$listSubCategorys)
        <div class="row">
            <div class="col-md-12 margin-bottom-40" style="border-bottom: 2px solid #ddd8e5">
                <h3>{{ucfirst($listSubCategorys->subCategory->subcategoryname)}}</h3>
            </div>
        </div>
        <div class="row news-v2 margin-bottom-40">
            @foreach($listProduct[$key] as $keyCheck => $listProductItem)
                <div class="col-md-4 col-sm-6  sm-margin-bottom-30" style="margin-bottom: 30px">
                    <div class="news-v2-badge">
                        <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
                        <!-- <a href="javascript:void(0)" onclick="onEditProduct(<?php echo $listProductItem->id+100000*1;?>)" title="{{Lang::get('user.edit_product')}}"> -->
                        <a href="{{URL::route('user.seller.productEdit',$listProductItem->id +100000)}}" title="{{Lang::get('user.edit_product')}}" target="_blank">
                            <img src = "<?php echo HTTP_PATH ?>/assets/media/images/camera.jpg" class="seller_store_add_picture_company">
                        </a>
                        <?php }?>
                        <div class="carousel slide" data-ride="carousel" id="blog-carousel<?php echo $key.$keyCheck;?>">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <?php for( $i=0; $i<count($product_picture[$key][$keyCheck]); $i++){?>
                                <li data-target="#blog-carousel<?php echo $key.$keyCheck;?>" data-slide-to="<?php echo $i; ?>" class="<?php if($i==0){echo 'active';}?> rounded-x"></li>
                                <?php }?>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php for( $i=0; $i<count($product_picture[$key][$keyCheck]); $i++){?>
                                <div class="item <?php if($i ==0) {echo 'active';}?>" style="text-align: center;">
                                    <a href="{{URL::route('user.category.product' ,(100000*1+$listProductItem->id))}}" target="_blank" style="font-weight: 700; text-transform: uppercase;">
                                      <img src="{{HTTP_LOGO_PATH.$product_picture[$key][$keyCheck][$i]->picture_url}}" alt="" style="height:228px; text-align: center;display:inline-block">
                                  </a>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="news-v2-desc bg-color-light">
                        <h3><a href="{{URL::route('user.category.product' ,(100000*1+$listProductItem->id))}}" target="_blank" style="font-weight: 700; text-transform: uppercase;">{{$listProductItem->product_name}}</a></h3>
                        <div class="row">
                            <div class="col-md-7 col-sm-7 col-xs-7">
                                <p>{{$listProductItem->productCurrencyPrice1->currency_symbol.number_format($listProductItem->product_price1,2)." ". $listProductItem->productCurrencyPrice1->currency_name}}</p>
                                <p><b>{{Lang::get('user.min_order')}} </b>{{$listProductItem->min_order." ".$listProductItem->minOrderUnit->unitname}}</p>
                                <p><b>{{Lang::get('user.supply_ability')}} </b>{{$listProductItem->supply_ability." ". $listProductItem->supplyAbilityUnit->unitname}}</p>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-5">
                                <a href="{{URL::route('user.category.product' ,(100000*1+$listProductItem->id))}}" class="btn-u btn-u-blue" target="_blank" class="sellerStoreProduct">Read More</a>
                                {{--<form action="{{URL::route('user.seller.store.contact',$user_id)}}" method="post" class="margin-top-10">--}}
                                    {{--<input type="hidden" name="subject" value="{{$listProductItem->product_name}}">--}}
                                    {{--<input type="submit" value="{{Lang::get('user.contact_seller')}}" class="btn-u btn-u-green">--}}
                                {{--</form>--}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>