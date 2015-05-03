<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/database.php");

session_start();
isLogged();
ob_start();

generate_head("Search");

$user = getLoggedUser();

//Verification 
if (isset($_POST['send'])) {
	$event = getAllEvents(array('name'=>$_POST['event']));
	$event = $event[0];
	if($event){
		header("Location:./views/info_event.php?e="$event=>getId());
	}else{
		echo 'No event found';
	}

?>
<nav>
	<a href="./" class="btn btn-info">Back to index</a>
</nav>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<h1>Search</h1><hr />
		<form class="form-horizontal" id="recherche" name ="find" method="post" 
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="control-group">
				<label class="control-label" for="login">Event name:</label>
			<div class="controls">
	        	<input type="text" class="form-control" placeholder="Event name" required  name="event">
			</div><hr />
			<div class="control-group">
				<div class="controls">
			        <button class="btn btn-lg btn-primary" type="submit" name="send" value ="send">Search</button>
				</div>
			</div>
		</form>
	</div>
</div>