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
        </ul>
    </div>
    <div class="row">
		<div class="col-md-12">
		   <div class="portlet box blue">
               <div class="portlet-title">
                   <div class="caption">
                       <i class="fa fa-globe"></i> Bargains  Management
                   </div>
                   <div class="actions">
                       <a id="sample_editable_1_new" class="btn btn-default btn-sm" href='{{ URL::route('admin.home.bargain.create')}}' style="margin-right:10px">
                               Add New <i class="fa fa-plus"></i>
                       </a>
                   </div>
               </div>
               <div class="portlet-body">
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
                    <div class="row">
                        @foreach($bargain as $key =>$value)
                            <div class="col-md-4 col-sm-6 margin-bottom-20">
                                <div id="myCarousel{{$key}}" class="carousel image-carousel slide">
                                    <div class="carousel-inner">
                                        <?php
                                            $product = $value->product;
                                            $productImages = $product->productpicture;
                                            for($i=0; $i<count($productImages); $i++){
                                        ?>
                                            <div class="item <?php if($i==0) {echo "active";} ?>">
                                                <img src="{{HTTP_LOGO_PATH.$productImages[$i]->picture_url}}" class="img-responsive" alt="">
                                                <div class="carousel-caption">
                                                    <h4>
                                                    <a href="{{URL::route('user.category.product',(100000+$value->id))}}" target="_blank">
                                                    {{$product->product_name}} </a>
                                                    </h4>
                                                    <p>
                                                         Price: {{$product->product_price1. $product->productCurrencyPrice1->currency_name}}
                                                         <a href="{{URL::route('admin.home.bargain.delete',$value->id)}}" class="btn red text-right btn-xs" style="float: right">Delete Bargain</a>
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
               </div>
           </div>
		</div>
	</div>
@stop
@stop