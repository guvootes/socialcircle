<?php

	Class User extends Application{

		public function add_user($data){

			// $data: username, email, password, birthday

			if ( strlen($data['username']) < 3 ) {
				return json_encode(array(
					'error' => true,
					'message' => $username . ' seems a bit short. Minimum 3 chars!'
				));
			}
		}
	}

?>