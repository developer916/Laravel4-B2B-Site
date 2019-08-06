@extends('user.seller.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/app.css')}}
        {{HTML::style('/assets/asset_view/plugins/font-awesome/css/font-awesome.min.css')}}
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 tab-v1 change-tab-v1">
                    <ul class="nav nav-tabs">
                        <li <?php if($slug == 'new') echo 'class="active"'; ?>>  <a href="{{URL::route('user.seller.email','new')}}" >{{Lang::get('user.new')}}</a></li>
                        <li <?php if($slug == 'all') echo 'class="active"'; ?>>  <a href="{{URL::route('user.seller.email','all')}}" >{{Lang::get('user.all')}}</a></li>
                        <li <?php if($slug == 'sent') echo 'class="active"'; ?>> <a href="{{URL::route('user.seller.email','sent')}}" >{{Lang::get('user.sent')}}</a></li>
                        <li <?php if($slug == 'inbox') echo 'class="active"'; ?>><a href="{{URL::route('user.seller.email','inbox')}}">{{Lang::get('user.inbox')}}</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12 emailContentBody">
                        <div class="row">
                            <div class="panel panel-default margin-bottom-40 change-panel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                          <table class="table table-striped">
                                              <thead>
                                                  <tr>
                                                      <th></th>
                                                      <th></th>
                                                      <th></th>
                                                      <th style="width: 90px;"></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
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
                                               <?php for($i=0; $i<count($emailList); $i++){?>
                                                  <tr>
                                                      <td>
                                                        <?php if($emailList[$i]->sender_id == Session::get('user_id')) {
                                                            echo Lang::get('user.me');
                                                         }else{
                                                            echo $emailList[$i]->sender->username;
                                                         } ?>
                                                        ,
                                                        <?php if($emailList[$i]->receiver_id == Session::get('user_id')) {
                                                          echo Lang::get('user.me');
                                                       }else{
                                                          echo $emailList[$i]->recevier->username;
                                                         } ?>
                                                         <?php if($itemList[$i] !=0){
                                                            echo "(".($itemList[$i]+1).")";
                                                         }?>
                                                      </td>
                                                      <td>
                                                            {{$emailList[$i]->subject}}
                                                      </td>
                                                      <td>
                                                          {{substr($emailList[$i]->create_at,0,10)}}
                                                      </td>
                                                      <td>
                                                           <a class="tooltips btn btn-sm rounded btn-primary" data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.show')}}" href="{{URL::route('user.seller.getEmailContent', array(100000*1+$emailList[$i]->id,$slug))}}" ><i class="fa fa-tasks"></i></a>
                                                           <a class ="tooltips btn btn-sm rounded btn-danger" data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.delete')}}" href="{{URL::route('user.seller.deleteEmail',array(100000*1+$emailList[$i]->id, $slug))}}"><i class="fa  fa-trash "></i></a>
                                                      </td>
                                                  </tr>
                                                  <?php }?>
                                              </tbody>
                                           </table>
                                           <div class="pull-right">{{ $emailList->links() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts-sub')
        <script type="text/javascript">
//            function onSendMessageReply(id){
//                var subID = $("#subID").val(id);
//                var base_url = window.location.origin;
//               $.ajax ({
//                    url: base_url + '/buyer/getEmailContent/'+id,
//                    type: 'get',
//                    data: {},
//                    cache: false,
//                    dataType : "json",
//                    success: function (data) {
//                        $("#myModalSellerBecome").hide();
//                        bootbox.alert(data);
//                        window.location.reload();
//                    }
//               });
//                var list = "<iframe src='"+base_url+'/buyer/getEmailContent/'+id+"'></iframe>";
//                $("#myModaltext").append(list);
//                 var a = $("<a>")
//                                    .attr("href", "#myReplyModal")
//                                    .attr("data-toggle","modal")
//                                    .appendTo("body");
//
//                                    a[0].click();
//
//                                    a.remove();
//            }
        </script>
    @stop
@stop