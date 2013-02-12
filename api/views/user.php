<?php 

	$app->post("/user", function () use($app) {

    	$app->response()->header("Content-Type", "application/json");
    	$requestBody = $app->request()->getBody();  // <- getBody() of http request
    	$post = json_decode($requestBody, true);

    	$user = new User();
    	echo $user->add_user($post);

	});
?>