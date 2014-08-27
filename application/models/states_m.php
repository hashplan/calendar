<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class States_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'states';
    }
    
    public function getStateNameById($stateId) {
        $res = $this->db->select('state')
                        ->from('states s')
                        ->where('s.id', $stateId)
                        ->get()
                        ->row();
        return isset($res->state)&&!empty($res->state)?$res->state:false;
    }
}