<div class="row">
    <div class="col-md-12 margin-bottom-40" style="border-bottom: 2px solid #ddd8e5">
        <h3 style="display: inline-block">{{Lang::get('user.company_introduction')}}</h3>
        <button class="btn-u btn-u-blue" onclick="onReadDiv()" style="float:right">{{Lang::get('user.read_more')}}</button>
    </div>
    <div class="col-md-12 col-sm-12" id="companyIntroduceDiv" style="display: none">
        <div class="row">
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
            <div class="col-md-5 col-sm-5">
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
            <div class="col-md-2 col-sm-2">
                <a href =" {{URL::route('user.contact',$user_id)}}" class="btn-u btn-u-orange" style="margin-top: 20px"> <i class=" fa fa-pencil-square-o"></i> Contact Seller</a>
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
            <div class="col-md-2 col-sm-2">
                <a href =" {{URL::route('user.contact',$user_id)}}" class="btn-u btn-u-orange" style="margin-top: 20px"> <i class=" fa fa-pencil-square-o"></i> Contact Seller</a>
            </div>
            <?php }?>
        </div>
    </div>
</div>