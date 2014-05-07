<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile_m extends MY_Model {
//inherits from core/my_model
		
	public function get_profile($user_id){
    $this->db->where('userId',$user_id);
	$user_profile =  $this->db->get('user_profile')->result();
	return $user_profile;
  }

}
?>