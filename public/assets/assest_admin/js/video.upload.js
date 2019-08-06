$(document).ready( function(){
	$("input#imageUpload").change( function(){
		$(this).parents("form").ajaxForm({
			target: '#' + $(this).parents("form").find("#imagePrevDiv").val()
		}).submit();
	});
	$("input#musicUpload").change( function(){
		var bar = $(".bar");
		var percent = $(".percent");
		var status = $('#status'); 
		$(this).parents("form").ajaxForm({
			beforeSend: function(){
				status.empty();  
				var percentVal = '0%';  
				bar.width(percentVal)  
				percent.html(percentVal); 				
			},
			uploadProgress: function(event, position, total, percentComplete) {  
				var percentVal = percentComplete + '%';  
				bar.width(percentVal)  
				percent.html(percentVal);  
			},
			complete: function(xhr) {
				if( xhr.responseText.substring(0, 7) == "success" ){
					var musicPath = xhr.responseText.substring( 8 );
					$("#musicPath").val( musicPath );
					bar.width("100%");  
					percent.html("100%");
					status.html( "File Uploaded Successfully." );
				}else{
					status.html( xhr.responseText );
				}
			}
		}).submit();
	});
	
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
        }
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
var initTable2 = function () {

    var table = $('#sample_2');

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
        }
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
var initTable3 = function () {

    var table = $('#sample_3');

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
        }
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

function onAddVideoUpload(){
	window.location.href="./addVideo.php";
}

function onUploadImage(){
	$("#imageForm").find('input[type=file]').click();
}

function onUploadVideo(){
	$("#musicForm").find('input[type=file]').click();
}
function onCancelVideo(){
	window.location.href = "./frontVideoUpload.php";
}

function onSaveVideo(){
	var videoID = $("#videoID").val();
	var order = $("#order").val();
	if(order == "") { $("#selectVideoError").show(); return;}
	//var imagepath = $('#previewLocationImage').find('img').attr('src');
	var imagepath = "";
	var videopath = $('#musicPath').val();
	if(videopath == "") {$("#videoUploadError").show(); return;}

	$.ajax({
		 url: "./async-saveVideo.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : {imagepath:imagepath,videoID:videoID,videopath:videopath,order:order},
			success : function(data){
				
				if(data.result == "success"){
					$("#videoSucessfullyUpload").show();
					window.location.href = "./frontVideoUpload.php";
				}
				else if(data.result == "update_success"){
					$("#videoSucessfullyUpdate").show();
					window.location.href = "./frontVideoUpload.php"; 
				}
				else if(data.result == "exist" ){
					$("#videoOrderCheckError").show();
					window.location.reload();
				}
				
			}
	});	
}


function onVideoEdit(obj){
	var VideoID = $(obj).parents('tr').eq(0).find("#chkVideoID").eq(0).val();
	window.location.href="./addVideo.php?VideoID="+VideoID;
}

function onVideoDelete(obj){
	var VideoID = $(obj).parents('tr').eq(0).find("#chkVideoID").eq(0).val();
	$.ajax({
		 url: "./async-deleteVideo.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : {VideoID:VideoID},
			success : function(data){
				
				if(data.result == "success"){
					$("#videodeletedSuccess").show();
					window.location.reload();
				}
				
			}
	});	
}


function onAddRssFeed(){
	window.location.href="./addRssFeed.php";
}
function onSaveRssFeed(){
	var RssID = $("#RssID").val();
	var rssFeedUrl = $("#rssFeedUrl").val();
	if(rssFeedUrl == "") {$("#insertRssFeedEmpty").show(); return;}
	$.ajax({
		 url: "./async-saveRssFeed.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : {RssID:RssID,rssFeedUrl:rssFeedUrl},
			success : function(data){
				
				if(data.result == "success"){
					$("#rssFeedSucessfullyUpload").show();
					window.location.reload();
				}
				else if(data.result == "update_success"){
					$("#rssFeedSucessfullyUpdate").show();
					window.location.href='./frontVideoUpload.php';
				}
				else if(data.result == "exist" ){
					$("#existRssFeedUrl").show();
					window.location.reload();
				}
				
			}
	});	
}
function onRssDelete(obj){
	var RssID = $(obj).parents('tr').eq(0).find("#chkRssFeed").eq(0).val();
	$.ajax({
		 url: "./async-deleteRssFeed.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : {RssID:RssID},
			success : function(data){
				
				if(data.result == "success"){
					$("#RssFeedUrlDeleteSuccessfully").show();
					window.location.reload();
				}
				
			}
	});	
}
function onSaveFreeUserQUestionNumber(){
	var freeQuestionNumber = $("#freeQuestionNumber").val();
	$.ajax({
		 url: "./async-saveFreeQuestionNumber.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : {freeQuestionNumber:freeQuestionNumber},
			success : function(data){
				
				if(data.result == "success"){
					$("#freeQuestionNumberSuccessfully").show();
					window.location.reload();
				}else if(data.result == "update"){
					$("#freeQuestionNumberSuccessfully").show();
					window.location.reload();
				}
				
			}
	});	
}
function onCancelFreeUserQuestionNumber(){
	window.location.href="./overview.php";
}
function onRssEdit(obj){
	var RssID = $(obj).parents('tr').eq(0).find("#chkRssFeed").eq(0).val();
	window.location.href="./addRssFeed.php?RssID="+RssID;
}
function onAddAds(){
	window.location.href="./addAds.php";
}
function onSaveAds(){
	var AdsID = $("#AdsID").val();
	var adsUrl= $("#adsUrl").val();
	$.ajax({
		 url: "./async-saveAds.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : {AdsID:AdsID,adsUrl:adsUrl},
			success : function(data){
				
				if(data.result == "success"){
					$("#adsSucessfullyUpload").show();
					window.location.reload();
				}
				else if(data.result == "update_success"){
					$("#adsSucessfullyUpdate").show();
					window.location.href='./frontVideoUpload.php';
				}
				else if(data.result == "exist" ){
					$("#existAdsUrl").show();
					window.location.reload();
				}
				
			}
	});
}
function onAdsEdit(obj){
	var AdsID = $(obj).parents('tr').eq(0).find("#chkAdsID").eq(0).val();
	window.location.href="./addAds.php?AdsID="+AdsID;
}
function onAdsDelete(obj){
	var AdsID = $(obj).parents('tr').eq(0).find("#chkAdsID").eq(0).val();
	$.ajax({
		 url: "./async-deleteAds.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : {AdsID:AdsID},
			success : function(data){
				
				if(data.result == "success"){
					$("#RssFeedUrlDeleteSuccessfully").show();
					window.location.reload();
				}
				
			}
	});	
}