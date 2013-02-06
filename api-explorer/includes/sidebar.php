<?php 
	
	$args = array(
		'class' => 'navigation',
		'childClass' => 'children'
	);
?>

<section class="sidebar">
<?php
	echo $app->getNav($args);
?>
</section>