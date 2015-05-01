<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

session_start();

if (isset($_GET['rd'], $_SESSION['ref_date']) && $_GET['rd'])
{
	setReferenceDate();
}

if (isset($_GET['e']) && $_GET['e'])
{
    removeAllEvents();
}

ob_start();

generate_head("Login");

?>
	<section>
		<div class="col-lg-6 col-lg-offset-3">
            <section>
                <p>
                    The "reference date is reset..."
                </p>
            </section>
            <hr /><a href="./" class="btn btn-info">Back to index</a>
		</div>
	</section>     
<?php
generate_footer();
ob_end_flush();