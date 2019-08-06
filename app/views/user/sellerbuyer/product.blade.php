<div class="shop-product-heading">
    <h2>{{$product->product_name}}</h2>
</div>
<p>{{$product->product_description}}</p><br>
<?php  $productShipping =$product->productShipping;   ?>
<div class="form-horizontal">
    <div class="form-group">
        <label class="col-md-4 col-sm-4 col-xs-4">
            {{Lang::get('user.min_order')}}
        </label>
        <div class="col-md-8 col-sm-8 col-xs-8">
            {{$product->min_order." ".$product->minOrderUnit->unitname}}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 col-sm-4 col-xs-4">
            {{Lang::get('user.supply_ability')}}
        </label>
        <div class="col-md-8 col-sm-8 col-xs-8">
            {{$product->supply_ability." ".$product->supplyAbilityUnit->unitname}}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 col-sm-4 col-xs-4">
            {{Lang::get('user.less_than')."100: "}}
        </label>
        <div class="col-md-3 col-sm-3 col-xs-4">

            <p>
                @if($product->productCurrencyPrice1->currency_name !="USD")
                    {{"$".number_format(round($product->price_usd1,2),2)."USD" }} <br>
                @endif
                {{ $product->productCurrencyPrice1->currency_symbol. number_format($product->product_price1,2)." ".$product->productCurrencyPrice1->currency_name}}
            </p>
        </div>
        @if(count($productShipping)>0)
            <div class="col-md-5 col-sm-5 col-xs-4">
                @if($productShipping->shipping_type1 == 1)
                    <p>
                        @if($productShipping->flatRate1->currency_name !="USD")
                            {{"$".number_format(round($productShipping->price_usd1,2),2)."USD"}} <br>
                        @endif
                        {{$productShipping->flatRate1->currency_symbol}} {{$productShipping->flat_rate1}} {{$productShipping->flatRate1->currency_name}}
                        Shipping
                    </p>
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
    <div class="form-group">
        <label class="col-md-4 col-sm-4 col-xs-4">
            {{Lang::get('user.less_than')."500: "}}
        </label>
        <div class="col-md-3 col-sm-3 col-xs-4">
            <p>
                @if($product->productCurrencyPrice2->currency_name !="USD")
                    {{"$".number_format(round($product->price_usd2,2),2)."USD" }} <br>
                @endif
                {{ $product->productCurrencyPrice2->currency_symbol.number_format($product->product_price2,2)." ".$product->productCurrencyPrice2->currency_name}}
            </p>
        </div>
        @if(count($productShipping)>0)
            <div class="col-md-5 col-sm-5 col-xs-4">
                @if($productShipping->shipping_type2 == 1)
                    <p>
                        @if($productShipping->flatRate2->currency_name !="USD")
                            {{"$".number_format(round($productShipping->price_usd2,2),2)."USD"}} <br>
                        @endif
                        {{$productShipping->flatRate2->currency_symbol}} {{$productShipping->flat_rate2}} {{$productShipping->flatRate2->currency_name}} Shipping </p>
                @elseif($productShipping->shipping_type2 == 2)
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
                <p>{{$productShipping->estimated_time2}}</p>
            </div>
        </div>
    @endif
    <div class="form-group">
        <label class="col-md-4 col-sm-4 col-xs-4">
            {{Lang::get('user.more_than')."500: "}}
        </label>
        <div class="col-md-3 col-sm-3 col-xs-4">
            <p >
                @if($product->productCurrencyPrice3->currency_name !="USD")
                    {{"$".number_format(round($product->price_usd3,2),2)."USD" }} <br>
                @endif
                {{ $product->productCurrencyPrice3->currency_symbol.number_format($product->product_price3,2)." ".$product->productCurrencyPrice3->currency_name}}
            </p>
        </div>
        @if(count($productShipping)>0)
            <div class="col-md-5 col-sm-5 col-xs-4">
                @if($productShipping->shipping_type3 == 1)
                    <p>
                        @if($productShipping->flatRate3->currency_name !="USD")
                            {{"$".number_format(round($productShipping->price_usd3,2),2)."USD"}} <br>
                        @endif
                        {{$productShipping->flatRate3->currency_symbol}} {{$productShipping->flat_rate3}} {{$productShipping->flatRate3->currency_name}} Shipping
                    </p>
                @elseif($productShipping->shipping_type3 == 2)
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
                <p>{{$productShipping->estimated_time3}}</p>
            </div>
    </div>
    @endif
</div>
<h3 class="shop-product-title">Size</h3>
<ul class="list-inline product-size margin-bottom-30" id="sizeList">
    @if(count($productAdditionalCategorySize) >0)
        @foreach($productAdditionalCategorySize as $key_size =>$value_size)
            <li>
                <input type="radio" id="size-{{$key_size+1}}" name="size" value="{{$value_size->values}}" @if($key_size == 0) checked @endif onchange="onProductSize(this)" >
                <label for="size-{{$key_size+1}}" class="product-size-label">{{$value_size->values}}</label>
            </li>
        @endforeach
    @else
        <li>
            <input type="radio" id="size-1" name="size" value="s" onchange="onProductSize(this)">
            <label for="size-1">S</label>
        </li>
        <li>
            <input type="radio" id="size-2" name="size" value="m" onchange="onProductSize(this)">
            <label for="size-2">M</label>
        </li>
        <li>
            <input type="radio" id="size-3" name="size" value="l" checked onchange="onProductSize(this)">
            <label for="size-3">L</label>
        </li>
        <li>
            <input type="radio" id="size-4" name="size" value="xl" onchange="onProductSize(this)">
            <label for="size-4">XL</label>
        </li>
    @endif
</ul>
@if(count($productAdditionalCategoryColor)>0)
<h3 class="shop-product-title">
    {{Lang::get('user.colors')}}
</h3>
<div class="margin-bottom-40">
    <div class="row">
        <div class="col-md-12 form-horizontal">
            <div class="form-group">
                <div class="col-md-12">
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
                <div class="col-md-12">
                    @if(count($mainProductPicture)>0)
                        <a href="{{URL::route('user.showProduct',array($product->id+100000)) }}">
                            @if($id ==0)
                                <img src="{{HTTP_LOGO_PATH.$mainProductPicture[0]->picture_url}}" class="additionalImage" style="border: 1px solid red;">
                            @else
                                <img src="{{HTTP_LOGO_PATH.$mainProductPicture[0]->picture_url}}" class="additionalImage" >
                            @endif
                        </a>
                    @endif
                    @foreach($productAdditionalCategoryColor as $key =>$value)
                        <?php
                            $productAdditionalImage = $value->productAdditionalCategoryImage;
                        ?>
                        @if(count($productAdditionalImage)>0)
                            <a href="{{URL::route('user.showProduct',array($product->id+100000,$value->id))}}">
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
        </div>
    </div>
</div>

@endif
<h3 class="shop-product-title">Quantity</h3>
<div class="margin-bottom-40" style="display: inline-block">
    <form name="f1" class="product-quantity sm-margin-bottom-20" action="{{URL::route('user.addCart')}}" id="sendAddProductForm" method="post">
        <button type='button' class="quantity-button" name='subtract' onclick='javascript: subtractQty();' value='-'>-</button>
        <input type='text' class="quantity-field" name='qty' value="{{$product->min_order}}" id='qty'/>
        <input type='hidden' class="quantity-field" name='min_order_qty' value="{{$product->min_order}}" id='min_order_qty'/>
        <input type="hidden" name="productID" value="<?php echo (100000*1+ $product->id); ?>">
        <input type="hidden" name="size" id="size" value="l">
        <input type="hidden" name="image_url" id="image_url">
        <input type="hidden" name="main_id" value="{{$id}}">
        <input type="hidden" name="unit"  value="{{$product->minOrderUnit->unitname}}">
        <button type='button' class="quantity-button" name='add' onclick='javascript: SubPlusQty();' value='+'>+</button>
    </form>
</div>
<div class="margin-bottom-40">
    <button type="button" class="btn-u btn-u-sea-shop btn-u-lg margin-top-20" onclick="onChangeForm()"><i class="fa fa-shopping-cart"></i> {{Lang::get('user.add_to_cart')}}</button>

    <a href =" {{URL::route('user.seller.store',(100000*1+$helps->user_id))}}" class="btn-u btn-u-blue btn-u-lg margin-top-20"><i class="fa fa-bars"></i> {{ Lang::get('user.seller_store') }}</a>
    <a href =" {{URL::route('user.contact',(100000*1+$helps->user_id))}}" class="btn-u btn-u-orange btn-u-lg margin-top-20"> <i class=" fa fa-pencil-square-o"></i> {{Lang::get('user.contact_seller')}}</a>
</div>
<script type="text/javascript">
    function onProductSize(obj){
        var objList = $(obj).val();
        $("#size").val(objList);
    }
    function onChangeForm(){
        var selectedVal = "l";
        $("#sizeList").find("input").each(function (){
          var selected = $("input[type='radio'][name='size']:checked");
            if (selected.length > 0) {
                selectedVal = selected.val();
            }
        });
        $("#image_url").val(($(".mz-thumb-selected").find("img").attr('src')));
        $("#size").val(selectedVal);
        $("#sendAddProductForm").ajaxForm({
            success:function(data){
                if(data.result == "success"){
                    window.location.href =(data.url);
                }else{
                    bootbox.alert(data.message);
                }
            }
        }).submit();
    }


    function onShowCargo(){
        $("#addCategoryModel").modal('show');
    }
</script>