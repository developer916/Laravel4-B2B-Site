@extends('user.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/blocks.css')}}
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/css/sky-forms.css')}}
        {{HTML::style('/assets/asset_view/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css')}}
        {{HTML::style('/assets/asset_view/css/pages/page_contact.css')}}
        {{HTML::style('/assets/asset_view/css/style.css')}}
    @stop
    @section('body')
         <div class="breadcrumbs">
            <div class="container">
                <h1 class="pull-left">{{Lang::get('missing.contact_us')}}</h1>
                <ul class="pull-right breadcrumb">
                    <li><a href="{{URL::route('user.home')}}">{{Lang::get('user.layout_home')}}</a></li>
                    <li class="active">{{Lang::get('missing.contact_us')}}</li>
                </ul>
            </div>
        </div>
        <div class="container content">
            <div class="row margin-bottom-30">
                {{--<div class="col-md-9 col-sm-9 mb-margin-bottom-30">--}}
                     {{--<div id="map" class="map map-box map-box-space margin-bottom-40"></div>--}}
                     <div class="col-m-12 col-sm-12 mb-margin-bottom-30">
                     <form action="{{URL::route('user.contact.contactSend')}}" method="post" id="sky-form3" class="sky-form contact-style">
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
                         <fieldset class="no-padding">
                             <label>{{Lang::get('user.name')}} <span class="color-red">*</span></label>
                             <div class="row sky-space-20">
                                 <div class="col-md-7 col-md-offset-0">
                                     <div>
                                         <input type="text" name="name" id="name" class="form-control">
                                     </div>
                                 </div>
                             </div>

                             <label>{{Lang::get('user.email')}} <span class="color-red">*</span></label>
                             <div class="row sky-space-20">
                                 <div class="col-md-7 col-md-offset-0">
                                     <div>
                                         <input type="text" name="email" id="email" class="form-control">
                                     </div>
                                 </div>
                             </div>

                             <label>{{Lang::get('user.message')}} <span class="color-red">*</span></label>
                             <div class="row sky-space-20">
                                 <div class="col-md-11 col-md-offset-0">
                                     <div>
                                         <textarea rows="8" name="message" id="message" class="form-control"></textarea>
                                     </div>
                                 </div>
                             </div>

                             <p><button type="submit" class="btn-u">{{Lang::get('user.send_message')}}</button></p>
                         </fieldset>

                         <div class="message">
                             <i class="rounded-x fa fa-check"></i>
                             <p>{{Lang::get('missing.your_message_was_successfully_sent')}}</p>
                         </div>
                     </form>
                </div>
                {{--<div class="col-md-3 col-sm-3">--}}
                    {{--<div class="headline"><h2>Contacts</h2></div>--}}
                    {{--<ul class="list-unstyled who margin-bottom-30">--}}
                        {{--<li><i class="fa fa-home"></i> 5B Streat, City 50987 New Town US</li>--}}
                        {{--<li><i class="fa fa-envelope"></i> info@example.com</li>--}}
                        {{--<li><i class="fa fa-phone"></i> 1(222) 5x86 x97x</li>--}}
                        {{--<li><i class="fa fa-globe"></i> http://www.purchasetree.com</li>--}}
                    {{--</ul>--}}

                    {{--<!-- Business Hours -->--}}
                    {{--<div class="headline"><h2>Business Hours</h2></div>--}}
                    {{--<ul class="list-unstyled margin-bottom-30">--}}
                        {{--<li><strong>Monday-Friday:</strong> 10am to 8pm</li>--}}
                        {{--<li><strong>Saturday:</strong> 11am to 3pm</li>--}}
                        {{--<li><strong>Sunday:</strong> Closed</li>--}}
                    {{--</ul>--}}

                {{--</div>--}}
            {{--</div>--}}
         </div>
    @stop
    @section('custom-scripts')
    {{ HTML::script('//maps.google.com/maps/api/js?sensor=true') }}
    {{ HTML::script('/assets/asset_view/plugins/gmap/gmap.js') }}
    {{ HTML::script('/assets/asset_view/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js') }}
    {{ HTML::script('/assets/asset_view/js/forms/contact.js') }}
    {{ HTML::script('/assets/asset_view/js/pages/page_contacts.js') }}
        <script type="text/javascript">
            jQuery(document).ready(function() {
                ContactPage.initMap();
                ContactForm.initContactForm();
                });
        </script>

    @stop
@stop