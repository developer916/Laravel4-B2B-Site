@extends('admin.layout')
    @section('body')
        <h3 class="page-title">Escrow Electronic Management</h3>
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
                    <a href="{{URL::route('admin.escrow.electronic')}}">Escrow Electronic Setting</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-body">
                        <?php if (isset($alert)) { ?>
                            <div class="alert alert-<?php echo $alert['type'];?> alert-dismissibl fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <p>
                                    <?php echo $alert['msg'];?>
                                </p>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12 margin-bottom-40">
                                <form action="{{URL::route('admin.escrow.electronic.store')}}" method="post" class="form-horizontal" id="onSendMessageModalContentDiv">
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-3 col-md-4 col-sm-4 col-xs-5 control-label">Electronic Content</label>
                                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7">
                                            <textarea class="form-control" name="electronic" id="electronic" placeholder="Electronic Content" rows="10">
                                                <?php
                                                    if(count($electronic) >0){
                                                        echo $electronic[0]->content;
                                                    }
                                                ?>
                                            </textarea>
                                            <input type="hidden" name="realContent" id="realContent">
                                            <input type="hidden" name="electronic_id" value=" <?php if(count($electronic) >0){ echo $electronic[0]->id;}?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-7 col-lg-offset-3 col-md-offset-4 col-sm-offset-4 col-xs-offset-5 text-right">
                                            <input type="button" class="btn blue" value="Edit" onclick="onSaveForm()">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
            <script type="text/javascript">
                 jQuery(document).ready(function() {
                    tinymce.init({
                          selector: "textarea#electronic",
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
                 function onSaveForm(){
                    var subContent =tinymce.get('electronic').getContent();
                    if(subContent  == "" || subContent == "<p></p>"){
                        bootbox.alert("Please insert content");
                        return;
                    }
                    $('#realContent').val(subContent);

                    $("#onSendMessageModalContentDiv").submit();
                 }
            </script>
        @stop
@stop