<?php 

	Class ActivityModel extends Model{

		public function fetchActivities($limit, $offset){

			$sql = "SELECT * FROM ".DB_PREFIX."posts WHERE parent = 0 ORDER BY date DESC LIMIT :limit OFFSET :offset";	

			$stmt = $this->db->prepare($sql);

			$stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
			$stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);			
			$stmt->execute();

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $result;

		}

		public function countActivities(){

			$sql = "SELECT COUNT(*) FROM ".DB_PREFIX."posts WHERE parent = 0";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			return $stmt->fetchColumn();


		}


	}

?>