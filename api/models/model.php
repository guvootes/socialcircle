<?php 

	Class Model{

		protected $db;

		public function __construct() {
			$this->connect();
		}

		protected function connect(){

			try {
				$this->db = new PDO('mysql:host='.HOST.';dbname='.NAME.';', USER, PASS);
			} catch (PDOException $e) {
				die('DB Connection Failed: ' . $e->getMessage());
			}
		}

		public function getAttempts($userId){

			$now = date('Y-m-d H:i:s');
			// All login attempts are counted from the past 2 hours. 
			$validAttempts = $now - (2 * 60 * 60);

			$sql = 'SELECT dateTime FROM '.DB_PREFIX.'login_attempts WHERE user_id = ? AND dateTime > '.$validAttempts;

			$stmt = $this->db->prepare($sql); 

			$stmt->bindParam(1, $userId, PDO::PARAM_INT);
			$stmt->execute(); // Execute the prepared query.

			return $stmt->rowCount();
		}

		public function addLoginAttempt($userId) {

			$now = date('Y-m-d H:i:s');

			$data[':id'] = $userId;
			$data[':dateTime'] = $now;

			$sql = "INSERT INTO ".DB_PREFIX."login_attempts (user_id, datetime) VALUES (:id, :dateTime)";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($data);

		}


	}

?>