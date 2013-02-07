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

		public function getTopNav($args){

			$output;

			// html before loop
			$output .= (isset($args['class'])) ? "<ul class='".$args["class"]."'>" : "<ul>";

			// Loop trough data
			foreach($this->data as $parent => $val):
				$active = (isset($_GET['p']) &&  $this->slug($parent) == $_GET['p'] ) ? 'active' : null;
				$output .= "<li class='".$this->slug($parent)."'>";
					$output .= '<a class="'.$active.'" href="?p='.$this->slug($parent).'">';
						$output .= '<i></i>';
						$output .= $parent;
					$output .= '</a>';
				$output .= "</li>";
			endforeach;

			// html after loop
			$output .="</ul>";

			return $output;


		}

		static public function slug($input){ 
		  // replace non letter or digits by -
		  $output = preg_replace('~[^\\pL\d]+~u', '-', $input);

		  // trim
		  $output = trim($output, '-');

		  // transliterate
		  $output = iconv('utf-8', 'us-ascii//TRANSLIT', $output);

		  // lowercase
		  $output = strtolower($output);

		  // remove unwanted characters
		  $output = preg_replace('~[^-\w]+~', '', $output);

		  if (empty($output))
		  {
		    return 'n-a';
		  }

		  return $output;
		}

	}

?>