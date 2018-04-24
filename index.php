<?php
	require 'config.php' ;

	$Page = new Page;
	$route = isset( $_GET['route'] ) ? $_GET['route'] : "";

	$obj = Page::get_page();

	var_dump( $obj );

	echo $obj['data']['template'];

	$template = Page::get_page_template( $obj['data']['template'] );

	require $template;
?>