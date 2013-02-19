<?php 
	Class ActivityController extends Controller{

		protected $authentication;


		protected function authenticate(){

			$errors = array();

			$this->authentication = UserController::checkUser();

			if(!$this->authentication){
				$name = 'Authenticatie';
				$message = 'Je hebt geen rechten om deze pagina te bekijken';
				array_push($errors, array("message" => $message, "name" => $name));
				return json_encode($errors);
			}

			if(!empty($errors))	return json_encode($errors);

			// if the're no error return true
			return $this->authentication;

		}

		public function getActivities($amount, $offset){

			$activityModel = new ActivityModel;
			return $activityModel->fetchActivities($amount, $offset);

		}

		public function getActivity($id){


		}





	}

?>