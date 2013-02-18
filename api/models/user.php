<?php

	Class UserModel extends Model {
	
		protected $user;
		
		public function addUser ($username, $email, $password, $birthday, $activation_token, $role = 0 ) {

			$data[':username'] = $username;
			$data[':email'] = $email;
			$data[':password'] = $password;
			$data[':birthday'] = $birthday;
			$data[':activation_token'] = $activation_token;
	
			$sql = "INSERT INTO ".DB_PREFIX."users (username, email, password, birthday, activation_token) VALUES (:username, :email, :password, :birthday, :activation_token)";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($data);

			if($stmt->rowCount() > 0){
				return true;
			}

		}
		
		public function getUserByEmail($email){
			$data[':email'] = $email;
			$sql = 'SELECT * FROM '.DB_PREFIX.'users WHERE email = :email LIMIT 1';	
			$stmt = $this->db->prepare($sql);
			$stmt->execute($data);	
			
			$result = $stmt->fetch();
			$this->user = $result;	

			return $stmt->rowCount();	

		}
		
		public function getHash(){
					
			return $this->user['password'];
			
		}

		public function countUser($key, $value){

			$sql = 'SELECT COUNT(*) from '.DB_PREFIX.'users WHERE '.$key.' = ?';
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(1, $value, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetchColumn();

		}


		public function getUser(){

			return $this->user;

		}

		public function getHashById($userId){

			if ($stmt = $this->db->prepare('SELECT password FROM '.DB_PREFIX.'users WHERE id = ? LIMIT 1')) { 

				$stmt->bindParam(1, $userId, PDO::PARAM_INT);
				$stmt->execute(); // Execute the prepared query.

        		if($stmt->rowCount() == 1) {

        			$password = $stmt->fetch();

           			return $password['password'];

        		}else{
        			return false;
        		}

			}else{

				return false;

			}
		}

		public function getAttempts($userId){

			$now = time();

		   // All login attempts are counted from the past 2 hours. 
		   $validAttempts = $now - (2 * 60 * 60); 

			$sql = 'SELECT time FROM '.DB_PREFIX.'login_attempts WHERE user_id = ? AND time > '.$validAttempts;

			$stmt = $this->db->prepare($sql); 

			$stmt->bindParam(1, $userId, PDO::PARAM_INT);
			$stmt->execute(); // Execute the prepared query.

			return $stmt->rowCount();
		}

		public function addLoginAttempt($userId) {

			$now = time();

			$data[':id'] = $userId;
			$data[':time'] = $now;

			$sql = "INSERT INTO ".DB_PREFIX."login_attempts (user_id, time) VALUES (:id, :time)";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($data);

		}

		public function activate($activation_token){

			$sql = "UPDATE ".DB_PREFIX."users SET active=1 WHERE activation_token =?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array($activation_token));

			return $stmt->rowCount();

		}

		public function resetPassword($token){

			$now = time();

			$data[':id'] = $this->user['id'];
			$data[':time'] = $now;
			$data[':token'] = $token;

			$sql = "INSERT INTO ".DB_PREFIX."forgot_password (user_id, time, token) VALUES (:id, :time, :token)";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($data);

			return $stmt->rowCount();

		}

		public function updatePassword($userId, $password){

			$data[':id'] = $userId;
			$data[':password'] = $password;

			$sql = "UPDATE ".DB_PREFIX."users SET password = :password WHERE id = :id";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($data);

			return $stmt->rowCount();


		}

		public function getForgetPasswordRow($token){

			$sql = "SELECT user_id, time FROM ".DB_PREFIX."forgot_password WHERE token = ?";

			$stmt = $this->db->prepare($sql); 

			$stmt->bindParam(1, $token, PDO::PARAM_INT);
			$stmt->execute(); // Execute the prepared query.

			$result = $stmt->fetch();
			return $result;	

		}

	}

?>