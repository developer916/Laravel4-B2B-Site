@extends('user.seller.layout')
    @section('custom-styles')
    @stop
    @section('body-right')
        <div class="col-md-offset-1 col-md-8 rightMenu col-sm-8 col-sm-offset-1 " >
            <div class="row">
             @if(isset($quote) && count($quote)>0)
                   @foreach($quote as $key => $value)
                        <?php $rfq = $value->rfq;
                        ?>
                <div class="col-md-12 orderContent margin-bottom-40" >
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 orderTitle">
                            <div class="row">
                                <div class="col-md-8">
                                   <h4><span class="buyerHeaderRed">{{$rfq->rfq_title}}</span></h4>
                                </div>
                                <div class="col-md-4">
                                   <h4><span class="buyerHeaderRed">{{Lang::get('user.date')}} {{substr($rfq->created_at,0,10)}}</span> </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 margin-bottom-20">
                                     <a href="javascript:void(0)" class="display_inline" onclick="onShowEscrow({{100000*1+$value->id}})">
                                        <img src="/assets/images/escrow.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.escrow')}}</p>
                                    </a>
                                    <a href="javascript:void(0)" class="display_inline" onclick="onShowSample({{100000*1+$value->id}})">
                                        <img src="/assets/images/sample.jpg" class="orderItemSubList" >
                                        <p class="leftMenuSubItem">{{Lang::get('user.sample')}}</p>
                                    </a>
                                    <a href="javascript:void(0)" class="display_inline" onclick="onShowOrders({{100000*1+$value->id}})">
                                        <img src="/assets/images/orders.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.orders')}}</p>
                                    </a>
                                    <a href="javascript:void(0)" class="display_inline" onclick="onShowShipping({{100000*1+$value->id}})">
                                        <img src="/assets/images/shipping.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.shipping')}}</p>
                                    </a>
                                    <a href="javascript:void(0)" class="display_inline"  onclick="onShowMail({{100000*1+$value->id}})">
                                        <img src="/assets/images/mail.jpg" class="orderItemSubList">
                                        <p class="leftMenuSubItem">{{Lang::get('user.mail')}}</p>
                                    </a>
                                    <a href="javascript:void(0)" class="display_inline" onclick="onShowDocument({{100000*1+$value->id}})">
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
                       {{$quote->links();}}
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
            <div class="modal-dialog ">
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
    @stop
    @section('custom-scripts')
     {{ HTML::script('/assets/assest_admin/js/jquery.form.js') }}
     {{ HTML::script('/assets/assest_admin/js/spin.js') }}
        <script type="text/javascript">
            function onShowShipping(id){
                $.ajax ({
                    url: '{{route("user.seller.sub.shipping")}}',
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
            function onShowSample(id){
                 var base_url = window.location.origin;
                 $.ajax ({
                    url: '{{route("user.seller.sub.sample")}}',
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
                var base_url = window.location.origin;
                 $.ajax ({
                    url: '{{route("user.seller.sub.escrow")}}',
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
            function onShowOrders(id){
                var base_url = window.location.origin;
                     $.ajax ({
                        url: '{{route("user.seller.sub.orders")}}',
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
            function onShowMail(id){
                var base_url = window.location.origin;
                 $.ajax ({
                    url: '{{route("user.seller.sub.mail")}}',
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
            function onShowDocument(id){
                 var base_url = window.location.origin;
                 $.ajax ({
                     url: '{{route("user.seller.sub.documents")}}',
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
                                bootbox.alert("{{Lang::get('missing.message_sent_successfully') }}");
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