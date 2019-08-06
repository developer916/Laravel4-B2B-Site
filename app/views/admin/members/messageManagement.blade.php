@extends('admin.layout')
@section('custom-styles')
    {{--{{ HTML::style('/assets/assest_admin/css/bootstrap-modal-bs3patch.css') }}--}}
    {{--{{ HTML::style('/assets/assest_admin/css/bootstrap-modal.css') }}--}}
@endsection
@section('body')
    <h3 class="page-title">Message Management</h3>
    <!-- page layout -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <i class="fa fa-pencil"></i>
                <a href="{{URL::route('admin.members.messageManagement')}}">Message Management</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Message Management
                    </div>
                </div>
                <div class="portlet-body">
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
                    <div class="tab-v2 margin-bottom-40">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#alert-1" data-toggle="tab" aria-expanded="true">Emails</a></li>
                            <li class=""><a href="#alert-2" data-toggle="tab" aria-expanded="false">RFQ Emails</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="alert-1">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th class="table-checkbox">
                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                        </th>
                                        <th>Sender</th>
                                        <th>Receiver</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th class= "sorting_disabled">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($emails as  $key =>$email)
                                            <tr>
                                                <td><input type="checkbox" class="checkboxes" value="{{$email->id}}" id="chkClientID"></td>
                                                <td>{{$email->sender->username}}</td>
                                                <td>{{$email->recevier->username}}</td>
                                                <td>{{$email->subject}}</td>
                                                <td>{{$email->content}}</td>
                                                <td>
                                                    <a href="{{ URL::route('admin.members.messageManagementView',$email->id)}}"  class='btn btn-xs blue' target="_blank">
                                                        <i class='fa fa-edit'></i>View
                                                    </a>
                                                    <form action="{{ URL::route('admin.members.messageManagementDelete' , $email->id) }}" id="formTest" onsubmit = "return onDeleteConfirm(this)" style="display:inline-block" method="GET">
                                                        <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                                            <i class='fa fa-trash-o'></i> Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="alert-2">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th class="table-checkbox">
                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                        </th>
                                        <th>RFQ ID</th>
                                        <th>Quote ID</th>
                                        <th>Sender</th>
                                        <th>Receiver</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th class= "sorting_disabled">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rfqEmails as $key => $rfqEmail)
                                            <tr>
                                                <td><input type="checkbox" class="checkboxes" value="{{$rfqEmail->id}}" id="chkClientID"></td>
                                                <td>{{$rfqEmail->rfq_id}}</td>
                                                <td>{{$rfqEmail->quote_id}}</td>
                                                <td>{{$rfqEmail->sender->username}}</td>
                                                <td>{{$rfqEmail->receiver->username}}</td>
                                                <td>{{$rfqEmail->subject}}</td>
                                                <td>{{$rfqEmail->message}}</td>
                                                <td>
                                                    <a href="{{ URL::route('admin.members.messageManagementRFQView',$rfqEmail->id)}}"  class='btn btn-xs blue' target="_blank">
                                                        <i class='fa fa-edit'></i>View
                                                    </a>
                                                    <form action="{{ URL::route('admin.members.messageManagementRFQDelete' , $rfqEmail->id) }}" id="formTest" onsubmit = "return onDeleteConfirm(this)" style="display:inline-block" method="GET">
                                                        <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                                            <i class='fa fa-trash-o'></i> Delete</button>
                                                    </form>
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
        </div>
    </div>
@stop
@section('custom-scripts')
    <script type="text/javascript">
        function onDeleteConfirm( obj){
            bootbox.confirm("Are you sure?", function(result) {

                if ( result ) {

                    obj.submit();

                }

            });

            return false;
        }
    </script>
@stop
@stop