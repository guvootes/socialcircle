<?php 

	$app->get('/activities/:page', function ($page) use($app) {

		$app->response()->header("Content-Type", "application/json");
    		
		$activityController = new ActivityController($app);
		echo $activityController->getActivities($page);

	});



?>