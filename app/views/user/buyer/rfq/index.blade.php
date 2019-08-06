@extends('user.buyer.layout')
    @section('custom-styles')
         {{HTML::style('/assets/asset_view/css/blocks.css')}}
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 favoriteContentBody">
                     <div class="panel margin-bottom-40 change-panel">
                         <div class="panel-heading">
                            <a class="btn-u btn-u-blue rfqHeaderA" href="{{URL::route('user.buyer.rfqCreate')}}"><i class="fa fa-plus"></i> {{Lang::get('user.create')}}</a>
                            <div class="clearboth"></div>
                         </div>
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
                                                                    <img src="{{HTTP_LOGO_PATH.$rist[0]->picture_url}}" style="width: 100%">
                                                                <?php } else{?>
                                                                    <img src="/assets/asset_view/img/main/img1.jpg" class="img-responsive" style="width: 100%">
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
                                                                <p>{{Lang::get('user.quantity_required')}} : {{$rfqItem->rfq_quantity." ".$rfqItem->unit->unitname}}</p>
                                                                <p>{{Lang::get('user.posted_date')}} : {{substr($rfqItem->created_at,0,10)}}</p>
                                                                <div class="row" style="margin-top: 20px">
                                                                    <div class="col-md-4 col-xs-12 col-sm-4">
                                                                        <img src="{{HTTP_LOGO_PATH.$buyerList[$key]->country->country_flag}}">
                                                                        {{$buyerList[$key]->country->country_name}}
                                                                    </div>
                                                                    <div class="col-md-8 col-xs-12 col-sm-8">
                                                                        <a href="{{ URL::route('user.buyer.rfqView',(100000*1+$rfqItem->id))}}"  class=' tooltips btn-u btn-u-green ' data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.view')}}">
                                                                            <i class='fa fa-bars'></i>
                                                                        </a>
                                                                        <a href="{{ URL::route('user.buyer.rfqEdit',(100000*1+$rfqItem->id))}}"  class='tooltips btn-u  btn-u-blue ' data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.edit')}}">
                                                                            <i class='fa fa-edit'></i>
                                                                        </a>
                                                                        <a href="javascript:void(0)"  class=' tooltips btn-u btn-u-orange ' data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.quotes')}}" onclick="onSendEmailFailed(<?php echo (100000*1+$rfqItem->id); ?>)">
                                                                            <i class='fa fa-comments-o'></i>
                                                                        </a>

                                                                        <a href="javascript:void(0)" class="tooltips btn-u <?php if($emailList[$key] == 1){?> btn-u-dark-blue  <?php }?> " data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.emails')}}"  onclick="onSendEmail(<?php echo (100000*1+$rfqItem->id);?>)">
                                                                            <i class="fa fa-envelope"></i>
                                                                        </a>

                                                                         <form action="{{ URL::route('user.buyer.rfqDelete', (100000*1+$rfqItem->id)) }}" id="formTest" onsubmit = "return onDeleteConfirm(this)" style="display:inline-block">
                                                                            <button type="submit" class="tooltips btn-u btn-u-red " id="js-a-delete" data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.delete')}}">
                                                                            <i class='fa fa-trash-o'></i></button>
                                                                        </form>
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
                                </div>
                                <div class="pull-right">{{ $rfq->links() }}</div>
                         </div>
                     </div>
                 </div>
            </div>
        </div>
        <div class="modal fade" id="buyerSellerEmail" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
             <div class="modal-dialog modal-lg">
                <div class="modal-content modalChangeContent">
                    <div class="modal-header modalChangeHeader">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.rfq_quote_list')}}</h4>
                    </div>
                    <div class="modal-body" id="myModaltext">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                   <div class="panel-body" >
                                       <div class="form-horizontal" id="panelBodyContent">

                                       </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn default"  data-dismiss="modal">{{Lang::get('user.cancel')}}</button>
                    </div>
                </div>
             </div>
        </div>
        <div class="modal fade" id="sellerEmailModal" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
             <div class="modal-dialog modal-lg">
                <div class="modal-content modalChangeContent">
                    <div class="modal-header modalChangeHeader">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title modalChangeTitle" id="myModalLabel">{{Lang::get('user.emails')}}</h4>
                    </div>
                    <div class="modal-body" id="myModaltext">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                   <div class="panel-body" >
                                       <div class="form-horizontal" id="panelBodyContent1">

                                       </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn default"  data-dismiss="modal">{{Lang::get('user.cancel')}}</button>
                    </div>
                </div>
             </div>
        </div>
    @stop
    @section('custom-scripts')
        <script type="text/javascript">
            function onSendEmailFailed(RFQ){
                $("#panelBodyContent").text('');
                $.ajax ({
                    url:'{{URL::route("user.buyer.getQuotes") }}',
                    type: 'POST',
                    data: {RFQ : RFQ},
                    cache: false,
                    dataType : "json",
                    success: function (data) {
                          if(data.result == "success"){
                                $("#panelBodyContent").append(data.content);
                                var a = $("<a>")
                                .attr("href", "#buyerSellerEmail")
                                .attr("data-toggle","modal")
                                .appendTo("body");

                                a[0].click();

                                a.remove();
                          }
                          else if(data.result == "empty"){
                               bootbox.alert("{{Lang::get('missing.this_rfq_do_not_have_quote_now') }}");
                          }
                       }
                    });
            }
            function onSendEmail(RFQ){
                $("#panelBodyContent1").text('');
                 var base_url = window.location.origin;
                    $.ajax ({
                        url: base_url + '/buyer/getEmails',
                        type: 'POST',
                        data: {RFQ : RFQ},
                        cache: false,
                        dataType : "json",
                        success: function (data) {
                          if(data.result == "success"){
                            $("#panelBodyContent1").append(data.content);
                                var a = $("<a>")
                                .attr("href", "#sellerEmailModal")
                                .attr("data-toggle","modal")
                                .appendTo("body");

                                a[0].click();

                                a.remove();
                          }else if(data.result == "empty"){
                                bootbox.alert("This rfq don't have emails");
                          }
                        }
                     });
            }
            function onDeleteConfirm(obj){
                bootbox.confirm("Do you want to delete this RFQ?", function(result) {

                    if ( result ) {

                        obj.submit();

                    }

                });

                return false;
            }
        </script>
    @stop
@stop