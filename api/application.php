<?php

// Require config
require '../sc-config.php';

// Require Slim Framework
require 'Slim/Slim.php';

// Require libraries
require 'libs/bcrypt.php';
require 'libs/phpmailer/class.phpmailer.php';
require 'libs/validate.php';

// Require models
require 'models/model.php';
require 'models/user.php';
require 'models/activity.php';

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
require 'routes/user.php';
require 'routes/activity.php';

// run Slim
$app->run();

?>