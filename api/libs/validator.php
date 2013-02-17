<?php 
	Class Validator{

		public function validate_username($username){

			return(!preg_match("/^[a-z\d_]{4,28}$/i", $username));

		}

		public function validate_email($email){

			return( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email));

		}

		public function validate_password($password){

			return (strlen($password) <= 5);

		}

		public function validate_date($date){

			return (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date));

		}

	}

?>