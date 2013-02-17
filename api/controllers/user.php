<?php
	Class UserController extends Controller{

		protected 	$user,
					$verification;
	
		public function get_user($data){

			// $data: email, password
		
			$errors = array();

			// Set Variables
			$email = (isset($data['email']) && $data['email'] !== '') ? $data['email'] : null;
			$password = (isset($data['password']) && $data['password'] !== '') ? $data['password'] : null;

			$rowCount = $this->getUserModel($email, $password);

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
					$userModel = new UserModel;
					$userModel->addLoginAttempt($this->user->id);

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

			// Set post data to local variables
			$username = (isset($data['username'])) ? $data['username'] : null;
			$email = (isset($data['email'])) ? $data['email'] : null;
			$password = (isset($data['password'])) ? $data['password'] : null;
			$birthday = (isset($data['birthday'])) ? $data['birthday'] : null;

			$errors = array();

			// Check for username length
			if ( !preg_match("/^[a-z\d_]{4,28}$/i", $username)) {
				$name = "username";
				$message = 'Kies een gebruikersnaam tussen de 4 en 28 tekens lang. Aleen nummers en cijfers toegestaan';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check if username exists
			if( $this->in_use('username', $username)){				
				$name = "username";
				$message = 'Uw gekozen gebruikersnaam is al in gebruik, kies een andere gebruikersnaam.';
				array_push($errors, array("message" => $message, "name" => $name));
			}


			// Check for email
			if( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)){				
				$name = "email";
				$message = 'Uw e-mailadres is niet geldig.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check for email
			if( $this->in_use('email', $email)){
				$name = "email";
				$message = 'Uw e-mailadres is al in gebruik';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check for password length
			if ( strlen($password) <= 5 ) {				
				$name = "password";
				$message = 'Uw wachtwoord is te kort, gebruik minimaal 3 tekens.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check birthdate
			if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $birthday)){
				$name = "birthday";
				$message = 'Uw geboortedatum is niet correct ingevoerd';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Send verification mail
			if(!$this->sendVerificationMail($email, $username)):
				$name = "email";
				$message = 'Je activatie email is niet verzonden';
				array_push($errors, array("message" => $message, "name" => $name));
			endif;

			// return errors if they exists
			if(!empty($errors))	return json_encode($errors);

			// Encript password
			$bcrypt = new Bcrypt(15);
			$hash = $bcrypt->hash($password);

			// Make new user model instance and add user
			$userModel = new UserModel();
			$status = $userModel->addUser(ucfirst($username), strtolower($email), $hash, $data['birthday']);

			return $status;
			
		}

		protected function sendVerificationMail($email, $username){

			$subject = 'Verificatie e-mail';

			ob_start();
			include('../views/emails/generic.php');
			$content = ob_get_contents();
			ob_end_clean();

			return $this->sendMail($email, $username, $subject, $content);

		}

		protected function getUserModel($email, $password){
			
			$bcrypt = new Bcrypt(15);
			
			// Make new usermodel instance
			$userModel = new UserModel();
			
			if (!$rowCount = $userModel->getUserByEmail($email)) return false;
			
			$user = $userModel->getUser();
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

		public function checkUser(){

			if(isset($_SESSION['user'], $_SESSION['loginString'])){

				$this->user = $_SESSION['user'];
				$this->loginString = $_SESSION['loginString'];

				$ipAddress = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
     			$userBrowser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

     			$userModel = new UserModel;
     			$password = $userModel->getHashById($this->user->id);

     			$loginCheck = hash('sha512', $password.$ipAddress.$userBrowser);

     			if($loginCheck == $this->loginString){
     				return true;
     			}

			}else{
				return false;
			}
		}

		public function checkBrute($userId){

			$userModel = new UserModel;
			$attempts = $userModel->getAttempts($userId);

			if($attempts >= NUMBER_OF_ATTEMPTS){
				return true;
			}else{
				return false;
			}

		}


		public function logOutUser(){

			// Unset all session values
			$_SESSION = array();
			
			// get session parameters 
			$params = session_get_cookie_params();
			
			// Delete the actual cookie.
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
			
			// Destroy session
			session_destroy();

		}

	}
?>