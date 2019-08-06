@extends('user.layout')
    @section('custom-styles')
         {{HTML::style('/assets/asset_view/plugins/animate.css')}}
         {{HTML::style('/assets/asset_view/css/blocks.css')}}
         {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
         {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
         {{HTML::style('/assets/asset_view/css/forestChange.css')}}
         {{ HTML::style('/assets/assest_admin/js/typeahead/typeahead.css') }}
    @stop
    @section('body')
        <div class="breadcrumbs">
            <div class="container">
                <h1 class="pull-left">{{Lang::get('missing.Help_Center')}}</h1>
                <ul class="pull-right breadcrumb">
                    <li><a href="{{URL::route('user.home')}}">{{Lang::get('user.layout_home')}}</a></li>
                    <li><a href="">{{Lang::get('missing.Help_Center')}}</a></li>
                </ul>
            </div>
        </div>
         <!--=== Content Part ===-->
        <div class="container content">
            <div class="row">
                <!-- Begin Sidebar Menu -->
                <div class="col-md-3 col-sm-3">
                    <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                        <?php $i=0;?>
                        @foreach($helpCategory as $helpCategories)
                           <li class="list-group-item list-toggle">
                                <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse<?php echo $i;?>">{{$helpCategories->categoryname}}</a>
                                <ul id="collapse<?php echo $i;?>" class="collapse">
                                    <?php $helpSubCategory = $helpCategories->subCategories;?>
                                    @foreach($helpSubCategory as $helpSubCategories)
                                        <li class="<?php if($id == $helpSubCategories->id) {echo 'active';}?>">
                                            <a href="{{URL::route('user.help.faq_list',(100000*1+$helpSubCategories->id))}}">{{$helpSubCategories->subcategoryname}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                           </li>
                           <?php $i++; ?>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9 col-sm-9">
                    <div class="row margin-bottom-40">
                        <form action="{{URL::route('user.help.search')}}">
                            <div class="col-md-9 col-sm-9 col-xs-9" id="bloodhound">
                                <input type="text" class="form-control helpSearch" placeholder='{{Lang::get('user.help_placeholder')}}' id="helpSearchText" name="searchTitle">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 helpSearchButtonDiv">
                                <button class="btn-u btn-u-blue helpSearchButton"><i class="search fa fa-search search-button"></i> {{Lang::get('user.search_help')}}</button>
                            </div>
                        </form>
                    </div>
                    @yield('body-content')

                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        {{ HTML::script('/assets/assest_admin/js/typeahead/typeahead.bundle.js') }}
        <script type="text/javascript">
            $( document ).ready(function() {
            var source = new Array();
            $.ajax ({
                url: '{{ route("user.help.getTitle") }}',
                type: 'POST',
                data: {},
                cache: false,
                dataType : "json",
                success: function (data) {
                   if(data.result =="success"){
                       if(data.source.length>0){
                            for(var i=0; i<data.source.length; i++){
                                source[i] = data.source[i];
                            }
                       }
                    }
                }
          });
          var substringMatcher = function(strs) {
              return function findMatches(q, cb) {
                  var matches, substrRegex;
                  matches = [];
                  substrRegex = new RegExp(q, 'i');
                  $.each(strs, function(i, str) {
                      if (substrRegex.test(str)) {
                          matches.push({ value: str });
                      }
                  });
                  cb(matches);
              };
          };
         $('#helpSearchText').typeahead({
             hint: true,
             highlight: true,
             minLength: 3
         }, {
             name: 'cities',
             displayKey: 'value',
             source: substringMatcher(source)
         });


        });
        </script>
    @stop
@stop