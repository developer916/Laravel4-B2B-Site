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
                    <h1 class="pull-left">
                      {{$title}}
                    </h1>
                </div>
            </div>
            <div class="container" style="margin-top: 40px;">
                <div class="row">
                   <div class="col-md-3 col-sm-3">
                       <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                           <?php $i=0;?>
                           @foreach($category as $categories)
                              <li class="list-group-item list-toggle">
                                   <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse<?php echo $i;?>">{{$categories->categoryname}}</a>
                                   <ul id="collapse<?php echo $i;?>" class="collapse">
                                       <?php $subCategory = $categories->subCategories;?>
                                       @foreach($subCategory as $subCategories)
                                           <li>
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
                        @yield('body-content')
                    </div>
                </div>
            </div>
    @stop
@stop