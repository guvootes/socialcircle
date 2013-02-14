<?php

	Class Controller {

		protected 	$session,
					$secure,
					$httponly,
					$cookieParams,
					$user,
					$loginString;	

		public function startSecureSession () {


			// Set a custom session name
			$session_name = 'secureSessionID'; 

			// Set to true if using https.
	        $secure = false; 

	        // This stops javascript being able to access the session id.
	        $httponly = true;  
	 
	 		// Forces sessions to only use cookies. 
	        ini_set('session.use_only_cookies', 1); 

	        // Gets current cookies params.
	        $cookieParams = session_get_cookie_params(); 

	        session_set_cookie_params(	$cookieParams["lifetime"], 
	        							$cookieParams["path"], 
	        							$cookieParams["domain"], 
	        							$secure, 
	        							$httponly
	        						); 

	        session_name($session_name); // Sets the session name to the one set above.
	        session_start(); // Start the php session
	        session_regenerate_id(true); // regenerated the session, delete the old one.   


		}

	}

?>