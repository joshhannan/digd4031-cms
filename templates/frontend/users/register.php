<?php
	/*
		Register Template
	*/
	Page::get_header();
	User::register_user();
?>
<form method="post" action="register.php" class="login-form">
	<div class="field">
		<label>Username</label>
		<input type="text" name="username" />
	</div>
	<div class="field">
		<label>Email</label>
		<input type="email" name="email" />
	</div>
	<div class="field">
		<label>Password</label>
		<input type="password" name="password_1" />
	</div>
	<div class="field">
		<label>Confirm password</label>
		<input type="password" name="password_2" />
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="reg_user">Register</button>
	</div>
	<p>Already a member? <a href="<?php echo Page::get_url('users/login'); ?>">Sign in</a></p>
</form>
<?php
	Page::get_footer();
?>