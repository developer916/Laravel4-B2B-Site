@extends('admin.layout')
@section('body')
    <h3 class="page-title">Email  Management</h3>
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
                <a href="{{URL::route('admin.members.messageManagement')}}">Email Message Management</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{URL::route('admin.members.messageManagementView',$email->id)}}">View Email Message</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        View Email Message
                    </div>
                </div>
                <div class="portlet-body form">
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
                    <div class="row">
                        <div class="col-md-12">
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
                                    <tr>
                                        <td><input type="checkbox" class="checkboxes" value="{{$email->id}}" id="chkClientID"></td>
                                        <td>{{$email->sender->username}}</td>
                                        <td>{{$email->recevier->username}}</td>
                                        <td>{{$email->subject}}</td>
                                        <td>{{$email->content}}</td>
                                        <td></td>
                                    </tr>
                                    @foreach($emails as $key => $value)
                                        <tr>
                                            <td><input type="checkbox" class="checkboxes" value="{{$value->id}}" id="chkClientID"></td>
                                            <td>{{$value->sender->username}}</td>
                                            <td>{{$value->recevier->username}}</td>
                                            <td>{{$value->subject}}</td>
                                            <td>{{$value->content}}</td>
                                            <td>
                                                <form action="{{ URL::route('admin.members.messageManagementDelete',$value->id) }}" id="formTest" onsubmit = "return onDeleteConfirm(this)" style="display:inline-block" method="GET">
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
                    {{--<div class="row">--}}
                        {{--<form  class="form-horizontal" id="addCategoryFiledForm" method="POST" action="{{URL::route('admin.currency.store')}}" enctype="multipart/form-data">--}}
                            {{----}}
                        {{--</form>--}}
                    {{--</div>--}}
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