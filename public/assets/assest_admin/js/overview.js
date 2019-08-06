var zipcodeList = new Array();
var base_url = window.location.origin+"/admin/images";
var revenueList = new Array();
var totalreveneList;
jQuery(document).ready(function() {     
	initialize();
	getContent();
});

function initialize() {
  var mapOptions = {
    zoom:3,
    center: new google.maps.LatLng(35.11934, -89.939),
	mapTypeId: google.maps.MapTypeId.ROADMAP
	
  };
map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
 }


function getContent(){
	$.ajax({
        url: "./async-getUserZip.php",
        dataType : "json",
        type : "POST",
        data : { },
        success : function(data){
            if(data.result == "success"){
            	zipcodeList = data.content;
            	onShowUserZip();
            }
        }
    });
}

function getRevenuePrice(){
	$.ajax({
        url: "./async-getRevenuePrice.php",
        dataType : "json",
        type : "POST",
        data : { },
        success : function(data){
            if(data.result == "success"){
            	revenueList = data.content;
            	totalreveneList = data.totalContent;
            	$("#totalRevenue").text("$"+totalreveneList);
            	Index.initCharts(); // init index page's custom scripts
        	   Index.initChat();
        	   Index.initMiniCharts();
            }
        }
    });
}

function onShowUserZip(){
	for(var i=0; i<zipcodeList.length; i++){
		var myLatlng = new google.maps.LatLng( zipcodeList[i]['UserLatitude'], zipcodeList[i]['UserLongitude']);
		var marker = new google.maps.Marker({
			  position: myLatlng,
			  map: map,
			  icon: base_url + '/markerBucket.png',
			  title: zipcodeList[i]['UserName']
			});
	} 
	
}