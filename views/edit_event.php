<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/Event.php");

session_start();
isLogged();

ob_start();
generate_head("Edit event");

$is_edit = false;
$event = getEventById(intval($_GET['e']));
$list_users = getAllUsers();

if (isset($_POST['mode']) && $_POST['mode'] == "edit")
{
	unset($_POST['mode']);
	$is_edit = true;
	$event = updateEvent($event, $_POST);
}

?>

<nav>
	<a href="./" class="btn btn-primary">Back to index</a>	
</nav>

<?php 
	if ($is_edit)
	{ ?>
		<div  class="alert alert-success" role="alert">
			<p>Event is correct updated..</p>
		</div>
	<?php }
?>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
	<?php
		if ($event != null){
	?>
	<h1>Edit event</h1><hr />
		<form role="form" id="form_create_event" action="./edit_event.php?e=<?php echo $event->getId() ?>" method="POST">
			<div class="form-group">
				<label class="control-label" for="event_name">Name : </label>
				<input class="form-control" id="event_name" type="text" name="name_event" value="<?php echo $event->getName()?>"/>
			</div>			
			<div class="form-group">
				<label class="control-label" for="date_event">Date : </label>
				<input class="form-control" id="date_event" type="text" name="date_event" value="<?php echo getFormattedDate($event->getDateEvent());?>"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_guests">Event guest : </label>
				<select class="form-control" id="event_guests" name="event_guests[]" multiple>
				<?php
				$userlogged = getLoggedUser();
				$guests = $event->getGuests();
				foreach ($list_users as $username => $user) {
					if ($user != $userlogged)
					{
						echo '<option value="'.$username. '"';
						if (in_array($user, $guests))
							echo " selected ";
						echo '">'.$username.'</option>'. "<br/>";
					}
				}				
				?>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_description">Event description : </label>
				<textarea class="form-control" id="event_description"
					name="event_description"><?php echo $event->getDescription(); ?></textarea>
			</div>
			<input type="hidden" name="mode" value="edit"/>
			<input class="form-control btn btn-success" type="submit" value="Edit"/>
			</form>
			<?php 
				}
				else
					echo "<h1>Event not found</h1>";?>
	</div>
</div>
  

<?php

generate_footer();

ob_end_flush();