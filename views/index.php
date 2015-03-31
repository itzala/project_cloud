<?php

require($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$columns = $days;
$nb_columns = count($columns);
$nb_lines = 24;//count($lines);

ob_start();

generate_head("List of event");

?>
	<nav>
		<a href="./login.php" class="btn btn-primary">Log in</a>
	</nav>
    <section>
    	<form>
    		
    	</form>
    </section>
	    <section>
		    <table class="table table-hover table-condensed table-bordered">
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

<?php
generate_footer();
ob_end_flush();