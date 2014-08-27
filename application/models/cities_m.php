<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cities_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'cities';
    }
    
    public function getCityNameById($cityId) {
        $res = $this->db->select('city')
                        ->from('cities c')
                        ->where('c.id', $cityId)
                        ->get()
                        ->row();
        return isset($res->city)&&!empty($res->city)?$res->city:false;
    }
}