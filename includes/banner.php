<?php if (isset($_SESSION['user']['username'])) { ?>
	<div class="logged_in_info">
		<span>welcome <?php echo $_SESSION['user']['username'] ?></span>
		|
		<span><a href="edit.php">edit profile</a></span><br>
		<span><a href="logout.php">logout</a></span>
		
	</div>
<?php }else{ ?>

<div class="banner">
	<div class="welcome_msg">
		<h2>Welcome to our website, please consider registering!</h2>
		
		<a href="register.php" class="btn">Register!</a>
	</div>
	<div class="login_div">
			<form action="<?php echo 'index.php'; ?>" method="post" >
				<h2>Login</h2>
				<div style="width: 60%; margin: 0px auto;">
					<?php include(ROOT_PATH . '/includes/errors.php') ?>
				</div>
				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="password" name="password"  placeholder="Password"> 
				<button class="btn" type="submit" name="login_btn">Sign in</button>
			</form>
		</div>
	</div>
<?php } ?>