var initTable1 = function () {

        var table = $('#sample_1');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            "columns": [{
                "orderable": false
            }, {
                "orderable": false
            }, {
                "orderable": false
            }, {
                "orderable": false
            }, {
                "orderable": false
            }, {
                "orderable": false
            }],
            
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            "iDisplayLength": 20,
            // set the initial value
            "pageLength": 5,            
            "pagingType": "bootstrap_full_number",
            "language": {
                "search": "Search: ",
                "lengthMenu": "  _MENU_ records",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],"order": [
                         [1, "asc"]
                         ]
            
            // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_1_wrapper');

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).attr("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
            jQuery.uniform.update(set);
        });

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });

        tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
    }


function onActivated(obj){
	var CommentID =  $(obj).parents('tr').eq(0).find("#chkCommentID").eq(0).val();
	$.ajax({
        url: "./async-setCommentApproved.php",
        dataType : "json",
        type : "POST",
        data : {CommentID:CommentID},
        success : function(data){
            if(data.result == "success"){
            	$("#commentApprovedSuccessfully").show();
            	window.location.reload(); 
            }
			
        }
    });	
}

function onCommentDelete(obj){
	var CommentID =  $(obj).parents('tr').eq(0).find("#chkCommentID").eq(0).val();
	$.ajax({
        url: "./async-deleteCommentApproved.php",
        dataType : "json",
        type : "POST",
        data : {CommentID:CommentID},
        success : function(data){
            if(data.result == "success"){
            	$("#commentApprovedDelete").show();
            	window.location.reload(); 
            }
			
        }
    });	
}
function onShowComment(obj){
	var CommentID =  $(obj).parents('tr').eq(0).find("#chkCommentID").eq(0).val();
	window.location.href="./showComment.php?CommentID="+CommentID;
}
function onReplyActivated(obj){
	var ReplyID =$(obj).parents('tr').eq(0).find("#chkReplyID").eq(0).val();
	$.ajax({
        url: "./async-setCommentReplyApproved.php",
        dataType : "json",
        type : "POST",
        data : {ReplyID:ReplyID},
        success : function(data){
            if(data.result == "success"){
            	$("#commentApprovedSuccessfully").show();
            	window.location.reload(); 
            }
			
        }
    });	
}
function onCommentReplyDelete(obj){
	var ReplyID =$(obj).parents('tr').eq(0).find("#chkReplyID").eq(0).val();
	$.ajax({
        url: "./async-deleteCommentReplyApproved.php",
        dataType : "json",
        type : "POST",
        data : {ReplyID:ReplyID},
        success : function(data){
            if(data.result == "success"){
            	$("#commentApprovedDelete").show();
            	window.location.reload(); 
            }
			
        }
    });
}