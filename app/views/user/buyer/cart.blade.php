@extends('user.buyer.layout')
@section('custom-styles')
@stop
@section('body-right')
    <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1">
        <div class="row">
            @if(count($carts)>0)
                @foreach($carts as $key=>$cart)
                    <div class="col-md-12 orderContent margin-bottom-40" >
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 orderTitle">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4><span class="buyerHeaderRed">{{$cart->product->product_name}}</span></h4>
                                    </div>
                                    <div class="col-md-4">
                                        <h4><span class="buyerHeaderRed">{{Lang::get('user.date')}} {{substr($cart->created_at,0,10)}}</span> </h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 margin-bottom-20">
                                        <a href="javascript:void(0)" class="display_inline" onclick="onShowBuyer({{100000*1+$cart->id}})">
                                            <img src="/assets/images/buyer-seller.jpg" class="orderItemSubList">
                                            <p class="leftMenuSubItem">{{Lang::get('user.seller')}}</p>
                                        </a>
                                        <a href="javascript:void(0)" class="display_inline" onclick="onShowEscrow({{100000*1+$cart->id}})">
                                            <img src="/assets/images/escrow.jpg" class="orderItemSubList">
                                            <p class="leftMenuSubItem">{{Lang::get('user.escrow')}}</p>
                                        </a>
                                        <a href="javascript:void(0)" class="display_inline" onclick="onShowOrders({{100000*1+$cart->id}})">
                                            <img src="/assets/images/orders.jpg" class="orderItemSubList">
                                            <p class="leftMenuSubItem">{{Lang::get('user.orders')}}</p>
                                        </a>
                                       @if($cart->status == 4)
                                            <a href="javascript:void(0)" class="display_inline" onclick ="onShowShipping({{100000*1+$cart->id}})">
                                                <img src="/assets/images/shipping.jpg" class="orderItemSubList">
                                                <p class="leftMenuSubItem">{{Lang::get('user.shipping')}}</p>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="display_inline" onclick ="onShowShippingStatus({{100000*1+$cart->id}})">
                                                <img src="/assets/images/shipping.jpg" class="orderItemSubList">
                                                <p class="leftMenuSubItem">{{Lang::get('user.shipping')}}</p>
                                            </a>
                                        @endif
                                        <a href="javascript:void(0)" class="display_inline"  onclick="onShowMail({{100000*1+$cart->id}})">
                                            <img src="/assets/images/mail.jpg" class="orderItemSubList">
                                            <p class="leftMenuSubItem">{{Lang::get('user.mail')}}</p>
                                        </a>
                                        <a href="javascript:void(0)" class="display_inline" onclick="onShowDocument({{100000*1+$cart->id}})">
                                            <img src="/assets/images/document.jpg" class="orderItemSubList" >
                                            <p class="leftMenuSubItem">{{Lang::get('user.documents')}}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12" style="text-align: right">
                    {{$carts->links();}}
                </div>
            @else
                <div class="col-md-12 orderContent" style="min-height: 200px;">
                    <div class ="row">
                        <div class="col-md-10 col-md-offset-1" style="margin-top: 20px">
                            {{Lang::get('user.you_have_empty')}}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm"  id="payNowFirstDiv" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modalChangeContent">
                <div class="modal-header modalChangeHeader">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title modalChangeTitle" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="myModaltext">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-u btn-u-default" data-dismiss="modal">{{Lang::get('user.close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm"  id="sendProductConfirm" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modalChangeContent">
                <div class="modal-header modalChangeHeader">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title modalChangeTitle" id="myModalProductLabel"></h4>
                </div>
                <div class="modal-body" id="myModalProductText">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="" id="productID">
                    <button type="button" class="btn-u btn-u-blue" onclick ="onReceiveConfirm()">{{Lang::get('missing.confirm')}}</button>
                    <button type="button" class="btn-u btn-u-default" data-dismiss="modal">{{Lang::get('user.close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm"  id="sendProductStatus" tabindex="-1" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modalChangeContent">
                <div class="modal-header modalChangeHeader">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title modalChangeTitle" id="myModalProductStatusLabel"></h4>
                </div>
                <div class="modal-body" id="myModalProductStatusText">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-u btn-u-default" data-dismiss="modal">{{Lang::get('user.close')}}</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('custom-scripts')
    {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
    {{ HTML::script('/assets/assest_admin/js/spin.js') }}
    <script type="text/javascript">
        function onShowDocument(product_id){
            $.ajax ({
                url: '{{route('user.buyer.cart.document')}}',
                type: 'POST',
                data: {id : product_id},
                cache: false,
                dataType : "json",
                success: function (data) {
                    if(data.result == "success"){
                        $("#myModaltext").html(data.content);
                        $("#myModalLabel").html(data.title);
                        $("#payNowFirstDiv").modal('show');
                    }
                }
            });
        }
        function onShowShipping(id){
            $.ajax ({
                url: "{{route('user.buyer.cart.getStatus')}}",
                type: 'POST',
                data: {id : id},
                cache: false,
                dataType : "json",
                success: function (data) {
                    if(data.result == "success"){
                        $("#myModalProductText").html(data.content);
                        $("#myModalProductLabel").html(data.title);
                        $("#sendProductConfirm").find("#productID").val(data.id);
                        $("#sendProductConfirm").modal('show');

                    }
                }
            });
        }
        function onShowShippingStatus(id){
            $.ajax ({
                url: "{{route('user.buyer.cart.getStatus')}}",
                type: 'POST',
                data: {id : id},
                cache: false,
                dataType : "json",
                success: function (data) {
                    if(data.result == "success"){
                        $("#myModalProductStatusText").html(data.content);
                        $("#myModalProductStatusLabel").html(data.title);
                        $("#sendProductStatus").modal('show');

                    }
                }
            });
        }
        function onReceiveConfirm(){
            var productID = $("#sendProductConfirm").find("#productID").val();
            $.ajax ({
                url: "{{route('user.buyer.cart.getConfirm')}}",
                type: 'POST',
                data: {id : productID},
                cache: false,
                dataType : "json",
                success: function (data) {
                    if(data.result == "success"){
                        bootbox.alert("{{ Lang::get('missing.success_check_product_pay_to_seller') }}");
                        window.location.reload();
                    }
                }
            });
        }
        function  onShowBuyer(id){
            $.ajax ({
                url: '{{ URL::route('user.buyer.cart.seller') }}',
                type: 'POST',
                data: {id : id},
                cache: false,
                dataType : "json",
                success: function (data) {
                    if(data.result == "success"){
                        $("#myModaltext").html(data.content);
                        $("#payNowFirstDiv").modal('show');
                        $("#myModalLabel").html(data.title);
                    }
                }
            });
        }
        function onShowEscrow(id){
            $.ajax ({
                url: '{{route('user.buyer.cart.escrow')}}',
                type: 'POST',
                data: {id : id},
                cache: false,
                dataType : "json",
                success: function (data) {
                    if(data.result == "success"){
                        $("#myModaltext").html(data.content);
                        $("#myModalLabel").html(data.title);
                        $("#payNowFirstDiv").modal('show');
                    }else{
                        bootbox.alert(data.message);
                    }
                }
            });
        }
        function onShowOrders(id){
            $.ajax ({
                url: '{{route('user.buyer.cart.orders')}}',
                type: 'POST',
                data: {id : id},
                cache: false,
                dataType : "json",
                success: function (data) {
                    if(data.result == "success"){
                        $("#myModaltext").html(data.content);
                        $("#myModalLabel").html(data.title);
                        $("#payNowFirstDiv").modal('show');

                    }
                }
            });
        }
        function onShowMail(id){
            $.ajax ({
                url: '{{route('user.buyer.cart.mail')}}',
                type: 'POST',
                data: {id : id},
                cache: false,
                dataType : "json",
                success: function (data) {
                    if(data.result == "success"){
                        $("#myModaltext").html(data.content);
                        $("#myModalLabel").html(data.title);
                        $("#payNowFirstDiv").modal('show');

                    }
                }
            });
        }

        function onSendFormButton(){
            $("#spin").css('display','block');
            $("#emailSendForm").find("#semd").hide();
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
            var target = document.getElementById('spin3');
            var spinner = new Spinner(opts).spin(target);
            $("#emailSendForm").ajaxForm({
                success:function(data){
                    $("#spin").hide();
                    if(data.result == "success"){
                        bootbox.alert("Message Sent Successfully.");
                        window.location.reload();
                    }else if(data.result == "failed"){
                        var arr = data.error;
                        var errorList = '';
                        $.each(arr, function(index, value)
                        {
                            if (value.length != 0)
                            {
                                errorList = errorList + value;
                            }
                        });
                        $("#spin").css('display','hide');
                        $("#myModaltext").find("#semd").show();
                        bootbox.alert(errorList);

                    }
                }
            }).submit();
        }
        function onHideMessageForm(){
            $("#payNowFirstDiv").modal('hide');
        }
    </script>
@stop
@stop