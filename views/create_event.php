<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/Event.php");

session_start();
isLogged();
ob_start();

generate_head("Create an event");
?>

<nav>
	<a href="./" class="btn btn-primary">Back to index</a>
</nav>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<h1>Create an event</h1><hr />
		<form role="form" id="form_create_event">
			<div class="form-group">
				<label class="control-label" for="event_name">Name : </label>
				<input class="form-control" id="event_name" type="text" name="name"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="date_event">Date : </label>
				<input class="form-control" id="date_event" type="text" name="name"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_name">Event name : </label>
				<input class="form-control" id="event_name" type="text" name="name"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_name">Event name : </label>
				<input class="form-control" id="event_name" type="text" name="name"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_name">Event name : </label>
				<input class="form-control" id="event_name" type="text" name="name"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_name">Event name : </label>
				<input class="form-control" id="event_name" type="text" name="name"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_name">Event name : </label>
				<input class="form-control" id="event_name" type="text" name="name"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_name">Event name : </label>
				<input class="form-control" id="event_name" type="text" name="name"/>
			</div>
			<input class="form-control btn btn-success" type="submit" value="Create"/>
		</form>
	</div>
</div>


<?php

generate_footer();

ob_end_flush();