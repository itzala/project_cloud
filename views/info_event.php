<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/database.php");

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/Event.php");

session_start();
isLogged();

ob_start();
generate_head("Info event");

$event = getEventById(intval($_GET['e']));
if ($event == null)
{
	echo "EVENT NULL<br/>";
}

?>

<nav>
	<a href="./" class="btn btn-primary">Back to index</a>
	<a href="./edit_event.php?e=<?php echo $event->getId()?>" class="btn btn-warning">Edit this event</a>
</nav>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<h1>Info event</h1><hr />
			<div class="form-group">
				<label class="control-label" for="event_name">Name : </label>
				<input class="form-control" id="event_name" type="text" name="name_event" readonly value="<?php echo $event->getName()?>"/>
			</div>			
			<div class="form-group">
				<label class="control-label" for="date_event">Date : </label>
				<input class="form-control" id="date_event" type="text" name="date_event" readonly value="<?php echo getFormattedDate($event->getDateEvent());?>"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_guests">Event guest : </label>
				<select class="form-control" id="event_guests" name="event_guests" readonly>
				<?php
				foreach ($event->getGuests() as $id => $guest) {
					echo '<option name="guests_event" value="' .$id. '">' .$guest->getUsername(). '</option>';
				}
				?>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_description">Event description : </label>
				<textarea class="form-control" id="event_description"
					name="event_description" readonly><?php echo $event->getDescription(); ?></textarea>
			</div>
	</div>
</div>
  

<?php

generate_footer();

ob_end_flush();