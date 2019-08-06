@extends('user.member.layout')
    @section('custom-member-styles')
        {{ HTML::style('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.css') }}
    @stop
    @section('list')
         <li><a href="{{URL::route('user.member.product')}}">{{Lang::get('user.product_picture')}}</a></li>
    @stop
    @section('body-content')
         <div class="tab-content">
            <div class="tab-pane fade active in margin-bottom-40" id="home-2">
               <div class="panel panel-sea margin-bottom-40">
                    <div class="panel-heading">
                        <div class="col-md-6 col-sm-6">
                            <h3 class="panel-title floatleft" style="line-height: 30px;">
                                <i class="icon-list"></i>{{Lang::get('user.product_picture')}}
                            </h3>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <button class="floatright btn-u btn-u-red" onclick="onDeleteInventoryImageList()" style="margin-right: 10px">
                                <i class="icon-trash"></i> {{Lang::get('user.delete')}}
                            </button>
                            <div class="floatright" style="margin-right: 10px;" id="uploadPdfCheck">
                                <button class="btn-u btn-u-blue"> <i class="icon-plus"></i> {{Lang::get('user.upload')}} </button>
                                <form id="imageForm" method="post" enctype="multipart/form-data" action="{{URL::route('user.member.productUpload')}}">
                                    <input type="file" name="imageUpload" id="imageUpload" style="cursor: pointer">
                                </form>
                            </div>
                        </div>
                        <div class="clearboth"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            if(count($productPicture) == 0){?>
                                <h4>{{Lang::get('user.picture_empty')}}</h4>
                        <?php }else{ ?>

                        <?php  $countDiv = count($productPicture);
                              $countDivDown = count($productPicture);
                              echo '';
                            for($i = 0; $i<count($productPicture);$i++){
                                if($i%3 == 0){echo '<div class="row  margin-bottom-30">';}
                            ?>
                                 <div class="col-sm-4 sm-margin-bottom-30" id="galleryList">
                                    <input type="checkbox" class="gallery-close-button" id="galleryID" value="{{$productPicture[$i]->id}}">
                                    <a href="/assets/logos/{{$productPicture[$i]->picture_url}}" rel="gallery1" class="fancybox img-hover-v1" title="Image 1">
                                        <span><img class="img-responsive" src="/assets/logos/{{$productPicture[$i]->picture_url}}" alt=""></span>
                                    </a>
                                </div>
                            <?php $countDivDown = $countDivDown -1;
                                if($i%3==2 || $countDivDown == 0){echo "</div>";}
                            }
                            echo "</div>";
                 }
               ?>
               </div>
            </div>
         </div>
    @stop
    @section('custom-member-scripts')
       {{ HTML::script('/assets/asset_view/js/app.js') }}
       {{ HTML::script('/assets/asset_view/plugins/fancybox/source/jquery.fancybox.pack.js') }}
       {{ HTML::script('/assets/asset_view/js/plugins/fancy-box.js') }}
       {{ HTML::script('/assets/assest_admin/js/bootbox.js') }}
       {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
       <script type="text/javascript">
           jQuery(document).ready(function() {
                   App.init();
                   FancyBox.initFancybox();
                   $("input#imageUpload").change( function(){
                      var imageUploadObj = $(this);
                      $(this).parents("form").ajaxForm({
                            success: function(data) {
                                if(data.result == "success"){
                                    bootbox.alert(data.message);
                                    window.location.reload();
                                }

                                else if(data.result == "failed"){
                                    var arr = data.error;
                                        var errorList = '';
                                       $.each(arr, function(index, value)
                                       {
                                           if (value.length != 0)
                                           {
                                               errorList = errorList + value;
                                           }
                                       });
                                        bootbox.alert(errorList);
                                 }
                           }
                      }).submit();
                    });
              });
            function  onDeleteInventoryImageList(){
                var checkList = new Array();
                var listIndex =0;
               $(".panel-body").find("div.row").each(function(){
               		$(this).find("div#galleryList").each(function(){
               			checkInputID = $(this).find("input#galleryID:checkbox:checked").eq(0).val();//find("input#galleryID:checkbox:checked").eq(0);
               			if(checkInputID != undefined && checkInputID != null && checkInputID !="" ){
               				checkList[listIndex] = checkInputID;
               				listIndex++;
               			}

               		});
               	});

               	if(checkList.length == 0){ bootbox.alert( "Please select image to delete"); return;}
               	 var base_url = window.location.origin;
                   $.ajax ({
                        url: base_url + '/member/productDelete',
                        type: 'POST',
                        data: {checkList : checkList},
                        cache: false,
                        dataType : "json",
                        success: function (data) {
                            if(data.result == "success"){
                               bootbox.alert(data.message);
                              window.location.reload();
                            }
                        }
                  });
            }
       </script>
    @stop
@stop