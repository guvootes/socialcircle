<?php 

	Class Application{

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

			if ( !isset($_SESSION['CSRF_TOKEN']) )
			$this->csrf_token();


		}

		public function csrf_token() {
			$this->csrf = md5(uniqid().rand());
			$_SESSION['CSRF_TOKEN'] = $this->csrf;
			return $this->csrf;
		}
	


	}

?>