	<?php

	Class UserController extends Controller{

		protected 	$user,
					$verification;
	
		public function get_user($data){

			// $data: email, password
		
			$errors = array();

			$rowCount = $this->getUserModel($data['email'], $data['password']);

			if($rowCount){

				if($this->checkBrute($this->user->id)){

					$name = "username";
					$message = 'Je account is tijdelijk geblokkeerd.';
					array_push($errors, array("message" => $message, "name" => $name));
					return json_encode($errors);

				}

				// check if account is verificated
				if(	$this->verification){

					// Set user in Session and return user object
					$_SESSION['user'] = $this->user;
					return json_encode($this->user);

				}else{

					// Add attempt 
					$model = new Model;
					$model->addLoginAttempt($this->user->id);

					// Return error
					$name = 'password';
					$message = 'Je wachtwoord is onjuist ingevoerd';
					array_push($errors, array("message" => $message, "name" => $name));
					return json_encode($errors);
					
				}

			}else{
				$name = "email";
				$message = 'Je e-mailadres is onjuist';
				array_push($errors, array("message" => $message, "name" => $name));
				return json_encode($errors);
			}

		}

		public function add_user($data){

			// $data: username, email, password, birthday

			$errors = array();

			// Check for username length
			if ( !preg_match("/^[a-z\d_]{4,28}$/i", $data['username'])) {
				$name = "username";
				$message = 'Kies een gebruikersnaam tussen de 4 en 28 tekens lang. Aleen nummers en cijfers toegestaan';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check if username exists
			if( $this->in_use('username', $data['username'])){				
				$name = "username";
				$message = 'Uw gekozen gebruikersnaam is al in gebruik, kies een andere gebruikersnaam.';
				array_push($errors, array("message" => $message, "name" => $name));
			}


			// Check for email
			if( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $data['email'])){				
				$name = "email";
				$message = 'Uw e-mailadres is niet geldig.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check for email
			if( $this->in_use('email', $data['email'])){
				$name = "email";
				$message = 'Uw e-mailadres is al in gebruik';
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
			if(!empty($errors)){
				return json_encode($errors);
			}

			// Encript password
			$bcrypt = new Bcrypt(15);
			$hash = $bcrypt->hash($data['password']);

			// Make new user model instance and add user
			$user = new UserModel();
			$status = $user->addUser(ucfirst($data['username']), strtolower($data['email']), $hash, $data['birthday']);

			return $status;
			
		}

		protected function getUserModel($email, $password){
			
			$bcrypt = new Bcrypt(15);
			
			// Make new usermodel instance
			$model = new UserModel();
			
			if (!$rowCount = $model->getUserByEmail($email)) return false;
			
			$user = $model->getUser();
			$hash = $user['password'];
			
			// Verify password input with database hashs
			$this->verification = $bcrypt->verify($password, $hash);	

			// set IP and user agent
			$ipAddress	= $_SERVER['REMOTE_ADDR'];
			$userBrowser = $_SERVER['HTTP_USER_AGENT'];

			// Make response object
			$response = new stdClass;
			$response->id = $user['id'];
			$response->username = $user['username'];
			$response->email = $user['email'];
			$response->role = $user['role'];

			$this->user = $response;

			if($this->verification) 
				$_SESSION['loginString'] = hash('sha512', $user['password'].$ipAddress.$userBrowser);

			return $rowCount;
			
			
		}

		protected function in_use($key, $value) {

			$user = new UserModel();
			return $user->countUser($key, $value);

		}

	}

?>