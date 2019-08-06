@extends('admin.layout')
    @section('custom-styles')
        {{ HTML::style('/assets/assest_admin/css/bootstrap-select.min.css') }}
        {{ HTML::style('/assets/assest_admin/css/select2.css') }}
        {{ HTML::style('/assets/assest_admin/css/multi-select.css') }}
    @endsection
	@section('body')
		<h3 class="page-title">Edit Company Management</h3>
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
						<a href="{{URL::route('admin.members')}}">Users</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="{{URL::route('admin.members.editcompany',$user_id)}}"> Edit Company Profile</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								Eidt Company Profile
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
							<form  class="form-horizontal" id="addCategoryFiledForm" method="POST" action="{{URL::route('admin.members.companystore')}}" enctype="multipart/form-data"  >
                                <input type="hidden" value="{{ $user_id }}" name="user_id">
                                <input type="hidden" value="{{ $companyprofile[0]->id }}" name="companyprofile_id">
                                <?php
                                    $companyCategory = array();
                                    $list = explode(',' , $companyprofile[0]->categories );
                                ?>
                                <div class="form-body">
                                     @foreach ([
                                        'companyname' => 'Company Name:',
                                        'companyaddress' => 'Company Address:',
                                        'companycity' => 'Company City:',
                                        'companystate' => 'Company State:',
                                        'companycountry' => 'Company Country:',
                                        'companyphonenumber' => 'Phone Number:',
                                        'companyfax' =>'Fax:',
                                        'companylogo' => 'Company Logo:',
                                        'busineestype' => 'Business Type:',
                                        'categories' => 'Categories:',
                                        'mainforcus' => 'Main Product Focus:',
                                        'companyyoutube' => 'Youtube Url:',
                                        'companydescription' => 'Company Description:',
                                        'companyyear' => 'Year Established:',
                                        'ceoownername' => 'CEO Owners Name:',
                                        'factorysize' => 'Factory Size:',
                                        'factorylocation' => 'Factory Location:',
                                        'qa_qc' => 'QA/QC:',
                                        'employees' => 'Number of Employees:',
                                        'marketingpicture' => 'Marketing Picture:',
                                        'marketingvideo' => 'Marketing Movie:',

                                        ]
                                         as $key=> $value)
                                        @if($key === 'busineestype')
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-7 col-sm-7 col-xs-12">
                                                     <div class="input-icon right">
                                                         <i class="fa"></i>
                                                        {{ Form::select($key
                                                            ,array('' => '---Select Business Type --- ') +  $business->lists('businesstype', 'id')
                                                            , $companyprofile[0]->busineestype
                                                            , array('class' => 'form-control','name'=>'business_id')) }}
                                                     </div>
                                                </div>
                                           </div>
                                        @elseif($key === 'mainforcus')
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-7 col-sm-7 col-xs-12">
                                                     <div class="input-icon right">
                                                       <i class="fa"></i>
                                                    {{ Form::select($key
                                                        ,array('' => '---Select Main Product Focus --- ') +  $productfocus->lists('productfocus', 'id')
                                                        ,$companyprofile[0]->mainforcus
                                                        , array('class' => 'form-control','name'=>'productfocus_id')) }}
                                                     </div>
                                                 </div>
                                            </div>
                                        @elseif(($key === 'companyyear'))
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-7 col-sm-7 col-xs-12">
                                                     <div class="input-icon right">
                                                          <i class="fa"></i>
                                                             <?php $currentYear = date("Y");?>
                                                             <select name="companyyear" class="form-control">
                                                                <?php
                                                                    for($i=$currentYear; $i>=1900; $i--) {
                                                                ?>
                                                                    <option value="<?php echo $i;?>" <?php if($companyprofile[0]->companyyear == $i) {echo "selected";}?>><?php echo $i;?></option>
                                                                <?php } ?>
                                                             </select>
                                                     </div>
                                                 </div>
                                            </div>
                                        @elseif(($key === 'factorysize'))
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                 <div class="col-md-7 col-sm-7 col-xs-12">
                                                     <div class="input-icon right">
                                                     <i class="fa"></i>
                                                     {{ Form::select($key
                                                        ,array('' => '---Select Factory Size --- ') +  $factorysize->lists('factorysize', 'id')
                                                        , $companyprofile[0]->factorysize
                                                        , array('class' => 'form-control','name'=>'factorysize_id')) }}
                                                      </div>
                                                 </div>
                                            </div>
                                        @elseif($key === 'categories')
                                             <div class="form-group" id="countryname">
                                                 <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-7 col-sm-7 col-xs-12">
                                                     <select id="select2_sample2" class="form-control select2" multiple name="categories[]">
                                                         @foreach($category as $categories)
                                                           <optgroup label=" {{ $categories->categoryname }}">
                                                                <?php $subcategory = $categories->subCategories;?>
                                                                @foreach($subcategory as $subcategories)
                                                                    <option value="{{ $subcategories->id }}"
                                                                        <?php
                                                                             for( $jk=0; $jk<count($list); $jk++){
                                                                             if($list[$jk] == $subcategories->id ){
                                                                                    echo "selected";
                                                                                 }
                                                                             }
                                                                        ?> >
                                                                        {{ $subcategories->subcategoryname }}
                                                                    </option>
                                                                @endforeach
                                                           </optgroup>
                                                         @endforeach
                                                    </select>
                                                 </div>
                                             </div>
                                        @elseif($key === 'companylogo')
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} </label>
                                                 <div class="col-md-5 col-sm-5 col-xs-12">
                                                    {{ Form::file($key, ['class' => 'form-control', 'id' => 'companylogofile']) }}
                                                 </div>
                                                 <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <button class="btn red" type="button" onclick="onRemoveCompanyLogo()">Remove</button>
                                                 </div>
                                             </div>
                                             <div class="form-group">
                                                <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-3 col-sm-offset-3 ">
                                                    <img src="<?php echo HTTP_LOGO_PATH.$companyprofile[0]->companylogo;?>">
                                                </div>
                                             </div>
                                        @elseif($key === 'marketingpicture')
                                            <div class="form-group" id="countryname">
                                                  <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                   <div class="col-md-5 col-sm-5 col-xs-12">
                                                      {{ Form::file($key, ['class' => 'form-control', 'id'=>'marketingpicturelogo']) }}
                                                   </div>
                                                   <div class="col-md-2 col-sm-2 col-xs-12">
                                                       <button class="btn red" type="button" onclick="onRemoveMarketingLogo()">Remove</button>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-3 col-sm-offset-3">
                                                    <img src="<?php echo HTTP_LOGO_PATH.$companyprofile[0]->marketingpicture ;?>">
                                                </div>
                                             </div>
                                        @elseif($key ==='companydescription')
                                            <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <textarea class="" id="companydescriptionID" name="companydescription" cols="50" rows="10">{{$companyprofile[0]->companydescription }}</textarea>
                                                    <input type="hidden" id="subContent" name="subContent" value="{{$companyprofile[0]->companydescription }}">
                                                </div>
                                            </div>
                                        @elseif($key ==='employees')
                                            <div class="form-group" id="countryname">
                                                 <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                 <div class="col-md-7 col-sm-7 col-xs-12">
                                                     {{ Form::select($key
                                                            ,array('' => '---Select Employees --- ') +  $employees->lists('employees', 'id')
                                                            ,$companyprofile[0]->employees
                                                            , array('class' => 'form-control','name'=>'employees')) }}
                                                 </div>
                                            </div>
                                        @elseif($key ==='qa_qc')
                                            <div class="form-group" id="countryname">
                                                 <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }}</label>
                                                 <div class="col-md-7 col-sm-7 col-xs-12">
                                                     {{ Form::select($key, array('' => '-- Select QA/QC --','In House' => 'In House', 'Third Parties' =>'Third Parties', 'No' =>'No'), $companyprofile[0]->qa_qc, ['class' => 'form-control']) }}
                                                 </div>
                                            </div>

                                        @elseif($key ==='companycountry')
                                             <div class="form-group" id="countryname">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">{{ Form::label($key, $value) }} <span style="color:red">*</span></label>
                                                 <div class="col-md-7 col-sm-7 col-xs-12">
                                                     <div class="input-icon right">
                                                           <i class="fa"></i>
                                                      {{ Form::select($key
                                                            ,array('' => ' --- Select Country --- ') +  $country->lists('country_name', 'id')
                                                            , $companyprofile[0]->companycountry
                                                            , array('class' => 'form-control','name'=>'country_id')) }}
                                                     </div>
                                                </div>
                                           </div>
                                        @else
                                          <div class="form-group" id="countryname">
                                             <label class="col-md-3 col-sm-3 col-xs-12 control-label">
                                                {{ Form::label($key, $value) }}
                                                <?php
                                                    if($key === "companyname" || $key === "companyaddress" || $key === "companycity" ){
                                                        echo  '<span style="color:red">*</span>';
                                                    }
                                                ?>
                                             </label>
                                              <div class="col-md-7 col-sm-7 col-xs-12">
                                                 <div class="input-icon right">
                                                      <i class="fa"></i>
                                                      <?php if($key == "companycountry"){?>
                                                            {{ Form::text($key, $companyprofile[0]->companycountry, ['class' => 'form-control','placeholder'=>$value]) }}
                                                      <?php }else{?>
                                                        {{ Form::text($key, $companyprofile[0]->$key, ['class' => 'form-control','placeholder'=>$value]) }}
                                                      <?php }?>
                                                  </div>
                                              </div>
                                         </div>

                                        @endif
                                      @endforeach
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-7 col-md-5">
                                            <button   class="btn  blue" type="button" onclick="onSubmitFunction()"><i class="fa fa-check-circle-o" style="margin-right:4px"></i><span id="savelist">Save</span></button>
                                            <a class="btn  green" href="{{URL::route('admin.members')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
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
	    {{ HTML::script('/assets/assest_admin/js/select2.min.js') }}
	    {{ HTML::script('/assets/assest_admin/js/jquery.multi-select.js') }}
	    {{ HTML::script('/assets/assest_admin/js/bootstrap-select.min.js') }}
	    {{ HTML::script('/assets/assest_admin/js/components-dropdowns.js') }}
        <script type="text/javascript">
             jQuery(document).ready(function() {
                ComponentsDropdowns.init();
                tinymce.init({
                      selector: "textarea#companydescriptionID",
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
                        templates: [
                            {title: 'Test template 1', content: 'Test 1'},
                            {title: 'Test template 2', content: 'Test 2'}
                        ]
                    });

             });
            function onRemoveCompanyLogo(){
                $("#companylogofile").val('');
            }
            function onRemoveMarketingLogo(){
                $("#marketingpicturelogo").val('');
            }
            function onSubmitFunction(){
                var subContent =tinymce.get('companydescriptionID').getContent();
                $('#subContent').val(subContent);
                $("#addCategoryFiledForm").submit();
            }

        </script>
	@stop
@stop
