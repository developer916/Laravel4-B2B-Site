@extends('admin.layout')
@section('custom-styles')
    {{ HTML::style('/assets/assest_admin/css/jquery.validate.password.css') }}
    {{ HTML::style('/assets/assest_admin/css/bootstrap-select.min.css') }}
    {{ HTML::style('/assets/assest_admin/css/select2.css') }}
    {{ HTML::style('/assets/assest_admin/css/multi-select.css') }}
@endsection
@section('body')
    <?php use QuickDetails as QuickDetailsModel;?>

    <h3 class="page-title">Add User Management</h3>
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
                <a href="{{URL::route('admin.post.edit', $product->id)}}">Edit Product</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        Edit Product
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
                    <div class="form-horizontal" id="signupform" method="POST"
                         action="{{URL::route('admin.post.store')}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{$product->id}}" name="productID">
                        <?php $productShipping = $product->productShipping;  ?>
                        <div class="form-body">
                            @foreach ([
                               'category' => 'Category:',
                               'subcategory' => 'Sub Category:',
                               'product_name' => 'Prodcut Name:',
                               'product_description' => 'Product Description:',
                               'quick_div' => Lang::get('user.quick_details'),
                               'quick_button' => Lang::get('user.quick_button'),
                               'meta' => 'Product Meta:',
                               'product_price1' =>'Price For 1~99:',
                               'product_price2' =>'Price For 100~499:',
                               'product_price3' =>'Price For 500~100:',
                               'min_order'=>'Min Order:',
                               'supply_ability' =>'Supply Ability:',
                               'additional_category' =>'Additional Category:',
                               ]
                                as $key=> $value)
                                @if($key === 'category')
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}
                                            <span style="color:red">*</span></label>

                                        <div class="col-md-7 col-sm-7 col-xs-10">
                                            <select class="form-control" name="country_id" id="category"
                                                    onchange="onChangeCategory()">
                                                <option value="" selected="selected"> --- Select Category ---</option>
                                                @foreach($category as $categories)
                                                    @if($categories->id == $product->category_id)
                                                        <option value="{{ $categories->id }}"
                                                                selected>{{$categories->categoryname}}</option>
                                                    @else
                                                        <option value="{{ $categories->id }}">{{$categories->categoryname}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-2">
                                            <div id="spin" style="display:none;" style="margin-top: 15px"></div>
                                        </div>
                                    </div>

                                @elseif($key ==='subcategory')
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}
                                            <span style="color:red">*</span></label>

                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <select class="form-control" name="subcategory" id="subcategory">
                                                <option value=""> --- Select Sub Category ---</option>
                                                @foreach($subcategory as $subcategories)
                                                    @if($subcategories->id == $product->subcategory_id)
                                                        <option value="{{$subcategories->id}}"
                                                                selected>{{$subcategories->subcategoryname}}</option>
                                                    @else
                                                        <option value="{{$subcategories->id}}">{{$subcategories->subcategoryname}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @elseif($key ==='product_description')
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>

                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <textarea class="form-control" id="description" name="description" cols="50"
                                                      rows="10">{{$product->product_description}}</textarea>
                                            <input type="hidden" id="subContent" name="subContent"
                                                   value="{{$product->product_description}}">
                                        </div>
                                    </div>

                                @elseif($key === "quick_button")
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <button class="btn blue" style="float: right"
                                                    onclick="onShowEditQuickDetail()">{{$value}}</button>
                                            <button class="btn green" style="float:right;margin-right:10px"
                                                    onclick="onEditNewQuickDetail()">{{Lang::get('user.new_quick_detail')}}</button>
                                        </div>
                                    </div>
                                @elseif($key == "quick_div")
                                    <div class="form-group" id="quickDiv">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                            {{$value}}
                                        </label>

                                        <div class="col-md-7 col-sm-7 col-xs-12 form-horizontal"
                                             id="quickEditDivContent">
                                            @foreach($productQuickDetails as $key_productQuickDetail => $value_productQuickDetail)
                                                <div class="row form-group">
                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                        <input type="text" name="label_select_question[]"
                                                               class="form-control"
                                                               value="{{$value_productQuickDetail->categoryname}}">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <input type="text" name="quickDetails[]" class="form-control"
                                                               value="{{$value_productQuickDetail->categorycontent}}">
                                                    </div>
                                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                                        <button class="btn red" onclick="onRemoveThisItem(this)">X
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                @elseif($key === 'product_price1' )
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                            {{ Form::label($key, $value) }}
                                            <?php
                                            if ($key === "product_price1") {
                                                echo '<span style="color:red">*</span>';
                                            }
                                            ?>
                                        </label>

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            {{ Form::text($key,$product->$key, ['class' => 'form-control','placeholder'=>$value]) }}
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            {{ Form::select($key
                                                ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                , $product->price1_currency
                                                , array('class' => 'form-control','name'=>$key.'currency')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row margin-bottom-30">
                                            <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12">
                                                <div class="radio-list">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="shipping1" @if(count($productShipping)>0) @if($productShipping->shipping_type1 == 1) checked @endif @else checked @endif value= "1" onchange="onChangeShipping(1,1)"> Normal
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="shipping1" @if(count($productShipping)>0) @if($productShipping->shipping_type1 == 2) checked @endif @endif value= "2"  onchange="onChangeShipping(1,2)"> Free Shipping
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio"  name="shipping1" @if(count($productShipping)>0) @if($productShipping->shipping_type1 == 3) checked @endif @endif value= "3" value= "3" onchange="onChangeShipping(1,3)"> Cargo
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12" >
                                                <div class="row">
                                                    <div class="col-md-12 margin-bottom-20" id="flatRate1" @if(count($productShipping)>0) @if($productShipping->shipping_type1 != 1) style="display: none" @endif @endif>
                                                        <div class="form-group ">
                                                            <label class="col-md-3 col-sm-3 col-xs-12">{{Lang::get('user.flat_rate')}} <span style="color:red">*</span> </label>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <input type="text" class="form-control" name="flatRate1" placeholder="{{Lang::get('user.flat_rate')}}" value ="@if(count($productShipping)>0){{($productShipping->flat_rate1)}}@endif">
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                @if(count($productShipping)>0)
                                                                    {{ Form::select($key
                                                                           ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                                           , $productShipping->add1
                                                                           , array('class' => 'form-control','name'=>'flatRateCurrency1')) }}
                                                                @else
                                                                    {{ Form::select($key
                                                                           ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                                           , null
                                                                           , array('class' => 'form-control','name'=>'flatRateCurrency1')) }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <p>{{Lang::get('user.normal_text')}}</p>
                                                    </div>
                                                    <div class="col-md-12 margin-bottom-20"  id="cargoDiv1" @if(count($productShipping)>0) @if($productShipping->shipping_type1 != 3) style="display: none" @endif @endif>
                                                        <p>{{Lang::get('user.cargo_text')}}</p>
                                                    </div>
                                                    <div class="col-md-12 margin-bottom-20">
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-sm-3 col-xs-4">{{Lang::get('user.estimated_time')}} <span style="color:red">*</span> </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-8">
                                                                <input type="text" class="form-control" name="estimatedTime1" placeholder="eg: 1 week" value="@if(count($productShipping)>0){{$productShipping->estimated_time1}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($key === 'product_price2' )
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                            {{ Form::label($key, $value) }}
                                        </label>

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            {{ Form::text($key,$product->$key, ['class' => 'form-control','placeholder'=>$value]) }}
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            {{ Form::select($key
                                                ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                , $product->price2_currency
                                                , array('class' => 'form-control','name'=>$key.'currency')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row margin-bottom-30">
                                            <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12">
                                                <div class="radio-list">
                                                    <label class="radio-inline">

                                                        <input type="radio" name="shipping2" @if(count($productShipping)>0) @if($productShipping->shipping_type2 == 1) checked @endif @else checked @endif value= "1" onchange="onChangeShipping(2,1)"> Normal
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="shipping2" @if(count($productShipping)>0) @if($productShipping->shipping_type2 == 2) checked @endif @endif value= "2"  onchange="onChangeShipping(2,2)"> Free Shipping
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio"  name="shipping2" @if(count($productShipping)>0) @if($productShipping->shipping_type2 == 3) checked @endif @endif value= "3" value= "3" onchange="onChangeShipping(2,3)"> Cargo
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12" >
                                                <div class="row">
                                                    <div class="col-md-12 margin-bottom-20" id="flatRate2" @if(count($productShipping)>0) @if($productShipping->shipping_type2 != 1) style="display: none" @endif @endif>
                                                        <div class="form-group ">
                                                            <label class="col-md-3 col-sm-3 col-xs-12">{{Lang::get('user.flat_rate')}} <span style="color:red">*</span></label>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <input type="text" class="form-control" name="flatRate2" placeholder="{{Lang::get('user.flat_rate')}}" value ="@if(count($productShipping)>0){{($productShipping->flat_rate2)}}@endif">
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                @if(count($productShipping)>0)
                                                                    {{ Form::select($key
                                                                           ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                                           , $productShipping->add2
                                                                           , array('class' => 'form-control','name'=>'flatRateCurrency2')) }}
                                                                @else
                                                                    {{ Form::select($key
                                                                           ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                                           , null
                                                                           , array('class' => 'form-control','name'=>'flatRateCurrency2')) }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <p>{{Lang::get('user.normal_text')}}</p>
                                                    </div>
                                                    <div class="col-md-12 margin-bottom-20"  id="cargoDiv2" @if(count($productShipping)>0) @if($productShipping->shipping_type2 != 3) style="display: none" @endif @endif>
                                                        <p>{{Lang::get('user.cargo_text')}}</p>
                                                    </div>
                                                    <div class="col-md-12 margin-bottom-20">
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-sm-3 col-xs-4">{{Lang::get('user.estimated_time')}} <span style="color:red">*</span></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-8">
                                                                <input type="text" class="form-control" name="estimatedTime2" placeholder="eg: 1 week" value="@if(count($productShipping)>0){{$productShipping->estimated_time2}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($key === 'product_price3' )
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                            {{ Form::label($key, $value) }}
                                        </label>

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            {{ Form::text($key,$product->$key, ['class' => 'form-control','placeholder'=>$value]) }}
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            {{ Form::select($key
                                                ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                , $product->price3_currency
                                                , array('class' => 'form-control','name'=>$key.'currency')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row margin-bottom-30">
                                            <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12">
                                                <div class="radio-list">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="shipping3" @if(count($productShipping)>0) @if($productShipping->shipping_type3 == 1) checked @endif @else checked @endif value= "1" onchange="onChangeShipping(3,1)"> Normal
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="shipping3" @if(count($productShipping)>0) @if($productShipping->shipping_type3 == 2) checked @endif @endif value= "2"  onchange="onChangeShipping(3,2)"> Free Shipping
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio"  name="shipping3" @if(count($productShipping)>0) @if($productShipping->shipping_type3 == 3) checked @endif @endif value= "3" value= "3" onchange="onChangeShipping(3,3)"> Cargo
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12" >
                                                <div class="row">
                                                    <div class="col-md-12 margin-bottom-20" id="flatRate3" @if(count($productShipping)>0) @if($productShipping->shipping_type3 != 1) style="display: none" @endif @endif>
                                                        <div class="form-group ">
                                                            <label class="col-md-3 col-sm-3 col-xs-12">{{Lang::get('user.flat_rate')}} <span style="color:red">*</span></label>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <input type="text" class="form-control" name="flatRate3" placeholder="{{Lang::get('user.flat_rate')}}" value ="@if(count($productShipping)>0){{($productShipping->flat_rate3)}}@endif">
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                @if(count($productShipping)>0)
                                                                    {{ Form::select($key
                                                                           ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                                           , $productShipping->add3
                                                                           , array('class' => 'form-control','name'=>'flatRateCurrency3')) }}
                                                                @else
                                                                    {{ Form::select($key
                                                                           ,array('' => ' --- Select Currency --- ') +  $currency->lists('currency_name', 'id')
                                                                           , null
                                                                           , array('class' => 'form-control','name'=>'flatRateCurrency3')) }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <p>{{Lang::get('user.normal_text')}}</p>
                                                    </div>
                                                    <div class="col-md-12 margin-bottom-20"  id="cargoDiv3" @if(count($productShipping)>0) @if($productShipping->shipping_type3 != 3) style="display: none" @endif @endif>
                                                        <p>{{Lang::get('user.cargo_text')}}</p>
                                                    </div>
                                                    <div class="col-md-12 margin-bottom-20">
                                                        <div class="form-group">
                                                            <label class="col-md-3 col-sm-3 col-xs-4">{{Lang::get('user.estimated_time')}} <span style="color:red">*</span></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-8">
                                                                <input type="text" class="form-control" name="estimatedTime3" placeholder="eg: 1 week" value="@if(count($productShipping)>0){{$productShipping->estimated_time3}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($key === "min_order")
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                            {{ Form::label($key, $value) }}
                                            <span style="color:red">*</span>
                                        </label>

                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            {{ Form::text($key, $product->$key, ['class' => 'form-control','placeholder'=>$value]) }}
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            {{ Form::select($key
                                              ,array('' => ' --- Select Unit --- ') +  $unit->lists('unitname', 'id')
                                              , $product->min_order_unit
                                              , array('class' => 'form-control','name'=>$key.'unit')) }}
                                        </div>
                                    </div>
                                @elseif($key === "additional_category")
                                    <div class="form-group" id="addtionalCategoryDiv">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                            {{ Form::label($key, $value) }}
                                        </label>

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="additionalCategory" class="form-control"
                                                    onchange="onChangeAdditionalCategory()" id="additionalCategory">
                                                <option value=""> -- Select Additional Category --</option>
                                                @foreach($additionalCategories as $key_category =>$value_category)
                                                    @if($product->additional_category_id == $value_category->id)
                                                        <option value="{{$value_category->id}}"
                                                                selected>{{$value_category->categoryname}}</option>
                                                    @else
                                                        <option value="{{$value_category->id}}">{{$value_category->categoryname}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @elseif($key === "supply_ability")
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                            {{ Form::label($key, $value) }}
                                            <span style="color:red">*</span>
                                        </label>

                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            {{ Form::text($key, $product->$key, ['class' => 'form-control','placeholder'=>$value]) }}
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            {{ Form::select($key
                                              ,array('' => ' --- Select Unit --- ') +  $unit->lists('unitname', 'id')
                                              , $product->supply_ability_unit
                                              , array('class' => 'form-control','name'=>$key.'unit')) }}
                                        </div>
                                    </div>

                                @else
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                            {{ Form::label($key, $value) }}
                                            <?php
                                            if ($key === "product_name" || $key === "meta" || $key === "min_order" || $key === "supply_ability") {
                                                echo '<span style="color:red">*</span>';
                                            }
                                            ?>
                                        </label>
                                        <?php if($key === "product_name" || $key === "meta"){ ?>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            {{ Form::text($key, $product->$key, ['class' => 'form-control','placeholder'=>$value]) }}
                                        </div>
                                        <?php } else if($key === "min_order"){?>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            {{ Form::text($key, $product->$key, ['class' => 'form-control','placeholder'=>$value]) }}
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            {{ Form::select($key
                                                ,array('' => ' --- Select Unit --- ') +  $unit->lists('unitname', 'id')
                                                , $product->min_order_unit
                                                , array('class' => 'form-control','name'=>$key.'unit')) }}
                                        </div>
                                        <?php } ?>
                                    </div>
                                @endif
                            @endforeach
                            @if($product->additional_category_id == 3 || $product->additional_category_id == 1 )
                                <div class="form-group" id="size">
                                    @else
                                        <div class="form-group" id="size" style="display: none;">
                                            @endif
                                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                                Sizes
                                            </label>

                                            <div class="col-md-7 col-sm-7 col-xs-12">
                                                <p>The numeric or text version of the item's size.</p>
                                                @if($product->additional_category_id == 3 || $product->additional_category_id == 1 )
                                                    @foreach($productAdditionalCategorySize as $key_size =>$value_size)
                                                        <input type="text"
                                                               class="form-control margin-bottom-10 changeSize"
                                                               name="size[]" onchange="onChangeSizeList(this)"
                                                               id="sizeInput" value="{{$value_size->values}}">
                                                    @endforeach
                                                @endif
                                                <input type="text" class="form-control margin-bottom-10 changeSize"
                                                       name="size[]" onchange="onChangeSizeList(this)" id="sizeInput">

                                                <p>Example: 2T, 6X, 12, Small, X-Large, 18 months, 14 Tall, 28Wx32L</p>
                                            </div>
                                        </div>
                                        @if($product->additional_category_id == 3 || $product->additional_category_id == 2 )
                                            <div class="form-group" id="color">
                                                @else
                                                    <div class="form-group" id="color" style="display: none">
                                                        @endif
                                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                                            Colors
                                                        </label>

                                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                                            <p>The color of the item.</p>
                                                            @if($product->additional_category_id == 3 || $product->additional_category_id == 2 )
                                                                @foreach($productAdditionalCategoryColor as $key_color =>$value_color)
                                                                    <input type="text"
                                                                           class="form-control margin-bottom-10 changeSize"
                                                                           name="color[]"
                                                                           onchange="onChangeColorList(this)"
                                                                           id="colorInput"
                                                                           value="{{$value_color->values}}">
                                                                @endforeach
                                                            @endif
                                                            <input type="text"
                                                                   class="form-control margin-bottom-10 changeSize"
                                                                   name="color[]" onchange="onChangeColorList(this)"
                                                                   id="colorInput">

                                                            <p>Example: Red, Navy Blue, Pink, Green</p>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-7 col-md-5">
                                                        <button class="btn  blue" type="button"
                                                                onclick="onSaveProduct()"><i
                                                                    class="fa fa-check-circle-o"
                                                                    style="margin-right:4px"></i>Save
                                                        </button>
                                                        <a class="btn  green" href="{{URL::route('admin.post')}}"><i
                                                                    class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group" id="quick_detail_form_group_clone" style="display: none">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <input type="text" name="label_select_question[]" class="form-control">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" name="quickDetails[]" class="form-control">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <button class="btn red" onclick="onRemoveThisItem(this)">X</button>
                </div>
            </div>
            <div class="modal fade" id="editItemModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                            <h4 id="myModalLabel1" class="modal-title">{{Lang::get('user.edit_product')}}</h4>
                        </div>
                        <div class="modal-body" id="EditItemModalBody">
                            <div class="form-horizontal" id="addQuickDetailFormDiv">
                                <div class="alert alert-danger fade in" style="display: none" id="alertDangerFadeIn">
                                    {{Lang::get('user.please_check_quick_details')}}
                                </div>
                                @foreach($quickDetailsCategory as $key_category =>$value_category)
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <h3><?php
                                                $category = QuickDetailsModel::getCategory($value_category->category_id);
                                                echo $category->categoryname;?>
                                            </h3>
                                        </div>
                                    </div>
                                    <?php
                                    $lists = QuickDetailsModel::getAll($value_category->category_id);
                                    ?>
                                    @foreach($lists as $key_list =>$value_key)
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="checkbox" name="quick_details[]"
                                                       value="{{ucfirst($value_key->quick_details_name);}}"> {{ucfirst($value_key->quick_details_name)}}
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                        <button class="btn blue" type="button" onclick="onChangeAddQuickDetail()"><i
                                                    class="fa fa-check-circle-o"
                                                    style="margin-right:4px"></i>{{Lang::get('user.save')}}</button>
                                        <button class="btn default" type="button" onclick="onReturnFirstDiv()"><i
                                                    class="fa fa-repeat"
                                                    style="margin-right:4px"></i>{{Lang::get('user.cancel')}}</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @stop
            @section('custom-scripts')
                {{ HTML::script('/assets/assest_admin/js/select2.min.js') }}
                {{ HTML::script('/assets/assest_admin/js/jquery.multi-select.js') }}
                {{ HTML::script('/assets/assest_admin/js/bootstrap-select.min.js') }}
                {{ HTML::script('/assets/assest_admin/js/components-dropdowns.js') }}
                {{ HTML::script('/assets/assest_admin/js/spin.js') }}
                {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
                <script>
                    $(document).ready(function () {
                        $("input#imageUploadPostBuy").change(function () {
                            var base_url = window.location.origin;
                            var postUrl = base_url + '/admin/listing/post/specificationPicutre';
                            var imageUploadObj = $(this);
                            var html = "<form id='file_upload_form' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                            imageUploadObj.wrap(html);
                            $(this).parent().ajaxForm({
                                success: function (data) {
                                    if (data.result == "success") {
                                        var cnt = imageUploadObj.closest("form#file_upload_form").contents();
                                        imageUploadObj.closest("form#file_upload_form").replaceWith(cnt);
                                        var htmlObj = "<div class='img-wrap'>" + data.content + "<input type='hidden' value='" + data.url + "' name='image[]'><div class='close-button'></div></div>";
                                        $("#previewNewsImageBuy").append(htmlObj);
                                        $("#previewNewsImageBuy").find(".img-wrap").each(function () {
                                            $(this).find(".close-button").click(function () {
                                                $(this).parent().remove();
                                            });
                                        });
                                    } else if (data.result == "failed") {
                                        var arr = data.error;
                                        var errorList = '';
                                        $.each(arr, function (index, value) {
                                            if (value.length != 0) {
                                                errorList = errorList + value;
                                            }
                                        });
                                        bootbox.alert(errorList);
                                    }
                                }
                            }).submit();
                        });
                        $("#previewNewsImageBuy").find(".img-wrap").each(function () {
                            $(this).find(".close-button").click(function () {
                                $(this).parent().remove();
                            });
                        });
                    });
                    function onChangeCategory() {
                        $("#spin").css('display', 'block');
                        var opts = {
                            lines: 7, // The number of lines to draw
                            length: 6, // The length of each line
                            width: 5, // The line thickness
                            radius: 8, // The radius of the inner circle
                            corners: 1, // Corner roundness (0..1)
                            rotate: 90, // The rotation offset
                            direction: 1, // 1: clockwise, -1: counterclockwise
                            color: '#000', // #rgb or #rrggbb or array of colors
                            speed: 0.7, // Rounds per second
                            trail: 60, // Afterglow percentage
                            shadow: false, // Whether to render a shadow
                            hwaccel: false, // Whether to use hardware acceleration
                            className: 'spinner', // The CSS class to assign to the spinner
                            zIndex: 2e9, // The z-index (defaults to 2000000000)
                            top: 'auto', // Top position relative to parent in px
                            left: 'auto' // Left position relative to parent in px
                        };
                        var target = document.getElementById('spin');
                        var spinner = new Spinner(opts).spin(target);
                        var categoryID = $("#category").val();
                        var base_url = window.location.origin;
                        $.ajax({
                            url: base_url + '/admin/listing/post/getSubcategory',
                            type: 'POST',
                            data: {categoryID: categoryID},
                            cache: false,
                            dataType: "json",
                            success: function (data) {
                                $("#spin").css('display', 'none');
                                if (data.result == "success") {
                                    $("#subcategory").find("option").remove();
                                    $("#subcategory").append('<option value=""> --- Select Sub Category --- </option>');
                                    if (data.subcategory.length > 0) {
                                        for (var i = 0; i < data.subcategory.length; i++) {
                                            $("#subcategory").append('<option value="' + data.subcategory[i]['id'] + '">' + data.subcategory[i]['subcategoryname'] + '</option>');
                                        }
                                    } else {
                                        $("#subcategory").find("option").remove();
                                        $("#subcategory").append('<option value="">--- Select Sub Category --- </option>');
                                    }
                                }
                            }
                        });
                    }
                    function onSaveProduct() {
                        var subContent = $("#description").val();
                        $('#subContent').val(subContent);
                        var base_url = window.location.origin;
                        var postUrl = base_url + '/admin/listing/post/store';
                        var imageUploadObj = $("#signupform");
                        var html = "<form id='file_upload_product_store' method='post' action='" + postUrl + "' enctype='multipart/form-data'></form>";
                        imageUploadObj.wrap(html);
                        $("#signupform").parent().ajaxForm({
                            success: function (data) {
                                var cnt = imageUploadObj.closest("form#file_upload_product_store").contents();
                                imageUploadObj.closest("form#file_upload_product_store").replaceWith(cnt);
                                if (data.result == "success") {
                                    bootbox.alert("Your product has been updated successfully");
                                    window.location.href = data.url;
                                } else {
                                    var arr = data.error;
                                    var errorList = '';
                                    $.each(arr, function (index, value) {
                                        if (value.length != 0) {
                                            errorList = errorList + value;
                                        }
                                    });
                                    bootbox.alert(errorList);
                                }
                            }
                        }).submit();
                    }

                    function onChangeAdditionalCategory() {
                        var id = $("#additionalCategory").val();
                        if (id == 1) {
                            $("#size").show();
                            $("#color").hide();
                        } else if (id == 2) {
                            $("#size").hide();
                            $("#color").show();
                        } else if (id == 3) {
                            $("#size").show();
                            $("#color").show();
                        } else if (id == 0) {
                            $("#size").hide();
                            $("#color").hide();
                        }
                    }
                    function onChangeSizeList(obj) {
                        var value = $(obj).val();
                        if (value == "") {
                            $(obj).remove();
                        } else {
                            var disc = $(obj).next();
                            if(disc.prop("tagName") != "INPUT") {
                                if (disc.val() == "") {
                                    $(obj).after('<input type="text" class="form-control margin-bottom-10 changeSize" name="size[]" onchange="onChangeSizeList(this)" id="sizeInput">');
                                }
                            }
                        }
                    }
                    function onChangeColorList(obj) {
                        var value = $(obj).val();
                        if (value == "") {
                            $(obj).remove();
                        } else {
                            var disc = $(obj).next();
                            if(disc.prop("tagName") != "INPUT"){
                                if (disc.val() == "") {
                                    $(obj).after('<input type="text" class="form-control margin-bottom-10 changeSize" name="color[]"  onchange="onChangeColorList(this)" id="colorInput">');
                                }
                            }

                        }
                    }
                    function onEditNewQuickDetail() {
                        var obj_clone = $("#quick_detail_form_group_clone").clone();
                        var size = $("#quickEditDivContent").find(".form-group").size();
                        obj_clone.attr("id", "spcificationDescriptionDiv" + size);
                        obj_clone.show();
                        if (size == 0) {
                            $("#quickEditDivContent").append(obj_clone);
                        } else {
                            $("#quickEditDivContent").find("div.form-group:last").after(obj_clone);
                        }
                    }
                    function onRemoveThisItem(obj) {
                        $(obj).parents('div.form-group').eq(0).remove();
                    }
                    function onShowEditQuickDetail() {
                        $("#editItemModel").modal('show');
                    }
                    function onReturnFirstDiv() {
                        $("#editItemModel").modal('hide');
                    }
                    function onChangeAddQuickDetail() {
                        $("#alertDangerFadeIn").hide();
                        var selected = [];
                        var key = 0;
                        $('#addQuickDetailFormDiv input:checked').each(function () {
                            selected[key] = $(this).attr('value');
                            key++;
                        });
                        var selectLength = selected.length;
                        if (selectLength == 0) {
                            $("#alertDangerFadeIn").show();
                            return;
                        } else {
                            var i = 0;
                            var kk;
                            for (i = 0; i < selectLength; i++) {
                                var kk = 0;
                                $('#quickEditDivContent').find("div.form-group input[name='label_select_question[]']").each(function () {
                                    if ($(this).val() == selected[i]) {
                                        kk++;
                                    }
                                });
                                if (kk == 0) {
                                    var questionDetail = '<div class="row form-group">' + '<div class="col-md-4 col-sm-4 col-xs-4">' + '<input type="text" name="label_select_question[]" class="form-control" value="' + selected[i] + '" style="border:0px!important;" disable>' + '</div>' + '<div class="col-md-6 col-sm-6 col-xs-6">' + '<input type="text" name="quickDetails[]" class="form-control">' + '</div>' + '<div class="col-md-2 col-sm-2 col-xs-2">' + '<button class="btn  red" onclick="onRemoveThisItem(this)">X</button>' + '</div>' + '</div>';
                                    $("#quickEditDivContent").append(questionDetail);
                                }

                            }
                        }
                        $("#editItemModel").modal('hide');
                    }
                    /*****functions on change shipping method *****/
                    function onChangeShipping(divID , id){
                        if(id == 1){
                            $("#flatRate"+divID).show();
                            $("#cargoDiv"+divID).hide();
                        }else if(id == 2){
                            $("#flatRate"+divID).hide();
                            $("#cargoDiv"+divID).hide();
                        }else if(id == 3){
                            $("#flatRate"+divID).hide();
                            $("#cargoDiv"+divID).show();
                        }
                    }
                </script>
@stop
@stop
