<?php

	Class UserModel extends Model {
	
		protected $user;

		public function __construct() {
			$this->connect();
		}


		public function addUser ($username, $email, $password, $birthday, $role = 0) {

			$data[':username'] = $username;
			$data[':email'] = $email;
			$data[':password'] = $password;
			$data[':birthday'] = $birthday;

			$sql = "INSERT INTO ".DB_PREFIX."users (username, email, password, birthday) VALUES (:username, :email, :password, :birthday)";

			$sth = $this->db->prepare($sql);
			$sth->execute($data);

			if($sth->rowCount() > 0){
				return true;
			}

		}
		
		public function getUserByEmail($email){
			$data[':email'] = $email;
			$sql = 'SELECT * FROM '.DB_PREFIX.'users WHERE email = :email LIMIT 1';	
			$sth = $this->db->prepare($sql);
			$sth->execute($data);	
			
			$result = $sth->fetch();
			$this->user = $result;			
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



	}

?>