@extends('user.category.layout')
    @section('body-content')
        @if(count($helps)>0)
            @foreach($helps as $help)
                <div class="row margin-bottom-40">
                     <div class="shadow-wrapper">
                         <blockquote class="hero box-shadow shadow-effect-2">
                            <div class="row">
                                <div class="col-md-4 col-sm-8">
                                    <?php
                                        $productImage = $help->productpicture;
                                    ?>
                                    <img src="{{HTTP_LOGO_PATH.$productImage[0]->picture_url}}" class="imageUrl">
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <div class="row">
                                        <div class="col-md-12 margin-bottom-20">
                                            <a href="{{URL::route('user.category.product',(100000*1+$help->id))}}" class="helpSize">{{$help->product_name}}</a>
                                        </div>
                                        <div class="col-md-12 margin-bottom-20">
                                             <p>
                                                {{Lang::get('user.category')}}
                                                <?php echo $help->category->categoryname." -> ".ucfirst($help->subcategory->subcategoryname);?>
                                             </p>
                                             <p>
                                                {{Lang::get('user.min_order')}}
                                                <?php echo $help->min_order." ".$help->minOrderUnit->unitname ;?>
                                             </p>
                                             <p>
                                                 {{Lang::get('user.supply_ability')}}
                                                 <?php echo $help->supply_ability." ".$help->supplyAbilityUnit->unitname ;?>
                                              </p>
                                              <p>
                                                {{Lang::get('user.meta')}}
                                                <?php echo $help->meta ;?>
                                              </p>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <a href="{{URL::route('user.contact',(100000*1+$help->user_id))}}" class="btn-u btn-u-orange" target="_blank"><i class=" fa fa-pencil-square-o"></i> {{Lang::get('user.contact_seller')}}</a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                         </blockquote>
                     </div>
                </div>
            @endforeach
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        {{ $helps->links() }}
                    </div>
                </div>

        @else
            <h2>{{Lang::get('missing.search')}}</h2>
        @endif
    @stop
@stop