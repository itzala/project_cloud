<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

session_start();
//isLogged();
$ref_date = getFormattedDate();
$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$columns = $days;
$nb_columns = count($columns);
$nb_lines = 24;//count($lines);
$current_day = date('w');

ob_start();

$js = array("js/event");

generate_head("List of event", $js);

$date = new DateTime();
echo "Date de référence : ".$ref_date."<br/>";
echo "Date du jour : ".date("d/m/Y H:i")." <br/>";

?>
	<nav>	
	<?php if (!isset($_SESSION['user'])){ ?>
		<a href="./login.php" class="btn btn-primary">Log in</a>
	<?php }else {?>
		<a href="./profile.php">Logged as <?php echo $_SESSION['user']->getUsername(); ?></a>
		<a href="./logout.php" class="btn btn-primary">Log out</a>		
		<a href="./reset_session.php" class="btn btn-primary">Reset session</a>		
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
				    		foreach ($columns as $i => $col) {
				    			echo "<th ";
				    			if ($i < $current_day)
				    				$day = date("d/m", strtotime("last ".$col));
				    			else if ($i > $current_day)
				    				$day = date("d/m", strtotime("next ".$col));
				    			else 
				    				$day = date("d/m");				    			
				    			echo ">".$col." " . $day. "</th>\n";
				    		}
				    	?>
				    	</tr>
					</thead>
					<tbody>
				    	<?php
				    	for ($i=0; $i < $nb_lines; $i++) { 
				    		echo "<tr><th>".$i.":00</th>";
				    		for ($j=0; $j < $nb_columns ; $j++) { 
				    			echo "<td data_day='$j' data_time='$i:00'></td>";
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