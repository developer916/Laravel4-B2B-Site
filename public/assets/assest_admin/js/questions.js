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
                "orderable": true
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


function onAddAnswer(){
	var countclonetext = 0;
	countclonetext = $("#addQuestionFiledList").find("div#answerList").size();
	var obj = $("#answerListClone").clone();
	
	obj.find("textarea").attr("id","answer"+countclonetext);
	obj.find("textarea").addClass("form-control");
	obj.find("textarea").summernote({height: 160});
	obj.find("#option").val(countclonetext);
	obj.find("#option").attr("id","option"+countclonetext);
	obj.attr("id","answerList");
	obj.show();
	
	$("#addQuestionFiledList").find("div#answerList:last").after(obj);
	obj.find("input[type='radio']").attr("class", "make-switch switch-radio1");
	obj.find("input[type='radio']").bootstrapSwitch();
	
} 
function onDeleteAnswer(obj){
	$(obj).parents("#answerList").remove();
}


function onCancelQuestion(){
	window.location.href="./questions.php";
}

function onSaveQuestion(){
	
		$("#rateValidateShow").hide();
		$("#categoryNameEmptyError").hide();
		$("#questionInsertEmptyError").hide();
		$("#rateEmptyShow").hide();
		$("#correctAnswer").hide();
		var countclonetext = 0;
		var answerlist = new Array();
		var answerCorrectList = new Array();
		var QuestionID = $("#QuestionID").val(); 
		var categoryName = $("#categoryName").val();
		var question =$('#question').code();
		var hintCheck = $("#hintCheck").val();
		var questionTime = "";
		var rateValue = $("#rate").val();
		var explanation = $("#explanation").code();
		countclonetext = $("#addQuestionFiledList").find("div#answerList").size();
		if(categoryName == "") { $("#categoryNameEmptyError").show(); return;}
		if(question == "" || question=="<p><br></p>")	   { $("#questionInsertEmptyError").removeClass("display-hide"); return;}
		if(rateValue == "") {$("#rateEmptyShow").show();return;}
		
		if(IsNumeric(rateValue)== false){$("#rateValidateShow").show(); return;}
		if(rateValue<1 || rateValue>100){$("#rateValidateShow").show(); return;}
		
		if($('input[name="radio1"]:checked').length == 0){
			$("#correctAnswer").show(); return; 
		}
		var checkedValue = $('input[name="radio1"]:checked').val();
		for(var i = 0; i< countclonetext; i++)
		{
			var value = $("#addQuestionFiledList").find("div#answerList").eq(i).find("textarea").attr("id");
			answerlist[i] =$("#"+value).code();
			if(answerlist[i] == "") {$("#insertAnswer").show(); return;}
			var valueCorrect = $("#addQuestionFiledList").find("div#answerList").eq(i).find(".make-switch").eq(0).val();
			if(valueCorrect == checkedValue ){
				answerCorrectList[i] = 1;
			}else{
				answerCorrectList[i] = 0;
			}
		}
		alert(answerlist);
			$.ajax({
		        url: "./async-saveQuestions.php",
		        dataType : "json",
		        type : "POST",
		        data : { answerlist:answerlist,categoryName:categoryName,question:question,
		        		checkedValue:checkedValue, questionTime : questionTime, hintCheck:hintCheck,QuestionID:QuestionID ,
		        		answerCorrectList:answerCorrectList, rateValue : rateValue,explanation:explanation},
		        success : function(data){
		            if(data.result == "success"){
		            	$("#questionInsertSuccess").show();
		            	window.location.reload(); 
		            }
					else if (data.result =="update_success"){
						$("#questionUpdateSuccess").show();
		            	window.location.reload(); 
					}
		        }
		    });	
}

function onQuestionEdit(obj){
	var QuestionID = $(obj).parents('tr').eq(0).find("#chkQuestionID").eq(0).val();
	window.location.href="./addQuestion.php?QuestionID="+QuestionID;
}
var QuestionDeleteID;
var type;
function onQuestionDelete(obj){
	
	var QuestionID = $(obj).parents('tr').eq(0).find("#chkQuestionID").eq(0).val();
	
	QuestionDeleteID = QuestionID;
	type ="field";
	$("#deleteContent").text(" Do you want delete this question?");
	var a = $("<a>")
    .attr("href", "#static")
    .attr("data-toggle","modal")
    .appendTo("body");

	a[0].click();

	a.remove();
	
	
}

function onDeleteQuestion(){
	$.ajax({
        url: "./async-deleteQuestions.php",
        dataType : "json",
        type : "POST",
        data : {QuestionID:QuestionDeleteID,type:type},
        success : function(data){
            if(data.result == "success"){
            	$("#questionDeleteSuccessfully").show();
            	window.location.reload(); 
            }
			
        }
    });	
}

function onTopEditQuestions(){
	var objList = $("table#sample_1").find("input#chkQuestionID:checkbox:checked");
	if( objList.length == 0 ){ alert("Please select question field to edit."); return;}
	if( objList.length > 1 ) { alert("Please select one question field to edit."); return;}
	var QuestionID = objList.eq(0).val();
	window.location.href="./addQuestion.php?QuestionID="+QuestionID;
}

function onTopDeleteQuestions(){
	var objList = $("table#sample_1").find("input#chkQuestionID:checkbox:checked");
	if( objList.length == 0 ){ alert("Please select question field to delete."); return;}
	var QuestionID = "";
	type = "fields";
	for( var i = 0 ; i < objList.length; i ++ ){
		QuestionID += objList.eq(i).val();
		if( i != objList.length - 1 )
			QuestionID += ",";
	}
	QuestionDeleteID = QuestionID;
	type ="field";
	$("#deleteContent").text(" Do you want delete this questions?");
	var a = $("<a>")
    .attr("href", "#static")
    .attr("data-toggle","modal")
    .appendTo("body");

	a[0].click();

	a.remove();
}
function IsNumeric(num) {
    return (num >=0 || num < 0);
}
function onChangeSorting(value){
	var sortingValue = value;
	$.ajax({
        url: "./async-sortQuestions.php",
        dataType : "json",
        type : "POST",
        data : {sortingValue:sortingValue},
        success : function(data){
            if(data.result == "success"){
            	$("#questionBody").remove();
            	$("#questionHeader").after(data.content);
            	initTable1();
            }
			
        }
    });
	
}