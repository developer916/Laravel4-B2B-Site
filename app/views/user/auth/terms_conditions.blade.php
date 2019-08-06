@extends('user.layout')
    @section('body')
        <div class="container" style="margin-top:40px">
            <div class="row">
               @foreach($conditions as $key =>$condition)
                    <div class="col-md-12 margin-bottom-40">
                        @if(isset($condition->title))
                            <h1>{{$condition->title}}</h1>
                        @endif
                        {{$condition->description}}
                    </div>
               @endforeach

            </div>
        </div>
    @stop