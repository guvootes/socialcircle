<?php 

	Class Core{

		protected 	$dataPath,
					$data;

		public function __construct(){

			// Set datapath
			$this->dataPath = EXPLORER_ROOT."data.json";
			$this->fetchData();

		}

		protected function fetchData(){

			$json = file_get_contents($this->dataPath);
			$this->data = json_decode($json);

		}

		public function getNav($args){

			$output;

			// html before loop
			$output .= (isset($args['class'])) ? "<ul class='".$args["class"]."'>" : "<ul>";

			// Loop trough data
			foreach($this->data as $parent => $val):
				$output .= "<li>";
					$output .= $parent;

					// Loop trough key data
					if(!empty($val)):
						$output .= (isset($args['childClass'])) ? "<ul class='".$args["childClass"]."'>" : "<ul>";
						foreach($val as $child => $val):
							$output .= "<li>";
								$output .= $val->title;
							$output .= "</li>";	
						endforeach;
						$output .= "</ul>";
					endif;
				$output .= "</li>";
			endforeach;

			// html after loop
			$output .="</ul>";

			return $output;


		}

	}

?>