@extends('user.member.layout')
    @section('custom-member-styles')
        {{ HTML::style('/assets/assest_admin/css/bootstrap-select.min.css') }}
        {{ HTML::style('/assets/assest_admin/css/select2.css') }}
        {{ HTML::style('/assets/assest_admin/css/multi-select.css') }}
    @stop
    @section('list')
       <li><a href="{{URL::route('user.member.company')}}">{{Lang::get('user.company_profile')}}</a></li>
    @stop
    @section('body-content')
         <div class="tab-content">
             <div class="tab-pane fade active in margin-bottom-40" id="home-2">
                <h4>{{Lang::get('user.company_profile')}} </h4>
                <div class="row" style="margin-top: 20px">
                    <form class="col-md-12 form-horizontal" action="{{URL::route('user.member.companyStore')}}" method="post" id="addCategoryFiledForm">
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
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.company_name')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$companyProfile[0]->companyname}}" name="companyname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.company_address')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$companyProfile[0]->companyaddress}}" name="companyaddress">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.company_city')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$companyProfile[0]->companycity}}" name="companycity">
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.company_state')}}
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type='text' class="form-control" placeholder=""  value="{{$companyProfile[0]->companystate}}" name="companystate">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.company_country')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                               <select class="form-control" name="country">
                                   <option value=""> {{Lang::get('user.select_country')}} </option>
                                     @foreach($country as $countries)
                                           @if($countries->country_name == "USA")
                                               <option value="{{$countries->id}}" selected>{{$countries->country_name}}</option>
                                           @else
                                               <option value="{{$countries->id}}">{{$countries->country_name}}</option>
                                           @endif
                                     @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.phone_number')}}
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" class="form-control" value="{{$companyProfile[0]->companyphonenumber}}" name="phonenumber">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.fax_address')}}
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" class="form-control" value="{{$companyProfile[0]->companyfax}}" name="faxaddress">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.company_logo')}}
                            </label>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <input type="file" class="form-control" name="companylogo" id="companylogo">
                                 <?php
                                    IF($companyProfile[0]->companylogo != ""){ ?>
                                        <img src="{{HTTP_LOGO_PATH.$companyProfile[0]->companylogo}}" style="width:70px; margin-top: 10px">
                                    <?php }
                                 ?>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                 <button class="btn btn-danger" type="button" onclick="onRemoveCompanyLogo()">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.business_type')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <select name="business_type" class="form-control">
                                    <option value="">{{Lang::get('user.select_businesstype')}}</option>
                                    @foreach($business as $businesses)
                                        <option value="{{$businesses->id}}" <?php if($businesses->id == $companyProfile[0]->busineestype) {echo "selected";}?>>{{$businesses->businesstype}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.categories')}}
                                <span style="color:red">*</span>
                            </label>
                             <div class="col-lg-7 col-md-7 col-sm-7">
                                <select id="select2_sample23" class="form-control select2 " multiple name="categories[]" style="padding: 0px;   height: auto !important;">
                                     @foreach($category as $categories)
                                       <optgroup label=" {{ $categories->categoryname }}">
                                            <?php $subcategory = $categories->subCategories;?>
                                            @foreach($subcategory as $subcategories)
                                                <option value="{{ $subcategories->id }}" <?php
                                                   for( $jk=0; $jk<count($subCategoryList); $jk++){
                                                   if($subCategoryList[$jk]->subcategory_id == $subcategories->id ){
                                                          echo "selected";
                                                       }
                                                   }
                                              ?>  >{{ ucfirst($subcategories->subcategoryname) }}</option>
                                            @endforeach
                                       </optgroup>
                                     @endforeach
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.main_focus_product')}}
                                <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <select name="mainFocus" class="form-control">
                                    <option value="">{{Lang::get('user.select_mainfocus')}}</option>
                                    @foreach($productfocus as $productfocuses)
                                        <option value="{{$productfocuses->id}}" <?php if($productfocuses->id == $companyProfile[0]->mainforcus) {echo "selected";}?>>{{$productfocuses->productfocus}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.youtube_url')}}
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" class="form-control" value="{{$companyProfile[0]->companyyoutube}}" name="youtube">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.company_description')}}
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <textarea class="" id="companydescriptionID" name="companydescription" cols="50" rows="10">{{$companyProfile[0]->companydescription }}</textarea>
                                <input type="hidden" id="subContent" name="subContent" value="{{$companyProfile[0]->companydescription }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.year_established')}}
                                 <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <?php $currentYear = date("Y");?>
                                 <select name="companyyear" class="form-control">
                                    <?php
                                        for($i=$currentYear; $i>=1900; $i--) {
                                    ?>
                                        <option value="<?php echo $i;?>" <?php if($companyProfile[0]->companyyear == $i) {echo "selected";}?>><?php echo $i;?></option>
                                    <?php } ?>
                                 </select>
                            </div>
                        </div>
                        <div class="form-group">
                             <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.ceo_owner_name')}}
                                 <span style="color:red">*</span>
                             </label>
                             <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" class="form-control" name="ceo" value="{{$companyProfile[0]->ceoownername}}">
                             </div>
                        </div>
                        <div class="form-group">
                             <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.factory_size')}}
                             </label>
                             <div class="col-lg-7 col-md-7 col-sm-7">
                                <select name="factorysize" class="form-control">
                                     <option value="">{{Lang::get('user.select_factory_size')}}</option>
                                    @foreach($factorysize as $factorysizes)
                                        <option value="{{$factorysizes->id}}" <?php if($factorysizes->id == $companyProfile[0]->factorysize){echo "selected";}?>>{{$factorysizes->factorysize}}</option>
                                    @endforeach
                                </select>
                             </div>
                        </div>
                        <div class="form-group">
                             <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.factory_location')}}
                             </label>
                             <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" value="{{$companyProfile[0]->factorylocation}}" class="form-control" name="factorylocation">
                             </div>
                        </div>
                        <div class="form-group margin-bpttom-20">
                             <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.qa_qc')}}
                             </label>
                             <div class="col-lg-7 col-md-7 col-sm-7" >
                               <select class="form-control" name="qa_qc">
                                    <option value="In House" <?php if($companyProfile[0]->qa_qc == "In House") {echo "selected";}?>>In House</option>
                                    <option value="Third Parties" <?php if($companyProfile[0]->qa_qc == "Third Parties") {echo "selected";}?>>Third Parties</option>
                                    <option value="No" <?php if($companyProfile[0]->qa_qc == "No") {echo "selected";}?>>No</option></select>
                               </select>
                             </div>
                        </div>
                        <div class="form-group margin-bpttom-20">
                             <label for="" class="col-lg-3 col-md-4 col-sm-4 control-label">
                                {{Lang::get('user.number_of_employees')}}
                             </label>
                             <div class="col-lg-7 col-md-7 col-sm-7" >
                                <select name="employees" class="form-control">
                                    <option value="">{{Lang::get('user.select_employee')}}</option>
                                    @foreach($employees as $employeeses)
                                        <option value="{{$employeeses->id}}" <?php if($employeeses->id == $companyProfile[0]->employees) {echo "selected";}?>> {{$employeeses->employees}}</option>
                                    @endforeach
                                </select>
                             </div>
                         </div>
                        <div class="form-group">
                             <div class="col-lg-7 col-md-7 col-sm-7 col-md-offset-4 col-sm-offset-4 col-lg-offset-3">
                                <input type="button" class="btn-u btn-u-blue" value="{{Lang::get('user.change')}}" onclick="onChangeSubmit()">
                             </div>
                        </div>
                    </form>
                </div>
             </div>
         </div>
    @stop
    @section('custom-scripts')
          {{ HTML::script('/assets/assest_admin/js/select2.min.js') }}
          {{ HTML::script('/assets/assest_admin/js/jquery.multi-select.js') }}
          {{ HTML::script('/assets/assest_admin/js/bootstrap-select.min.js') }}
          {{ HTML::script('/assets/assest_admin/js/components-dropdowns.js') }}
          {{ HTML::script('/assets/assest_admin/js/tinymce/js/tinymce/tinymce.min.js') }}
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
             function onChangeSubmit(){
                var subContent =tinymce.get('companydescriptionID').getContent();
                 $('#subContent').val(subContent);
                 $("#addCategoryFiledForm").submit();
             }
             function onRemoveCompanyLogo(){
                $("#companylogo").val('');
             }
          </script>
    @stop
@stop