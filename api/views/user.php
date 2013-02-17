<?php 

	$app->post("/user/register", function () use($app) {

    	$app->response()->header("Content-Type", "application/json");
    	$requestBody = $app->request()->getBody();  // <- getBody() of http request
    	$post = json_decode($requestBody, true);

    	$user = new UserController();
    	echo $user->add_user($post);

	});

	$app->post('/user/login', function() use ($app) {
		
		$app->response()->header("Content-Type", "application/json");
		$requestBody = $app->request()->getBody();  // <- getBody() of http request
		$post = json_decode($requestBody, true);
		
		$user = new UserController();
		echo $user->get_user($post);
	
	});

	$app->get('/user/logout', function() use ($app) {
		
		$app->response()->header("Content-Type", "application/json");

		$user = new UserController(true);
		echo $user->logOutUser();
	
	});

?>