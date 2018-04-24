<?php
	/*
	Default Template
	 */
	Page::get_header();
?>
<main class="default-template">
	<div class="container">
		<h1>Default Page</h1>
<?php
	echo '<pre>';
	var_dump( $obj );
	echo '</pre>';
?>
	</div><!--/container-->
</main><!--/default-template-->
<?php
	Page::get_footer();
?>