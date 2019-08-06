@extends('admin.layout')
@section('body')
    <h3 class="page-title">Edit Quick Details Management</h3>
    <!-- page layout -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <i class="fa fa-pencil"></i>
                <a href="{{URL::route('admin.quick')}}">Quick Details</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{URL::route('admin.quick.edit',$quick->id)}}">Edit Country</a>
            </li>
        </ul>
    </div>
    @include('admin.details.category')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        Edit Quick Detail
                    </div>
                </div>
                <div class="portlet-body form">
                    @if ($errors->has())
                        <div class="alert alert-danger alert-dismissibl fade in">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                    <form  class="form-horizontal" id="addCategoryFiledForm" method="POST" action="{{URL::route('admin.quick.store')}}" enctype="multipart/form-data">
                        <input type="hidden" name="quick_id" value="{{ $quick->id }}">
                        <div class="form-body">
                            @foreach ([
                                   'category' => 'Category  Name',
                                   'quick_details' => 'Quick Detail',]
                                    as $key=> $value)
                                @if ($key === 'category')
                                    <div class="form-group" id="countryname">
                                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="{{$key}}" class="form-control">
                                                <option value ="">Select Category</option>
                                                @foreach($quickCategory as $key =>$category)
                                                    @if($quick->category_id == $category->id)
                                                        <option value="{{$category->id}}" selected>{{$category->categoryname}}</option>
                                                    @else
                                                    <option value="{{$category->id}}">{{$category->categoryname}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group" id="countryflag">
                                        <label class="col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                        <div class="col-sm-6 col-xs-12">
                                            {{ Form::text($key, $quick->quick_details_name, ['class' => 'form-control','placeholder'=>$value]) }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-7 col-md-5">
                                    <button   class="btn  blue" type="submit" ><i class="fa fa-check-circle-o" style="margin-right:4px"></i>Edit</button>
                                    <a class="btn  green" href="{{URL::route('admin.quick')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('custom-scripts')
@stop
@stop
