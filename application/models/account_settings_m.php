<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_settings_m extends MY_Model {

    public function __construct(){
        $this->table = 'user_settings';
    }

    public function get_account_settings($user_id = null){
        $result = false;
        if(is_null($user_id) || !$this->ion_auth->in_group("admin")){
            $user_id = $this->ion_auth->user()->row()->id;
        }
        $query = $this->db->where('userId', $user_id)->get($this->table);
        if($query->num_rows() > 0){
            $result = $query->result();
            $result = $result[0];
        }
        return $result;
    }

    public function save($key, $value, $user_id = null){
        if(is_null($user_id)){
            $user_id = $this->ion_auth->user()->row()->id;
        }
        if($this->db->get_where($this->table, array('userId'=>$user_id))->num_rows()){
            $result = $this->db->update($this->table, array($key=>$value), array('userId' => $user_id));
        }
        else{
            $result = $this->db->insert($this->table, array($key=>$value, 'userId' => $user_id));
        }

        return $result;
    }

    public function find_user_by_facebook_id($facebook_id){
        return $this->db
            ->from($this->table)
            ->where(array('fb_id' => $facebook_id))
            ->get()
            ->row();
    }

}