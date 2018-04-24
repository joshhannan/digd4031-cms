<?php
	/*
	CMS Admin - Edit Article Template
	 */
	$obj['pageTitle'] = 'Edit Article';
	Admin::get_admin_header();
	$article = '';
	if( isset( $_GET['articleId'] ) ) :
		$article = Article::getById( $_GET['articleId'] );
	endif;
	Article::editArticle();
?>
 <main>
 	<div class="container">
<?php if( !empty( $article ) ) : ?>
 		<h1><?php echo $article->title; ?></h1>
<?php else : ?>
		<h1>New Article</h1>
<?php endif; ?>
 		<form action="admin.php?route=editArticle" method="post">
 			<input type="hidden" name="articleId" value="<?php if( isset( $_GET['articleId'] ) ) : echo $_GET['articleId']; endif; ?>"/>
 <?php
 	if( isset( $results['errorMessage'] ) ) :
		echo '<div class="errorMessage">' . $results['errorMessage'] . '</div>';
	endif;
?>
			<div class="field">
				<label for="title">Article Title</label>
				<input type="text" name="title" id="title" placeholder="Name of the article" required autofocus maxlength="255" value="<?php if(!empty($article->title)) : echo htmlspecialchars( $article->title ); endif; ?>" />
			</div><!--/field-->
			<div class="field">
				<label for="summary">Article Summary</label>
				<textarea name="summary" id="summary" placeholder="Brief description of the article" required maxlength="1000" style="height: 5em;"><?php if(!empty($article->summary)) : echo htmlspecialchars( $article->summary ); endif; ?></textarea>
			</div><!--/field-->
			<div class="field">
				<label for="content">Article Content</label>
				<textarea name="content" id="content" placeholder="The HTML content of the article" required maxlength="100000" style="height: 30em;"><?php if(!empty($article->content)) : echo htmlspecialchars( $article->content ); endif; ?></textarea>
			</div><!--/field-->
			<div class="field">
				<label for="publicationDate">Publication Date</label>
				<input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php if(!empty($article->publicationDate)) : echo date( "Y-m-d", $article->publicationDate ); endif; ?>" />
			</div><!--/field-->
			<div class="buttons buttons-set">
				<input class="button" type="submit" formnovalidate name="cancel" value="Cancel" />
				<input class="button" type="submit" name="saveChanges" value="Save Changes" />
			</div>
		</form>
<?php
	if( !empty( $article->id ) ) :
?>
		<div class="buttons">
			<a class="red button" href="admin.php?route=deleteArticle&amp;articleId=<?php echo $article->id ?>" onclick="return confirm('Delete This Article?')">Delete This Article</a>
		</div><!--/buttons-->
<?php
	endif;
?>
	</div><!--/container-->
</main>
<?php
	Admin::get_admin_footer();
?>