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
            }, {
                "orderable": false
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
            }],
            "order": [
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
 var handleSpinners = function () {
     $('#spinner1').spinner();
     $('#spinner2').spinner({disabled: true});
     $('#spinner3').spinner({value:0, min: 0, max: 10});
     $('#spinner4').spinner({value:0, step: 1, min: 0, max: 200});
 }
 
 var handleBootstrapTouchSpin = function() {

     
     $("#touchspin_demo2").TouchSpin({
         buttondown_class: 'btn blue',
         buttonup_class: 'btn blue',
         min: 0,
         max: 100,
         step: 1,
         decimals: 0,
         boostat: 5,
         maxboostedstep: 10,
         postfix: '%'
     });         

     $("#touchspin_demo3").TouchSpin({          
    	 buttondown_class: 'btn blue',
         buttonup_class: 'btn blue',
         min: 0,
         max: 100,
         step: 1,
         decimals:0,
         boostat: 5,
         maxboostedstep: 10,
         postfix: '%'
     });
     $("#touchspin_demo4").TouchSpin({          
    	 buttondown_class: 'btn blue',
         buttonup_class: 'btn blue',
         min: 0,
         max: 100,
         step: 1,
         decimals: 0,
         boostat: 5,
         maxboostedstep: 10,
         postfix: '%'
     });
     $("#touchspin_demo5").TouchSpin({          
    	 buttondown_class: 'btn blue',
         buttonup_class: 'btn blue',
         min: 0,
         max: 1000,
         step: 1,
         decimals: 0,
         boostat: 5,
         maxboostedstep: 10,
         postfix: 'Min'
     });
 }
 function onSaveTest(){
	 $("#testNameError").hide(); 
	 $("#numberQuestionError").hide();
	 $("#selectCategoryError").hide();
	 $("#selectQuestionError").hide();
	 $("#insertNumberError").hide();
	 $("#selectTestType").hide();
	 var testID = $("#testID").val();
	 var testName = $("#testName").val();
	 if(testName == "") { $("#testNameError").show(); return;}
	 var testType = $("#testType").val();
	 if(testType == "") {$("#selectTestType").show(); return;}
	 var numberQuestion = $("#numberQuestion").val();
	 if(numberQuestion==0){$("#numberQuestionError").show(); return;}
	 var categoryName= $("#categoryName").val();
	 if(categoryName == "" || categoryName == null) {$("#selectCategoryError").show();return;}
	 var categoryID = "";
		for(var i=0; i<categoryName.length; i++){
			categoryID += categoryName[i];
			if( i != categoryName.length - 1 )
				categoryID += ",";
		}
	
//	 var  minDifficulty = $("#touchspin_demo2").val();
//	 var  maxDifficulty = $("#touchspin_demo3").val();
	 var  passRating = $("#touchspin_demo4").val();
	 var testRating = $("#testRating").val();
	 //if(testRating == "") {$("#selectQuestionRatingError").show(); return;}
	 var  testTime	= $("#touchspin_demo5").val();
	 if(testTime == ""){$("#testTimeError").show(); return;}
	 var objList = $("div#questionShowAllList").find("input#QuestionIDS:checkbox:checked");
	 if( objList.length == 0 ){ $("#selectQuestionError").show(); return;}
	 if(numberQuestion != objList.length){
		 $("#insertNumberError").show();
		 return;
	 }
	 
	 var QuestionID = "";
	 for( var i = 0 ; i < objList.length; i ++ ){
			QuestionID += objList.eq(i).val();
			if( i != objList.length - 1 )
				QuestionID += ",";
	}
	 $.ajax({
	        url: "./async-saveTestQuestion.php",
	        dataType : "json",
	        type : "POST",
	        data : {testID : testID, testName:testName , numberQuestion: numberQuestion, categoryID:categoryID, testRating:testRating, passRating:passRating , QuestionID:QuestionID,testType:testType,testTime:testTime},
	        success : function(data){
	            if(data.result == "success"){
	            	$("#testInsertSuccess").show();
	            	window.location.reload();
	            }else if(data.result == "update"){
	            	$("#testUpdateSuccess").show();
	            	window.location.href="./testing.php";
	            }else if(data.result == "exist"){
	            	$("#testExistError").show();
	            	window.location.reload();
	            }
				
	        }
	    });
 }
 
 
 function onChangeCategory(){
	 var categoryName= $("#categoryName").val();
	 var str="";
	 var categorySize=1;
	 if(categoryName.length == 0 ){
		 categorySize=0;
	 }else{
		for(var i=0; i<categoryName.length; i++){
			str += categoryName[i];
			if( i != categoryName.length - 1 )
				str += ",";
		}
	}
		$.ajax({
	        url: "./async-getTestQuestion.php",
	        dataType : "json",
	        type : "POST",
	        data : {str:str , categorySize: categorySize},
	        success : function(data){
	            if(data.result == "success"){
	            	if(data.content.length == 0){
	            		$("#categoryQuestionSize").show();
	            		$("#questionSelectList").hide();
	            		return;
	            	}else{
	            		
	            		var questionSize = $("div#questionSelectList").find("div#questionShowAllList").find(".icheck").size();
	            		
	            		for(var k=0; k<questionSize; k++){
	            			var QuestionID = $("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).val();
	            			var Compare =0;
	            			
	            			for(var j=0; j<data.content.length; j++){
		            			if( QuestionID== data.content[j]){
		            				Compare = Compare+1;
		            				//$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).parents("label").show();
		            			}
		            		}
		            		if(Compare==1) {
		            			$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).parents("label").show();
		            		}else{
		            			if(	$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).is(':checked')){
		            				$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).attr('checked', false);
		            				$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).parents("label").eq(0).find("div.icheckbox_minimal-grey").eq(0).removeClass("checked");
		            			}
		            			$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).parents("label").hide();
		            		}
		            	}	
	            		$("#questionSelectList").show();
	            	}
	            	
	            }
				
	        }
	    });
 }
 
 
 function onTestEdit(obj){
	 var TestID = $(obj).parents('tr').eq(0).find("#chkTestID").eq(0).val();
	 window.location.href="./addTest.php?TestID="+TestID;
 }
 
 function onTestDelete(obj){
	 var TestID = $(obj).parents('tr').eq(0).find("#chkTestID").eq(0).val();
	 var type = "field";
		$.ajax({
	        url: "./async-deleteTest.php",
	        dataType : "json",
	        type : "POST",
	        data : {TestID:TestID,type:type},
	        success : function(data){
	            if(data.result == "success"){
	            	$("#testDeletedSuccess").show();
	            	window.location.reload(); 
	            }
				
	        }
	    });	
	 
 }
 function onTopDeleteTest(){
	 var objList = $("table#sample_1").find("input#chkTestID:checkbox:checked");
		if( objList.length == 0 ){ $("#topDeleteEmptyError").show(); return;}
		var TestID = "";
		var type = "fields";
		for( var i = 0 ; i < objList.length; i ++ ){
			TestID += objList.eq(i).val();
			if( i != objList.length - 1 )
				TestID += ",";
		}
		if( !confirm("Are you sure?") ){ return; }
		$.ajax({
	        url: "./async-deleteTest.php",
	        dataType : "json",
	        type : "POST",
	        data : {TestID:TestID,type:type},
	        success : function(data){
	            if(data.result == "success"){
	            	$("#testDeletedSuccess").show();
	            	window.location.reload(); 
	            }
				
	        }
	    });	
 }
 
 function onTopEditTest(){
	 $("#topEditEmptyError").hide();
	 $("#topEditManyError").hide();
	 var objList = $("table#sample_1").find("input#chkTestID:checkbox:checked");
		if( objList.length == 0 ){ $("#topEditEmptyError").show(); return;}
		if( objList.length > 1 ) { $("#topEditManyError").show(); return;}
		var TestID = objList.eq(0).val();
		window.location.href="./addTest.php?TestID="+TestID;
 }
 
 function onShowQuestionList() {
	 var categoryName= $("#categoryName").val();
	 if(categoryName == "" || categoryName==null){$("#testShowQuestionError").show(); return;}
	 var str="";
	 var categorySize=1;
	 if(categoryName.length == 0 ){
		 categorySize=0;
	 }else{
		for(var i=0; i<categoryName.length; i++){
			str += categoryName[i];
			if( i != categoryName.length - 1 )
				str += ",";
		}
	}
	var testRating = $("#testRating").val();
		 $.ajax({
		        url: "./async-getTestQuestion.php",
		        dataType : "json",
		        type : "POST",
		        data : {str:str , categorySize: categorySize, testRating:testRating},
		        success : function(data){
		            if(data.result == "success"){
		            	if(data.content.length == 0){
		            		$("#categoryQuestionSize").show();
		            		$("#questionSelectList").hide();
		            		return;
		            	}else{
		            		
		            		var questionSize = $("div#questionSelectList").find("div#questionShowAllList").find(".icheck").size();
		            		
		            		for(var k=0; k<questionSize; k++){
		            			var QuestionID = $("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).val();
		            			var Compare =0;
		            			
		            			for(var j=0; j<data.content.length; j++){
			            			if( QuestionID== data.content[j]){
			            				Compare = Compare+1;
			            				//$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).parents("label").show();
			            			}
			            		}
			            		if(Compare==1) {
			            			$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).parents("label").show();
			            		}else{
			            			if(	$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).is(':checked')){
			            				$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).attr('checked', false);
			            				$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).parents("label").eq(0).find("div.icheckbox_minimal-grey").eq(0).removeClass("checked");
			            			}
			            			$("div#questionSelectList").find("div#questionShowAllList").find(".icheck").eq(k).parents("label").hide();
			            		}
			            	}	
		            		$("#questionSelectList").show();
		            	}
		            	
		            }
					
		        }
		    });
 }