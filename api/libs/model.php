<?php 

	Class Model{

		protected $db;

		protected function connect(){

			try {
				$this->db = new PDO('mysql:host='.HOST.';dbname='.NAME.';', USER, PASS);
			} catch (PDOException $e) {
				die('DB Connection Failed: ' . $e->getMessage());
			}

		}


	}

?>