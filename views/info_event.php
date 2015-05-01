<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/Event.php");

session_start();
isLogged();

ob_start();
generate_head("Info event");
?>

<nav>
	<a href="./" class="btn btn-primary">Back to index</a>
</nav>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<h1>Create an event</h1><hr />
			<div class="form-group">
				<label class="control-label" for="event_name">Name : </label>
				<input class="form-control" id="event_name" type="text" name="name_event" required />
			</div>
			<div class="form-group">
				<label class="control-label" for="date_event">Ref date : </label>
				<input class="form-control" id="date_event" type="text" readonly value=""/>
			</div>
			<div class="form-group">
				<label class="control-label" for="date_event">Date : </label>
				<input class="form-control" id="date_event" type="text" name="date_event" required value="<?php echo $date_event?>"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_guests">Event guest : </label>
				<select class="form-control" id="event_guests" name="event_guests" multiple="true">
				<?php
				// foreach ($list_users as $username => $user) {
				// 	echo '<option name="guests_event" value="' .$username. '">' .$username. '</option>';
				// }
				?>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_description">Event description : </label>
				<textarea class="form-control" id="event_description" name="event_description">
				</textarea>
			</div>
	</div>
</div>
  

<?php

generate_footer();

ob_end_flush();