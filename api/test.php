<?php 
	
	ini_set('display_errors', 1); 

	// Require config
	require '../sc-config.php';
	
	// Require libraries
	require 'libs/bcrypt.php';
	require 'libs/validate.php';
	require 'libs/phpmailer/class.phpmailer.php';

	// Require models
	require 'models/model.php';
	require 'models/user.php';

	// Require controllers
	require 'controllers/controller.php';
	require 'controllers/user.php';
	require 'controllers/activity.php';


		$output = new stdClass;

		if(isset($_GET['register'])):
			$user = new UserController;
			$output->register = json_decode($user->add_user($_GET));
		endif;

		if(isset($_GET['login'])):
			$user = new UserController;
			$output->login = json_decode($user->get_user($_GET));
		endif;


		if(isset($_GET['activity'])):
			$activityControler = new ActivityController;
			$output->activity = $activityControler->getSession();
		endif;


		if(isset($_GET['logout'])):

			$user = new UserController;
			$user->logOutUser();

		endif;

		if(isset($_SESSION)) $output->session = $_SESSION;

		

		echo '<pre>';
		print_r($output);
		echo '</pre>';





	?>
	