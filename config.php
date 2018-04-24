<?php
/*
	Timezone reference:  http://www.php.net/manual/en/timezones.php
 */
	ini_set( "display_errors", true );
	date_default_timezone_set( "America/New_York" );
	define( "DB_DSN", "mysql:host=localhost;dbname=example" );
	define( "DB_USERNAME", "root" );
	define( "DB_PASSWORD", "" );
	define( "CLASS_PATH", "classes" );
	define( "FUNCTION_PATH", "functions" );
	define( "TEMPLATE_PATH", "templates" );
	define( "ADMIN_PATH", "templates/admin" );
	define( "FRONTEND_PATH", "templates/frontend" );
	define( "HOMEPAGE_NUM_ARTICLES", 10 );
	define( "ADMIN_USERNAME", "admin" );
	define( "ADMIN_PASSWORD", "pass" );
	define( "SITE_URL", "http://example.local/" );
	define( "ROOT", dirname($_SERVER['PHP_SELF'] ) );

	require( CLASS_PATH . "/Article.php" );
	require( CLASS_PATH . "/Page.php" );
	require( CLASS_PATH . "/Admin.php" );
	require( CLASS_PATH . "/User.php" );
	require( CLASS_PATH . "/Entry.php" );
	 
	try {
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

?>