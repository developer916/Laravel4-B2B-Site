@extends('user.layout')
    @section('body')
        <div class="container">

                <?php $i =0; ?>
                @foreach($category as $categories)
                    <?php if($i%3 ==0){?>
                    <div class="row" style="margin-top: 20px">
                    <?php }?>
                        <div class="col-md-4">
                            <div class="headline">
                                <h2>{{$categories->categoryname}}</h2>
                            </div>
                            <ul class="list-unstyled">
                                <?php $subcategory = $categories->subCategories?>
                                @foreach($subcategory as $subcategories)
                                    <li><a href="{{URL::route('user.category.sub',100000*1+$subcategories->id)}}">{{ucfirst($subcategories->subcategoryname)}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                     <?php if(($i%3 == 2) ||($i==(count($category)-1))){?>
                    </div>
                    <?php }
                        $i++;
                    ?>
                @endforeach

        </div>
    @endsection
@stop
