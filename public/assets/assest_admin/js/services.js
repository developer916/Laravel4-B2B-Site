$(document).ready(function(){
	$('#addCategoryFiledForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: {
        	professionID: {
                required: true
            },
			serviceName:{
				required: true
			}
        },

        messages: {
        	professionID: {
                required: "Profession is required."
            },
            serviceName: {
                required: "Service Name is required."
            }
        },
        invalidHandler: function (event, validator) { //display error alert on form submit   
            $('.alert-danger', $('#addCategoryFiledForm')).show();
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element.closest('.input-icon'));
        },

      
    });
	/*  add Edit table */
	
});

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

        
        "lengthMenu": [
           [5, 20,100, -1],
           [5, 20, 100, "All"] // change per page values here
       ],
       // set the initial value
       "pageLength": 100,             
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
        }],
        "order": [
            [1, "asc"]
        ] // set first column as a default sort by asc
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

var type="";
var CategoryID;
function onAddService(){
	window.location.href="./addService.php";
}
function onCancelCategory(){
	window.location.href="./serviceManagement.php";
}
function onSaveCategory(){
	if ($('#addCategoryFiledForm').valid()) {
		var professionID = $("#professionID").val();
		var serviceName = $("#serviceName").val();
		var serviceID = $("#serviceID").val();
		$.ajax({
			 url: "./async-saveService.php",
				cache : false,
				dataType : "json",
				type : "POST",
				data : { serviceID:serviceID, professionID:professionID, serviceName:serviceName},
				success : function(data){
					if(data.result == "success"){
						$("#categorySavedSuccess").show();
						window.location.href="./serviceManagement.php"
					}else if(data.result == "update"){
						$("#categoryUpdateSuccess").show();
						window.location.href="./serviceManagement.php";
					}else if(data.result == "exist"){
						$("#categorySavedExist").show();
						window.location.reload();
					}
					
				}
		});
	}
}

function onServiceEdit(obj){
	var ServiceID = $(obj).parents('tr').eq(0).find("#chkServiceID").eq(0).val();
	window.location.href="./addService.php?ServiceID="+ServiceID;
}
function onServiceDelete(obj){
	var ServiceID = $(obj).parents('tr').eq(0).find("#chkServiceID").eq(0).val();
	type = "field";
	CategoryID = ServiceID;
	$("#deleteContent").text(" Do you want delete this service?");
	var a = $("<a>")
    .attr("href", "#static")
    .attr("data-toggle","modal")
    .appendTo("body");

	a[0].click();

	a.remove();
}
function onDeleteServices(){
	var objList = $("table#sample_1").find("input#chkServiceID:checkbox:checked");
	if( objList.length == 0 ){ $("#selectDeleteError").show(); return;}
	var CategoryDeleteID = "";
	 type = "fields";
	for( var i = 0 ; i < objList.length; i ++ ){
		CategoryDeleteID += objList.eq(i).val();
		if( i != objList.length - 1 )
			CategoryDeleteID += ",";
	}
	CategoryID = CategoryDeleteID;
	$("#deleteContent").text(" Do you want delete this services?");
	var a = $("<a>")
    .attr("href", "#static")
    .attr("data-toggle","modal")
    .appendTo("body");
	a[0].click();
	a.remove();
}
function onDeleteService(){
	$.ajax({
		 url: "./async-deleteService.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : { CategoryID:CategoryID,type : type},
			success : function(data){
				
				if(data.result == "success"){
					$("#categorydeletedSuccess").show();
					window.location.reload();
				}
				
			}
	});
}