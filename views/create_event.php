<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/Event.php");

session_start();
isLogged();

$event_date = getReferenceDate();
$ref_date = getFormattedDate();


if (isset($_GET['d'], $_GET['t']))
{	
	$event_date = getDateEvent($_GET['d'], $_GET['t']);
}
else if (isset($_GET['d']) && !isset($_GET['t']))
{
	$event_date = getDateEvent($_GET['d']);
}
else if (!isset($_GET['d']) && isset($_GET['t']))
{
	$event_date = getDateEvent(0, $_GET['t']);
}
else
{
	$event_date = new DateTime();
}

$event_date = getFormattedDate($event_date);

$list_users = getAllUsers();
 
ob_start();
generate_head("Create an event");
 ?>

<nav>
	<a href="./" class="btn btn-primary">Back to index</a>
</nav>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<h1>Create an event</h1><hr />
		<form role="form" id="form_create_event" action="./confirm_event.php" method="POST">
			<div class="form-group">
				<label class="control-label" for="event_name">Name : </label>
				<input class="form-control" id="event_name" type="text" name="event_name" required autofocus/>
			</div>
			<div class="form-group">
				<label class="control-label" for="ref_date">Ref date : </label>
				<input class="form-control" id="ref_date" type="text" readonly value="<?php echo $ref_date?>"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_date">Date : </label>
				<input class="form-control" id="event_date" type="text" name="event_date" required value="<?php echo $event_date?>"/>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_guests">Event guest : </label>
				<select class="form-control" id="event_guests" name="event_guests[]" multiple="true">					
				<?php
				$userlogged = getLoggedUser();
				foreach ($list_users as $username => $user) {
					if ($user != $userlogged)
						echo '<option value="'.$username.'">'.$username.'</option>'. "<br/>";
				}
				?>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="event_description">Event description : </label>
				<textarea class="form-control" id="event_description" name="event_description"></textarea>
			</div>			
			<input class="form-control btn btn-success" type="submit" value="Create"/>
		</form>
	</div>
</div>


<?php

generate_footer();

ob_end_flush();