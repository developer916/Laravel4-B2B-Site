<div class ="row" style="margin-bottom: 20px">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Quick Details Category</span>
                </div>
            </div>
            <div class="portlet-body">
                <form class="form-horizontal" action="{{URL::route('admin.quick.categoryStore')}} " method="POST">
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
                    <input type="hidden" name="quick_category_id" id="quick_category_id">
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-4">Category Name</label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                            <input type="text" name="categoryName" class="form-control" id="categoryName" value="">
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-7 col-md-5">
                                <button   class="btn  blue" type="submit" ><i class="fa fa-check-circle-o" style="margin-right:4px"></i>Save</button>
                                <a class="btn  green" href="{{URL::route('admin.quick')}}"><i class="fa fa-repeat" style="margin-right:4px"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Quick Details Category Management
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="table-checkbox">
                            <input type="checkbox" class="group-checkable"/>
                        </th>
                        <th>Category Name</th>
                        <th class= "sorting_disabled">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quickCategory as $key_quickCategory =>$valueCategory)
                        <tr>
                            <td><input type="checkbox" class="checkboxes" value="{{$valueCategory->id}}" id="chkClientID"></td>
                            <td>{{$valueCategory->categoryname}}</td>
                            <td>
                                <a href="javascript:void(0)"  class='btn btn-xs blue' onclick ="onEditCategory({{$valueCategory->id}})"><i class='fa fa-edit'></i>Edit</a>
                                <form action="{{ URL::route('admin.quick.CategoryDelete' , $valueCategory->id) }}" id="formTest" onsubmit = "return onDelteConfirm(this)" style="display:inline-block">
                                    <button type="submit" class="btn btn-xs red" id="js-a-delete" >
                                        <i class='fa fa-trash-o'></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <script type="text/javascript">
                    function onEditCategory(id){
                        var base_url = window.location.origin;
                        $.ajax ({
                            url: base_url + '/admin/quick_details/categoryEdit',
                            type: 'POST',
                            data: {id : id},
                            cache: false,
                            dataType : "json",
                            success: function (data) {
                                if(data.result == "success"){
                                    $("#quick_category_id").val(data.id);
                                    $("#categoryName").val(data.categoryName);
                                }
                            }
                        });
                    }
                </script>
            </div>
        </div>
    </div>
</div>