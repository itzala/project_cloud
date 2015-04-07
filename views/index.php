<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

session_start();
//isLogged();
$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$columns = $days;
$nb_columns = count($columns);
$nb_lines = 24;//count($lines);

ob_start();

$js = array("js/event");

generate_head("List of event", $js);

?>
	<nav>
	<?php if (!isset($_SESSION['user'])){ ?>
		<a href="./login.php" class="btn btn-primary">Log in</a>
	<?php }else {?>
		<a href="./profile.php">Logged as <?php echo $_SESSION['user']->getUsername(); ?></a>
		<a href="./logout.php" class="btn btn-primary">Log out</a>
		<?php }?>
	</nav>
    <section>
    	<form>
    		<a href="./create_event.php" class="btn btn-default">Create a new event</a>
    		<a href="./profile.php" class="btn btn-default">See profile</a>
    	</form>
    </section>
    <div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		    <section>
			    <table id="event-table" class="table table-hover table-condensed table-bordered">
				    <thead>
				    	<tr>
				    	<th></th>
				    	<?php
				    		foreach ($columns as $col) {
				    			echo "<th>".$col."</th>\n";
				    		}
				    	?>
				    	</tr>
					</thead>
					<tbody>
				    	<?php
				    	for ($i=0; $i < $nb_lines; $i++) { 
				    		echo "<tr><th>".$i."</th>";
				    		for ($j=0; $j < $nb_columns ; $j++) { 
				    			echo "<td></td>";
				    		}
				    		echo "</tr>\n";
				    	}
				    	?>
				    </tbody>
			    </table>
		    </section>
		</div>
	</div>

<?php
generate_footer();
ob_end_flush();