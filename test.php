<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>API Tester</title>
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
	<form id="testform">
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

	<script src="js/libs/jquery-1.7.1.min.js"></script>
	<script>
		(function($) {

			var Form = {

				state: {
					enabled: false
				},

				values: {},

				init: function (el) {

					this.element = el;
					this.inputs = this.element.find('input');

					if(!this.state.enabled) this.enable();

				},

				enable: function () {

					this.element.on('submit', $.proxy(this, 'onSubmit'));
					this.state.enabled = true;

				},

				onSubmit: function (e) {

					e.preventDefault();

					var self = this;

					$.each(this.inputs, function () {
						self.values[this.name] = $(this).val();
					});

					this.ajaxCall();

				},

				ajaxCall: function () {

					console.log(JSON.stringify(this.values));

					$.ajax({
						type: 'POST',
						contentType: 'application/json',
						url: 'api/user',
						dataType: "json",
						data: this.values,
						success: function(data, textStatus, jqXHR){
							console.log(data);
						},
						error: function(jqXHR, textStatus, errorThrown){
							console.log('error: ', jqXHR, textStatus, errorThrown);
						}
					});



				}

			}

			Form.init($('#testform'));

			window.Form = Form;

		})(jQuery);
	</script>	
</body>
</html>