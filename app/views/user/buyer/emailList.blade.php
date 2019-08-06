@extends('user.buyer.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/app.css')}}
        {{HTML::style('/assets/asset_view/plugins/font-awesome/css/font-awesome.min.css')}}
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 tab-v1 change-tab-v1">
                    <ul class="nav nav-tabs">
                        <li <?php if($slug == 'new') echo 'class="active"'; ?>>  <a href="{{URL::route('user.buyer.email','new')}}" >{{Lang::get('user.new')}}</a></li>
                        <li <?php if($slug == 'all') echo 'class="active"'; ?>>  <a href="{{URL::route('user.buyer.email','all')}}" >{{Lang::get('user.all')}}</a></li>
                        <li <?php if($slug == 'sent') echo 'class="active"'; ?>> <a href="{{URL::route('user.buyer.email','sent')}}" >{{Lang::get('user.sent')}}</a></li>
                        <li <?php if($slug == 'inbox') echo 'class="active"'; ?>><a href="{{URL::route('user.buyer.email','inbox')}}">{{Lang::get('user.inbox')}}</a></li>
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
                                                      </td>
                                                      <td>
                                                        {{$emailList[$i]->subject}}
                                                      </td>
                                                      <td>{{substr($emailList[$i]->created_at,0,10)}}</td>
                                                      <td>
                                                           <a class="tooltips btn btn-sm rounded btn-primary" data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.show')}}" href="{{URL::route('user.buyer.newList', array(100000*1+$emailList[$i]->id,$slug))}}" ><i class="fa fa-tasks"></i></a>
                                                           <a class ="tooltips btn btn-sm rounded btn-danger" data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.delete')}}" href="{{URL::route('user.buyer.deleteEmail',array(100000*1+$emailList[$i]->id, $slug))}}"><i class="fa  fa-trash "></i></a>
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
        {{--<div class="modal fade" id="myReplyModal" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">--}}
               {{--<div class="modal-dialog">--}}
                   {{--<div class="modal-content modalChangeContent">--}}
                       {{--<div class="modal-header modalChangeHeader">--}}
                           {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>--}}
                           {{--<h4 class="modal-title modalChangeTitle" id="myModalLabel"></h4>--}}
                       {{--</div>--}}
                       {{--<div class="modal-body" id="myModaltext">--}}

                       {{--</div>--}}
                       {{--<div class="modal-footer">--}}
                           {{--<button type="button" class="btn-u btn-u-blue"  style="margin-right: 10px" onclick="OnSendBecomeSeller()">{{Lang::get('user.do_it_now')}}</button>--}}
                           {{--<button type="button" class="btn default"  data-dismiss="modal">{{Lang::get('user.do_it_later')}}</button>--}}
                       {{--</div>--}}
                   {{--</div>--}}
               {{--</div>--}}
           {{--</div>--}}
    @stop
    @section('custom-scripts-sub')
    @stop
@stop