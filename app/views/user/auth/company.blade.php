@extends('user.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/pages/page_log_reg_v1.css')}}
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
        {{ HTML::style('/assets/assest_admin/css/bootstrap-select.min.css') }}
        {{ HTML::style('/assets/assest_admin/css/select2.css') }}
        {{ HTML::style('/assets/assest_admin/css/multi-select.css') }}
    @stop
	@section('body')
	      <div class="breadcrumbs-v4">
                <div class="container">
                    <h1>{{Lang::get('user.get_started_with')}}  <span class="shop-green">{{Lang::get('user.purchasetree')}}</span></h1>
                    <ul class="breadcrumb-v4-in">
                        <li><a href="index.html">{{Lang::get('user.home')}}</a></li>
                        <li class="active">{{Lang::get('user.company_profile')}}</li>
                    </ul>
                </div><!--/end container-->
          </div>
           <div class = "registerBackground" >
                <div class="container content" >
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                            <form class="reg-page sky-form" method="post" action="{{URL::route('user.auth.companystore')}}" id="sky-form" style="margin-bottom:15px" enctype="multipart/form-data">
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
                                 <div class="reg-header">
                                     <h2 class="createRegisterHead">{{Lang::get('user.create_company_profile')}}</h2>
                                 </div>
                                 <input type="hidden" value="{{$user_id}}" name="user_id">
                                 <fieldset>
                                     <div class="row">
                                        <section>
                                             <label>{{Lang::get('user.company_name')}} <span class="color-red">*</span></label>
                                             <input type="text" class="form-control margin-bottom-20" name="company_name" id="username" placeholder="{{Lang::get('user.company_name')}}" >
                                        </section>
                                        <section>
                                             <label>{{Lang::get('user.company_address')}} <span class="color-red">*</span></label>
                                             <input type="text" class="form-control margin-bottom-20" name="company_address" placeholder="{{Lang::get('user.company_address')}}" >
                                        </section>
                                        <section>
                                             <label>{{Lang::get('user.company_city')}} <span class="color-red">*</span></label>
                                             <input type="text" class="form-control margin-bottom-20" name="company_city" placeholder="{{Lang::get('user.company_city')}}" >
                                        </section>
                                         <section>
                                             <label>{{Lang::get('user.company_state')}} </label>
                                             <input type="text" class="form-control margin-bottom-20" name="company_state" placeholder="{{Lang::get('user.company_state')}}" >
                                        </section>
                                         <section>
                                             <label>{{Lang::get('user.company_country')}} <span class="color-red">*</span> </label>
                                             <select name="company_country" class="form-control margin-bottom-20">
                                                <option value="">-- Select Country--</option>
                                                @foreach($country as $countries)
                                                     @if($countries->country_name == "USA")
                                                         <option value="{{$countries->id}}" selected>{{$countries->country_name}}</option>
                                                     @else
                                                         <option value="{{$countries->id}}">{{$countries->country_name}}</option>
                                                     @endif
                                                @endforeach
                                             </select>
                                        </section>
                                         <section>
                                             <label>{{Lang::get('user.phone_number')}} </label>
                                             <input type="text" class="form-control margin-bottom-20" name="phone_number" placeholder="{{Lang::get('user.phone_number')}}" >
                                        </section>
                                        <section>
                                             <label>{{Lang::get('user.fax_address')}} </label>
                                             <input type="text" class="form-control margin-bottom-20" name="fax_address" placeholder="{{Lang::get('user.fax_address')}}" >
                                         </section>
                                     </div>
                                     <div class="row">
                                               <div class="col-md-8 col-sm-8" style="padding-left: 0px">
                                                    <label>{{Lang::get('user.company_logo')}}   </label>
                                                    <input type="file" class="form-control" id="companylogofile" name="companylogo" >
                                                    {{--<input type="file" class="form-control margin-bottom-20" name="company_logo" id="company_logo">--}}
                                                </div>
                                            <div class="col-md-4 col-sm-4" style="margin-top: 25px">
                                                <section >
                                                    <label>&nbsp;</label>
                                                    <button class="btn btn-danger" type="button" onclick="onRemoveCompanyLogo()">Remove</button>
                                                </section>
                                            </div>
                                     </div>
                                     <div class="row">
                                        <section>
                                            <lable class="select">
                                                {{Lang::get('user.business_type')}} <span class="color-red">*</span>
                                            </lable>
                                             <select name="business_type" class="form-control margin-bottom-20">
                                                <option value ="" > -- Select Business Type -- </option>
                                                    @foreach($business as $businesses)
                                                        <option value="{{$businesses->id}}">{{$businesses->businesstype}}</option>
                                                    @endforeach
                                             </select>
                                        </section>
                                        <div class="row ">
                                           <div class="col-md-12 margin-bottom-20">
                                                <label class="select">
                                                    {{Lang::get('user.categories')}} <span class="color-red">*</span>
                                                </label>
                                                <select id="select2_sample23" class="form-control select2 " multiple name="categories[]" style="padding: 0px;   height: auto !important;">
                                                     @foreach($category as $categories)
                                                       <optgroup label=" {{ $categories->categoryname }}">
                                                            <?php $subcategory = $categories->subCategories;?>
                                                            @foreach($subcategory as $subcategories)
                                                                <option value="{{ $subcategories->id }}">{{ $subcategories->subcategoryname }}</option>
                                                            @endforeach
                                                       </optgroup>
                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <section>
                                            <label>
                                                {{Lang::get('user.main_focus_product')}} <span class="color-red">*</span>
                                            </label>
                                             <select name="main_focus" class="form-control">
                                                 <option value=""> ---Select Main Product Focus --- </option>
                                                 @foreach($productfocus as $productfocuses)
                                                    <option value="{{$productfocuses->id}}">{{$productfocuses->productfocus}}</option>
                                                 @endforeach
                                             </select>
                                        </section>
                                        <section>
                                            <label>
                                                {{Lang::get('user.youtube_url')}}
                                            </label>
                                            <input type="text" class="form-control margin-bottom-20" name="youtube_url" placeholder="{{Lang::get('user.youtube_url')}}">
                                        </section>
                                        <section>
                                            <label>
                                                {{Lang::get('user.company_description')}}
                                            </label>
                                            <textarea class="" id="companydescriptionID" name="companydescription" cols="50" rows="10"></textarea>
                                            <input type="hidden" id="subContent" name="subContent" value="">
                                        </section>
                                        <section>
                                            <label>
                                                {{Lang::get('user.year_established')}} <span class="color-red">*</span>
                                            </label>
                                            <?php $currentYear = date("Y");?>
                                             <select name="companyyear" class="form-control">
                                                <?php for($i=$currentYear; $i>=1900; $i--) {?>
                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                <?php } ?>
                                             </select>
                                        </section>
                                        <section>
                                            <label>
                                                {{Lang::get('user.ceo_owner_name')}} <span class="color-red">*</span>
                                            </label>
                                            <input type="text" class="form-control margin-bottom-20" name="ceo_owner_name" placeholder="{{Lang::get('user.ceo_owner_name')}}" >
                                        </section>
                                        <section>
                                            <label class="select">
                                                {{Lang::get('user.factory_size')}}
                                            </label>
                                            <select class="form-control margin-bottom-20" name="factory_size">
                                                <option value=""> ---Select Factory Size --- </option>
                                                @foreach($factorysize as $factorysizes)
                                                    <option value="{{$factorysizes->id}}">{{$factorysizes->factorysize}}</option>
                                                @endforeach
                                            </select>
                                        </section>
                                        <section>
                                            <label >
                                                {{Lang::get('user.factory_location')}}
                                            </label>
                                            <input type="text" class="form-control margin-bottom-20" name="factory_location" placeholder="{{Lang::get('user.factory_location')}}" >
                                        </section>
                                        <section>
                                            <label >
                                                {{Lang::get('user.qa_qc')}}
                                            </label>
                                            <select class="form-control" name="qa_qc">
                                                <option value=""> -- Select QA/QC -- </option>
                                                <option value="In House">In House</option>
                                                <option value="Third Parties">Third Parties</option>
                                                <option value="No">No</option></select>
                                            </select>
                                        </section>
                                        <section>
                                            <label >
                                                {{Lang::get('user.number_of_employees')}}
                                            </label>
                                            <select name="number_of_employees" class="form-control">
                                                <option value="" selected="selected">---Select Employees --- </option>
                                                @foreach($employees as $employeeses)
                                                    <option value="{{$employeeses->id}}">{{$employeeses->employees}}</option>
                                                @endforeach
                                            </select>
                                        </section>
                                     </div>
                                     <div class="row">
                                        <div class="col-md-12" style="padding-left: 0px">
                                            <label for="file">{{Lang::get('user.company_product_pictures')}}</label>
                                        </div>
                                         <section class="col col-8" style="padding-left: 0px">
                                            <input type="file" multiple class="form-control margin-bottom-20" name="companyproducts[]" id="company_products"  >
                                        </section>
                                        <div class="col-md-4 col-sm-4">
                                            <section >
                                                <label>&nbsp;</label>
                                                <button class="btn btn-danger" type="button" onclick="onRemoveCompanyProducts()">Remove</button>
                                            </section>
                                        </div>
                                     </div>
                                     <div class="row">
                                        <div class="col-md-12" style="padding-left: 0px">
                                            <label for="file">{{Lang::get('user.marketing_picture')}}</label>
                                        </div>
                                         <section class="col col-8" style="padding-left: 0px">
                                                {{--<label for="file">{{Lang::get('user.marketing_picture')}} </label>--}}
                                                <input type="file" class="form-control margin-bottom-20" name="marketing_picture" id="marketing_picture" placeholder="{{Lang::get('user.marketing_picture')}}" id="marketing_picture">
                                            </section>
                                        <div class="col-md-4 col-sm-4">
                                            <section >
                                                <label>&nbsp;</label>
                                                <button class="btn btn-danger" type="button" onclick="onRemoveMarketingLogo()">Remove</button>
                                            </section>
                                        </div>
                                     </div>
                                     <div class="row">
                                         <section class="col col-8" style="padding-left: 0">
                                            <label >
                                                {{Lang::get('user.marketing_movie')}}
                                            </label>
                                            <input type="file" name="marketing_movie" id="marketing_movie" class="form-control" placeholder="{{Lang::get('user.marketing_movie')}}">
                                         </section>
                                         <div class="col-md-4 col-sm-4" style="margin-top: 25px">
                                            <section >
                                                <label>&nbsp;</label>
                                                <button class="btn btn-danger" type="button" onclick="onRemoveMarketingVideo()">Remove</button>
                                            </section>
                                         </div>
                                     </div>
                                 </fieldset>
                                 <hr>
                                 <fieldset>
                                     <div class="row">
                                            <div class="col-md-12" style="float: right">
                                                 {{ Form::captcha() }}
                                            </div>
                                        </div>
                                 </fieldset>
                                     <div class="row" style="margin-top: 20px">
                                        <div class="col col-8"></div>
                                         <div class="col col-4 text-right">
                                             <button class="btn-u" type="button" onclick="onSubmitFunction()" ><span id="savelist">Save</span></button>
                                             <a class="btn-u btn-u-red" href="">Cancel</a>
                                         </div>
                                     </div>
                            </form>
                        </div>
                    </div>
                </div>
           </div>
    @stop
    @section('custom-scripts')

          {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js') }}
          {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') }}
          {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') }}
          {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.maskedinput.min.js') }}
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
                  function onRemoveCompanyLogo(){
                      $("#company_logo").val('');
                  }
                  function onRemoveMarketingLogo(){
                      $("#marketing_picture").val('');
                  }
                  function onRemoveMarketingVideo(){
                    $("#marketing_movie").val('');
                  }
                  function onSubmitFunction(){
                      var subContent =tinymce.get('companydescriptionID').getContent();
                      $('#subContent').val(subContent);
                      $("#sky-form").submit();
                  }
          </script>
    @stop
@stop