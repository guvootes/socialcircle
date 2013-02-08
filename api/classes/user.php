<?php

	Class User{

		public function add_user($data){

			// $data: username, email, password, birthday

			$errors = array();

			// Check for username length
			if ( !preg_match("/^[a-z\d_]{4,28}$/i", $data['username'])) {
				$name = "username";
				$message = 'Kies een gebruikersnaam tussen de 4 en 28 tekens lang. aleen nummers en cijfers toegestaan';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check if username exists
			if( $this->in_use('username', $data['username'])){				
				$name = "username";
				$message = 'Uw gekozen gebruikersnaam is al in gebruik, kies een andere gerbuikersnaam.';
				array_push($errors, array("message" => $message, "name" => $name));
			}


			// Check for email
			if( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $data['email'])){				
				$name = "email";
				$message = 'Uw e-mail adres is niet geldig.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check for email
			if( $this->in_use('email', $data['email'])){
				$name = "email";
				$message = 'Uw e-mail adres is al in gebruik, gebruik een ander e-mail adres.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check for password length
			if ( strlen($data['password']) <= 5 ) {				
				$name = "password";
				$message = 'Uw wachtwoord is te kort, gebruik minimaal 3 tekens.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check birthdate
			if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data['birthday'])){
				$name = "username";
				$message = 'Uw geboortedatum is niet correct ingevoerd';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// return errors if they exists
			if(!empty($errors)) return json_encode($errors);

			// Encript password
			$bcrypt = new Bcrypt(15);
			$hash = $bcrypt->hash($data['password']);

			// Make new user model instance and add user
			$user = new UserModel();
			$status = $user->addUser(ucfirst($data['username']), strtolower($data['email']), $hash, $data['birthday']);

			return $status;
			
		}

		protected function in_use($key, $value) {

			$user = new UserModel();
			return $user->countUser($key, $value);

		}

	}

?>