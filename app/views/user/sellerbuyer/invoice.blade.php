@extends('main')
    @section('styles')
        {{HTML::style('//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/bootstrap/css/bootstrap.min.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/css/shop.style.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/css/headers/header-v5.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/css/footers/footer-v4.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/animate.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/line-icons/line-icons.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/font-awesome/css/font-awesome.min.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/scrollbar/css/jquery.mCustomScrollbar.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/owl-carousel/owl-carousel/owl.carousel.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/plugins/revolution-slider/rs-plugin/css/settings.css')}}
        {{HTML::style('/assets/asset_view/shop-ui/css/custom.css')}}
        {{HTML::style('/assets/asset_view/css/forestChange.css')}}
    @stop
    @section('content')
        <div class="container content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="border-bottom: 1px solid #D5D5D5;">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <img src="/assets/asset_view/img/332563ae50abec_Logo-01.jpg" class="invoiceImage">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h1  class="invoiceTitle ">{{Lang::get('user.invoice')}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row margin-bottom-30">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <p class = "invoiceHeader" >{{Lang::get('user.invoiceHeader')}}</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <div class="row" >
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <p class = "invoiceHeader1" >{{Lang::get('user.invoice_no')}}</p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <p class = "invoiceHeader1" >{{$quoteSample->invoicenumber}}</p>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <p>{{Lang::get('user.date')}}</p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <p>{{substr($quoteSample->createInvoiceDate,0,10)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-bottom-30">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-6">
                                    <h4 style="font-weight: 900">{{Lang::get('user.buyer')}}</h4>
                                    <p>{{$quote->buyerMember->firstname." ". $quote->buyerMember->lastname}}</p>
                                    <p>{{$quote->buyerMember->street}}</p>
                                    <p>{{$quote->buyerMember->city.", ". $quote->buyerMember->state.", ". $quote->buyerMember->zipcode.", ". $buyerCountry->country_name}}</p>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-6">
                                    <h4 style="font-weight: 900">{{Lang::get('user.seller')}}</h4>
                                    <p>{{$quote->sellerMember->firstname." ". $quote->sellerMember->lastname}}</p>
                                    <p>{{$quoteSample->street}}</p>
                                    <p>{{$quote->sellerMember->city.", ". $quote->sellerMember->state.", ". $quote->sellerMember->zipcode.", ". $sellerCountry->country_name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-bottom-30">
                        <div class="col-md-12">
                            <table  class="invoiceTable">
                                <thead>
                                    <tr class="invoiceTableHeaderTr">
                                        <th style="width:10%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.quantity'))?></th>
                                        <th style="width:50%" class="invoiceTableHeaderTD"><?php echo strtoupper(Lang::get('user.description'))?></th>
                                        <th style="width:15%" class="invoiceTableHeaderTD">{{Lang::get('user.unit_price')}}</th>
                                        <th style="width:15%" class="invoiceTableHeaderTD">{{Lang::get('user.line_total')}}</th>
                                        {{--<th></th>--}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($quote->quoteSpe)>0){
                                        $countResultSelect = count($quote->quoteSpe);
                                        if($countResultSelect%2 == 1){
                                            $countResultSelectMiddle = ($countResultSelect-1)/2+1;
                                        }else{
                                            $countResultSelectMiddle = ($countResultSelect)/2;
                                        }

                                    if($countResultSelectMiddle !=0){
                                        for($i=0; $i<$countResultSelect; $i++){ ?>
                                            <tr>
                                                <td class="invoiceTableBodyTD"><?php if(($i+1) == $countResultSelectMiddle) {echo $quoteSample->sampleamount;}?></td>
                                                <td class="invoiceTableBodyTD" style="text-align:left;"><?php echo $quote->quoteSpe[$i]->specification;?></td>
                                                <td class="invoiceTableBodyTD">
                                                    <?php if(($i+1) == $countResultSelectMiddle) {

                                                            echo $productItemPrice."(".$productUnit .")";
                                                       }
                                                    ?>
                                                </td>
                                                <td class="invoiceTableBodyTD">
                                                    <?php if(($i+1) == $countResultSelectMiddle) {
                                                            if(strtoupper($productUnit) !="USD"){
                                                                echo $prodcutPrice."(".$productUnit .")"." OR ".$totalProduct."(USD)";
                                                            }else{
                                                                echo $prodcutPrice."(".$productUnit .")";
                                                            }

                                                       }
                                                    ?>
                                                </td>
                                            </tr>
                                    <?php }}
                                    }else{?>
                                        <tr>
                                            <td class="invoiceTableBodyTD"><?php echo $quoteSample->sampleamount;?></td>
                                            <td class="invoiceTableBodyTD" style="text-align:left;"><?php echo $quote->seller_product;?></td>
                                            <td class="invoiceTableBodyTD">
                                                <?php
                                                        echo $productItemPrice."(".$productUnit .")";
                                                ?>
                                            </td>
                                            <td class="invoiceTableBodyTD">
                                                <?php
                                                        if(strtoupper($productUnit) !="USD"){
                                                            echo $prodcutPrice."(".$productUnit .")"." OR ".$totalProduct."(USD)";
                                                        }else{
                                                            echo $prodcutPrice."(".$productUnit .")";
                                                        }

                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="invoiceTableBodyTD">&nbsp;</td>
                                        <td class="invoiceTableBodyTD">&nbsp;</td>
                                        <td class="invoiceTableBodyTD">&nbsp;</td>
                                        <td class="invoiceTableBodyTD">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="invoiceTableBodyTD"></td>
                                        <td class="invoiceTableBodyTD" style="text-align:left;"><?php echo "Fedex Shipping Price"; ?></td>
                                        <td class="invoiceTableBodyTD"><?php echo $totalShipping." (".$quoteSample->shippingcurrency.")";?></td>
                                        <td class="invoiceTableBodyTD"><?php echo $totalShipping." (".$quoteSample->shippingcurrency.")";?></td>
                                    </tr>
                                    <tr>
                                        <td class="invoiceTableBodyTD">&nbsp;</td>
                                        <td class="invoiceTableBodyTD">&nbsp;</td>
                                        <td class="invoiceTableBodyTD">&nbsp;</td>
                                        <td class="invoiceTableBodyTD">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="text-align:right"><font style="font-weight:700; font-size:13px; text-align:right">TOTAL</font></td>
                                        <td class="invoiceTableBodyTD"><?php echo  $total." (USD)"; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @stop
    @section('scripts')
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
    @stop
@stop