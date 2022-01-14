<?php  include('config.php'); ?>
<!-- Source code for handling registration and login -->
<?php  include('includes/registration_login.php'); ?>

<?php include('includes/header.php'); ?>    

<title>Music Tech Blog | Edit </title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
    <!-- banner -->
        <?php include( ROOT_PATH . '/includes/banner.php') ?>
		

	<div style="width: 40%; margin: 20px auto;">
		<h1>Account Page</h1>
        <form method="post" action="edit.php" >
			<h2>Change password</h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<input type="password" name="password_1" placeholder="Password">
			<input type="password" name="password_2" placeholder="Password confirmation">
			<button type="submit" class="btn" name="edit">Change</button>
			
		</form>
	</div>
</div>
<!-- // container -->
<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->