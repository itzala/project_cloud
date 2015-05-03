<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/database.php");

session_start();
//isLogged();
$ref_date = getReferenceDate();
$ref_date_formatted = getFormattedDate();
$calendar_date = clone $ref_date;
$nb_columns = 7;//count($columns);
$nb_lines = 24;//count($lines);

ob_start();

$js = array("js/event");
//$css = array("css/event");

generate_head("List of event", $js);

$date = new DateTime();
$current_day = date('w');
$displayed_events = getDisplayedEvents();

echo "<p> Date de référence : ".$ref_date_formatted."<br/></p>";
echo "<p> Date du jour : ".date("d/m/Y H:i")." <br/></p>";
echo "<p> Nombre d'évènements : ".$displayed_events['count']." <br/></p>";

$style_event = 'style="display:inline-block; width:90%; border:1px solid black; text-align:center;"';
$style_cell = 'style="display:inline-block; width:10%; border:1px solid red;"';

?>
	<nav>	
	<?php if (($user = getLoggedUser()) == null){ ?>
		<a href="./login.php" class="btn btn-primary">Log in</a>
		<a href="./register.php" class="btn btn-primary">Register</a>
	<?php }else {?>
		<a href="./profile.php">Logged as <?php echo $user->getUsername(); ?></a>
		<a href="./logout.php" class="btn btn-primary">Log out</a>		
		<a href="./reset_session.php?rd=1&e=1" class="btn btn-primary">Reset session</a>
	<?php 		
		}?>
	</nav>	
    <section>
    	<form>
    		<a href="./create_event.php" class="btn btn-default">Create a new event</a>
    		<a href="./profile.php" class="btn btn-default">See profile</a>
    	</form>
    </section>
    <div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<ul class="pager">
				<li class="previous"><a href="change_refdate.php?d=-1"><span aria-hidden="true">&larr;</span> Older</a></li>
				<li class="next"><a href="change_refdate.php?d=1">Newer <span aria-hidden="true">&rarr;</span></a></li>
			</ul>
    	</div>
    </div>
    <div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		    <section>
			    <table id="event-table" class="table table-hover table-condensed table-bordered">
				    <thead>
				    	<tr>
				    	<th></th>
				    	<?php
				    		for ($i=0; $i < $nb_columns ; $i++) {
				    			echo "<th>".$calendar_date->format("D d/m")."</th>\n";
				    			$calendar_date->modify("+1 day");
				    		}
				    	?>
				    	</tr>
					</thead>
					<tbody>
				    	<?php					    
				    	$calendar_date = clone $ref_date;
				    	for ($i=0; $i < $nb_lines; $i++) {
				    		$calendar_time = $calendar_date->format("H:i");
				    		echo "<tr><th>".$calendar_time."</th>";
				    		for ($j=0; $j < $nb_columns ; $j++) { ?>
								<td>
								 <?php /*<!-- <div class="event_cell" data_day="<?php echo $j; ?>" data_time="<?php echo $calendar_time; ?>"
								  <?php echo $style_cell?>></div> -->
								 <!-- <a href="./create_event.php?d=<?php echo $j.'&t='.$calendar_time; ?>"  style="display:block;">Create</a> -->
								 */ ?>
				    			<?php 
				    			$event_day = $calendar_date->format("d/m");
				    			if (isset($displayed_events[$event_day][$calendar_time]))
				    			{
					    			foreach ($displayed_events[$event_day][$calendar_time] as $event) { ?>
					    				<div class="event_box" <?php echo $style_event ?> >
											<span>
												<a href="./info_event.php?e=<?php echo $event->getId();?>">
													<?php echo $event->getName() ?>
												</a>
											</span>
											<div>												
												<a href="./edit_event.php?e=<?php echo $event->getId(); ?>">
													<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
												</a>
											</div>
											<div>
												<a href="./remove_event.php?e=<?php echo $event->getId();?>">												
													<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
												</a>
											</div>
										</div>					    				
					    			<?php }
				    			}
				    			echo '</td>';
				    			$calendar_date->modify("+1 day");
				    		}
				    		$calendar_date = clone $ref_date;
				    		$calendar_date->setTime($i+1,0);
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