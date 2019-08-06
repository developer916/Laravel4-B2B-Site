@extends('user.seller.storeLayout')
      @section('custom-styles')
       {{HTML::style('/assets/asset_view/css/blocks.css')}}
       {{HTML::style('/assets/asset_view/css/style.css')}}
       {{HTML::style('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.css') }}
       {{ HTML::style('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}
     @stop
    @section('body')
        <div class="breadcrumbs">
            <div class="container">
                <h1 class="pull-left">
                    <?php
                        echo ucfirst($companyProfile[0]->companyname);
                    ?>
                </h1>
                 <ul class="pull-right breadcrumb">
                        <li><a href="{{URL::route('user.seller.store',$user_id)}}">{{Lang::get('user.layout_home')}}</a></li>
                        <li class="active"><a href="{{URL::route('user.seller.profile',$user_id)}}"><?php echo ucfirst($companyProfile[0]->companyname);?></a></li>
                    </ul>
            </div>
        </div>
        <div class="container content">
            <div class="row margin-bottom-40">
                <?php if((isset($companyProfile[0]->marketingvideo) && $companyProfile[0]->marketingvideo!='') || (isset($companyProfile[0]->companyyoutube) && $companyProfile[0]->companyyoutube!='')) { ?>
                    <div class="col-md-5 col-sm-5">

                        <div class="owl-video">
                            <?php if($companyProfile[0]->marketingvideo!='' && $companyProfile[0]->companyyoutube!='') {?>
                            <div class="item">
                                <a class="fbox-modal fancybox.iframe" href="{{URL::route('user.video',$user_id)}}">
                                    <?php if($companyProfile[0]->marketingpicture !=''){?>
                                    <img class="img-responsive" width="100%" src="/assets/logos/<?php echo $companyProfile[0]->marketingpicture; ?>" alt="">
                                    <?php }else{?>
                                    <img class="img-responsive" width="100%" src="/assets/asset_view/img/main/img20.jpg" alt="">
                                    <?php }?>
                                    <img class="video-play" src="/assets/asset_view/img/icons/video-play.png" alt="">
                                </a>
                            </div>
                            <div class="item">
                                <a class="fbox-modal fancybox.iframe" href="{{$companyProfile[0]->companyyoutube}}">
                                   <?php if($companyProfile[0]->marketingpicture !=''){?>
                                       <img class="img-responsive" width="100%" src="/assets/logos/<?php echo $companyProfile[0]->marketingpicture; ?>" alt="">
                                       <?php }else{?>
                                       <img class="img-responsive" width="100%" src="/assets/asset_view/img/main/img20.jpg" alt="">
                                       <?php }?>
                                    <img class="video-play" src="/assets/asset_view/img/icons/video-play.png" alt="">
                                </a>
                            </div>
                            <?php }else if($companyProfile[0]->marketingvideo!=''){?>
                                <div class="item">
                                    <a class="fbox-modal fancybox.iframe" href="{{URL::route('user.video',$user_id)}}">
                                        <?php if($companyProfile[0]->marketingpicture !=''){?>
                                        <img class="img-responsive" width="100%" src="/assets/logos/<?php echo $companyProfile[0]->marketingpicture; ?>" alt="">
                                        <?php }else{?>
                                        <img class="img-responsive" width="100%" src="/assets/asset_view/img/main/img20.jpg" alt="">
                                        <?php }?>
                                        <img class="video-play" src="/assets/asset_view/img/icons/video-play.png" alt="">
                                    </a>
                                </div>
                            <?php }else if($companyProfile[0]->companyyoutube!=''){?>
                                <div class="item">
                                    <a class="fbox-modal fancybox.iframe" href="{{$companyProfile[0]->companyyoutube}}">
                                       <?php if($companyProfile[0]->marketingpicture !=''){?>
                                           <img class="img-responsive" width="100%" src="/assets/logos/<?php echo $companyProfile[0]->marketingpicture; ?>" alt="">
                                           <?php }else{?>
                                           <img class="img-responsive" width="100%" src="/assets/asset_view/img/main/img20.jpg" alt="">
                                           <?php }?>
                                        <img class="video-play" src="/assets/asset_view/img/icons/video-play.png" alt="">
                                    </a>
                                </div>
                            <?php }?>
                         </div>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <div class="row margin-bottom-10">
                            <div class="col-md-5 col-sm-5 col-xs-6">
                                {{Lang::get('user.business_type')}}
                            </div>
                           <div class="col-md-7 col-sm-7 col-xs-6">
                                {{$business_type->businesstype}}
                            </div>
                        </div>
                        <div class="row margin-bottom-10">
                            <div class="col-md-5 col-sm-5 col-xs-6">
                                {{Lang::get('user.main_product_focus')}}
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-6">
                                {{$productfocus->productfocus}}
                            </div>
                        </div>
                        <div class="row margin-bottom-10">
                            <div class="col-md-5 col-sm-5 col-xs-6">
                                {{Lang::get('user.number_of_employees')}}
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-6">
                                {{$employees->employees}}
                            </div>
                        </div>
                         <div class="row margin-bottom-10">
                            <div class="col-md-5 col-sm-5 col-xs-6">
                                 {{Lang::get('user.year_establish')}}
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-6">
                               {{$companyProfile[0]->companyyear}}
                            </div>
                        </div>
                        <?php if(isset($companyProfile[0]->ceoownername)){?>
                             <div class="row margin-bottom-10">
                                <div class="col-md-5 col-sm-5 col-xs-6">
                                    {{Lang::get('user.ceo_name')}}
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    {{$companyProfile[0]->ceoownername}}
                                </div>
                            </div>
                            <?php }?>
                        <?php if(isset($companyProfile[0]->factorysize)){?>
                             <div class="row margin-bottom-10">
                                   <div class="col-md-5 col-sm-5 col-xs-6">
                                     {{Lang::get('user.factory_size')}}
                                 </div>
                                 <div class="col-md-7 col-sm-7 col-xs-6">
                                     {{$factorysize->factorysize}}
                                 </div>
                             </div>
                             <?php }?>
                              <?php if(isset($companyProfile[0]->factorylocation)){?>
                             <div class="row margin-bottom-10">
                                   <div class="col-md-5 col-sm-5 col-xs-6">
                                     {{Lang::get('user.factory_location')}}
                                 </div>
                                  <div class="col-md-7 col-sm-7 col-xs-6">
                                    {{$companyProfile[0]->factorylocation}}
                                 </div>
                             </div>
                             <?php }?>
                             <?php if(isset($companyProfile[0]->qa_qc)){?>
                             <div class="row margin-bottom-10">
                                  <div class="col-md-5 col-sm-5 col-xs-6">
                                     {{Lang::get('user.qa_qc')}}
                                 </div>
                                  <div class="col-md-7 col-sm-7 col-xs-6">
                                     {{$companyProfile[0]->qa_qc}}
                                 </div>
                             </div>
                             <?php } ?>
                         </div>
                    <?php }else { ?>

                        <div class="col-md-8 col-sm-8">
                            <div class="row margin-bottom-10">
                                <div class="col-md-5 col-sm-5 col-xs-6">
                                    {{Lang::get('user.business_type')}}
                                </div>
                               <div class="col-md-7 col-sm-7 col-xs-6">
                                    {{$business_type->businesstype}}
                                </div>
                            </div>
                            <div class="row margin-bottom-10">
                                <div class="col-md-5 col-sm-5 col-xs-6">
                                    {{Lang::get('user.main_product_focus')}}
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    {{$productfocus->productfocus}}
                                </div>
                            </div>
                            <div class="row margin-bottom-10">
                                <div class="col-md-5 col-sm-5 col-xs-6">
                                    {{Lang::get('user.number_of_employees')}}
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    {{$employees->employees}}
                                </div>
                            </div>
                             <div class="row margin-bottom-10">
                                <div class="col-md-5 col-sm-5 col-xs-6">
                                     {{Lang::get('user.year_establish')}}
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                   {{$companyProfile[0]->companyyear}}
                                </div>
                            </div>
                            <?php if(isset($companyProfile[0]->ceoownername)){?>
                                 <div class="row margin-bottom-10">
                                    <div class="col-md-5 col-sm-5 col-xs-6">
                                        {{Lang::get('user.ceo_name')}}
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-6">
                                        {{$companyProfile[0]->ceoownername}}
                                    </div>
                                </div>
                                <?php }?>
                            <?php if(isset($companyProfile[0]->factorysize)){?>
                                 <div class="row margin-bottom-10">
                                       <div class="col-md-5 col-sm-5 col-xs-6">
                                         {{Lang::get('user.factory_size')}}
                                     </div>
                                     <div class="col-md-7 col-sm-7 col-xs-6">
                                         {{$factorysize->factorysize}}
                                     </div>
                                 </div>
                                 <?php }?>
                                  <?php if(isset($companyProfile[0]->factorylocation)){?>
                                 <div class="row margin-bottom-10">
                                       <div class="col-md-5 col-sm-5 col-xs-6">
                                         {{Lang::get('user.factory_location')}}
                                     </div>
                                      <div class="col-md-7 col-sm-7 col-xs-6">
                                        {{$companyProfile[0]->factorylocation}}
                                     </div>
                                 </div>
                                 <?php }?>
                                 <?php if(isset($companyProfile[0]->qa_qc)){?>
                                 <div class="row margin-bottom-10">
                                      <div class="col-md-5 col-sm-5 col-xs-6">
                                         {{Lang::get('user.qa_qc')}}
                                     </div>
                                      <div class="col-md-7 col-sm-7 col-xs-6">
                                         {{$companyProfile[0]->qa_qc}}
                                     </div>
                                 </div>
                                 <?php } ?>
                             </div>
                    <?php }?>
            </div>

        </div>

    @stop
    @section('custom-scripts')
        {{ HTML::script('/assets/asset_view/js/app.js') }}
        {{ HTML::script('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.pack.js') }}
        {{ HTML::script('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}
        {{ HTML::script('/assets/asset_view/js/plugins/fancy-box.js') }}
        {{ HTML::script('/assets/asset_view/js/plugins/owl-carousel.js') }}
        <script type="text/javascript">
            jQuery(document).ready(function() {
                    App.init();
                    FancyBox.initFancybox();
                    OwlCarousel.initOwlCarousel();
                });
        </script>
    @stop
@stop