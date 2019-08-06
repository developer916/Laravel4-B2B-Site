@extends('user.help.layout')
    @section('body-content')
        <div class="row">
            <div class="col-md-12">
                <ul class="helpList">
                    @foreach($helps as $help)
                        <li><a href="{{URL::route('user.help.faq_item',100000*1+$help->id)}}">{{$help->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    @stop
@stop