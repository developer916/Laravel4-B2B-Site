@extends('user.layout')
@section('custom-styles')
 {{HTML::style('/assets/assest_main/css/bootstrap.css')}}
 {{HTML::style('/assets/assest_main/css/helper.css')}}
{{HTML::style('/assets/assest_main/css/styles.less')}}
@stop
@section('body')
    <!-- Category  and Bargain , Product Start-->
    <div class="container container-max-width padd-lr-none margin-top-20" >
        <div class="row">
            <div class="col-sm-3" id="categories">
                <!-- categories first-->
                <div class="mobile-sub-categories hidden-sm hidden-md hidden-lg">
                    <div class="col-xs-12 padd-lr-none">
                		<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
                			<a class="btn btn-default padd-top-10 padd-bot-10 pointer" role="button" onclick="backMainCategory()">
                				<div class="mobile-right-close pointer close-subcategory">
                					<img src="/assets/assest_main/icons/left_arro.svg" />
                				</div>
                			</a>
                			<a href="{{URL::route('user.auth.register')}}" class="btn btn-default joinsign padd-top-10 padd-bot-10 mobile-padd-lr-none" role="button">
                				{{Lang::get('missing.join_free')}}
                			</a>
                			<a href="{{URL::route('user.auth.login')}}" class="btn btn-default joinsign padd-top-10 padd-bot-10 mobile-padd-lr-none" role="button">
                				{{Lang::get('user.sign_in')}}
                			</a>
                			<a class="btn btn-default padd-top-10 padd-bot-10 pointer" role="button" onclick="closeSubCategory()">
                				<div class="mobile-right-close pointer close-subcategory1">
                					<img src="/assets/assest_main/icons/close.svg" />
                				</div>
                			</a>
                		</div>
                	</div>
                </div>
                <!-- categories second-->
                <div class="mobile-categories mobile-padd-top-0">
                    <div class="col-xs-12 padd-lr-none hidden-lg hidden-md hidden-sm">
                        <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
                            <a href="{{URL::route('user.home')}}" class="btn btn-default padd-top-10 padd-bot-10" role="button">
                                <img src="/assets/assest_main/images/small-icon.png" width="30px" />
                            </a>
                            <a href="{{URL::route('user.auth.register')}}" class="btn btn-default joinsign padd-top-10 padd-bot-10 mobile-padd-lr-none" role="button">
                                {{Lang::get('missing.join_free')}}
                            </a>
                            <a href="{{URL::route('user.auth.login')}}" class="btn btn-default joinsign padd-top-10 padd-bot-10 mobile-padd-lr-none" role="button">
                                {{Lang::get('user.sign_in')}}
                            </a>
                            <a class="btn btn-default padd-top-10 padd-bot-10 pointer" role="button">
                                <div class="mobile-right-close pointer close-category" onclick="closeCategory()">
                                    <img src="/assets/assest_main/icons/close.svg" />
                                </div>
                            </a>
                        </div>
                    </div>

                    <ul class="hidden-lg hidden-md hidden-xs nav navbar-nav user-authenticate-list col-xs-12 mar-bot-20 text-center padd-lr-none">
                        <li class="col-xs-6 padd-lr-none">
                            <a href="{{URL::route('user.auth.register')}}" class=""> {{Lang::get('missing.join_free')}} </a>
                        </li>
                        <li class="col-xs-6 padd-lr-none">
                            <a href="{{URL::route('user.auth.login')}}"> {{Lang::get('user.sign_in')}} </a>
                        </li>
                    </ul>
                    <div class="mobile-padd-left-15 mobile-padd-right-15">
                        <div class="col-xs-12 padd-lr-none mobile-mar-top-30">
                            <div class="categories-indicator-main">
                                <div class="indicator">
                                    <div class="dot"></div>
                                    <div class="line"></div>
                                </div>
                                <div class="indicator">
                                    <div class="dot"></div>
                                    <div class="line"></div>
                                </div>
                                <div class="indicator">
                                    <div class="dot"></div>
                                    <div class="line"></div>
                                </div>
                            </div>
                            <h4 class="categories-heading mar-top-3"> {{Lang::get('missing.categories')}} </h4>
                        </div>
                    </div>
                    <div class="col-xs-12 padd-lr-none categories-root">
                        <ul class="list-group categories-list">
                            @foreach($categories as $key =>$category)
                            <li class="list-group-item" onmouseover="showSubCategory({{$key }})" onclick="slideSubCategory({{$key}})" onmouseout="hideSubCategory({{$key}})">
                                <span class="pull-right">
                                    <img class="img-li-inactive" src="/assets/assest_main/icons/categories_right_black.svg" />
                                    <img class="img-li-active hide" src="/assets/assest_main/icons/categories_right_active.svg" />
                                </span>
                                {{ucfirst($category->categoryname)}}
                                <div class="categories-subs hide" id="subCategory{{$key}}">
                                    <div class="whiteBox"></div>
                                        <ul class="list-group">
                                            @foreach($category->subCategories as $index => $value )
                                            <li class="list-group-item">
                                                <a href="{{URL::route('user.category.sub',$value->id+100000)}}">
                                                    {{ucfirst($value->subcategoryname)}}
                                                </a>
                                            </li>
                                            @endforeach

                                        </ul>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 desktop-padd-right-0 mobile-padd-lr-5">
                <div class="col-sm-12 padd-lr-none" id="searchbar">
                 <!-- Search Function start-->
                    <div class="col-sm-8 col-md-9 padd-left-0 mobile-padd-lr-none">
                        <form class="search-input input-group" action="{{URL::route('user.seller.rfqSearch')}}">
                            <input type="text" class="form-control input-lg height-44" placeholder="" name="searchTitle">
                            <span class="input-group-addon padd-0 border-radius-0 border-0">
                                <button type="submit" class="btn btn-lg btn-search border-radius-0 border-radius-right-4" style="padding:11px; border: 1px solid transparent;">
                                    <img src="/assets/assest_main/icons/search_white.svg" />
                                    <span class="hidden-xs"> {{Lang::get('user.search')}} </span>
                                </button> </span>
                        </form>
                    </div>

                    <div class="col-sm-4 col-md-3 mobile-mar-top-7 padd-lr-none">
                        <a href="{{URL::route('user.buyer.rfqCreate')}}" class="btn btn-post btn-default btn-lg btn-block border-radius-4"> {{Lang::get('user.post_buying_request')}} </a>
                    </div>
                </div>
                <!-- search function end --->
                <!-- Langding page start -->
                    <div class="col-sm-12 padd-lr-none" id="productBody">
                        <div class="col-xs-12 padd-lr-none mar-top-10">

                        	<div id="carousel-example-generic" class="carousel slide main-carousel" data-ride="carousel" data-interval="3000">

                        		<ol class="carousel-indicators">
                        			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        			<li data-target="#carousel-example-generic" data-slide-to="3"></li>
                        		</ol>

                        		<div class="carousel-inner" role="listbox">

                        			<div class="item active">
                        				<img class="img-responsive" src="/assets/assest_main/images/home/purchasetree_banner.png" alt="...">
                        			</div>

                        			<div class="item">
                        				<img class="img-responsive" src="/assets/assest_main/images/home/Eyad Yousef - Home Page-11.png" alt="...">
                        				<div class="carousel-caption">
                        					<h1>{{Lang::get('missing.Shopping_Wishlist')}}</h1>
                        					<p style="color:white">
                        						{{Lang::get('missing.shopping_wishlist_description')}}
                        					</p>
                        				</div>
                        			</div>

                        			<div class="item">
                        				<img class="img-responsive" src="/assets/assest_main/images/home/Eyad Yousef - Home Page-13.png" alt="...">
                        				<div class="carousel-caption">
                        					<h1> {{Lang::get('missing.slider3_title')}} </h1>
                                            <p style="color:white">
                                                {{Lang::get('missing.slider3_description')}}
                        					</p>
                        				</div>
                        			</div>
                        			<div class="item">
                        				<img class="img-responsive" src="/assets/assest_main/images/home/Eyad Yousef - Home Page-14.png" alt="...">
                        				<div class="carousel-caption">
                        					<h1> {{Lang::get('missing.slider4_title')}} </h1>
                                            <p style="color:white">
                                                {{Lang::get('missing.slider4_description')}}
                        					</p>
                        				</div>
                        			</div>
                        		</div>

                        		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left thick-control" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                        		<a class="right carousel-control main-caro-next" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right thick-control" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>

                        	</div>
                        </div>
                    </div>
                <!-- Langding page End -->
                    <div class="col-xs-12 padd-lr-none mar-top-10">

                    	<div class="col-sm-12 padd-lr-none mar-top-10">
                    		<h4 class="mar-bot-35 mobile-padd-left-10">
                    		    <span class="images-heading"> {{Lang::get('user.bargain_buys')}} </span>
                    		    <small class="primary-font font-size-10">{{Lang::get('user.bargain_buys_description')}} </small>
                    		</h4>
                    	</div>
                    	<div class="col-xs-12 text-center padd-lr-none mar-bot-30">
                        	<div id="carousel-example-generic1" class="carousel slide product-carousel border-padding hidden-xs" data-ride="carousel" data-interval="false">
                        	    <div class="carousel-inner product-CarouselInner">
                        	        <?php $countBargain = count($bargain);?>
                                    @foreach($bargain as $key =>$value)
                                        <?php
                                            $product =$value->product;
                                            $productImage = $product->productpicture;
                                          ?>
                                          @if($key % 4 ==0)
                                            <div class="item <?php if($key ==0) {echo "active";}?>">
                                          @endif
                                               <div class="col-sm-3">
                                                    <div class="inner-product">
                                                        <a href="{{URL::route('user.category.product',(100000+$product->id))}}" target="_blank">
                                                        <img class="img-responsive margin-auto dmargin-auto" src="@if(count($productImage)>0){{HTTP_LOGO_PATH.$productImage[0]->picture_url}} @endif" alt="..." />
                                                        </a>
                                                    </div>
                                                </div>
                                        @if($key % 4 ==3 || $key == ($countBargain-1))
                                             </div>
                                        @endif
                                    @endforeach
                        	    </div>
                        	    <a class="left carousel-control" href="#carousel-example-generic1" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left thick-control" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                                <a class="right carousel-control" href="#carousel-example-generic1" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right thick-control" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                            </div>
                         </div>
                         <div id="carousel-example-generic2" class="carousel slide product-carousel border-padding hidden-sm hidden-md hidden-lg" data-ride="carousel" data-interval="false">
                            <div class="carousel-inner product-CarouselInner">
                                @foreach($bargain as $key =>$value)
                                    <?php
                                        $product =$value->product;
                                        $productImage = $product->productpicture;
                                      ?>
                                      @if($key % 2 ==0)
                                        <div class="item <?php if($key ==0) {echo "active";}?>">
                                      @endif
                                            <div class="col-xs-6 padd-left-0">
                                                <div class="inner-product">
                                                    <a href="{{URL::route('user.category.product',(100000+$product->id))}}" target="_blank">
                                                    <img class="img-responsive margin-auto dmargin-auto" src="@if(count($productImage)>0) {{HTTP_LOGO_PATH.$productImage[0]->picture_url}}@endif" alt="..." />
                                                    </a>
                                                </div>
                                            </div>
                                    @if($key % 2 ==1 || $key == ($countBargain-1))
                                         </div>
                                    @endif
                                @endforeach
                            </div>
                           <a class="left carousel-control" href="#carousel-example-generic2" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left thick-control" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                           <a class="right carousel-control" href="#carousel-example-generic2" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right thick-control" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                         </div>
                         <h4 class="mar-bot-30 mar-top-30 mobile-padd-left-10"><span class="images-heading1"> {{Lang::get('user.features_products')}} </span></h4>
                        <div id="carousel-example-generic3" class="carousel slide product-carousel border-padding hidden-xs" data-ride="carousel" data-interval="false">
                           <div class="carousel-inner product-CarouselInner">
                                <?php $countProducts = count($products);?>
                                @foreach($products as $key =>$value)
                                    <?php
                                        $productImage = $value->productpicture;
                                      ?>
                                      @if($key % 4 ==0)
                                        <div class="item <?php if($key ==0) {echo "active";}?>">
                                      @endif
                                           <div class="col-sm-3">
                                                <div class="inner-product">
                                                    <a href="{{URL::route('user.category.product',(100000+$value->id))}}" target="_blank">
                                                    <img class="img-responsive margin-auto dmargin-auto" src="@if(count($productImage)>0) {{ HTTP_LOGO_PATH.$productImage[0]->picture_url}} @endif" alt="..." />
                                                    </a>
                                                </div>
                                            </div>
                                    @if($key % 4 ==3 || $key == ($countProducts-1))
                                         </div>
                                    @endif
                                @endforeach
                           </div>
                           <a class="left carousel-control" href="#carousel-example-generic3" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left thick-control" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                           <a class="right carousel-control" href="#carousel-example-generic3" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right thick-control" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                        </div>
                        <div id="carousel-example-generic4" class="carousel slide product-carousel border-padding hidden-sm hidden-md hidden-lg" data-ride="carousel" data-interval="false">
                            <div class="carousel-inner product-CarouselInner">
                                 @foreach($products as $key =>$value)
                                <?php
                                    $productImage = $value->productpicture;
                                  ?>
                                  @if($key % 2 ==0)
                                    <div class="item <?php if($key ==0) {echo "active";}?>">
                                  @endif
                                       <div class="col-xs-6 padd-left-0">
                                            <div class="inner-product">
                                                <a href="{{URL::route('user.category.product',(100000+$value->id))}}" target="_blank">
                                                <img class="img-responsive margin-auto dmargin-auto" src="@if(count($productImage)>0) {{HTTP_LOGO_PATH.$productImage[0]->picture_url}} @endif" alt="..." />
                                                </a>
                                            </div>
                                        </div>
                                @if($key % 2 ==1|| $key == ($countProducts-1))
                                     </div>
                                @endif
                            @endforeach
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic4" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left thick-control" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                            <a class="right carousel-control" href="#carousel-example-generic4" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right thick-control" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Category  and Bargain , Product End-->
     <div class="col-sm-12 padd-lr-none" id="productBody">
        <div class="col-xs-12">
        	<h4 class="mar-top-20"><span class="images-heading1"> {{Lang::get('user.source_from_top_global_suppliers')}} </span><small class="primary-font font-size-10"> {{Lang::get('user.source_from_top_global_suppliers_description')}} </small></h4>
        </div>
        <div class="col-md-12">
            <div id="carousel-example-generic5" class="carousel slide product-carousel border-padding hidden-xs" data-ride="carousel" data-interval="false" style="height: 250px">
               <div class="carousel-inner product-CarouselInner" style="height: 250px">
                    <?php
                        $countClients = count($clients);
                        for($key=0; $key<$countClients; $key++){
                    ?>

                        @if($key % 4 ==0)
                           <div class="item <?php if($key ==0) {echo "active";}?>">
                        @endif
                            <div class="col-sm-3">
                                <div class="inner-product">
                                    <div class="col-xs-12 padd-lr-none">
                                        <img class="img-responsive margin-auto dmargin-auto" src="@if($companyProfiles[$key]['companylogo']!="") {{HTTP_LOGO_PATH.$companyProfiles[$key]['companylogo']}} @else /assets/asset_view/img/bg/8.jpg @endif" alt="..." />
                                    </div>
                                    <div class="col-xs-12 padd-lr-none">
                                        <div class="primary-color col-xs-12 padd-lr-none line-height-25">
                                           {{$companyProfiles[$key]['companyname']}}
                                        </div>
                                        {{--<div class="font-size-12 col-xs-12 padd-lr-none line-height-25">--}}
                                            {{--SUVs--}}
                                        {{--</div>--}}
                                        <div class="font-size-10 col-xs-12 padd-lr-none line-height-25">
                                            <a href="{{URL::route('user.seller.store',(100000*1+$companyProfiles[$key]['user_id']))}}" class="linkColor" target="_blank"><u>More products</u></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @if($key % 4 ==3 || $key == ($countClients-1))
                            </div>
                        @endif
                    <?php  }?>
               </div>
               <a class="left carousel-control" href="#carousel-example-generic5" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left thick-control" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
               <a class="right carousel-control" href="#carousel-example-generic5" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right thick-control" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
            </div>
            <div id="carousel-example-generic6" class="carousel slide product-carousel border-padding hidden-sm hidden-md hidden-lg" data-ride="carousel" data-interval="false" style="height: 300px">
                <div class="carousel-inner product-CarouselInner" style="height: 300px">
                      <?php
                             $countClients = count($clients);
                             for($key=0; $key<$countClients; $key++){
                         ?>

                          @if($key % 2==0)
                                <div class="item <?php if($key ==0) {echo "active";}?>">
                          @endif
                          <div class="col-xs-6">
                                <div class="inner-product">
                                    <div class="col-xs-12 padd-lr-none">
                                        <img class="img-responsive margin-auto dmargin-auto" src="{{HTTP_LOGO_PATH.$companyProfiles[$key]['companylogo']}}" alt="..." />
                                    </div>
                                    <div class="col-xs-12 padd-lr-none">
                                         <div class="primary-color col-xs-12 padd-lr-none line-height-25">
                                              {{$companyProfiles[$key]['companyname']}}
                                           </div>
                                           {{--<div class="font-size-12 col-xs-12 padd-lr-none line-height-25">--}}
                                               {{--SUVs--}}
                                           {{--</div>--}}
                                           <div class="font-size-10 col-xs-12 padd-lr-none line-height-25">
                                               <a href="{{URL::route('user.seller.store',(100000*1+$companyProfiles[$key]['user_id']))}}" class="linkColor" target="_blank"><u>More products</u></a>
                                           </div>
                                    </div>
                                </div>
                            </div>
                    @if($key % 2 ==1|| $key == ($countClients-1))
                         </div>
                    @endif
               <?php }?>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic6" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left thick-control" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                <a class="right carousel-control" href="#carousel-example-generic6" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right thick-control" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
            </div>
        </div>
     </div>
@stop
@section('custom-scripts')
<script type="text/javascript">
    var path = window.location.pathname;
    var page = path.split("/").pop();

    // Returns height of browser viewport
    var window_height = $(window).height();

    var window_width = $(window).width();

    // Returns height of HTML document
    var body_height = $('body').height();
    function loadjscssfile(filename, filetype) {
    	var fileref;
    	if (filetype == "js") {
    		fileref = document.createElement('script');
    		fileref.setAttribute("type", "text/javascript");
    		fileref.setAttribute("src", filename);
    	} else if (filetype == "css") {
    		fileref = document.createElement("link");
    		fileref.setAttribute("rel", "stylesheet");
    		fileref.setAttribute("type", "text/css");
    		fileref.setAttribute("href", filename);
    	} else if (filetype == "less") {
    		fileref = document.createElement("link");
    		fileref.setAttribute("rel", "stylesheet/less");
    		fileref.setAttribute("type", "text/css");
    		fileref.setAttribute("href", filename);
    	}
    	if ( typeof fileref != "undefined") {
    		document.getElementsByTagName("head")[0].appendChild(fileref);
    	}
    }

    loadjscssfile("/assets/assest_main/css/bootstrap.css", "css");
    loadjscssfile("/assets/assest_main/css/styles.less", "less");
    loadjscssfile("/assets/assest_main/js/less.js", "js");

    loadjscssfile("/assets/assest_main/css/helper.css", "css");
    /* loadjscssfile("assets/js/bootstrap.js", "js"); */
   // loadjscssfile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js", "js");
    loadjscssfile("/assets/assest_main/js/script.js", "js");
</script>
@stop
@stop
