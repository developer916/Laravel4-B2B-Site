@extends('admin.layout')
    @section('body')
        <h3 class="page-title">Escrow Email Template Management</h3>
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
                    <a href="{{URL::route('admin.escrow.email')}}">Escrow Email Template Setting</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                 <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i> Escrow Email Template Management
                        </div>
                        <div class="actions">
                            <a id="sample_editable_1_new" class="btn btn-default btn-sm" href='{{ URL::route('admin.escrow.email.create')}}' style="margin-right:10px">
                                    Add New <i class="fa fa-plus"></i>
                            </a>
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
                         <table class="table table-striped table-bordered table-hover" id="sample_1">
                              <thead>
                                  <tr>
                                      <th class="table-checkbox">
                                          <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                      </th>
                                      <th>Title</th>
                                      <th>Content</th>
                                      <th class= "sorting_disabled">ACTION</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @if(count($email)>0)
                                    @foreach($email as $key =>$value)
                                        <tr>
                                            <td><input type="checkbox"  class="checkboxes" value ="{{$value->id}}"></td>
                                            <td>{{$value->title}}</td>
                                            <td>
                                                <?php
                                                    if(strlen($value->content)<=40){
                                                        echo $value->content;
                                                    }else{
                                                        echo substr($value->content,0,39);
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="{{ URL::route('admin.escrow.email.edit',$value->id)}}"  class='btn btn-xs blue'>
                                                     <i class='fa fa-edit'></i>Edit
                                                 </a>
                                                 <form action="{{ URL::route('admin.escrow.email.delete' , $value->id) }}" id="formTest" onsubmit = "return onDelteConfirm(this)" style="display:inline-block">
                                                        <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                                        <i class='fa fa-trash-o'></i> Delete</button>
                                                    </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                              </tbody>
                         </table>
                    </div>
                 </div>
            </div>
        </div>
      @stop
      @section('custom-scripts')
         <script type="text/javascript">
             jQuery(document).ready(function() {
                  initTable1();
             });
             function onDelteConfirm( obj){
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