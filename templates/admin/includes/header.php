<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo htmlspecialchars( $obj['pageTitle'] ); ?></title>
	 <link href="https://fonts.googleapis.com/css?family=Enriqueta:400,700|Ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet"> 
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/admin.css" />
</head>
<body>
	<header class="admin-header">	
		<span class="logged-in">You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?page=logout"?>Log out</a></span>
		<nav>
			<ul>
				<li><a href="<?php echo Page::get_url('admin.php'); ?>">Dashboard</a></li>
				<li><a href="<?php echo Page::get_url('logout'); ?>">Logout</a></li>
			</ul>
		</nav>
	</header>