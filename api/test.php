<?php 
	
	ini_set('display_errors', 1); 

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
	require 'controllers/activity.php';


		$output = new stdClass;

		if(isset($_GET['login'])):
			$user = new UserController;
			$output->login = json_decode($user->get_user($_GET));
		endif;


		if(isset($_GET['activity'])):
			$activity = new ActivityController;
			$output->activity = $activity->getSession();
		endif;


		if(isset($_GET['logout'])):

			$user = new UserController;
			$user->logOutUser();

		endif;

		$output->session = $_SESSION;

		

		echo '<pre>';
		print_r($output);
		echo '</pre>';



	?>
	