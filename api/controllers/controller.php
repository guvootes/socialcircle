<?php

	Class Controller {

		protected 	$session,
					$secure,
					$httponly,
					$cookieParams,
					$user;	

		public function _contruct(){

			if(!$_SESSION) $this->startSecureSession();

		}

		protected function startSecureSession () {

			// Set a custom session name
			$this->session_name = 'sec_session_id'; 

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

			$this->user = $_SESSION['user'];

			// do some checks
			
		}



	}


?>