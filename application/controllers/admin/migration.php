<?php
class Migration extends My_Controller{
		public function __construct(){
			parent::__construct();
		}

	public function index(){
/*var_dump($this->db);
$root=dirname(__FILE__);
var_dump($root);
*/
$this->load->library('migration');
		if ( !$this->migration->current()) {
		show_error($this->migration->error_string());
}
else{
		echo 'Migration worked!';
	}

	}
}
?>