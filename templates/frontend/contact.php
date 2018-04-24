<?php
	/*
	Contact Us Template
	 */
	Page::get_header();
?>
<main class="default-template">
	<div class="container">
		<h1>Contact Us</h1>
		<form class="form-contact" method="post" action="">
			<div class="field">
				<label for="inputName" class="sr-only">Name</label>
				<input type="name" name="name" id="inputName" class="form-control" placeholder="Your Name" required>
			</div><!--/field-->
			<div class="field">
				<label for="inputEmail" class="sr-only">E-Mail</label>
				<input type="email" name="email" id="inputEmail" class="form-control" placeholder="name@email.com" required>
			</div><!--/field-->
			<div class="field">
				<label for="inputSubject" class="sr-only">Subject</label>
				<input type="name" name="subject" id="inputSubject" class="form-control" placeholder="Your Subject Line" required>
			</div><!--/field-->
			<div class="field">
				<label for="inputMessage" class="sr-only">Message</label>
				<textarea class="form-control" id="inputMessage" rows="3"></textarea>
			</div><!--/field-->
			<div class="buttons">
				<button type="submit">Send</button>
			</div><!--/buttons-->
		</form><!--/form-contact-->
	</div><!--/container-->
</main><!--/default-template-->
<?php
	Page::get_footer();
?>