<?php

class Admin extends Page {
	 
	function logout() {
		unset( $_SESSION['username'] );
		header( "Location: admin.php" );
	}


	function login() {
	 
		$results = array();
		$results['pageTitle'] = "Admin Login | Example Site";
	 
		if ( isset( $_POST['login'] ) ) {
	 
			// User has posted the login form: attempt to log the user in
	 
			if ( $_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD ) {
	 
				// Login successful: Create a session and redirect to the admin homepage
				$_SESSION['username'] = ADMIN_USERNAME;
				header( "Location:  admin.php" );
	 
			} else {
	 
				// Login failed: display an error message to the user
				$results['errorMessage'] = "Incorrect username or password. Please try again.";
				require( TEMPLATE_PATH . "/admin/login.php" );
			}
	 
		} else {
	 
			// User has not posted the login form yet: display the form
			require( TEMPLATE_PATH . "/admin/login.php" );
		}
	 
	}

	function is_logged_in() {
		$username = isset( $_SESSION['username'] );
		$status = false;
		if( !empty( $username ) ) :
			$status = true;
		endif;
		return $status;
	}

	/*
	function login_required() {
		if( $this->is_logged_in() ) {
			return true;
		} else {
			header('Location: admin/login.php');
			exit();
		}
	}
	*/

	function admin_router() {

		$route = isset( $_GET['route'] ) ? $_GET['route'] : "";
		$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

		if ( $route != "login" && $route != "logout" && !$username ) {
			$this->login();
			exit;
		}

		switch ( $route ) {
			case 'login' :
				$this->login();
				break;
			case 'logout' :
				$this->logout();
				break;
			case 'newArticle' :
				require ADMIN_PATH . '/articles/edit.php';
				break;
			case 'editArticle' :
				require ADMIN_PATH . '/articles/edit.php';
				break;
			case 'deleteArticle' :
				Article::deleteArticle();
				break;
			case 'newPage' :
				require ADMIN_PATH . '/pages/edit.php';
				break;
			case 'editPage' :
				require ADMIN_PATH . '/pages/edit.php';
				break;
			case 'deletePage' :
				Page::deletePage();
				break;
			default:
				require ADMIN_PATH . '/index.php';
		}

	}

	function get_admin_header() {
		require ADMIN_PATH . '/includes/header.php';
	}

	function get_admin_footer() {
		require ADMIN_PATH . '/includes/footer.php';
	}

}