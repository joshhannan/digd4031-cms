<?php

class User {

	function get_errors( $errors ) {

		if( !empty( $errors ) ) :
			require TEMPLATE_PATH . '/frontend/users/errors.php';
		endif;
		
	}
	
	function register_user() {
		session_start();
		
		// initializing variables
		$username = "";
		$email    = "";
		$errors = array(); 

		// connect to the database
		$db = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );

		// REGISTER USER
		if (isset($_POST['reg_user'])) {
  			// receive all input values from the form
  			$username = $db->prepare($_POST['username']);
  			$email = $db->prepare($_POST['email']);
  			$password_1 = $db->prepare($_POST['password_1']);
  			$password_2 = $db->prepare($_POST['password_2']);

  			// form validation: ensure that the form is correctly filled ...
  			// by adding (array_push()) corresponding error unto $errors array
  			if (empty($username)) { array_push($errors, "Username is required"); }
  			if (empty($email)) { array_push($errors, "Email is required"); }
  			if (empty($password_1)) { array_push($errors, "Password is required"); }
  			if ($password_1 != $password_2) {
				array_push($errors, "The two passwords do not match");
  			}

  			// first check the database to make sure 
  			// a user does not already exist with the same username and/or email
  			$user_check_query = $db->query("SELECT * FROM users WHERE username = ':username' OR email = ':email' LIMIT 1");
  			$user_check_query->execute([$username, $status]);
  			$user = $result->fetch();

  			if ($user) { // if user exists
  				if ($user['username'] === $username) {
  					array_push($errors, "Username already exists");
  				}
  				if ($user['email'] === $email) {
  					array_push($errors, "email already exists");
  				}
  			}

  			// Finally, register user if there are no errors in the form
  			if (count($errors) == 0) {
  				$password = md5($password_1);//encrypt the password before saving in the database
				$query = "INSERT INTO users (username, email, password) 
					VALUES('$username', '$email', '$password')";
				$db->query( $query );
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: admin.php');
			} else {
				$this->get_errors( $errors );
			}
		}
	}

	function login_user() {

		// LOGIN USER
		if (isset($_POST['login_user'])) {
			$username = mysqli_real_escape_string($db, $_POST['username']);
			$password = mysqli_real_escape_string($db, $_POST['password']);

			if (empty($username)) {
				array_push($errors, "Username is required");
			}
			if (empty($password)) {
				array_push($errors, "Password is required");
			}

			if (count($errors) == 0) {
				$password = md5($password);
				$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
				$results = mysqli_query($db, $query);
				if (mysqli_num_rows($results) == 1) {
					$_SESSION['username'] = $username;
					$_SESSION['success'] = "You are now logged in";
					header('location: admin.php');
				} else {
					array_push($errors, "Wrong username/password combination");
				}
			}
		}
		
	}

}