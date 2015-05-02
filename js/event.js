$(function(){

	var current_date = new Date();

	$("#event-table td").click(function(e){		
		var day = $(this).attr("data_day");
		var time = $(this).attr("data_time");
		e.preventDefault();
		console.log(e);
		console.log("this.length : " + $(this).length);
		//window.location = "./create_event.php?d="+day+"&t="+time;		
	});

	$(".event_box a").click(function(e){
		console.log($(this));
		e.preventDefault();

	});
});