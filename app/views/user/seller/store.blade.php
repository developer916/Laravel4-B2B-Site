@extends('user.category.layout')
    @section('body-content')
        <div class="row"  style="margin-top:20px">
            @foreach($helps as $key=>$value)
                <div class="col-md-4 col-sm-4 col-xs-6" style="margin-top:20px">
                    <?php
                        $tooltip = "<h4 style='font-size: 17px; font-weight:600' >".ucwords($value->product_name)."</h4>";
                        if ($value->meta) {
                             $tooltip.= "<p><b>". Lang::get('user.store_meta')." : </b>".$value->meta."</p>";
                        }
                        if ($value->min_order) {
                             $tooltip.= "<p><b>".Lang::get('user.min_order')." </b>".$value->min_order." ".$value->minOrderUnit->unitname."</p>";
                        }
                        if ($value->supply_ability) {
                             $tooltip.= "<p><b>".Lang::get('user.supply_ability')." </b>".$value->supply_ability." ".$value->supplyAbilityUnit->unitname."</p>";
                        }

                    ?>
                  <div class="tooltips" data-toggle="tooltip" data-placement="{{ $key % 3 == 2 ? 'left' : 'right' }}" data-html="true" data-original-title="{{ $tooltip }}" data-href="">
                       <?php
                        $listCheck = $value->productpicture;
                        if(count($listCheck) >0){?>
                            <div class="thumb-store-photo" style="background: url({{$listCheck[0]->picture_url }}); height: 185px;  width: 100%; background-size: 100% 100%; background-repeat: no-repeat">
                        <?php }else{
                       ?>
                       <?php }?>
                            <div class="thumb-store-name">
                                <div class="store-highlight">
                                    <a href ="{{URL::route('user.category.product' ,(100000*1+$value->id))}}">{{ ucwords($value->product_name) }}</a>
                                </div>
                            </div>
                         </div>
                  </div>
                </div>
            @endforeach
        </div>
    @stop
    @section('custom-scripts')
        {{HTML::script('assets/asset_view/js/bootstrap-tooltip.js')}}

    @stop
@stop