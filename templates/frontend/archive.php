<?php
	/*
	Article Archive Template
	 */
	Page::get_header();
	$articles = Article::getList();
	$count = count( $articles );
?>
<main class="article-archive">
	<div class="container">
		<h1>Article Archive</h1>
<?php
	if( !empty( $articles ) ) :
?>
		<section class="archive-list">
<?php
		foreach ( $articles as $article ) :
?>
			<article class="item">
				<header>
					<h2><a href="single-article.php?articleId=<?php echo $article->id; ?>"><?php echo htmlspecialchars( $article->title )?></a></h2>
				</header>
				<section>
					<p class="summary"><?php echo htmlspecialchars( $article->summary )?></p>
				</section>
				<footer>
					<span class="pubDate"><?php echo date('j F Y', $article->publicationDate)?></span>
				</footer>
			</article><!--/item-->
<?php
		endforeach;
?>
		</section><!--/archive-list-->
		<footer class="archive-footer">
			<p><?php echo $count; ?> article<?php echo ( $count != 1 ) ? 's' : '' ?> in total.</p>
			<a class="button" href="<?php echo Page::get_url(); ?>">Return to Homepage</a>
		</footer>
<?php
	else :
		echo '<h2>No Articles Found.</h2>';
	endif;
?>
	</div><!--/container-->
</main><!--/article-archive-->
<?php
	Page::get_footer();
?>