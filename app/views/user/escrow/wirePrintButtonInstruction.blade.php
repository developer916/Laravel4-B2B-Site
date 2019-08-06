  @extends('main')
    @section('styles')
            {{HTML::style('//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin')}}
            {{HTML::style('/assets/asset_view/shop-ui/plugins/bootstrap/css/bootstrap.min.css')}}
            <style>
                .form-horizontal .control-label {
                    padding-top: 7px;
                    margin-bottom: 0;
                    text-align: right;
                }
                .col-lg-3 {
                    width: 25%;
                }
                .col-lg-9 {
                    width: 75%;
                }
                .col-md-3 {
                    width: 25%;
                }
                .col-md-9 {
                    width: 75%;
                }
                .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                    float: left;
                }
                .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
                    float: left;
                }
                .form-horizontal .form-group {
                    margin-right: -15px;
                    margin-left: -15px;
                }
                .form-control {
                    display: block;
                    width: 100%;
                    height: 34px;
                    padding: 6px 12px;
                    font-size: 14px;
                    line-height: 1.42857143;
                    color: #555;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                }
                .escrow_wire_transfer_company_list {
                    display: inline-block;
                    border: 0px!important;
                    box-shadow: none;
                }
            </style>

    	@stop
      @section('content')
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
                <div class="form-horizontal">
                    <h4 class="text-center"> {{Lang::get('user.instruction_for_payment')}}</h4>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                {{Lang::get('user.full_payment_is_required')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                {{Lang::get('user.include_your_invoice_number')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                {{Lang::get('user.send_us_your_wire')}}<br>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                    {{Escrow_Email}} <br>
                                    {{Escrow_Fax}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group margin-bottom-20">
                            <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">
                                {{Lang::get('user.allow_hours_for_your_escrow')}}
                            </div>
                        </div>

                </div>
            </div>
        </div>
      @stop
      @section ('scripts')
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/jquery/jquery.min.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/jquery/jquery-migrate.min.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/bootstrap/js/bootstrap.min.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/back-to-top.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/smoothScroll.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/jquery.parallax.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/js/custom.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/js/shop.app.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/js/plugins/owl-carousel.js') }}
              {{ HTML::script('/assets/asset_view/shop-ui/js/plugins/revolution-slider.js') }}
              {{ HTML::script('/assets/assest_admin/js/bootbox.js') }}
              <script>
                  jQuery(document).ready(function() {
                      App.init();
                      App.initScrollBar();
                      App.initParallaxBg();
                      OwlCarousel.initOwlCarousel();
                      RevolutionSlider.initRSfullWidth();
                      window.print();
              });
              function OnBecomeSeller(){
                   var a = $("<a>")
                          .attr("href", "#myModalSellerBecome")
                          .attr("data-toggle","modal")
                          .appendTo("body");

                          a[0].click();

                          a.remove();
                  }
               function OnSendBecomeSeller(){
                  var user_type = ($('input[name=radio]:checked').val());
                     $.ajax ({
                         url: ' {{ route("user.member.confirm")}}',
                          type: 'POST',
                          data: {user_type : user_type},
                          cache: false,
                          dataType : "json",
                          success: function (data) {
                              $("#myModalSellerBecome").hide();
                              bootbox.alert(data);
                              window.location.reload();
                          }
                     });
               }
              </script>
      	@stop
  @stop