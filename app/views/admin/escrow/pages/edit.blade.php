@extends('admin.layout')
    @section('body')
        <h3 class="page-title">Edit Escrow Page Management</h3>
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
                    <a href="{{URL::route('admin.escrow.pages')}}">Escrow Pages Management</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="{{URL::route('admin.escrow.pages.edit',$pages->id)}}">Edit Escrow Page</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            Edit Escrow Page
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
                        <form  class="form-horizontal" id="signupform" method="POST" action="{{URL::route('admin.escrow.pages.store')}}" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" value="{{$pages->id}}" name="page_id">
                                  @foreach ([
                                    'page_title' => 'Page Title:',
                                    'page_content' => 'Page Content:'
                                    ]
                                     as $key=> $value)
                                      @if($key === 'page_title')
                                           <div class="form-group" id="countryname">
                                               <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                               <div class="col-md-7 col-sm-7 col-xs-12">
                                                  <input  class="form-control" name="page_name" id="title" readonly value="{{$pages->page_name}}">
                                               </div>
                                           </div>
                                      @else
                                            <div class="form-group" id="countryname">
                                               <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                               <div class="col-md-7 col-sm-7 col-xs-12">
                                                  <textarea class="form-control" name="content" id="content">{{$pages->page_content}}</textarea>
                                                  <input type="hidden" name="realContent" id="realContent" >
                                               </div>
                                           </div>
                                      @endif
                                  @endforeach
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-7 col-md-5">
                                        <button   class="btn  blue" type="button" onclick="onSaveEmail()" ><i class="fa fa-check-circle-o" style="margin-right:4px"></i>Save</button>
                                        <a class="btn  green" href="{{URL::route('admin.escrow.pages')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
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
        <script type="text/javascript">
             jQuery(document).ready(function() {
                tinymce.init({
                      selector: "textarea#content",
                        theme: "modern",
                        plugins: [
                            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars code fullscreen",
                            "insertdatetime media nonbreaking save table contextmenu directionality",
                            "emoticons template paste textcolor colorpicker textpattern"
                        ],
                        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                        toolbar2: "print preview media | forecolor backcolor emoticons",
                        image_advtab: true,
                        height:350,
                        templates: [
                            {title: 'Test template 1', content: 'Test 1'},
                            {title: 'Test template 2', content: 'Test 2'}
                        ]
                    });
             });
             function onSaveEmail(){
                var subContent =tinymce.get('content').getContent();
                if(subContent  == "" || subContent == "<p></p>"){
                    bootbox.alert("Please insert content");
                    return;
                }
                $('#realContent').val(subContent);

                $("#signupform").submit();
             }
        </script>
    @stop
@stop