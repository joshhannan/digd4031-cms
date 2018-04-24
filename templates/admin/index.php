<?php
	/*
	Default Template
	 */
	$obj['pageTitle'] = 'Dashboard';
	Admin::get_admin_header();
?>
<main class="default-template">
	<div class="container">
		<h1>DASHBOARD</h1>
		<p>Welcome!</p>
<?php
	$articles = Article::getList();
	$count = count($articles);
	if( !empty( $articles ) ) :
?>
		<h2>Articles</h2>
		<table>
			<tr>
				<th>Publication Date</th>
				<th>Article</th>
			</tr>
<?php
		foreach( $articles as $article ) :
?>
			<tr onclick="location='admin.php?route=editArticle&amp;articleId=<?php echo $article->id; ?>'">
				<td><?php echo date('j M Y', $article->publicationDate); ?></td>
				<td><?php echo $article->title; ?></td>
			</tr>
<?php
		endforeach;
?>
		</table>
		<p><?php echo $count; ?> article<?php echo ( $count != 1 ) ? 's' : '' ?> in total.</p>
		<p><a href="admin.php?route=newArticle">Add a New Article</a></p>
<?php
	endif;
?>
		<h2>Pages</h2>
<?php
	$pages = Page::getList();
	$count = count( $pages );
	if( !empty( $pages ) ) :
?>
		<table>
			<tr>
				<th>Publication Date</th>
				<th>Page</th>
			</tr>
<?php
		foreach( $pages as $page ) :
?>
			<tr onclick="location='admin.php?route=editPage&amp;pageId=<?php echo $page->id; ?>'">
				<td><?php echo date('j M Y', $page->publicationDate); ?></td>
				<td><?php echo $page->title; ?></td>
			</tr>
<?php
		endforeach;
?>
		</table>
		<p><?php echo $count; ?> page<?php echo ( $count != 1 ) ? 's' : '' ?> in total.</p>
<?php
	else :
		echo 'No Pages Found';
	endif;
?>
		<p><a href="admin.php?route=newPage">Add a New Page</a></p>
	</div><!--/container-->
</main><!--/default-template-->
<?php
	Admin::get_admin_footer();
?>