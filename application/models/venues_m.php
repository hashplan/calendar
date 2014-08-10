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
            ->select('v.id as venue_id, v.id as id, v.name as venue_name, v.address venue_address, v.city venue_city')
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


    public function get_top_venues($options = array())
    {
        $this->db
            ->select('v.id as venue_id, v.id as id, v.name as venue_name, v.address venue_address, v.city venue_city, count(e.id) events_count')
            ->from($this->table . ' v')
            ->join('events e', 'e.venueId = v.id');

        if (!isset($options['next_days']) || empty($options['next_days'])) {
            $options['next_days'] = 30;
        }
        $this->db
            ->where('e.datetime between now() and (NOW() + INTERVAL ' . $this->db->escape($options['next_days']) . ' DAY)');

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
        $this->db->limit($options['limit']);

        return $this->db->get()->result();
    }

} 