@extends('user.member.layout')
    @section('custom-member-styles')
        {{ HTML::style('/assets/assest_admin/css/bootstrap-select.min.css') }}
        {{ HTML::style('/assets/assest_admin/css/select2.css') }}
        {{ HTML::style('/assets/assest_admin/css/multi-select.css') }}
        {{HTML::style('/assets/asset_view/css/style.css')}}
        {{ HTML::style('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.css') }}
        {{ HTML::style('/assets/asset_view/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}
    @stop
    @section('list')
       <li><a href="{{URL::route('user.member.video')}}">{{Lang::get('user.marketing_video')}}</a></li>
    @stop
    @section('body-content')
         <div class="tab-content">
             <div class="tab-pane fade active in margin-bottom-40" id="home-2">
                <div class="row">
                    <?php
                        if($companyProfile[0]->marketingpicture == "" && $companyProfile[0]->marketingvideo == ""){
                      ?>
                          <div class="col-md-12 margin-bottom-40">
                                <h4 style="color: red">{{Lang::get('user.marketing_empty')}}</h4>
                          </div>


                     <?php }else if($companyProfile[0]->marketingpicture != "" && $companyProfile[0]->marketingvideo == ""){?>
                        <div class="col-md-12 margin-bottom-40">
                            <div class="row">
                                <div class="col-md-5 col-sm-5">
                                    <img class="img-responsive" width="100%" src="/assets/logos/<?php echo $companyProfile[0]->marketingpicture; ?>" alt="">
                               </div>
                            </div>
                        </div>

                     <?php }else if($companyProfile[0]->marketingvideo != ""){?>
                        <div class="col-md-12 col-sm-12 margin-bottom-40">
                            <div class="row">
                                  <div class="col-md-6 col-sm-6">
                                    <div class="owl-video">
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
                                      </div>
                                  </div>
                            </div>
                        </div>
                     <?php } ?>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                         <div class="row">
                             <div class="col-md-6 col-sm-6">
                                 <h4>{{Lang::get('user.upload_marketing_image')}}</h4>
                                 <form action="{{URL::route('user.member.pictureStore')}}" method="post"  enctype="multipart/form-data">
                                    <?php if (isset($alert) && $alert['list'] == "marketingImageSuccess") {?>
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
                                     @if ($errors->has())
                                        <?php
                                            $errorlist = $errors->all();
                                            if($errorlist[count($errorlist)-1] == "marketingImageError"){
                                                ?>
                                            <div class="alert alert-danger alert-dismissibl fade in">
                                                <button type="button" class="close" data-dismiss="alert">
                                                    <span aria-hidden="true">&times;</span>
                                                    <span class="sr-only">Close</span>
                                                </button>
                                               <?php $ik =1; ?>
                                                <?php foreach ($errors->all() as $error){
                                                        if($ik != count($errorlist)){
                                                            echo  $error;
                                                        }
                                                        $ik++;
                                                    }
                                                ?>
                                            </div>
                                            <?php }?>
                                        @endif
                                     <div class="form-group">
                                         <input type="file" class="form-control" name="image">
                                     </div>
                                     <div class="form-group">
                                         <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.upload')}}">
                                     </div>
                                 </form>
                             </div>
                              <div class="col-md-6 col-sm-6">
                                 <h4>{{Lang::get('user.upload_marketing_video')}}</h4>
                                 <form action="{{URL::route('user.member.videoStore')}}" method="post"  enctype="multipart/form-data">
                                     <?php if (isset($alert) && $alert['list'] == "VideoFileSuccess") {?>
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
                                     @if ($errors->has())
                                        <?php
                                            $errorlist = $errors->all();
                                            if($errorlist[count($errorlist)-1] == "VideoFileError"){
                                                ?>
                                            <div class="alert alert-danger alert-dismissibl fade in">
                                                <button type="button" class="close" data-dismiss="alert">
                                                    <span aria-hidden="true">&times;</span>
                                                    <span class="sr-only">Close</span>
                                                </button>
                                               <?php $ik =1; ?>
                                                <?php foreach ($errors->all() as $error){
                                                        if($ik != count($errorlist)){
                                                            echo  $error;
                                                        }
                                                        $ik++;
                                                    }
                                                ?>
                                            </div>
                                            <?php }?>
                                        @endif
                                     <div class="form-group">
                                         <input type="file" class="form-control" name="video">
                                     </div>
                                     <div class="form-group">
                                         <input type="submit" class="btn-u btn-u-blue" value="{{Lang::get('user.upload')}}">
                                     </div>
                                 </form>
                             </div>
                         </div>
                   </div>
                </div>
             </div>
         </div>
    @stop
    @section('custom-member-scripts')
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