<div class="row">
    <div class="col-md-12" id="printDiv">
        <div class="form-group" style="margin-bottom: 0px">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <img src="/assets/asset_view/img/purchasetree-logo-png.png">
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <a href="javascript:void(0)" class="btn-u btn-u-green hidden-print" onclick="onPrint()" style="float: right; background: black">PRINT</a>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 col-xs-12" >
                <h2 class="text-center" style="text-align: center">{{trans('cart.wire_transfer_payment')}}</h2>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label col-xs-3">{{Lang::get('user.company')}}</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <p class="form-control escrow_wire_transfer_company_list">
                    {{Lang::get('user.company_information_for_wire_transfer1')}} <br>
                    {{Lang::get('user.company_information_for_wire_transfer2')}} <br>
                    {{Lang::get('user.company_information_for_wire_transfer3')}}
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label col-xs-3">{{Lang::get('user.company_routing_name')}}</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <p class="form-control escrow_wire_transfer_company_list">
                    {{Lang::get('user.company_routing_value')}}
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label col-xs-3">{{Lang::get('user.company_account_name')}}</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <p class="form-control escrow_wire_transfer_company_list">
                    {{Lang::get('user.company_account_value')}}
                </p>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword1" class="col-lg-3 col-md-3 col-sm-3 control-label col-xs-3">{{Lang::get('user.invoice_number')}}</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <p class="form-control escrow_wire_transfer_company_list">
                    {{$shoppingCart->invoice_number}}
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label col-xs-3">{{Lang::get('user.wire_transfer_Amount')}}</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <p class="form-control escrow_wire_transfer_company_list">
                    {{$shoppingCart->total}}
                </p>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail1" class="col-lg-3 col-md-3 col-sm-3 control-label col-xs-3">{{Lang::get('user.wire_transfer_bank')}}</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <p class="form-control escrow_wire_transfer_company_list">
                    JPMorgan Chase Bank NA
                </p>
            </div>
        </div>

        <div class="form-group">
            {{--<div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-9 col-md-9 col-sm-9">--}}
            {{--<input type="hidden" name="quote_id" value="{{$quote_id}}">--}}
            {{--<input type="hidden" name="escrow_id" value="{{$escrow->escrow_id}}">--}}
            {{--</div>--}}
        </div>
        <h2 class="text-center margin-bottom-20"> {{Lang::get('user.instruction_for_payment')}}</h2>
        <div class="form-group">
            <div class="col-md-12">
                {{Lang::get('user.full_payment_is_required')}}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {{Lang::get('user.include_your_invoice_number')}}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {{Lang::get('user.send_us_your_wire')}}<br>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <span style="color:red">Email:</span> {{Escrow_Email}} <br>
                        <span style="color:red">Fax:</span>  {{Escrow_Fax}}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group margin-bottom-20">
            <div class="col-md-12">
                {{Lang::get('user.allow_hours_for_your_escrow')}}
            </div>
        </div>
    </div>
</div>
