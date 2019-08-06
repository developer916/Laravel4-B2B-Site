var content = new Array();
var countYear;
var labelList = new Array();
var LabelSimple = new Array();

$(document).ready(function() {    
	 countYear = $("#countYear").val();
 });

function getContent(){
	$.ajax({
        url: "./async-getUserContent.php",
        dataType : "json",
        type : "POST",
        data : { },
        success : function(data){
            if(data.result == "success"){
            	labelList = data.content;
            	chart5();
            }
			
        }
    });	
}


function chart5() {
			
        if ($('#chart_1').size() != 1) {
            return;
        }
	
        var tickets1 =[
                       [0,"JAN"],
                       [1,"FEB"],
                       [2,"MAR"],
                       [3,"APR"],
                       [4,"MAY"],
                       [5,"JUN"],
                       [6,"JUL"],
                       [7,"AUG"],
                       [8,"SEP"],
                       [9,"OCT"],
                       [10,"NOV"],
                       [11,"DEC"]
                     ];
        var stack = 0,
            bars = true,
            lines = false,
            steps = false;

        function plotWithOptions() {
        	for(var j=0; j<countYear; j++){
            	 var d1 = [];
                 for (var i = 0; i <= 11; i += 1)
                     d1.push([i, labelList[j][0][i]]);

                 var d2 = [];
                 for (var i = 0; i <= 11; i += 1)
                     d2.push([i, labelList[j][1][i]]);

                 var d3 = [];
                 for (var i = 0; i <= 11; i += 1)
                     d3.push([i,labelList[j][2][i]]);
                $.plot($("#chart_"+(j*1+1)),
                	
                    [{
                        label: "Pass",
                        data: d1,
                        lines: {
                            lineWidth: 1,
                        },
                        shadowSize: 0
                    }, {
                        label: "Fail",
                        data: d2,
                        lines: {
                            lineWidth: 1,
                        },
                        shadowSize: 0
                    }, {
                        label: "100%",
                        data: d3,
                        lines: {
                            lineWidth: 1,
                        },
                        shadowSize: 0
                    }]
                    , {
                        series: {
                            stack: stack,
                            bars: {
                                show: bars,
                                barWidth: 0.5,
                                lineWidth: 0, // in pixels
                                shadowSize: 0,
                                align: 'center'
                            }
                        },bars: {
                            align: "center",
                            barWidth: 0.5
                        }
                        ,
	                    xaxis: {
	                        axisLabel: "World Cities",
	                        axisLabelUseCanvas: true,
	                        axisLabelFontSizePixels: 12,
	                        axisLabelFontFamily: 'Verdana, Arial',
	                        axisLabelPadding: 10,
	                        ticks: tickets1
	                    },
	                    yaxis: {
	                        axisLabel: "Average Temperature",
	                        axisLabelUseCanvas: true,
	                        axisLabelFontSizePixels: 12,
	                        axisLabelFontFamily: 'Verdana, Arial',
	                        axisLabelPadding: 3
	                    },
                        grid: {
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    }
                );
        	}
       }
        plotWithOptions();
    }