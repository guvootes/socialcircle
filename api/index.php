<?php
	
	// Require Slim Framework
	require 'Slim/Slim.php';

	// Init $app instance
	\Slim\Slim::registerAutoloader();
    $app = new \Slim\Slim();


    //////////////////////////////////////////////////
    // Sample GET route   ////////////////////////////
    //////////////////////////////////////////////////
    
    $app->get('/sample/', function () use ($app) {
       $app->contentType('application/json');
    	   
    });


?>