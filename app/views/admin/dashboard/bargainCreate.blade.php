@extends('admin.layout')
@section('body')
    <h3 class="page-title">Home Bargain  Management</h3>
     <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <i class="fa fa-pencil"></i>
                <a href="{{URL::route('admin.home.bargain')}}">Bargains</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{URL::route('admin.home.bargain.create')}}">Add Bargain</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
             <div class="portlet box blue">
               <div class="portlet-title">
                   <div class="caption">
                       <i class="fa fa-globe"></i> Add Bargain
                   </div>
               </div>
               <div class="portlet-body">
                  <div class="row">
                   <?php if (isset($alert)) { ?>
                        <div class="alert alert-<?php echo $alert['type'];?> alert-dismissibl fade in">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <p>
                                <?php echo $alert['msg'];?>
                            </p>
                        </div>
                    <?php } ?>
                        @foreach($product as $key =>$value)
                            <div class="col-md-4 col-sm-6 margin-bottom-20">
                                <div id="myCarousel{{$key}}" class="carousel image-carousel slide">
                                    <div class="carousel-inner">
                                        <?php
                                            $productImages = $value->productpicture;
                                            for($i=0; $i<count($productImages); $i++){
                                        ?>
                                            <div class="item <?php if($i==0) {echo "active";} ?>">
                                                <img src="{{HTTP_LOGO_PATH.$productImages[$i]->picture_url}}" class="img-responsive" alt="">
                                                <div class="carousel-caption">
                                                    <h4>
                                                    <a href="{{URL::route('user.category.product',(100000+$value->id))}}" target="_blank">
                                                    {{$value->product_name}} </a>
                                                    </h4>
                                                    <p>
                                                         Price: {{$value->product_price1. $value->productCurrencyPrice1->currency_name}}
                                                         <a href="{{URL::route('admin.home.bargain.store',$value->id)}}" class="btn blue text-right btn-xs" style="float: right">Add Bargain</a>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <a class="carousel-control left" href="#myCarousel{{$key}}" data-slide="prev">
                                    <i class="m-icon-big-swapleft m-icon-white"></i>
                                    </a>
                                    <a class="carousel-control right" href="#myCarousel{{$key}}" data-slide="next">
                                    <i class="m-icon-big-swapright m-icon-white"></i>
                                    </a>
                                    <ol class="carousel-indicators">
                                        <?php for($i=0; $i<count($productImages); $i++){?>
                                        <li data-target="#myCarousel{{$key}}" data-slide-to="{{$i}}" <?php if($i ==0){?> class="active" <?php }?>>
                                        </li>
                                        <?php }?>
                                    </ol>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-7 col-md-5">
                                    <a class="btn  green" href="{{URL::route('admin.home.bargain')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
             </div>
        </div>
    </div>
@stop
@stop