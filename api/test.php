<?php ini_set('display_errors', 1); ?> 
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
	
		// Require Slim Framework
		require '../sc-config.php';
		require 'classes/bcrypt.php';
		require 'classes/model.php';
		require 'classes/user.model.php';
		require 'classes/user.php';
		
		$user = new User();
		echo $user->check_user($_GET);
	
	
	?>
	
</body>
</html>