<?php
require_once($_SERVER['DOCUMENT_ROOT']."/project_cloud/core/functions.php");

session_start();

if (isset($_SESSION['user']))
{
    unset($_SESSION['user']);
    session_destroy();
}

ob_start();

generate_head("Login");

?>
	<section>
		<div class="col-lg-6 col-lg-offset-3">
            <section>
                <p>
                    You are logged out successfully ! Thanks :p
                </p>
            </section>
            <hr /><a href="./" class="btn btn-info">Back to index</a>
		</div>
	</section>     
<?php
generate_footer();
ob_end_flush();