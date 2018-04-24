<?php
	/*
	Single Article Template
	 */
	Page::get_header();
	$articleId = $_GET['articleId'];
	$article = Article::getById( $articleId );
?>
<main class="article-view-template">
	<div class="container">
		<article class="single-item">
			<h1><?php echo htmlspecialchars( $article->title )?></h1>
			<div><?php echo htmlspecialchars( $article->summary )?></div>
			<div><?php echo $article->content?></div>
			<p class="pubDate">Published on <?php echo date('j F Y', $article->publicationDate)?></p>
		</article>
		<section class="archive-footer">
			<a class="button" href="./">Return to Homepage</a>
		</section>
	</div>
</main>
<?php
	Page::get_footer();
?>