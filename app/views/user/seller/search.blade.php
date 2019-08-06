@extends('user.layout')
 @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/blocks.css')}}
    @stop
    @section('body')
          <div class="breadcrumbs">
              <div class="container">
                  <h1 class="pull-left">
                      {{Lang::get('user.search_rfq')}}
                  </h1>
              </div>
          </div>
           <div class="container">
              <div class="row margin-bottom-40" style="margin-top: 20px">
                  <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-1">
                       <form action="{{URL::route('user.seller.rfqSearch')}}">
                          <div class="col-md-9 col-sm-9 col-xs-9" id="bloodhound">
                              <input type="text" class="form-control" placeholder='{{Lang::get('user.what_you_are_looking_for')}}' id="helpSearchText" name="searchTitle">
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-3 helpSearchButtonDiv">
                              <button class="btn-u btn-u-blue helpSearchButton"><i class="search fa fa-search search-button"></i> {{Lang::get('user.search_rfq')}}</button>
                          </div>
                      </form>
                  </div>
              </div>
              <div class="row margin-bottom-40">
                <div class="col-md-12">
                   <h2> <a href="{{URL::route('user.seller.rfq')}}">{{Lang::get('user.back_to_list')}}</a></h2>
                </div>
              </div>
              @foreach($rfq as $key =>$rfqs)
              <div class="row margin-bottom-20">
                  <div class="col-md-12">
                       <div class="shadow-wrapper">
                          <blockquote class="hero box-shadow shadow-effect-2">
                              <?php
                                  $listCheck =$rfqs->rfqImage;
                                  if(count($listCheck)>0){
                              ?>
                              <div class="row">
                                  <div class="col-md-12 margin-bottom-10">
                                       <h2 ><a href ="{{URL::route('user.rfq',(100000*1+$rfqs->id))}}" class="rfqTitle">{{ucwords($rfqs->rfq_title)}}</a></h2>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-8 col-sm-8">
                                      <div class="row">
                                          <div class="col-md-4 col-sm-4 col-xs-6">
                                               <img src="{{HTTP_LOGO_PATH.$listCheck[0]->picture_url}}" class="rfq_list_image">
                                          </div>
                                          <div class="col-md-8 col-sm-8 col-xs-6">
                                              <p>
                                                  {{$rfqs->rfq_description}}
                                              </p>
                                              <p>{{Lang::get('user.quantity_required')}} : {{$rfqs->rfq_quantity. $rfqs->rfq_unit}}</p>
                                              <p>{{Lang::get('user.posted_date')}} : {{substr($rfqs->created_at,0,10)}}</p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-2 col-sm-2">
                                      <img src="{{HTTP_LOGO_PATH.$buyerList[$key]->country->country_flag}}"> {{$buyerList[$key]->country->country_name}}
                                  </div>
                                  <div class="col-md-2 col-sm-2">
                                      <a href = "" class="btn-u btn-u-orange">{{Lang::get('user.quote_now')}}</a>
                                  </div>
                              </div>
                              <?php }else{?>
                                  <div class="row">
                                      <div class="col-md-12 margin-bottom-10">
                                           <h2 ><a href ="" class="rfqTitle">{{ucwords($rfqs->rfq_title)}}</a></h2>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-8 col-sm-8">
                                          <div class="row">
                                              <div class="col-md-12 col-sm-12 col-xs-12">
                                                  <p>
                                                      {{$rfqs->rfq_description}}
                                                  </p>
                                                  <p>{{Lang::get('user.quantity_required')}} : {{$rfqs->rfq_quantity. $rfqs->rfq_unit}}</p>
                                                  <p>{{Lang::get('user.posted_date')}} : {{substr($rfqs->created_at,0,10)}}</p>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-2 col-sm-2">
                                          <img src="{{HTTP_LOGO_PATH.$buyerList[$key]->country->country_flag}}"> {{$buyerList[$key]->country->country_name}}
                                      </div>
                                      <div class="col-md-2 col-sm-2">
                                          <a href = "" class="btn-u btn-u-orange">{{Lang::get('user.quote_now')}}</a>
                                      </div>
                                  </div>
                              <?php }?>
                          </blockquote>
                       </div>
                  </div>
              </div>
              @endforeach
              <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 text-center">
                   {{ $rfq->links() }}
              </div>
           </div>
    @stop
@stop