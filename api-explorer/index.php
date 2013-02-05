<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>API Explorer</title>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<?php 
		$inputs = array(
			0 => array(
				'label' => 'Name',
				'name' => 'username',
				'type' => 'text'
			),
			1 => array(
				'label' => 'Email',
				'name' => 'email',
				'type' => 'email'
			),
			2 => array(
				'label' => 'Password',
				'name' => 'password',
				'type' => 'password'
			),
			3 => array(
				'label' => 'Birthday',
				'name' => 'birthday',
				'type' => 'date'
			)

		);


	?>

	<h1>Register</h1>
	<form id="adduser">
		<ul>
		<?php 
			foreach ($inputs as $input):
		?>
			<li>
				<label for="<?php echo $input['name']; ?>"><?php echo $input['label']; ?></label>
				<input type="<?php echo $input['type']; ?>" name="<?php echo $input['name']; ?>" id="<?php echo $input['name']; ?>" />
			</li>
		<?php
			endforeach;
		?>
		</ul>
		<button type="submit" value="Submit">
			Submit
		</button>
	</form>

	<script src="../js/libs/jquery-1.7.1.min.js"></script>
	<script src="js/adduser.js"></script>
</body>
</html>