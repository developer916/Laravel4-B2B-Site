@extends('user.escrow.layout')
    @section('custom-styles')
        {{HTML::style('/assets/asset_view/css/forestchange.css')}}
    @stop
    @section('body')
        <div class="container content">
            <div class="col-md-12 text-center  margin-bottom-30">
                <h2>{{Lang::get('user.purchasetree_escrow')}}</h2>
            </div>
            <div class="col-md-12">
                <div class="alert alert-success">
                    <span class="caption-subject escrow-index-success-header">
                        {{Lang::get('user.Welcome')}} {{$account->userfullname}}
                    </span>
                    <br>
                    <strong>{{Lang::get('success')}}!</strong> {{Lang::get('user.you_can_use_escrow')}}
                </div>
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h4>{{Lang::get('user.your_account_information')}}</h4>
                            <p><span>{{Lang::get('user.user_name')}}:</span>  <span>{{$account->username}}</span></p>
                            <p><span>{{Lang::get('user.email')}}:</span>  <span>{{$account->useremail}}</span></p>
                            <a href="#">{{Lang::get('user.update_your_information')}}</a>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <h4>{{Lang::get('user.need_help')}}</h4>
                             <p>{{Lang::get('user.contact_the_24')}} <a href="#">{{Lang::get('user.support_desk')}}</a></p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{Lang::get('user.start_an_escrow_transaction')}}</h4>
                            <div class="row">
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
                                <form action="{{URL::route('user.escrow.transaction')}}" method="post">
                                    {{--<div class="col-md-12 col-sm-12">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label class="control-label">{{Lang::get('user.i_am')}}</label>--}}
                                            {{--<select name="type" class="form-control">--}}
                                                {{--<option value="1" >{{Lang::get('user.seller')}}</option>--}}
                                                {{--<option value="2" >{{Lang::get('user.buyer')}}</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                   <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">{{Lang::get('user.item')}}</label>
                                            <select class="form-control" name="item" onchange="onSelectItem()" id="selectItem">
                                                <option value="">-- Select Item --</option>
                                                @foreach($quoteList as $quote)
                                                    <option value="{{$quote->id}}">{{$quote->rfq->rfq_title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">{{Lang::get('user.escrow_price')}}</label>
                                            <input type="text" class="form-control" name="escrowPrice" id="escrowPrice">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">{{Lang::get('user.to_purchasetree_username')}}</label>
                                            <input type="text" class="form-control" name="username" id="username">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <input type="submit" value="{{Lang::get('user.start_transaction')}}" class="btn-u btn-u-blue">
                                        <div id="spin"></div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-success">
                            <h4>{{Lang::get('user.items_you_are_selling')}}</h4>
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <td>
                                            {{Lang::get('user.escrow_id')}}
                                        </td>
                                        <td>
                                            {{Lang::get('user.item')}}
                                        </td>
                                        <td>
                                            {{Lang::get('user.status')}}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sellerList as $key=>$sellerItem)
                                        <tr>
                                            <td>
                                                <a href = "{{URL::route('user.escrow.escrow', $sellerItem->escrow_id)}}">{{$sellerItem->escrow_id}}</a>
                                            </td>
                                            <td>{{$sellerItem->item}}</td>
                                            <td>
                                                @if($sellerItem->status == 1)
                                                    {{Lang::get('user.waiting_for_payment')}}
                                                @elseif($sellerItem->status ==2)
                                                    @if($sellerItem->confirm == 1)
                                                       {{Lang::get('user.the_money_are_in_escrow')}}
                                                    @elseif($sellerItem->confirm == 0)
                                                        {{Lang::get('user.wait_confirm')}}
                                                    @endif
                                                @elseif($sellerItem->status == 3)
                                                    @if($sellerItem->confirm =="2")
                                                        {{Lang::get('user.the_money_are_in_dispute')}}
                                                    @elseif($sellerItem->confirm== "3")
                                                        {{Lang::get('user.dispute_solved')}}
                                                    @endif
                                                @elseif($sellerItem->status == 4)
                                                    {{Lang::get('user.the_payment_was_canceled')}}
                                                @elseif($sellerItem->status == 5)
                                                    {{Lang::get('user.the_payment_was_approved')}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info">
                             <h4>{{Lang::get('user.items_you_are_buying')}}</h4>
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <td>
                                            {{Lang::get('user.escrow_id')}}
                                        </td>
                                        <td>
                                            {{Lang::get('user.item')}}
                                        </td>
                                        <td>
                                            {{Lang::get('user.status')}}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($buyerList as $key=>$buyerItem)
                                        <tr>
                                            <td>

                                                <a href = "{{URL::route('user.escrow.escrow', $buyerItem->escrow_id)}}">{{$buyerItem->escrow_id}}</a>
                                            </td>
                                            <td>{{$buyerItem->item}}</td>
                                            <td>
                                                @if($buyerItem->status == 1)
                                                    {{Lang::get('user.waiting_for_payment')}}
                                                @elseif($buyerItem->status ==2)
                                                    @if($buyerItem->confirm == 1)
                                                       {{Lang::get('user.the_money_are_in_escrow')}}
                                                    @elseif($buyerItem->confirm == 0)
                                                        {{Lang::get('user.wait_confirm')}}
                                                    @endif
                                                @elseif($buyerItem->status == 3)
                                                    @if($buyerItem->confirm =="2")
                                                        {{Lang::get('user.the_money_are_in_dispute')}}
                                                    @elseif($buyerItem->confirm== "3")
                                                        {{Lang::get('user.dispute_solved')}}
                                                    @endif
                                                @elseif($buyerItem->status == 4)
                                                    {{Lang::get('user.the_payment_was_canceled')}}
                                                @elseif($buyerItem->status == 5)
                                                    {{Lang::get('user.the_payment_was_approved')}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop
    @section('custom-scripts')
        {{ HTML::script('/assets/assest_admin/js/spin.js') }}
        <script type="text/javascript">
            function onSelectItem(){
                var selectItem = $("#selectItem").val();
                if(selectItem){
                $("#spin").css('display','block');
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
                var target = document.getElementById('spin');
                var spinner = new Spinner(opts).spin(target);
                   $.ajax ({
                        url: '{{ route("user.escrow.getPrice") }}',
                        type: 'POST',
                        data: {selectItem : selectItem},
                        cache: false,
                        dataType : "json",
                        success: function (data) {
                            $("#spin").css('display','none');
                            if(data.result == "success"){
                                $("#escrowPrice").val(data.price);
                                $("#username").val(data.username);
                            }
                        }
                    });
                }else{
                    $("#escrowPrice").val("");
                    $("#username").val("");
                }
            }
        </script>
    @stop
@stop