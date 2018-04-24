<?php
	/*
	CMS Admin - List Article Template
	 */
	/*
	Admin::get_admin_header();
	$articles = Article::getList();
	$count = count( $articles );
?>
<main class="admin-template">
	<div class="container">
		<h1>All Articles</h1>
		<table>
			<tr>
				<th>Publication Date</th>
				<th>Article</th>
			</tr>
<?php
	if( !empty( $articles ) ) :
		foreach( $articles as $article ) :
?>
			<tr onclick="location='admin.php?page=editArticle&amp;articleId=<?php echo $article->id?>'">
				<td><?php echo date('j M Y', $article->publicationDate)?></td>
				<td><?php echo $article->title?></td>
			</tr>
<?php
		endforeach;
	endif;
?>
		</table>
		<p><?php echo $count; ?> article<?php echo ( $count != 1 ) ? 's' : '' ?> in total.</p>
		<p><a href="admin.php?page=newArticle">Add a New Article</a></p>
	</div><!--/container-->
</main>
<?php
	Admin::get_admin_footer();
	*/
?>