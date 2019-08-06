@extends('user.seller.layout')
    @section('custom-styles')
         {{HTML::style('/assets/asset_view/css/blocks.css')}}
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 favoriteContentBody">
                    <div class="row" style="margin-top: 40px">
                        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                            <form action="{{URL::route('user.seller.loginSearch')}}">
                                <div class="col-md-9 col-sm-9 col-xs-9" id="bloodhound">
                                    <input type="text" class="form-control" placeholder='{{Lang::get('user.what_you_are_looking_for')}}' id="helpSearchText" name="searchTitle">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3 helpSearchButtonDiv">
                                    <button class="btn-u btn-u-blue helpSearchButton"><i class="search fa fa-search search-button"></i> {{Lang::get('user.search')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                     <div class="panel margin-bottom-40 change-panel">
                         <div class="panel-body">
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
                            <div class="table-responsive">
                                  <table class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                         @foreach($rfq as $key=>$rfqItem)
                                            <tr>
                                                <td>
                                                    <div class="funny-boxes">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-4 funny-boxes-img">
                                                                  <?php if(count($rfqItem->rfqImage)>0){
                                                                      $rist = $rfqItem->rfqImage;
                                                                      ?>
                                                                      <img src="{{HTTP_LOGO_PATH.$rist[0]->picture_url}}" style="width: 100%;">
                                                                  <?php } else{?>
                                                                      <img src="/assets/asset_view/img/main/img1.jpg" class="img-responsive" style="width: 100%;">
                                                                  <?php } ?>
                                                            </div>
                                                            <div class="col-md-8 col-sm-8">
                                                                <h2 class="margin-bottom-20"><a href ="{{URL::route('user.rfq',(100000*1+$rfqItem->id))}}" target="_blank">{{ $rfqItem->rfq_title }}</a></h2>
                                                                <p>
                                                                   <?php
                                                                         $length = strlen( $rfqItem->rfq_description);
                                                                         if($length >200){
                                                                            echo substr($rfqItem->rfq_description,0,200)."....";
                                                                         }else{
                                                                           echo $rfqItem->rfq_description;
                                                                         }
                                                                    ?>
                                                               </p>
                                                               <p>{{Lang::get('user.quantity_required')}} : {{$rfqItem->rfq_quantity. " ". $rfqItem->unit->unitname}}</p>
                                                               <p>{{Lang::get('user.posted_date')}} : {{substr($rfqItem->created_at,0,10)}}</p>
                                                                <div class="row" style="margin-top: 20px">
                                                                    <div class="col-md-4 col-xs-12 col-sm-4">
                                                                        <img src="{{HTTP_LOGO_PATH.$buyerList[$key]->country->country_flag}}">
                                                                        {{$buyerList[$key]->country->country_name}}
                                                                    </div>
                                                                    <div class="col-md-8 col-xs-12 col-sm-8">

                                                                        <?php if($listQuoteList[$key] == 1){?>
                                                                                 <a href="{{URL::route('user.seller.editQuoteNow',(100000*1+$rfqItem->id))}}" class="tooltips btn-u btn-u-blue " data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.edit_quote')}}">
                                                                                      <i class='fa fa-edit'></i>
                                                                                 </a>
                                                                                 <?php
                                                                                    if(isset($rfqQuote[$key]) && $rfqQuote[$key]->status == 2){
                                                                                 ?>
                                                                                    <a href="{{URL::route('user.seller.getPrice',(100000*1+$rfqQuote[$key]->id))}}" class=" tooltips btn-u btn-u-green" data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.shipping')}}"><i class="fa fa-anchor"></i> </a>
                                                                                 <?php } if(isset($rfqQuote[$key]) && $rfqQuote[$key]->status >=3){ ?>
                                                                                    <a href="{{URL::route('user.invoice',(100000*1+$rfqQuote[$key]->id))}}" class=" tooltips btn-u btn-u-green" target="_blank" data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.invoice')}}"><i class="fa  fa-tasks"></i> </a>
                                                                                 <?php } if(isset($rfqQuote[$key]) && $rfqQuote[$key]->status == 5){ ?>
                                                                                    <a href="{{URL::route('user.seller.getLabel',(100000*1+$rfqQuote[$key]->id))}}" class=" tooltips btn-u btn-u-orange" target="_blank" data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.get_label')}}"><i class="fa  fa-file-pdf-o"></i> </a>

                                                                                 <?php } ?>
                                                                                 <?php
                                                                                    if($emailList[$key] == 1){ ?>
                                                                                        <a href="{{URL::route('user.seller.rfqEmail',array(100000*1+$rfqItem->id,100000*1+$rfqQuote[$key]->id))}}" class="tooltips btn-u btn-u-dark-blue  " data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.emails')}}">
                                                                                            <i class="fa fa-envelope"></i>
                                                                                        </a>
                                                                                 <?php }else{ ?>
                                                                                       <a href="javascript:void(0)" class="tooltips btn-u  " data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.emails')}}" onclick="onSendEmail()">
                                                                                           <i class="fa fa-envelope"></i>
                                                                                       </a>
                                                                         <?php } }else{?>
                                                                            <a href="{{URL::route('user.seller.quoteNow',(100000*1+$rfqItem->id))}}" class="btn-u btn-u-orange " data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.quote_now')}}">
                                                                                 <i class='fa fa-comments-o'></i>
                                                                             </a>
                                                                         <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                         @endforeach
                                      </tbody>
                                  </table>
                                   <div class="pull-right">{{ $rfq->links() }}</div>
                            </div>
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        <script type="text/javascript">
            function onSendEmail(){
                bootbox.alert("{{ Lang::get('missing.you_did_not_get_email_from_buyer') }}");
            }

        </script>
    @endsection
@stop