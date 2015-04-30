$(function(){

	var current_date = new Date();

	$("#event-table td").click(function(){		
		var day = $(this).attr("data_day");
		var time = $(this).attr("data_time");
		window.location = "./create_event.php?d="+day+"&t="+time;		
	});
});