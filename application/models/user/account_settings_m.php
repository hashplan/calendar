<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account_settings_m extends MY_Model {
//inherits from core/my_model
	var $original_path;
	var $resized_path;
	var $thumbs_path;
	
function __construct(){
		parent::__construct();
		$this->original_path = realpath(APPPATH.'../assets/img/users');
		$this->resized_path = realpath(APPPATH.'../assets/img/users');
		}
		
	//user_profile table needs to be completely redesigned - and probably renamed "user_account_settinngs" -  since now we have the full crawler data available
	//also category and subcategory tables are no longer needed in the database, also because we have other data available in other tables via crawler		
	public function get_account_settings($user_id){
    $this->db->where('userId',$user_id);
	$account_settings =  $this->db->get('user_profile')->result();
	return $account_settings;
  }
  
  public function avatar_upload($user_id){
	
	$this->load->library('image_lib');
    //config for original upload
	$config = array(
    'allowed_types'     => 'jpg|jpeg|gif|png',
    'max_size'          => 2048, //2MB max
    'upload_path'       => $this->original_path
  );

	//upload the image
	$this->load->library('upload', $config);
    $this->upload->do_upload();
	$image_data = $this->upload->data();
	
	//config for resize()
    $config = array(
    'source_image' => $image_data['full_path'], 
    'new_image' => $this->resized_path,
    'maintain_ratio' => true,
    'width' => 152,
    'height' => 152
    );
    
	//resize the image
    $this->image_lib->initialize($config);
    $this->image_lib->resize();
	
	//NEED TO SET UP A MIGRATION FOR THE TABLE TO INCLUDE AVATAR PATH, DATE OF BIRTH
	//store the image path for the user in database
	$data = array(
               'avatar_path' => $this->resized_path,
            );

	$this->db->where('id', $user_id);
	$this->db->update('account_settings', $data); 

  }

}
?>