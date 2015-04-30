<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/Event.php");

session_start();
isLogged();
ob_start();

$date_event = getReferenceDate();
$ref_date = getFormattedDate();

generate_head("Create an event");
?>

<?php
if (isset($_GET['d'], $_GET['t']))
{	
	$date_event = getDateEvent($_GET['d'], $_GET['t']);
}
else if (isset($_GET['d']) && !isset($_GET['t']))
{
	$date_event = getDateEvent($_GET['d']);
}
else if (!isset($_GET['d']) && isset($_GET['t']))
{
	$date_event = getDateEvent(0, $_GET['t']);
}
else
{
	$date_event = new DateTime();
}

$date_event = getFormattedDate($date_event);
 
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
				<input class="form-control" id="event_name" type="text" name="name" />
			</div>
			<div class="form-group">
				<label class="control-label" for="date_event">Ref date : </label>
				<input class="form-control" id="date_event" type="text" name="date_event" value="<?php echo $ref_date?>"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="date_event">Date : </label>
				<input class="form-control" id="date_event" type="text" name="date_event" value="<?php echo $date_event?>"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_guest">Event guest : </label>
				<select class="form-control" id="event_guest" name="guest" multiple="true">
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_description">Event description : </label>
				<textarea class="form-control" id="event_description" name="description">
				</textarea>
			</div>			
			<input class="form-control btn btn-success" type="submit" value="Create"/>
		</form>
	</div>
</div>


<?php

generate_footer();

ob_end_flush();