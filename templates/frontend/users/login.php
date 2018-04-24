<?php
	/*
		User Login Template
	*/
	Page::get_header();
	User::login_user();
?>
	<form method="post" action="login.php">
		<div class="field">
			<label>Username</label>
			<input type="text" name="username" >
		</div>
		<div class="field">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="field">
			<button type="submit" class="btn" name="login_user">Login</button>
		</div>
		<p>Not yet a member? <a href="<?php echo get_url('register'); ?>">Sign up</a></p>
	</form>
<?php
	Page::get_footer();
?>