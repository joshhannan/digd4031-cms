<?php
	/*
	CMS Admin - Edit Page Template
	 */
	$obj['pageTitle'] = 'Edit Page';
	Admin::get_admin_header();
	$page = '';
	if( !empty( $_GET['pageId'] ) ) :
		$page = Page::getById( $_GET['pageId'] );
		var_dump( $page );
	endif;
	Page::editPage();

?>
 <main>
 	<div class="container">
<?php if( !empty( $page ) ) : ?>
 		<h1><?php echo $page->title; ?></h1>
<?php else : ?>
		<h1>New Page</h1>
<?php endif; ?>
 		<form action="admin.php?route=editPage" method="post">
 			<input type="hidden" name="pageId" value="<?php if( isset( $_GET['pageId'] ) ) : echo $_GET['pageId']; endif; ?>"/>
 <?php
 	if( isset( $obj['errorMessage'] ) ) :
		echo '<div class="errorMessage">' . $obj['errorMessage'] . '</div>';
	endif;
?>
			<div class="field">
				<label for="title">Page Title</label>
				<input type="text" name="title" id="title" placeholder="Name of the page" required autofocus maxlength="255" value="<?php if(!empty($page->title)) : echo htmlspecialchars( $page->title ); endif; ?>" />
			</div><!--/field-->
			<div class="field">
				<label for="page-slug">Page URL</label>
				<input type="text" name="slug" id="slug" placeholder="page-slug" required autofocus maxlength="255" value="<?php if(!empty($page->slug)) : echo htmlspecialchars( $page->slug ); endif; ?>" />
			</div><!--/field-->
			<div class="field">
				<label for="template">Page Template</label>
<?php
	if( !empty( $page->template ) ):
		$template = $page->template;
	else :
		$template = '';
	endif;
?>
				<select name="template" id="template">
					<option value="home"<?php if( !empty($template) && $template === 'home' ) : echo ' selected="selected"'; endif; ?>>Home</option>
					<option value="about"<?php if( !empty($template) && $template === 'about' ) : echo ' selected="selected"'; endif; ?>>About</option>
					<option value="articles"<?php if( !empty($template) && $template === 'articles' ) : echo ' selected="selected"'; endif; ?>>Articles</option>
					<option value="contact"<?php if( !empty($template) && $template === 'contact' ) : echo ' selected="selected"'; endif; ?>>Contact</option>
				</select>
			</div><!--/field-->
			<div class="field">
				<label for="summary">Page Summary</label>
				<textarea name="summary" id="summary" placeholder="Brief description of the page" required maxlength="1000" style="height: 5em;"><?php if(!empty($page->summary)) : echo htmlspecialchars( $page->summary ); endif; ?></textarea>
			</div><!--/field-->
			<div class="field">
				<label for="content">Page Content</label>
				<textarea name="content" id="content" placeholder="The HTML content of the page" required maxlength="100000" style="height: 30em;"><?php if(!empty($page->content)) : echo htmlspecialchars( $page->content ); endif; ?></textarea>
			</div><!--/field-->
			<div class="field">
				<label for="publicationDate">Publication Date</label>
				<input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php if(!empty($page->publicationDate)) : echo date( "Y-m-d", $page->publicationDate ); endif; ?>" />
			</div><!--/field-->
			<div class="buttons buttons-set">
				<input class="button" type="submit" formnovalidate name="cancel" value="Cancel" />
				<input class="button" type="submit" name="saveChanges" value="Save Changes" />
			</div>
		</form>
<?php
	if( !empty( $page->id ) ) :
?>
		<div class="buttons">
			<a class="button" href="admin.php?route=deletePage&amp;pageId=<?php echo $page->id; ?>" onclick="return confirm('Delete This Page?')">Delete This Page</a>
		</div><!--/buttons-->
<?php
	endif;
?>
	</div><!--/container-->
</main>
<?php
	Admin::get_admin_footer();
?>