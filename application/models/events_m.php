<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events_m extends MY_Model
{
    public function __construct(){
        parent::__construct();
        $this->table = 'events';
    }

    public function get_all($options = array())
    {
        $current_user_id = $this->ion_auth->user()->row()->id;
        $this->load->model('users_m');
        $user_id = !empty($options['user_id']) && $this->users_m->user_id_is_correct($options['user_id']) ? $options['user_id'] : $current_user_id;
        $is_admin_or_owner = $this->users_m->is_admin_or_owner($user_id);
        $is_friend_of = $this->users_m->is_friend_of($user_id);

        if (empty($options['limit'])) {
            $options['limit'] = 5;
        }

        if (empty($options['offset'])) {
            $options['offset'] = 0;
        }

        $is_deleted = !empty($options['events_type']) && $options['events_type'] === 'deleted' ? 1 : 0;
        $is_in_calendar = !empty($options['events_type']) && $options['events_type'] === 'my' ? 1 : 0;

        $this->db
            ->select('e.id, e.name, v.name as venue_name, e.datetime, DATE(e.datetime) AS date_only, e.ownerId AS event_owner_id')
            ->select($is_deleted . ' AS is_deleted', FALSE)
            ->select($is_in_calendar . ' AS is_in_calendar /* get_all() - ' . $this->db->escape($options['events_type']) . ' */', FALSE)
            ->from('events AS e')
            ->join('venues AS v', 'e.venueId = v.id', 'left')
            ->join('cities AS ci', 'v.cityId = ci.id', 'left')
            ->join('metroareas AS ma', 'ci.metroId = ma.id', 'left')
            ->where('(e.ownerId IS NULL OR e.ownerId = ' . $this->db->escape($user_id) . ' OR (e.ownerId IS NOT NULL AND e.is_public = 1))')
            ->order_by('e.datetime')
            ->limit($options['limit'], $options['offset']);

        if (!empty($options['events_type'])) {
            if ($options['events_type'] === 'deleted' && $is_admin_or_owner) {
                $this->db->join('events_deleted AS ed', 'e.id = ed.eventId AND ed.userId = ' . $this->db->escape($user_id), 'inner');
            }
            else if ($options['events_type'] === 'favourite' && $is_admin_or_owner) {
                $this->db->join('events_favourited AS ef', 'e.id = ef.eventId AND ef.userId = ' . $this->db->escape($user_id), 'inner');
                $this->db->where('NOT EXISTS (SELECT 1 FROM events_deleted ed WHERE e.id = ed.eventId AND ed.userId = ' . $this->db->escape($user_id) . ')', '', FALSE);
            }
            else if (($options['events_type'] === 'my' || $options['events_type'] === 'friends') && ($is_admin_or_owner || $is_friend_of)) {
                $this->db->join('user_events AS ue', 'e.id = ue.eventId AND ue.userId = ' . $this->db->escape($user_id), 'inner');
                $this->db->where('NOT EXISTS (SELECT 1 FROM events_deleted ed WHERE e.id = ed.eventId AND ed.userId = ' . $this->db->escape($user_id) . ')', '', FALSE);
            }
            else if ($options['events_type'] === 'all' && $is_admin_or_owner) {
                $this->db->select('IF(ue.eventId IS NOT NULL, 1, 0) AS is_in_calendar_all', FALSE);
                $this->db->select('IF(ef.eventId IS NOT NULL, 1, 0) AS is_favourite_all', FALSE);
                $this->db->where('NOT EXISTS (SELECT 1 FROM events_deleted ed WHERE e.id = ed.eventId AND ed.userId = ' . $this->db->escape($user_id) . ')', '', FALSE);
                $this->db->join('user_events ue', 'e.id = ue.eventId', 'left');
                $this->db->join('events_favourited AS ef', 'e.id = ef.eventId AND ef.userId = ' . $this->db->escape($user_id), 'left');
                $this->db->group_by('id');
            }
            else if ($options['events_type'] === 'custom' && $is_admin_or_owner) {
                $this->db->where('ownerId IS NOT NULL');
            }
            else {
                // 403
            }
        }

        //search by event name
        if (!empty($options['name'])) {
            $this->db->like('e.name', $options['name']);
        }
        //categories filter
        if (!empty($options['category'])) {
            $this->load->model('categories_m');
            $categories = $this->categories_m->get_child_categories($options['category']);
            $category_ids = array();
            foreach ($categories as $cat) {
                $category_ids[] = $cat->id;
            }
            $this->db->join('event_categories AS ec', 'e.id = ec.event_id', 'inner');
            $this->db->join('categories AS c', 'ec.category_id = c.id', 'inner');
            $this->db->where_in('c.id', $category_ids);
        }
        //metroarea filter
        if (!empty($options['metro_id'])) {
            $this->db->where('ma.id', $options['metro_id']);
        }
        //preselected filter
        if (!empty($options['preselects'])) {
            $date_range = array();
            if ($options['preselects'] == 'weekend') {
                $date_range['start'] = date('Y-m-d H:i:s', strtotime('next Friday'));
                $date_range['end'] = date('Y-m-d H:i:s', strtotime('next Sunday'));
                $date_range['end'] = str_replace('00:00:00', '23:59:59', $date_range['end']);
            } else if (is_numeric($options['preselects'])) {
                $date_range['start'] = date('Y-m-d H:i:s', strtotime('today'));
                $date_range['end'] = date('Y-m-d H:i:s', strtotime('+' . ($options['preselects'] - 1) . ' days midnight'));
                $date_range['end'] = str_replace('00:00:00', '23:59:59', $date_range['end']);
            }
        }
        //date filter
        if (!empty($options['specific_date'])) {
            $date_range['start'] = $options['specific_date'] . ' 00:00:00';
            $date_range['end'] = $options['specific_date'] . ' 23:59:59';
        }
        if (empty($options['specific_date']) && empty($options['preselects'])) {
            $date_range['start'] = date('Y-m-d') . ' 00:00:00';
            $date_range['end'] = date('Y-m-d', strtotime('+5 years')) . ' 23:59:59';
        }

        $this->db->where('e.datetime >=', $date_range['start']);
        $this->db->where('e.datetime <=', $date_range['end']);

        return $this->db->get()->result();
    }

    public function get_event_by_id($id)
    {

        $user_id = $this->ion_auth->user()->row()->id;;

        return $this->db
            ->select('
				e.id AS event_id,
				e.name AS event_name,
				e.description AS event_description,
				e.typeId AS event_typeId,
				e.datetime AS event_datetime,
				e.venueId AS event_venueId,
				e.stubhub_url AS event_stubhub_url,
				e.insertedon AS event_insertedon,
				e.insertedby AS event_insertedby,
				e.updatedon AS event_updatedon,
				e.updatedby AS event_updatedby,
				e.ownerId AS event_owner_id,
				v.id AS venue_id,
				v.name AS venue_name,
				v.address AS venue_address,
				v.city AS venue_city,
				v.cityId AS venue_cityId,
				v.stateId AS venue_stateId,
				v.zip AS venue_zip,
				v.phone AS venue_phone,
				v.website AS venue_website,
				v.description AS venue_description,
				v.typeId AS venue_typeId,
				v.insertedon AS venue_insertedon,
				v.insertedby AS venue_insertedby,
				v.updatedon AS venue_updatedon,
				v.updatedby AS venue_updatedby,
				ma.id AS city_id,
				ma.city AS city_city,
				ma.stateId AS city_state_id
			')
            ->from('events AS e')
            ->join('venues AS v', 'e.venueId = v.id', 'left')
            ->join('metroareas AS ma', 'v.cityId = ma.id', 'left')
            ->where('e.id', $id)
            ->where('(e.ownerId IS NULL OR e.ownerId = ' . $this->db->escape($user_id) . ' OR (e.ownerId IS NOT NULL AND (e.is_public = 1 OR EXISTS (SELECT 1 FROM user_connections uc WHERE e.id = uc.eventId AND uc.connectionUserId = ' . $this->db->escape($user_id) . '))))')
            ->get()
            ->row();
    }

    public function get_new_user_added_event()
    {
        $user_added_event = new stdClass();
        $user_added_event->name = '';
        $user_added_event->description = '';
        $user_added_event->typeId = '';
        $user_added_event->datetime = '';
        $user_added_event->venueId = '';
        $user_added_event->stubhub_url = '';
        $user_added_event->insertedon = '';
        $user_added_event->insertedby = '';
        $user_added_event->updatedon = '';
        $user_added_event->updatedby = '';
        return $user_added_event;
    }

    public function get_favourite_events($event_id = NULL, $user_id = NULL)
    {
        $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
        if (!$user_id_is_correct) {
            $user_id = $this->ion_auth->user()->row()->id;;
        }

        $this->db->from('events_favourited');

        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if ($event_id_is_correct) {
            $this->db->where('eventId', $event_id);
        }

        $this->db->where('userId', $user_id);

        return $this->db->get()->result();
    }

    public function get_deleted_events($event_id = NULL, $user_id = NULL)
    {
        $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
        if (!$user_id_is_correct) {
            $user_id = $this->ion_auth->user()->row()->id;;
        }

        $this->db->from('events_deleted');

        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if ($event_id_is_correct) {
            $this->db->where('eventId', $event_id);
        }

        $this->db->where('userId', $user_id);

        return $this->db->get()->result();
    }

    public function add_to_favourites($event_id, $user_id = NULL)
    {

        $result = false;

        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;

        if ($event_id_is_correct) {
            $event = $this->get_event_by_id($event_id);

            if (!empty($event)) {
                $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
                if (!$user_id_is_correct) {
                    $user_id = $this->ion_auth->user()->row()->id;
                }

                $already_favourite = count($this->get_favourite_events($event_id, $user_id)) === 1;

                if ($already_favourite) {
                } else if (!$already_favourite && $event_id_is_correct) {
                    $this->db->delete('events_deleted', array(
                        'userId' => $user_id,
                        'eventId' => $event_id,
                    ));
                    $result = $this->db->insert('events_favourited', array(
                        'userId' => $user_id,
                        'eventId' => $event_id,
                    ));
                }
            }
        }

        return $result;
    }

    public function delete_from_favourites($event_id, $user_id = NULL)
    {
        $result = false;
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;

        if ($event_id_is_correct) {
            $event = $this->get_event_by_id($event_id);

            if (!empty($event)) {
                $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
                if (!$user_id_is_correct) {
                    $user_id = $this->ion_auth->user()->row()->id;
                }
                $result = $this->db->delete('events_favourited', array(
                    'userId' => $user_id,
                    'eventId' => $event_id,
                ));
            }
        }

        return $result;
    }

    public function delete($event_id, $user_id = NULL)
    {

        $result = false;

        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;

        if ($event_id_is_correct) {
            $event = $this->get_event_by_id($event_id);

            if (!empty($event)) {
                $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
                if (!$user_id_is_correct) {
                    $user_id = $this->ion_auth->user()->row()->id;
                }

                $already_deleted = count($this->get_deleted_events($event_id, $user_id)) === 1;

                if ($already_deleted) {
                } else if (!$already_deleted && $event_id_is_correct) {
                    $this->db->delete('events_favourited', array(
                        'userId' => $user_id,
                        'eventId' => $event_id,
                    ));
                    $result = $this->db->insert('events_deleted', array(
                        'userId' => $user_id,
                        'eventId' => $event_id,
                    ));
                }
            }
        }
        return $result;
    }

    public function restore_from_trash($event_id, $user_id = NULL)
    {

        $result = false;

        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;

        $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
        if (!$user_id_is_correct) {
            $user_id = $this->ion_auth->user()->row()->id;
        }

        $is_deleted = count($this->get_deleted_events($event_id, $user_id)) === 1;

        if ($is_deleted) {
            $result = $this->db->delete('events_deleted', array(
                'userId' => $user_id,
                'eventId' => $event_id,
            ));
        }

        return $result;
    }

    public function get_calendar_events($event_id = NULL, $user_id = NULL)
    {
        $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
        if (!$user_id_is_correct) {
            $user_id = $this->ion_auth->user()->row()->id;;
        }

        $this->db->from('user_events');

        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if ($event_id_is_correct) {
            $this->db->where('eventId', $event_id);
        }

        $this->db->where('userId', $user_id);

        return $this->db->get()->result();
    }

    /**
     * Add event to user plan
     *
     * @param $event_id
     * @param null $user_id
     * @return bool
     */
    public function add_to_calendar($event_id, $user_id = NULL)
    {
        $result = false;
        $event = $this->get_event_by_id($event_id);
        if (!empty($event)) {
            $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
            if (!$user_id_is_correct) {
                $user_id = $this->ion_auth->user()->row()->id;
            }

            $already_in_calendar = count($this->get_calendar_events($event_id, $user_id)) === 1;
            if (!$already_in_calendar) {
                $result = $this->db->insert('user_events', array(
                    'userId' => $user_id,
                    'eventId' => $event_id,
                    'insertedon' => NULL,
                    'insertedby' => NULL,
                    'updatedon' => NULL,
                    'updatedby' => NULL,
                    'ownerId' => $event->event_owner_id,
                ));
            }
        }
        return $result;
    }

    /**
     * Remove event from user plan
     *
     * @param $event_id
     * @param null $user_id
     * @return bool
     */
    public function delete_from_calendar($event_id, $user_id = NULL)
    {
        $result = false;
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;

        if ($event_id_is_correct) {
            $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
            if (!$user_id_is_correct) {
                $user_id = $this->ion_auth->user()->row()->id;
            }
            $result = $this->db->delete('user_events', array(
                'userId' => $user_id,
                'eventId' => $event_id,
                'ownerId !=' => $user_id
            ));
        }

        return $result;
    }

    public function restore_from_calendar($event_id, $user_id = NULL)
    {
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;

        if ($event_id_is_correct) {
            $user_id_is_correct = $user_id !== NULL && is_numeric($user_id) && $user_id;
            if (!$user_id_is_correct) {
                $user_id = $this->ion_auth->user()->row()->id;
            }

            $already_in_calendar = count($this->get_calendar_events($event_id, $user_id)) === 1;

            if ($already_in_calendar) {
                $this->db->delete('user_events', array(
                    'userId' => $user_id,
                    'eventId' => $event_id,
                ));
            }
        }
    }

    public function save($data)
    {
        $user_id = $this->ion_auth->user()->row()->id;
        $is_new = empty($data['id']);
        if (empty($data['private'])) {
            $data['private'] = FALSE;
        }
        if ($is_new) {

            $venue_data = array(
                'address' => $data['address']
            );
            if ($data['city']) {
                $venue_data['cityId'] = $data['city']->id;
                $venue_data['city'] = $data['city']->city;
                $venue_data['stateId'] = $data['city']->stateId;
                $venue_data['name'] = $data['address'];
            }
            $venue_id = NULL;
            if ($this->db->insert('venues', $venue_data)) {
                $venue_id = $this->db->insert_id();
            }

            $this->db->insert('events', array(
                'name' => $data['name'],
                'description' => $data['description'],
                'typeId' => NULL,
                'datetime' => $data['date'] . ' ' . $data['time'],
                'venueId' => $venue_id,
                'stubhub_url' => NULL,
                'insertedon' => NULL,
                'insertedby' => NULL,
                'updatedon' => NULL,
                'updatedby' => NULL,
                'is_public' => !((bool)$data['private']),
                'ownerId' => $user_id,
            ));
            $event_id = $this->db->insert_id();
            $this->add_to_calendar($event_id);
        }

    }

    public function get_total_count($type = 'all'){
        if($type == 'future_events'){
            $this->db->where(array('datetime >='=>date('Y-m-d H:i:s')));
        }
        elseif($type == 'custom_events'){
            $this->db->where('ownerId IS NOT NULL');
        }
        return $this->db->count_all_results($this->table);
    }
}