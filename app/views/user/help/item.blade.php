@extends('user.help.layout')
    @section('body-content')
        <div class="row">
            <div class="col-md-12 margin-bottom-40">
              <a href="{{URL::route('user.help.faq_list',100000*1+$helps[0]->subcategory_id)}}">{{Lang::get('user.back_to_list')}}</a>
           </div>
           <div class="col-md-12">
               <h2>{{$helps[0]->title}}</h2>
               <?php echo $helps[0]->content;?>
           </div>
        </div>
    @stop
@stop