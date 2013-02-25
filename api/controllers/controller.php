<?php

	Class Controller {

		protected 	$app;	


		function __construct($app){

			$this->app = $app;

			$this->startSecureSession();

		}

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

		protected function sendMail($email, $username, $subject, $content){

			$mail  = new PHPMailer();
			$mail->IsSMTP();

 
			$mail->SMTPAuth   = SMTP_AUTH;       
			$mail->SMTPSecure = SMTP_SECURE;             
			$mail->Host       = SMTP_HOST;      
			$mail->Port       = SMTP_PORT;                   
			$mail->Username   = SMTP_USER; 
			$mail->Password   = SMTP_PASS; 
			 
			$mail->From       = MAIL_FROM;
			$mail->FromName   = MAIL_NAME;
			$mail->Subject    = $subject;
			$mail->MsgHTML($content);
			 
			$mail->AddAddress($email,$username);
			$mail->IsHTML(true);
			 
			return $mail->Send();



		}

		protected function authenticate(){

			$authentication = UserController::checkUser();

			return $authentication;

		}

	}

?>