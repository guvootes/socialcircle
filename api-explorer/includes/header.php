<?php 
	require_once 'application/bootstrap.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>&raquo; API explorer</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="<?php echo EXPLORER_ROOT; ?>">API Explorer</a>
      <div class="nav-collapse collapse">
        <?php 
        	$args = array(
        		'class' => 'navbar-fixed-top nav'
        	);

        	echo $app->getTopNav($args);

        ?>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
<!-- /.navbar -->
