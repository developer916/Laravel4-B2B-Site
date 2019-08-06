var Calendar = function() {

	var fnDateToString = function ( date ) {
		function pad( num ) {
			num = num + '';
			return num.length < 2 ? '0' + num : num;
		}
		return date.getFullYear() + '-' +
		        pad(date.getMonth() + 1) + '-' +
		        pad(date.getDate()) + ' ' +
		        pad(date.getHours()) + ':' +
		        pad(date.getMinutes()) + ':' +
		        pad(date.getSeconds());
	};
    return {
        //main function to initiate the module
        init: function() {
            Calendar.initCalendar();
        },
        
        saveCalendar: function () {
        	console.log ( 'save calendar');
        	var events = $('#calendar').fullCalendar('eventSources');
        	console.log ( events );
        }, 

        initCalendar: function() {

            if (!jQuery().fullCalendar) {
                return;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var h = {};

            if (Metronic.isRTL()) {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        right: 'title, prev, next',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        right: 'title',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today, prev,next'
                    };
                }
            } else {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month,agendaWeek,agendaDay'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }

            var initDrag = function(el) {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim(el.text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                el.data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                el.draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            };

            var addEvent = function(title) {
                title = title.length === 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default">' + title + '</div>');
                jQuery('#event_box').append(html);
                initDrag(html);
            };

            $('#external-events div.external-event').each(function() {
                initDrag($(this));
            });

            $('#event_add').unbind('click').click(function() {
                var title = $('#event_title').val();
                addEvent(title);
            });

            //predefined events
            $('#event_box').html("");

            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            var calendar = $('#calendar').fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/ 
                slotMinutes: 15,
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function ( start, end, allDay ) {
                	var title;
                	bootbox.prompt("Event Title:", function(result) {
                		if (result =="") {                                             
                		   $("#alertShow").find("span").text("Please insert your event title");     
                		   $("#eventDeleteSuccessfully").hide();
                		   $("#alertShow").show();
	                		   var a = $("<a>")
	                		    .attr("href", "#basicInsertUrl")
	                		    .attr("data-toggle","modal")
	                		    .appendTo("body");
	
	                			a[0].click();
	
	                			a.remove();
                		  } else if(result == null){
                			  
                		  }else{
                			   title = result;
                			   var strStart = moment(start).format('YYYY-MM-DD, HH:mm:ss');
                       		   var strEnd = moment(end).subtract(1, 'seconds').format('YYYY-MM-DD, HH:mm:ss');
                       		   var url ="";
		                       		$.ajax({
		                    			url: 'async-saveEvents.php',
		                    			data: { title: title, url: url, start: strStart, end: strEnd },
		                    			type: "POST",
		                    			success: function(json) {
		                    				calendar.fullCalendar('renderEvent',
		            	                		{
		            	                			title: title,
		            	                			start: start,
		            	                			end: end,
		            	                			allDay: allDay,
		            	                			id: json
		            	                		},
		            	                		true // make the event "stick"
		                            		);
		                    			}
		                    		});
		                    		
		                    	calendar.fullCalendar('unselect');
		                		  }
                	});
                	
                },
                eventRender: function(event, element, view) {
                	if (event.allDay === 'true') {
                		event.allDay = true;
                	} else {
                		event.allDay = false;
                	}
                },
                eventClick: function(event) {
                	bootbox.confirm("Do you really want to do that?", function(decision) {
                		if (decision) {
                    		$.ajax({
                    			type: "POST",
                    			url: "async-deleteEvents.php",
                    			data: {id: event.id},
                    		});
                    		calendar.fullCalendar('removeEvents', event.id);
 	                			window.location.reload();
                    	} else {
                    		window.location.reload();
                    	}
                    	return false;
                	});
                },
                events: "async-getEvents.php",
                eventDrop: function ( event, data) {
                	var strStart = moment(event.start).format('YYYY-MM-DD, HH:mm:ss');
                	var strEnd = '';
                	if ( event.end == null ) {
                		strEnd = moment(event.start).add( 3, 'hours').format('YYYY-MM-DD, HH:mm:ss');
                	}else {
                		strEnd = moment(event.end).format('YYYY-MM-DD, HH:mm:ss');
                	}
                	 $.ajax({
                		 url: 'async-updateEvents.php',
                		 data: {title: event.title, start: strStart, end: strEnd, id: event.id},
                		 type: "POST",
                		 success: function(json) {
                		 }
                	 });
                },
                eventResize: function ( event ) {
                	var strStart = moment(event.start).format('YYYY-MM-DD, HH:mm:ss');
                	var strEnd = '';
                	if ( event.end == null ) {
                		strEnd = moment(event.start).add( 3, 'hours').format('YYYY-MM-DD, HH:mm:ss');
                	}else {
                		strEnd = moment(event.end).format('YYYY-MM-DD, HH:mm:ss');
                	}
                	alert(event.id);
                	alert(strStart);
                	alert(strEnd);
                	 $.ajax({
                		 url: 'async-updateEvents.php',
                		 data: {title: event.title, start: strStart, end: strEnd, id: event.id},
                		 type: "POST",
                		 success: function(json) {
                		 }
                	 });
                },
            });

        }

    };

}();


var Example = (function() {
    "use strict";

    var elem,
        hideHandler,
        that = {};

    that.init = function(options) {
        elem = $(options.selector);
    };

    that.show = function(text) {
        clearTimeout(hideHandler);

        elem.find("span").html(text);
        elem.delay(200).fadeIn().delay(4000).fadeOut();
    };

    return that;
}());