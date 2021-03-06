<?php 
	
	$username = "";
	$email    = "";
	$errors = array(); 

	// register
	if (isset($_POST['reg_user'])) {
		
		$username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$password1 = esc($_POST['password_1']);
		$password2 = esc($_POST['password_2']);

		// validation
		if (empty($username)) {  array_push($errors, "Please provide a username"); }
		if (empty($email)) { array_push($errors, "Please provide an email"); }
		if (empty($password1)) { array_push($errors, "Please provide a password"); }
		if ($password1 != $password2) { array_push($errors, "Password not match");}

		// Ensure that no user is registered twice. 
		// the email and usernames should be unique
		$user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);

		if ($user) { // if user exists
			if ($user['username'] === $username) {
			  array_push($errors, "Username already exists");
			}
			if ($user['email'] === $email) {
			  array_push($errors, "Email already exists");
			}
		}
		// register user 
		if (count($errors) == 0) {
			
            $hash = password_hash($password1, PASSWORD_BCRYPT);
            // $password = md5($password1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password, created_at, updated_at) 
					  VALUES('$username', '$email', '$hash', now(), now())";
			mysqli_query($conn, $query);

			// get id of created user
			$reg_user_id = mysqli_insert_id($conn); 

			// put logged in user into session array
			$_SESSION['user'] = getUserById($reg_user_id);

			// if user is admin, redirect to admin area
			if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
				$_SESSION['message'] = "You are now logged in";
				// redirect to admin area
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['message'] = "You are now logged in";
				// redirect to public area
				header('location: index.php');				
				exit(0);
			}
		}
	}

	// LOG USER IN
	if (isset($_POST['login_btn'])) {
		$username = esc($_POST['username']);
		$password1 = esc($_POST['password']);

		if (empty($username)) { array_push($errors, "Username required"); }
		if (empty($password1)) { array_push($errors, "Password required"); }
		if (empty($errors)) {
			
            // $hash = password_hash($password1, PASSWORD_BCRYPT);
            // $password = md5($password); // encrypt password
			
			if (!password_verify($password1, $hash)) {
				array_push($errors, 'Invalid username or password');
				throw new \Exception('Bad password');
				exit(0);
			}	else {
					$sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
				}
			

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// get id of created user
				$reg_user_id = mysqli_fetch_assoc($result)['id']; 

				// put logged in user into session array
				$_SESSION['user'] = getUserById($reg_user_id); 

				// verify password matches
				if (!password_verify($password1, $hash)) {
					array_push($errors, 'Invalid username or password');
					throw new \Exception('Bad password');
					exit(0);
				}
				// if user is admin, redirect to admin area
				if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
					$_SESSION['message'] = "You are now logged in";
					// redirect to admin area
					header('location: ' . BASE_URL . 'admin/dashboard.php');
					exit(0);
				} else {
					$_SESSION['message'] = "You are now logged in";
					// redirect to public area
					header('location: index.php');				
					exit(0);
				}
			} else {
				array_push($errors, 'Wrong credentials');
			}
		}
	}
	// escape value from form
	function esc(String $value)
	{	
		// bring the global db connect object into function
		global $conn;

		$val = trim($value); // remove empty space sorrounding string
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}
	// Get user info from user id
	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

		// returns user in an array format: 
		// ['id'=>1 'username' => 'Awa', 'email'=>'a@a.com', 'password'=> 'mypass']
		return $user; 
	}

	if (isset($_POST['edit'])) {
		
	
		$password1 = esc($_POST['password_1']);
		$password2 = esc($_POST['password_2']);

		// validation
		if (empty($password1)) { array_push($errors, "Please provide a new password"); }
		if ($password1 != $password2) { array_push($errors, "Password not match");}

		// Ensure that no user is registered twice. 
		// the email and usernames should be unique
		$user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);

	
		// register user 
		if (count($errors) == 0) {
			
            $hash = password_hash($password1, PASSWORD_BCRYPT);
            // $password = md5($password1);//encrypt the password before saving in the database
			$query = "UPDATE users SET password ='$hash' WHERE $id='$id'";
			mysqli_query($conn, $query);

			// get id of created user
			$reg_user_id = mysqli_insert_id($conn); 

			// put logged in user into session array
			$_SESSION['user'] = getUserById($reg_user_id);

			// if user is admin, redirect to admin area
			if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
				$_SESSION['message'] = "Password updated";
				// redirect to admin area
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['message'] = "Password updated";
				// redirect to public area
				header('location: index.php');				
				exit(0);
			}
		}
	}

?>