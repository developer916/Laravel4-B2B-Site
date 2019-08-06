<?php
if(count($userMakertingPicture)>0){
?>
<div class="shadow-wrapper margin-bottom-50">
    <div class="carousel slide carousel-v1 box-shadow shadow-effect-2" id="myCarousel">
        <ol class="carousel-indicators">
            @foreach($userMakertingPicture as $key=>$value)
                <li class="rounded-x <?php if($key == 0) {echo 'active';}?>" data-target="#myCarousel" data-slide-to="<?php echo $key;?>" class="active"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            <?php if(Session::get('user_id') == ($user_id - 100000)) {?>
            <a href="javascript:void(0)" onclick="onChangeCompanyLogoPicture(<?php echo $user_id;?>)" title="{{Lang::get('user.Add_change_pic')}}">
                <img src = "<?php echo HTTP_PATH ?>/assets/media/images/camera.jpg" class="seller_store_add_picture_company">
            </a>
            <?php }?>
            @foreach($userMakertingPicture as $key=>$value)
                <div class="item <?php if($key ==0){echo 'active';}?>">
                    <img class="img-responsive" src="<?php echo HTTP_LOGO_PATH.$value->picture_url?>" alt="" >
                </div>
            @endforeach

        </div>

        <div class="carousel-arrow">
            <a data-slide="prev" href="#myCarousel" class="left carousel-control">
                <i class="fa fa-angle-left"></i>
            </a>
            <a data-slide="next" href="#myCarousel" class="right carousel-control">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
</div>
<?php }else{?>
<?php if(Session::get('user_id') == ($user_id - 100000)) {?>
<div class="row">
    <div class="col-md-12" style="height: 50px">
        <a href="javascript:void(0)" onclick="onChangeCompanyLogoPicture(<?php echo $user_id;?>)" title="{{Lang::get('user.Add_change_pic')}}">
            <img src = "<?php echo HTTP_PATH ?>/assets/media/images/camera.jpg" class="seller_store_add_picture_company">
        </a>
    </div>
</div>

<?php }?>
<?php }?>