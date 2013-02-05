<?php

	Class User extends Application{

		public function add_user($data){

			// $data: username, email, password, birthday

			$errors = array();

			// Check for username length
			if ( strlen($data['username']) <= 3 ) {
				$errors['username'] = 'Uw gebruikersnaam is te kort, minimaal 3 tekens';
			}

			// Check for email

			// Check for password length
			if ( strlen($data['password']) <= 3 ) {
				$errors['password'] = 'Uw wachtwoord is te kort, minimaal 3 tekens';
			}

			


		}


		protected function in_use($key, $value, $table) {

			$stmt = $this->db->prepare('SELECT * from '.$table.' where '.$item.' = ":value"');
			$stmt->bindParam(':value', $value);
			$stmt->execute();

			return $stmt->rowCount();

		}

	}

?>