<?php 

	$app->post("/user/register", function () use($app) {

    	$app->response()->header("Content-Type", "application/json");
    	$requestBody = $app->request()->getBody();  // <- getBody() of http request
    	$post = json_decode($requestBody, true);

    	$user = new UserController($app);
    	echo $user->add_user($post);

	});

	$app->post('/user/login', function() use ($app) {
		
		$app->response()->header("Content-Type", "application/json");
		$requestBody = $app->request()->getBody();  // <- getBody() of http request
		$post = json_decode($requestBody, true);
		
		$user = new UserController($app);
		echo $user->get_user($post);
	
	});

	$app->get('/user/logout', function() use ($app) {
		
		$app->response()->header("Content-Type", "application/json");

		$user = new UserController($app);
		echo $user->logOutUser();
	
	});

	$app->get('/user/activate/:token', function($token) use ($app) {
		
		$app->response()->header("Content-Type", "application/json");

		$user = new UserController($app);
		echo $user->activateUser($token);
	
	});

	$app->post('/user/forgot', function($email) use ($app) {
		
		$app->response()->header("Content-Type", "application/json");

		$requestBody = $app->request()->getBody();  // <- getBody() of http request
		$post = json_decode($requestBody, true);

		$user = new UserController($app);
		echo $user->forgotPassword($post);
	
	});

	$app->post('/user/newpassword/:token', function() use ($app) {
		
		$app->response()->header("Content-Type", "application/json");

		$requestBody = $app->request()->getBody();  // <- getBody() of http request
		$post = json_decode($requestBody, true);

		$user = new UserController($app);
		echo $user->newPassword($post);
	
	});

?>