<?php
	
	// Require Slim Framework
	require '../sc-config.php';
	require 'Slim/Slim.php';
	require 'classes/application.php';
	require 'classes/user.php';
	

	// Init $app instance
   	use Slim\Slim;
	Slim::registerAutoloader();

    $app = new Slim();

    $app->post("/user", function () use($app, $user) {

    	$app->response()->header("Content-Type", "application/json");
    	$post = $app->request()->post();

    	$user = new User;
    	echo $user->add_user($post);

	});

    $app->run();
?>