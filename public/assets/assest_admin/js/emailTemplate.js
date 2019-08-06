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
                "orderable": true
            }, {
                "orderable": false
            }],
            
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
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
 
 $(document).ready(function(){
		$('#addEmailTemplateFiledForm').validate({
	        errorElement: 'span', //default input error message container
	        errorClass: 'help-block', // default input error message class
	        focusInvalid: false, // do not focus the last invalid input
	        rules: {
	        	selectUser: {
	                required: true
	            },
	            textbody: {
	                required: true
	            }
	        },

	        messages: {
	        	textbody: {
	                required: "Email Template Content is required."
	            },
	            selectUser: {
	                required: "Select user type is required."
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
 function onAddDivShow(){
	 window.location.href="./addEmailTemplate.php";
 }
 
 function onSaveTemplate(){
	 if ($('#addEmailTemplateFiledForm').valid()) {
		 var selectUser = $("#selectUser").val();
		 var textbody = $("#textbody").val();
		 var emailTemplateID = $("#emailTemplateID").val();
		 $.ajax({
			 url: "./async-saveEmailTemplate.php",
				cache : false,
				dataType : "json",
				type : "POST",
				data : { selectUser: selectUser, textbody : textbody , emailTemplateID:emailTemplateID},
				success : function(data){
					
					if(data.result == "success"){
						$("#emailSavedSuccess").show();
						window.location.href="./emailTemp.php"
					}else if(data.result == "update"){
						$("#emailUpdateSuccess").show();
						
						window.location.href="./emailTemp.php"
					}
					
				}
		});
	 }
 }
 
 function onEmailTemplateEdit(obj){
	 var EmailTemplateID =$(obj).parents('tr').eq(0).find("#chkEmailTemplateID").eq(0).val();
	window.location.href = "./addEmailTemplate.php?EmailTemplateID="+EmailTemplateID;
 }
 function onEmailTemplateDelete(obj){
	 var emailTemplateID = $(obj).parents('tr').eq(0).find("#chkEmailTemplateID").eq(0).val();
	 var type="one";
	 $.ajax({
		 url: "./async-deleteEmailTemplate.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : { emailTemplateID:emailTemplateID, type:type},
			success : function(data){
				
				if(data.result == "success"){
					$("#emaildeletedSuccess").show();
					window.location.reload();
				}				
			}
	});
 }
 
 
 function onTopEditTemplate(){
	 var objList = $("table#sample_1").find("input#chkEmailTemplateID:checkbox:checked");
		if( objList.length == 0 ){ $("#selectEmptyError").show(); return;}
		if( objList.length > 1 ) {  $("#selectOneError").show();  return;}
		var EmailTemplateID = objList.eq(0).val();
		window.location.href='./addEmailTemplate.php?EmailTemplateID='+EmailTemplateID;
 }
 
 function onCancelTemplate() {
	 window.location.href = './emailTemp.php';
 }
 
 function onTopDeleteTemplate(){
	 var objList = $("table#sample_1").find("input#chkEmailTemplateID:checkbox:checked");
		if( objList.length == 0 ){$("#selectOneDeleteError").show(); return;}
		var emailTemplateID = "";
		var type = "all";
		for( var i = 0 ; i < objList.length; i ++ ){
			emailTemplateID += objList.eq(i).val();
			if( i != objList.length - 1 )
				emailTemplateID += ",";
		}
		if( !confirm("Are you sure?") ){ return; }
		 $.ajax({
		        url: "./async-deleteEmailTemplate.php",
		        dataType : "json",
		        type : "POST",
		        data : { emailTemplateID : emailTemplateID, type:type  },
		        success : function(data){
		            if(data.result == "success"){
		            	$("#emaildeletedSuccess").show();
		            	window.location.reload(); 
		            }
		        }
		 });
 }