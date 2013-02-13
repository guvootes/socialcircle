<?php

	Class UserModel extends Model {
	
		protected $user;

		public function __construct() {
			parent::__construct();
		}


		public function addUser ($username, $email, $password, $birthday, $role = 0) {

			$data[':username'] = $username;
			$data[':email'] = $email;
			$data[':password'] = $password;
			$data[':birthday'] = $birthday;

			$sql = "INSERT INTO ".DB_PREFIX."users (username, email, password, birthday) VALUES (:username, :email, :password, :birthday)";

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
	}

?>