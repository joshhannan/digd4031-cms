<?php
	/*
	CMS Admin - List Pages Template
	 */
	Page::get_admin_header();
	$pages = Page::getList();
	$count = count( $pages );
?>
<main class="admin-template">
	<div class="container">
		<h1>All Pages</h1>
		<table>
			<tr>
				<th>Publication Date</th>
				<th>Page</th>
			</tr>
<?php
	if( !empty( $pages ) ) :
		foreach( $pages as $page ) :
?>
			<tr onclick="location='admin.php?page=editPage&amp;pageId=<?php echo $page->id?>'">
				<td><?php echo date('j M Y', $page->publicationDate); ?></td>
				<td><?php echo $page->title; ?></td>
			</tr>
<?php
		endforeach;
	endif;
?>
		</table>
		<p><?php echo $count; ?> page<?php echo ( $count != 1 ) ? 's' : '' ?> in total.</p>
		<p><a href="admin.php?page=newPage">Add a New Page</a></p>
	</div><!--/container-->
</main>
<?php
	Page::get_admin_footer();
?>