<?php 

	$app->get('/logout', function() use ($app) {
		
		$app->response()->header("Content-Type", "application/json");

		$user = new UserController(true);
		echo $user->logOutUser();
	
	});

?>