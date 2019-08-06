@if(count($productPicture1) >0)
    <a id="Zoom-1" class="MagicZoom" href="{{HTTP_LOGO_PATH.$productPicture1[0]->image_url}}">
        <img src="{{HTTP_LOGO_PATH.$productPicture1[0]->image_url}}?scale.height=400"  id="imageList">
    </a>
    <div class="selectors">
        @foreach($productPicture1 as $key_productpicture =>$value_productpicture )
            <a data-zoom-id="Zoom-1" href="{{HTTP_LOGO_PATH.$value_productpicture->image_url}}"
               data-image="{{HTTP_LOGO_PATH.$value_productpicture->image_url}}?scale.height=400" class="mz-thumb">
                <img srcset="{{HTTP_LOGO_PATH.$value_productpicture->image_url}}?scale.width=112 2x" src="{{HTTP_LOGO_PATH.$value_productpicture->image_url}}?scale.width=56"/>
            </a>
        @endforeach
    </div>
@endif