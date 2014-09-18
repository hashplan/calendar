<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Venues_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'venues';
    }

    public function get_venues($options = array())
    {
        $this->db
            ->select('v.id as venue_id, v.id as id, v.name as venue_name, v.address venue_address, v.city venue_city, v.is_excluded is_excluded')
            ->from($this->table . ' v');

        if (isset($options['metroarea']) && !empty($options['metroarea'])) {
            $this->db
                ->join('cities c', 'v.cityId = c.id')
                ->join('metroareas m', 'c.metroId = m.id')
                ->where('m.id', $options['metroarea']);

        }
        
        if (isset($options['limit']) && !empty($options['limit'])) {
            $this->db->limit($options['limit']);
        }

        return $this->db->get()->result();
    }

  public function get_venues_list($options = array())
    {
        $this->db
            ->select('v.id as venue_id, v.id as id, v.name as venue_name, v.address venue_address, v.city venue_city, co.country as venue_country, s.state as venue_state, v.is_excluded is_excluded')
            ->from($this->table . ' v');

            $this->db
                ->join('cities c', 'v.cityId = c.id', 'left')
                ->join('states s', 'v.stateId = s.id', 'left')
                ->join('countries co', 's.countryid = co.id', 'left');
        
        if (isset($options['venues_type']) && !empty($options['venues_type'])) {
            $this->db->where('v.typeId', $options['venues_type']);
        }
        if (!isset($options['offset']) || empty($options['offset'])) {
            $options['offset'] = 0;
        }
        if (isset($options['limit']) || empty($options['limit'])) {
            $options['limit'] = 50;
        }

        $this->db->limit($options['limit'], $options['offset']);

        return $this->db->get()->result();
    }
    
    
    public function get_top_venues($options = array())
    {
        $this->db
            ->select('v.id as venue_id, v.id as id, v.name as venue_name, v.address venue_address, v.city venue_city, count(e.id) events_count')
            ->from($this->table . ' v')
            ->join('events e', 'e.venueId = v.id');

        if (!isset($options['next_days']) || empty($options['next_days'])) {
            $options['next_days'] = 30;
        }
        $this->db->where('e.datetime between now() and (NOW() + INTERVAL ' . $this->db->escape($options['next_days']) . ' DAY)');
        $this->db->where('v.is_excluded', 0);

        if (isset($options['metroarea']) && !empty($options['metroarea'])) {
            $this->db
                ->join('cities c', 'v.cityId = c.id')
                ->join('metroareas m', 'c.metroId = m.id')
                ->where('m.id', $options['metroarea']);

        }

        $this->db
            ->group_by('e . venueId')
            ->order_by('events_count', 'DESC');

        if (!isset($options['limit']) || empty($options['limit'])) {
            $options['limit'] = 5;
        }
        if (!isset($options['offset']) || empty($options['offset'])) {
            $options['offset'] = 0;
        }
        $this->db->limit($options['limit'], $options['offset']);

        return $this->db->get()->result();
    }
    
    public function delete($venueId)
    {
        $this->db->where('id', $venueId);
        return $this->db->delete('venues');
    }
    
    public function get_venue_by_id($venueId)
    {
        if (!$venueId)
        {
            return false;
        }
        $this->db
            ->select('v.id as venue_id, v.id as id, v.name, v.address, v.website, v.city city, v.description, v.phone, v.zip, co.country as country, s.state as state, s.id as stateId, co.id as country_id, c.id as cityId')
            ->from($this->table . ' v');

            $this->db
                ->join('cities c', 'v.cityId = c.id', 'left')
                ->join('states s', 'v.stateId = s.id', 'left')
                ->join('countries co', 's.countryid = co.id', 'left');
            $this->db->where('v.id', $venueId);
        return $this->db->get()->row();
    }
    
    public function save($data, $venueId = 0)
    {
        if ($venueId) {
            $this->db->where('id', $venueId);
            $res = $this->db->update('venues', $data);
        } else {
            $res = $this->db->insert('venues', $data);
        }
        return $res;
    }

    public function switch_excluded($venueId, $status = 0)
    {
        return $this->db->update('venues', array('is_excluded' => ($status == 1 ? 1 : 0)), array('id' => $venueId));
    }


    public function get_total_count(){
        return $this->db->count_all_results($this->table);
    }
}