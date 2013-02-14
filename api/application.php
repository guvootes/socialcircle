<?php

// Require config
require '../sc-config.php';

// Require Slim Framework
require 'Slim/Slim.php';

// Require libraries
require 'libs/bcrypt.php';

// Require models
require 'models/model.php';
require 'models/user.php';

// Require controllers
require 'controllers/controller.php';
require 'controllers/user.php';
require 'controllers/activity.php';


// Init $app instance
use Slim\Slim;
Slim::registerAutoloader();

// Make new Slim instance
$app = new Slim();

// Require Views
require 'views/user.php';
require 'views/login.php';
require 'views/logout.php';

// run Slim
$app->run();

?>