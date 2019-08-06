@extends('admin.layout')
	@section('body')
		<h3 class="page-title">Add Help  Management</h3>
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
						<a href="{{URL::route('admin.helpCreating')}}">Categories</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="{{URL::route('admin.helpCreating.create')}}">Add Help</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								Add  Help
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
							<form  class="form-horizontal" id="addCategoryFiledForm" method="POST" action="{{URL::route('admin.helpCreating.store')}}" enctype="multipart/form-data">

							    <div class="form-body">
                                     @foreach ([
                                        'categoryname' => 'Category Name',
                                        'subcategoryname' => 'Sub Category Name',
                                        'title' =>'Title',
                                        'content' =>'Content'
                                        ]
                                         as $key=> $value)
                                         @if ($key === 'categoryname')
                                            <div class="form-group" id="countryname">
                                                 <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                  <div class="col-md-7 col-sm-7 col-xs-12">
                                                      <select name="category" class="form-control" onchange="onChangeCategory()" id="category">
                                                           <option value="">-- Select Category --</option>
                                                           @foreach($category as $categories)
                                                            <option value="{{$categories->id }}">{{$categories->categoryname}}</option>
                                                           @endforeach
                                                      </select>
                                                 </div>
                                                  <div class="col-md-1 col-sm-1 col-xs-2">
                                                      <div id="spin" style ="display:none;" style="margin-top: 15px"></div>
                                                  </div>
                                            </div>
                                         @elseif($key ==='subcategoryname')
                                            <div class="form-group" id="countryname">
                                                 <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                  <div class="col-md-7 col-sm-7 col-xs-12">
                                                      <select name="subcategory" class="form-control" id="subcategory">
                                                        <option value="">-- Select Sub Category --</option>
                                                      </select>
                                                 </div>
                                            </div>
                                         @elseif($key==='title')
                                            <div class="form-group" id="countryname">
                                                 <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                  <div class="col-md-7 col-sm-7 col-xs-12">
                                                      <textarea class="form-control" name="title"></textarea>
                                                  </div>
                                            </div>
                                          @else
                                            <div class="form-group" id="countryname">
                                                 <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                  <div class="col-md-7 col-sm-7 col-xs-12">
                                                      <textarea class="form-control" name="content" id="content"></textarea>
                                                      <input type="hidden" id="subcontent" name="subcontent">
                                                  </div>
                                            </div>
                                         @endif

                                      @endforeach
							    </div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-7 col-md-5">
											<button   class="btn  blue" type="button" onclick="onSetContent()" ><i class="fa fa-check-circle-o" style="margin-right:4px"></i>Save</button>
											<a class="btn  green" href="{{URL::route('admin.helpCategory')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
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
         {{ HTML::script('/assets/assest_admin/js/spin.js') }}
         {{ HTML::script('/assets/assest_admin/js/bootbox.js') }}
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
                        height : 350,
                        templates: [
                            {title: 'Test template 1', content: 'Test 1'},
                            {title: 'Test template 2', content: 'Test 2'}
                        ]
                    });
             });

             function onChangeCategory(){
                 $("#spin").css('display','block');
                    var opts = {
                      lines: 7, // The number of lines to draw
                      length: 6, // The length of each line
                      width: 5, // The line thickness
                      radius: 8, // The radius of the inner circle
                      corners: 1, // Corner roundness (0..1)
                      rotate: 90, // The rotation offset
                      direction: 1, // 1: clockwise, -1: counterclockwise
                      color: '#000', // #rgb or #rrggbb or array of colors
                      speed: 0.7, // Rounds per second
                      trail: 60, // Afterglow percentage
                      shadow: false, // Whether to render a shadow
                      hwaccel: false, // Whether to use hardware acceleration
                      className: 'spinner', // The CSS class to assign to the spinner
                      zIndex: 2e9, // The z-index (defaults to 2000000000)
                      top: 'auto', // Top position relative to parent in px
                      left: 'auto' // Left position relative to parent in px
                    };
                    var target = document.getElementById('spin');
                    var spinner = new Spinner(opts).spin(target);
                    var categoryID = $("#category").val();
                    var base_url = window.location.origin;
                    $.ajax ({
                        url: base_url + '/admin/help/creating/getSubCategory',
                        type: 'POST',
                        data: {categoryID : categoryID},
                        cache: false,
                        dataType : "json",
                        success: function (data) {
                            $("#spin").css('display','none');
                           if(data.result =="success"){
                               $("#subcategory").find("option").remove();
                               $("#subcategory").append('<option value=""> --- Select Sub Category --- </option>');
                               if(data.subcategory.length>0){
                                    for(var i=0; i<data.subcategory.length; i++){
                                        $("#subcategory").append('<option value="'+data.subcategory[i]['id']+'">'+data.subcategory[i]['subcategoryname']+'</option>');
                                    }
                                }else{
                                    $("#subcategory").find("option").remove();
                                    $("#subcategory").append('<option value="">--- Select Sub Category --- </option>');
                                }
                            }
                        }
                  });
             }
             function onSetContent(){
                    var subContent =tinymce.get('content').getContent();
                    $('#subcontent').val(subContent);
                    if(subContent =="" || subContent == "<p></p>"){
                        bootbox.alert("Please insert content");
                    }
                    $("#addCategoryFiledForm").submit();
             }
         </script>
	@stop
@stop
