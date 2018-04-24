<?php
	require 'config.php' ;
	session_start();
	
	$Admin = new Admin;
	$Admin->admin_router();
?>