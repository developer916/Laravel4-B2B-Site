@extends('user.seller.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/app.css')}}
        {{HTML::style('/assets/asset_view/plugins/font-awesome/css/font-awesome.min.css')}}
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 favoriteContentBody">
                     <div class="panel panel-default margin-bottom-40 change-panel">
                        <div class="panel-body">
                            <div class="table-responsive">
                                  <table class="table table-striped">
                                      <thead>
                                          <tr>
                                              <th></th>
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

                                            @foreach($members as $key=>$member)
                                                <tr>
                                                    <td>
                                                        <div class="funny-boxes">
                                                            <div class="row">
                                                                <div class="col-md-4 funny-boxes-img">
                                                                    @if(count($company[$key])>0)
                                                                     <?php if($company[$key][0]->companylogo != "") {?>
                                                                           <img src="{{HTTP_LOGO_PATH.$company[$key][0]->companylogo}}"  class="img-responsive" style="width: 100%">
                                                                       <?php }else{?>
                                                                            <img src="/assets/asset_view/img/main/img1.jpg" class="img-responsive">
                                                                       <?php }?>
                                                                     @else
                                                                        <img src="/assets/asset_view/img/main/img1.jpg" class="img-responsive">
                                                                     @endif
                                                                </div>
                                                                <div class="col-md-8">
                                                                    @if(count($company[$key])>0)
                                                                    <?php if($company[$key][0]->companyname !=""){?>
                                                                        <h2 class="margin-bottom-20">{{$company[$key][0]->companyname}}</h2>
                                                                    <?php } ?>
                                                                    @endif
                                                                    <p class="margin-bottom-20"><?php echo $member->firstname." ".$member->lastname ?></p>
                                                                    <a href = "{{URL::route('user.seller.store',(100000*1+$member->id))}}" class="btn-u btn-u-green buttonChangeBoxShadow" target="_blank" style="margin-right: 30px"><i class="fa fa-bars"></i> {{Lang::get('user.web_store')}}</a>
                                                                    <a href="{{URL::route('user.contact',(100000*1+$member->id))}}" class="btn-u btn-u-green buttonChangeBoxShadow" target="_blank"><i class=" fa fa-pencil-square-o"></i> {{Lang::get('user.layout_contact')}}</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                      </tbody>
                                      <div class="pull-right">{{ $members->links() }}</div>
                                  </table>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts-sub')
    @stop
@stop