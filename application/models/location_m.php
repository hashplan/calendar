<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Location_m extends MY_Model
{
    private $allowed_countries = array(1,2,3,7);
    function __construct()
    {
        parent::__construct();
        $this->table = 'metroareas';
    }

    public function get_event_metro_areas()
    {
        return $this->db
            ->select('ma.id, ma.city, ma.picture_path, count(v.Id) as count /* get_event_metro_areas() */', FALSE)
            ->from($this->table . ' as ma')
            ->join('cities as c', 'ma.id = c.metroId')
            ->join('venues as v', 'v.cityId  = c.id', 'inner')
            ->join('events as e', 'e.venueId = v.id AND e.datetime > CURDATE() + INTERVAL 1 DAY', 'inner')
            ->group_by('ma.id')
            ->order_by('ma.city')
            ->get()
            ->result();
    }

    public function get_all_metro_areas()
    {
        $post = $this->input->post();
        $options['name'] = (!empty($post['name'])) ? $post['name'] : NULL;
        if ($options['name'] !== NULL) {
            $this->db->like('city', $options['name']);
        }

        $this->db
            ->select('ma.*', FALSE)
            ->from($this->table . ' as ma')
            ->order_by('ma.city');

        return $this->db
            ->get()
            ->result();
    }

    public function get_metro_areas($options = array())
    {
        if (!isset($options['limit']) || empty($options['limit'])) {
            $options['limit'] = 50;
        }
        if (!isset($options['offset']) || empty($options['offset'])) {
            $options['offset'] = 0;
        }
        if (!isset($options['sort']) || empty($options['sort'])) {
            $options['sort'] = 'ma.city';
        }
        if (!isset($options['sort_type']) || empty($options['sort_type'])) {
            $options['sort_type'] = 'ASC';
        }

        return $this->db
            ->select('ma.*, COUNT(s.id) cities_count')
            ->from($this->table . ' ma')
            ->join('cities s', 's.metroId = ma.id')
            ->order_by($options['sort'], $options['sort_type'])
            ->limit($options['limit'], $options['offset'])
            ->group_by('ma.id')
            ->get()
            ->result();
    }

    public function get_left_block_metro_areas()
    {
        $cities = array(
            'Atlanta',
            'San Diego',
            'San Francisco Bay Area',
            'Charlotte',
            'Las Vegas',
            'Atlantic City',
            'Charlotte',
            'New York Metro',
        );
        return $this->db
            ->select('ma.* /* get_left_block_metro_areas() */', FALSE)
            ->from($this->table . ' as ma')
            ->where_in('ma.city', $cities)
            ->get()
            ->result();
    }

    public function get_city_by_name($city_name = '')
    {
        $result = false;
        $query = $this->db->like('city', $city_name)->limit(1)->get('cities');
        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return $result;
    }

    public function get_city_name_by_id($city_id = '')
    {
        $result = array();
        $query = $this->db->like('id', $city_id)->limit(1)->get('cities');
        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return !empty($result)?$result->city : false;
    }

    public function get_metroareas_total_count()
    {
        return $this->db->count_all_results($this->table);
    }

    public function getMetroById($id)
    {
        return $this->db
            ->select('ma.*, ma.PollstarID pollstar_id, s.id state_id, s.countryId country_id, s.state state_name, c.country country_name')
            ->from($this->table . ' ma')
            ->join('states s', 's.id = ma.stateId')
            ->join('countries c', 'c.id = s.countryId')
            ->where('ma.id', $id)
            ->get()
            ->row();
    }

    public function save_metro($data){
        $metro = array(
            'city' => $data['city'],
            'stateid' => $data['state_id'],
            'PollstarID' => $data['pollstar_id'],
        );
        if(isset($data['id'])&&!empty($data['id'])){
            $result = $this->db->update($this->table, $metro, array('id'=>$data['id']));
        }
        else{
            $result = $this->db->insert($this->table, $metro);
        }
        return $result;
    }

    public function get_states($options = array())
    {
        $this->db
            ->select('id, state')
            ->from('states');
        if (isset($options['country_id']) && !empty($options['country_id'])) {
            $this->db->where('countryId', $options['country_id']);
        }
        return $this->db->get()->result();
    }

    public function get_countries(){
        return $this->db
            ->from('countries')
            ->where_in('id', $this->allowed_countries)
            ->get()
            ->result();
    }

    public function getCities($stateId = false) {
        if (!empty($stateId))
            $this->db->where('stateId', $stateId);
        $res = $this->db->select('id, city')
                        ->from('cities c')
                        ->get()
                        ->result();
        
        $cities[''] = 'Select City';
        foreach ($res as $city)
        {
            $cities[$city->id] = $city->city;
        }
        return $cities;
    }

} 