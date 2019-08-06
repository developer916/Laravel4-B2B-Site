@extends('user.seller.layout')
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
            <div class="row">
                <div class="col-md-12 favoriteContentBody">
                     <div class="panel  margin-bottom-40 change-panel">
                        <div class="panel-heading">
                            <a class="btn-u btn-u-blue rfqHeaderA" href="{{URL::route('user.seller.productCreate')}}"><i class="fa fa-plus"></i> {{Lang::get('user.create')}}</a>
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
                                        @foreach($products as $key => $product)
                                            <tr>
                                                 <td>
                                                    <div class="funny-boxes">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-4 funny-boxes-img">
                                                                <?php if(count($product->productpicture)>0){
                                                                        $rist = $product->productpicture;
                                                                        ?>
                                                                        <img src="{{$rist[0]->picture_url}}" style="width: 100%">
                                                                    <?php } else{?>
                                                                        <img src="/assets/asset_view/img/main/img1.jpg" class="img-responsive" style="width: 100%">
                                                                    <?php } ?>
                                                            </div>
                                                            <div class="col-md-8 col-sm-8">
                                                                <h2 class="margin-bottom-20">
                                                                    <a href ="{{URL::route('user.rfq',(100000*1+$product->id))}}" target="_blank">
                                                                        {{ $product->product_name }}
                                                                    </a>
                                                                </h2>
                                                                <p>
                                                                    <?php
                                                                        $length = strlen( $product->product_description);
                                                                        if($length >200){
                                                                           echo substr($product->product_description,0,200)."....";
                                                                        }else{
                                                                          echo $product->product_description;
                                                                        }
                                                                   ?>
                                                                </p>
                                                                <p>
                                                                    {{Lang::get('user.min_order')}} {{$product->min_order." ".$product->minOrderUnit->unitname}}
                                                                </p>
                                                                <p>
                                                                    {{Lang::get('user.supply_ability')}} {{$product->supply_ability." ".$product->supplyAbilityUnit->unitname}}
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                       <a href="{{ URL::route('user.seller.productEdit',(100000*1+$product->id))}}"  class='tooltips btn-u  btn-u-blue ' data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.edit')}}">
                                                                           <i class='fa fa-edit'></i>
                                                                       </a>
                                                                       {{--<a href="{{ URL::route('user.seller.productView',(100000*1+$product->id))}}" class='tooltips btn-u  btn-u-green ' data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.view')}}">--}}
                                                                            {{--<i class='fa fa-bars'></i>--}}
                                                                       {{--</a>--}}
                                                                       <a href="{{ URL::route('user.seller.productDelete',(100000*1+$product->id))}}"  class='tooltips btn-u  btn-u-red ' data-toggle="tooltip" data-placement="top" title="{{Lang::get('user.delete')}}">
                                                                          <i class='fa fa-trash'></i>
                                                                      </a>
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
                        </div>
                     </div>
                </div>
            </div>
        </div>
    @stop
@stop