<?php
	/*
	CMS Login page template
	 */
	Page::get_header();

	if( Admin::is_logged_in() ) {
		header( 'Location: admin.php' );
	}

	if(isset( $_POST['login'] ) ) {
		Admin::login();
	}
?>
<main>
	<div class="container">
		<form action="" method="post" class="login-form">
			<input type="hidden" name="login" value="true" />
			<section>
				<div class="field">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" placeholder="Your admin username" required autofocus maxlength="20" />
				</div><!--field-->
				<div class="field">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" placeholder="Your admin password" required maxlength="20" />
				</div><!--field-->
			</section>
			<div class="buttons">
				<input class="button" type="submit" name="login" value="Login" />
			</div>
		</form>
	</div><!--/container-->
</main>
<?php
	Page::get_footer();
?>