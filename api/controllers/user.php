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
				if($this->verification){

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
			if (Validate::username($username)){
				$name = "username";
				$message = 'Kies een gebruikersnaam tussen de 4 en 28 tekens lang. Aleen nummers en cijfers toegestaan.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check if username exists
			if( $this->in_use('username', $username)){				
				$name = "username";
				$message = 'Uw gekozen gebruikersnaam is al in gebruik.';
				array_push($errors, array("message" => $message, "name" => $name));
			}


			// Check for email
			if(Validate::email($email)){				
				$name = "email";
				$message = 'Uw e-mailadres is niet geldig.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check for email
			if( $this->in_use('email', $email)){
				$name = "email";
				$message = 'Uw e-mailadres is al in gebruik.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check for password length
			if (Validate::password($password)) {				
				$name = "password";
				$message = 'Uw wachtwoord is te kort, gebruik minimaal 3 tekens.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Check birthdate
			if(Validate::date($birthday)){
				$name = "birthday";
				$message = 'Uw geboortedatum is niet correct ingevoerd';
				array_push($errors, array("message" => $message, "name" => $name));
			}


			// check if email and username are provided and return errors if they exists
			if(!empty($errors))	return json_encode($errors);

			// Make activation token
			$activation_token = md5(rand(0,1000));


			// Send verification mail
			if(!$this->sendActivationMail($email, $username, $activation_token)):
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
			$status = $userModel->addUser(ucfirst($username), strtolower($email), $hash, $birthday, $activation_token);

			return $status;
			
		}

		protected function sendActivationMail($email, $username, $activation_token){

			// Set subject
			$subject = 'Account activatie e-mail';

			$body = 'The activation token= '.$activation_token;

			// Cache the mail template
			ob_start();
			include('views/emails/account-activation.php');
			$content = ob_get_contents();
			ob_end_clean();


			// search and replace template tags
			$search = array(
				'*|SITENAME|*',
				'*|SUBJECT|*',
				'*|BODY|*'
			);

			$replace = array(
				SITENAME,
				$subject,
				$body
			);

			$content = str_replace($search, $replace, $content);

			// return if the mail is send (bool)
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

		public function activateUser($activation_token){

			$errors = array();
			
			if(!$activation_token){
				$name = "activatie";
				$message = 'uw account kon niet worden geactiveerd wegens gebrekkige data';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			if(!empty($errors))	return json_encode($errors);

			$userModel = new UserModel();
			if($userModel->activate($activation_token)){
				
				return true;

			}else{

				$name = "activatie";
				$message = 'Uw account kon niet worden geactiveerd.';
				array_push($errors, array("message" => $message, "name" => $name));				

			}

			if(!empty($errors))	return json_encode($errors);

		}

		public function forgotPassword($data){

			$errors = array();
			$email = (isset($data['email'])) ? $data['email'] : null;

			if(!$email){
				$name = "activatie";
				$message = 'Uw wachtwoord kon niet worden vernieuwd';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Return errors 
			if(!empty($errors))	return json_encode($errors);

			$forgot_password_token = md5(rand(0,1000));
			
			$userModel = new UserModel;

			if(!$userModel->getUserByEmail($email)){
				
				$name = "password reset";
				$message = 'Er is geen gebruiker bekend met het opgegeven e-mailadres';
				array_push($errors, array("message" => $message, "name" => $name));

			}else{

					if($userModel->resetPassword($forgot_password_token)){
						$user = $userModel->getUser();
						$mail = $this->sendForgotPasswordMail($forgot_password_token, $user);
					}

				if(!$mail){
					$name = "password reset";
					$message = 'Er heeft zich een fout opgetreden bij het versturen van de e-mail';
					array_push($errors, array("message" => $message, "name" => $name));					
				}else{
					return $mail;
				}


			}

			// Return errors 
			if(!empty($errors))	return json_encode($errors);

		}


		public function newPassword($data){

			$errors = array();

			// Set Variables
			$token = (isset($data['token']) && $data['token'] !== '') ? $data['token'] : null;
			$password = (isset($data['password']) && $data['password'] !== '') ? $data['password'] : null;

			if(!$token){
				$name = "token";
				$message = 'Een token is vereist om deze actie te kunnen doen.';
				array_push($errors, array("message" => $message, "name" => $name));					
			}

			// Check for password length
			if (Validate::password($password)) {				
				$name = "password";
				$message = 'Uw wachtwoord is te kort, gebruik minimaal 3 tekens.';
				array_push($errors, array("message" => $message, "name" => $name));
			}

			// Return errors 
			if(!empty($errors))	return json_encode($errors);

			$userModel = new UserModel;
			$row = $userModel->getForgetPasswordRow($token);

			// All login attempts are counted from the past half hour. 
			$now = time();
		   	$expired = $now - (30 * 60); 

			if(!$row){
				$name = "token";
				$message = 'Uw token is ongeldig.';
				array_push($errors, array("message" => $message, "name" => $name));				
			}elseif($row['time'] < $expired ){
				$name = "token";
				$message = 'Uw token is verlopen.';
				array_push($errors, array("message" => $message, "name" => $name));								
			}

			// Return errors 
			if(!empty($errors))	return json_encode($errors);


			return $this->updatePassword($row['user_id'],$password);

		}

		protected function updatePassword($userId, $password){

			$bcrypt = new Bcrypt(15);
			$hash = $bcrypt->hash($password);

			$userModel = new UserModel;

			return $userModel->updatePassword($userId, $hash);

		}

		protected function sendForgotPasswordMail($token, $user){

			// Set subject
			$subject = 'Password vergeten';

			$body = 'The reset token= '.$token;

			// Cache the mail template
			ob_start();
			include('views/emails/forgot-password.php');
			$content = ob_get_contents();
			ob_end_clean();


			// search and replace template tags
			$search = array(
				'*|SITENAME|*',
				'*|SUBJECT|*',
				'*|BODY|*'
			);

			$replace = array(
				SITENAME,
				$subject,
				$body
			);

			$content = str_replace($search, $replace, $content);

			// return if the mail is send (bool)
			return $this->sendMail($user['email'], $user['username'], $subject, $content);

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