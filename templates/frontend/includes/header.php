<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo htmlspecialchars( $obj['pageTitle'] ); ?></title>
	 <link href="https://fonts.googleapis.com/css?family=Enriqueta:400,700|Ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet"> 
	<link rel="stylesheet" href="<?php echo Page::get_file('css/normalize.css'); ?>" />
	<link rel="stylesheet" href="<?php echo Page::get_file('css/site.css'); ?>" />
</head>
<body>
	<header class="site-header">
		<div class="container">
			<div class="logo"><a href="<?php echo Page::get_url(); ?>"><img style="max-width: 250px;" src="http://placehold.it/500x250" /></a></div>
			<nav>
				<ul>

					<li><a href="<?php echo Page::get_url(); ?>">Home</a></li>
					<li><a href="<?php echo Page::get_url('about-us'); ?>">About</a></li>
					<li><a href="<?php echo Page::get_url('articles'); ?>">Articles</a></li>
					<li><a href="<?php echo Page::get_url('contact'); ?>">Contact</a></li>
					<li><a href="<?php echo Page::get_url('login'); ?>">Login</a></li>
				</ul>
			</nav>
		</div><!--/container-->
	</header>