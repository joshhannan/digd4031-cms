<?php
	$page = Page::get_page();
	Page::get_header();
	$articles = Article::getList( HOMEPAGE_NUM_ARTICLES );
?>
<main class="homepage">
	<section class="home-banner">
		<div class="slide">
			<div class="image">
				<img class="mobile" src="http://placehold.it/640x500" />
				<img class="tablet" src="http://placehold.it/1538x500" />
				<img class="desktop" src="http://placehold.it/2000x500" />
			</div><!--/image-->
			<div class="content">
			</div><!--/content-->
		</div><!--/slide-->
	</section><!--/home-banner-->
	<section class="intro">
		<div class="container">
			<div class="content">
				<h1>Site Name - Welcome!</h1>
				<p>Donec ullamcorper nulla non metus auctor fringilla. Etiam porta sem malesuada magna mollis euismod. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Curabitur blandit tempus porttitor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
			</div>
		</div><!--/container-->
	</section><!--/intro-->
<?php 
	if( !empty( $articles ) ) :
 ?>
	<section class="articles">
		<div class="container">
			<div class="article-list">
<?php
		foreach( $articles as $article ) :
?>
				<article class="item">
					<header>
						<h2><a href="<?php echo Page::get_url( $article->id ); ?>"><?php echo htmlspecialchars( $article->title )?></a></h2>
					</header>
					<section>
						<p class="summary"><?php echo htmlspecialchars( $article->summary ); ?></p>
					</section>
					<footer>
						<span class="pubDate"><?php echo date('j F', $article->publicationDate); ?></span>
					</footer>
				</article>
<?php
		endforeach;
?>
			</div><!--/article-list-->
			<footer class="article-footer">
				<a class="button" href="./?route=archive">Article Archive</a>
			</footer>
		</div><!--/container-->
	</section><!--/articles-->
<?php
	else :
?>
	<section class="articles no-articles">
		<div class="container">
			<h2>No Articles Found</h2>
		</div><!--/container-->
	</section><!--/no-articles-->
<?php
	endif;
?>
</main>
<?php
	Page::get_footer();
?>