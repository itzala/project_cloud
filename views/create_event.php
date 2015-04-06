<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

ob_start();

generate_head("Create an event");

?>

	<nav>
		<a href="./" class="btn btn-primary">Back to index</a>
	</nav>

	<form>
		<div class="form-group">
			<label for="event_name">Name : </label>
			<input id="event_name" type="text" class="" name="name"/>
		</div>
		<div class="form-group">
			<label for="date_event">Date : </label>
			<input id="date_event" type="text" class="" name="name"/>
		</div>
		<div class="form-group">
			<label for="event_name">Event name : </label>
			<input id="event_name" type="text" class="" name="name"/>
		</div>
		<div class="form-group">
			<label for="event_name">Event name : </label>
			<input id="event_name" type="text" class="" name="name"/>
		</div>
		<div class="form-group">
			<label for="event_name">Event name : </label>
			<input id="event_name" type="text" class="" name="name"/>
		</div>
		<div class="form-group">
			<label for="event_name">Event name : </label>
			<input id="event_name" type="text" class="" name="name"/>
		</div>
		<div class="form-group">
			<label for="event_name">Event name : </label>
			<input id="event_name" type="text" class="" name="name"/>
		</div>
		<div class="form-group">
			<label for="event_name">Event name : </label>
			<input id="event_name" type="text" class="" name="name"/>
		</div>
		<input type="submit" value="Create" class="btn btn-success"/>
	</form>


<?php
generate_footer();
ob_end_flush();