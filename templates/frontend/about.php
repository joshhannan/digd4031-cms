<?php
	/*
	Article About Us Template
	 */
	$page = Page::get_page();
	$data = $page['data'];
	Page::get_header();
?>
<main class="default-template">
	<div class="container">
		<h1><?php echo $data['title']; ?></h1>
		<?php echo $data['content']; ?>
	</div><!--/container-->
</main><!--/default-template-->
<?php
	Page::get_footer();
?>