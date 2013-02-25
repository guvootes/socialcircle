<?php 
	Class ActivityController extends Controller{

		public function getActivities($page = 0, $limit = 10){


			$errors = array();

			if(!$this->authenticate()){

				$this->app->response()->status(400);

				$name = 'Authenticatie';
				$message = 'Je hebt geen rechten om deze pagina te bekijken';
				array_push($errors, array("message" => $message, "name" => $name));
				return json_encode($errors);

			}

			$offset = ($page -1) * $limit;

			$activityModel = new ActivityModel;


			// count row for total activities
			$total = $activityModel->countActivities();
			$totalPages  = ceil($total / $limit);



			$response = new stdClass;

			$response->posts = $activityModel->fetchActivities($limit, $offset);
			$response->total = $total;
			$response->totalPages = $totalPages;
 

			return json_encode($response);

		}

	}

?>