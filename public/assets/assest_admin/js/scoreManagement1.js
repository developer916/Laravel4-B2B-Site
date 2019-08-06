var content = new Array();
var countYear;
var labelList = new Array();
var LabelSimple = new Array();
var passRate;
var failRate;

$(document).ready(function() {    
	loadingGetContent();
 });
function loadingGetContent(){
	var scoreType= 0;
	$.ajax({
        url: "./async-getUserContentTestScore.php",
        dataType : "json",
        type : "POST",
        data : { scoreType:scoreType},
        success : function(data){
            if(data.result == "success"){
            	passRate = data.pass;
            	failRate = data.fail;
            	chartshow();
            }
			
        }
    });	
}
function chartshow(){
	 var chart = AmCharts.makeChart("chart_6", {
         "type": "pie",
         "theme": "light",

         "fontFamily": 'Open Sans',
         
         "color":    '#888',

         "dataProvider": [{
             "country": "Pass",
             "litres": passRate
         }, {
             "country": "Fail",
             "litres": failRate
         }],
         "valueField": "litres",
         "titleField": "country",
         "exportConfig": {
             menuItems: [{
                 icon: Metronic.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                 format: 'png'
             }]
         }
     });

     $('#chart_6').closest('.portlet').find('.fullscreen').click(function() {
         chart.invalidateSize();
     });
}
function getContent(){
	var scoreType = $("#scoreType").val();
	$.ajax({
        url: "./async-getUserContentTestScore.php",
        dataType : "json",
        type : "POST",
        data : { scoreType:scoreType},
        success : function(data){
            if(data.result == "success"){
            	passRate = data.pass;
            	failRate = data.fail;
            	chartshow();
            }
			
        }
    });	
}


