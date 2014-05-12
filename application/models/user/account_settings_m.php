<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account_settings_m extends MY_Model {
//inherits from core/my_model


	//user_profile table needs to be completely redesigned - and probably renamed "user_account_settinngs" -  since now we have the full crawler data available
	//also category and subcategory tables are no longer needed in the database, also because we have other data available in other tables via crawler		
	public function get_account_settings($user_id){
    $this->db->where('userId',$user_id);
	$account_settings =  $this->db->get('user_profile')->result();
	return $account_settings;
  }

}
?>