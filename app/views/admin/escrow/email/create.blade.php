@extends('admin.layout')
    @section('body')
        <h3 class="page-title">Add Email Template Management</h3>
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
                    <a href="{{URL::route('admin.escrow.email')}}">Email Template Management</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <i class="fa fa-pencil"></i>
                    <a href="{{URL::route('admin.escrow.email.create')}}">Add Email Template</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            Add Email Template
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
                         <form  class="form-horizontal" id="signupform" method="POST" action="{{URL::route('admin.escrow.email.store')}}" enctype="multipart/form-data">
                            <div class="form-body">
                                @foreach ([
                                    'title' => 'Email Title:',
                                    'content' => 'Email Content:'
                                    ]
                                     as $key=> $value)
                                      @if($key === 'title')
                                           <div class="form-group" id="countryname">
                                               <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                               <div class="col-md-7 col-sm-7 col-xs-12">
                                                  <textarea class="form-control" name="title" id="title"></textarea>
                                               </div>
                                           </div>
                                      @else
                                            <div class="form-group" id="countryname">
                                               <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                               <div class="col-md-7 col-sm-7 col-xs-12">
                                                  <textarea class="form-control" name="content" id="content" rows="10"></textarea>
                                                  <input type="hidden" name="realContent" id="realContent">
                                               </div>
                                           </div>
                                      @endif
                                  @endforeach
                                  <div class="form-actions">
                                      <div class="row">
                                          <div class="col-md-offset-7 col-md-5">
                                              <button   class="btn  blue" type="submit"><i class="fa fa-check-circle-o" style="margin-right:4px"></i>Save</button>
                                              <a class="btn  green" href="{{URL::route('admin.escrow.email')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
                                          </div>
                                      </div>
                                  </div>
                            </div>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    @stop
@stop