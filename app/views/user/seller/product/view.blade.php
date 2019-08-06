@extends('user.seller.layout')
    @section('custom-styles')
        {{HTML::style('//www.jqueryscript.net/css/jquerysctipttop.css')}}
       {{ HTML::style('/assets/assest_admin/css/reset.css') }}
        {{HTML::style('/zoom/magiczoomplus.css')}}
        {{HTML::style('/zoom/change_magiczoomplus.css')}}
    @stop
    @section('body-right')
         <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 favoriteContentBody">
                     <div class="panel  margin-bottom-40 change-panel">
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-12" style="background-color: white; padding-top:40px; padding-bottom: 40px">
                                    <div class="col-md-4 col-sm-4">
                                        @if(count($productPicture)>0)
                                            <a id="Zoom-1" class="MagicZoom" href="{{$productPicture[0]->picture_url}}">
                                                <img src="{{$productPicture[0]->picture_url}}?scale.height=400"  id="imageList">
                                            </a>
                                            <div class="selectors">
                                                @foreach($productPicture as $key_productpicture =>$value_productpicture )
                                                    <a data-zoom-id="Zoom-1" href="{{$value_productpicture->picture_url}}"
                                                       data-image="{{$value_productpicture->picture_url}}?scale.height=400" class="mz-thumb">
                                                        <img srcset="{{$value_productpicture->picture_url}}?scale.width=112 2x" src="{{$value_productpicture->picture_url}}?scale.width=56"/>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8 col-sm-8">
                                    </div>
                              </div>
                        </div>
                     </div>
                </div>
             </div>
         </div>
         </div>
    @stop
    @section('custom-scripts')
        {{ HTML::script('/zoom/magiczoomplus.js') }}
        {{ HTML::script('/zoom/change_magiczoomplus.js') }}
    	@stop
@stop