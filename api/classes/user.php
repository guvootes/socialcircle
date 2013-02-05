<?php

	Class User extends Application{

		public function add_user($data){

			// $data: username, email, password, birthday

			$errors = array();

			// Check for username length
			if ( !preg_match("/^[a-z\d_]{4,28}$/i", $data['username'])) {
				$errors['username'][] = 'Kies een gebruikersnaam tussen de 4 en 28 tekens lang. aleen nummers en cijfers toegestaan';
			}

			// Check if username exists
			if( $this->in_use('username', $data['username'], 'users')){
				$errors['username'][] = 'Uw gekozen gebruikersnaam is al in gebruik, kies een andere gerbuikersnaam.';
			}


			// Check for email
			if( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $data['email'])){
				$errors['email'][] = 'Uw e-mail adres is niet geldig.';
			}

			// Check for email
			if( $this->in_use('email', $data['email'], 'users')){
				$errors['email'][] = 'Uw e-mail adres is al in gebruik, gebruik een ander e-mail adres.';
			}

			// Check for password length
			if ( strlen($data['password']) <= 3 ) {
				$errors['password'][] = 'Uw wachtwoord is te kort, gebruik minimaal 3 tekens.';
			}

			// Check birthdate
			if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data['birthday'])){
				$errors['birthday'][] = 'Uw geboortedatum is niet correct ingevoerd';
			}

			if(!empty($errors)) return json_encode($errors);

			$bcrypt = new Bcrypt(15);
			$hash = $bcrypt->hash($data['password']);

			$data[':username'] = ucfirst($data['username']);
			$data[':email'] = strtolower($data['email']);
			$data[':password'] = $hash;
			$data[':birthday'] = $data['birthday'];

			$sql = "INSERT INTO ".DB_PREFIX."users (username, email, password, birthday) VALUES (:username, :email, :password, :birthday)";

			$sth = $this->db->prepare($sql);
			$sth->execute($data);

			if ( $sth->rowCount() > 0 ) {
				$success = true;
				return json_encode($success);
			}else{
				$errors['database'][] = 'Er heeft zich een onbekende fout opgetreden.';			
			}

			if(!empty($errors)) return json_encode($errors);
			
		}

		protected function in_use($key, $value, $table) {

			$sql = 'SELECT COUNT(*) from '.DB_PREFIX.$table.' WHERE '.$key.' = ?';
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(1, $value, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetchColumn();

		}

	}

?>