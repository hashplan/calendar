<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Events_m extends MY_Model {
//inherits from core/my_model
		
		
	public function events_autocomplete($event_search_input){
    $this->db->select('name,eventId');
    $this->db->like('name', $event_search_input);
	$this->db->or_like('datetime', $event_search_input);
    $query = $this->db->get('events');
		if($query->num_rows > 0){
		  foreach ($query->result_array() as $row){
				$event_array[] = htmlentities(stripslashes($row['name']));//build an array
		  }
	//echo header('Content-Type: application/json');
	echo json_encode($event_array); //format the array into json data
		}
  }

 /** public function events_autocomplete($event_search_input){
    $this->db->select('name');
    $this->db->like('name', $event_search_input);
    $query = $this->db->get('events');
		if($query->num_rows > 0){
			$header = false;
			$output_string = '<div class = "row panel panel-info" style = "background-color:lightgray">';
		  foreach ($query->result_array() as $row){
				$output_string .= $row['name'];
		  }
			$output_string .= '</div>';
			} else{
				$output_string = 'There are no results';
			}
				echo json_encode($output_string);//echo json_encode($output_string); //format the array into json data
		}
		*/
  }
?>