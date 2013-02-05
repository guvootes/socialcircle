<?php
	
	// Require Slim Framework
	require '../sc-config.php';
	require 'Slim/Slim.php';
	require 'classes/bcrypt.php';
	require 'classes/model.php';
	require 'classes/user.model.php';
	require 'classes/user.php';
	

	// Init $app instance
   	use Slim\Slim;
	Slim::registerAutoloader();

    $app = new Slim();

    $app->post("/user", function () use($app) {

    	$app->response()->header("Content-Type", "application/json");
    	$req = $app->request();
    	$post = $req->post();

    	$user = new User;
    	echo $user->add_user($post);

	});

    $app->run();
?>