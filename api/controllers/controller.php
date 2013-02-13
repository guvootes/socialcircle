<?php

	Class Controller {

		protected 	$session,
					$secure,
					$httponly,
					$cookieParams,
					$user,
					$loginString;	

		public function _contruct(){

			if(!$_SESSION) $this->startSecureSession();

		}

		protected function startSecureSession () {

			// Set a custom session name
			$this->session_name = 'secureSessionID'; 

			// Set to true if using https.
	        $this->$secure = false; 

	        // This stops javascript being able to access the session id.
	        $this->$httponly = true;  
	 
	 		// Forces sessions to only use cookies. 
	        ini_set('session.use_only_cookies', 1); 

	        // Gets current cookies params.
	        $this->cookieParams = session_get_cookie_params(); 

	        session_set_cookie_params(	$this->cookieParams["lifetime"], 
	        							$this->cookieParams["path"], 
	        							$this->cookieParams["domain"], 
	        							$this->secure, 
	        							$this->httponly
	        						); 

	        session_name($this->session_name); // Sets the session name to the one set above.
	        session_start(); // Start the php session
	        session_regenerate_id(true); // regenerated the session, delete the old one.   

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

			$model = new Model;
			$attempts = $model->getAttempts($userId);

			if($attempts >= NUMBER_OF_ATTEMPTS){
				return true;
			}else{
				return false;
			}

		}
	}


?>