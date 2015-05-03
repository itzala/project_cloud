<?php

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/database.php");

require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/objects/Event.php");

session_start();
isLogged();

ob_start();
generate_head("Confirm event");
$new_event = addEvent($_POST);
//$list_events = getAllEvents();
?>
<section>
		<div class="col-lg-6 col-lg-offset-3">
		<label>List of events</label>	
		<ul>
			<?php 
				// foreach ($list_events as $event) {
				// 	echo '<li>event <a href="./info_event.php?e='. $event->getId().'">#"'
				// 	 .$event->getId(). '"</a> => '.$event->getName().'</li>';
				// }
			?>
		</ul>
            <section>
                <p>
                    This event is created ! Thanks :p
                </p>
                <p>
                	Click <a href="./info_event.php?e=<?php echo $new_event->getId();?>"> here </a> to see details
                </p>
            </section>
            <hr /><a href="./" class="btn btn-info">Back to index</a>
		</div>
	</section>   

<?php

generate_footer();

ob_end_flush();