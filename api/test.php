<?php 
	ini_set('display_errors', 1); 

	// start session
	session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Tester</title>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>

	<?php 

	// Require config
	require '../sc-config.php';
	
	// Require libraries
	require 'libs/bcrypt.php';

	// Require models
	require 'models/model.php';
	require 'models/user.php';

	// Require controllers
	require 'controllers/controller.php';
	require 'controllers/user.php';

	?>
	<pre>

	<?php
		$user = new UserController();
		print_r(json_decode($user->get_user($_GET)));
		print_r($_SESSION);



	?>

	</pre>
	
</body>
</html>