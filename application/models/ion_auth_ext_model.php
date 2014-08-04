<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ion_auth_ext_model extends Ion_auth_model
{

    public function include_group_info(){
        $this->db->select($this->tables['groups'].'.name AS user_group');
        $this->db->join(
            $this->tables['users_groups'],
            $this->tables['users_groups'].'.'.$this->join['users'].'='.$this->tables['users'].'.id',
            'inner'
        );
        $this->db->join(
            $this->tables['groups'],
            $this->tables['users_groups'].'.'.$this->join['groups'].'='.$this->tables['groups'].'.id',
            'inner'
        );
        return $this;
    }

    /**
     * Users
     *
     * @param null $groups
     * @return $this|object
     */
    public function users($groups = NULL)
    {
        $this->trigger_events('users');

        if (isset($this->_ion_select) && !empty($this->_ion_select))
        {
            foreach ($this->_ion_select as $select)
            {
                $this->db->select($select);
            }

            $this->_ion_select = array();
        }
        else
        {
            //default selects
            $this->db->select(array(
                $this->tables['users'].'.*',
                $this->tables['users'].'.id as id',
                $this->tables['users'].'.id as user_id'
            ));
        }

        //filter by group id(s) if passed
        if (isset($groups))
        {
            //build an array if only one group was passed
            if (is_numeric($groups))
            {
                $groups = Array($groups);
            }

            //join and then run a where_in against the group ids
            if (isset($groups) && !empty($groups))
            {
                $this->db->distinct();
                $this->db->where_in($this->tables['users_groups'].'.'.$this->join['groups'], $groups);
            }
        }

        $this->trigger_events('extra_where');

        //run each where that was passed
        if (isset($this->_ion_where) && !empty($this->_ion_where))
        {
            foreach ($this->_ion_where as $where)
            {
                $this->db->where($where);
            }

            $this->_ion_where = array();
        }

        if (isset($this->_ion_like) && !empty($this->_ion_like))
        {
            foreach ($this->_ion_like as $like)
            {
                $this->db->or_like($like);
            }

            $this->_ion_like = array();
        }

        if (isset($this->_ion_limit) && isset($this->_ion_offset))
        {
            $this->db->limit($this->_ion_limit, $this->_ion_offset);

            $this->_ion_limit  = NULL;
            $this->_ion_offset = NULL;
        }
        else if (isset($this->_ion_limit))
        {
            $this->db->limit($this->_ion_limit);

            $this->_ion_limit  = NULL;
        }

        //set the order
        if (isset($this->_ion_order_by) && isset($this->_ion_order))
        {
            $this->db->order_by($this->_ion_order_by, $this->_ion_order);

            $this->_ion_order    = NULL;
            $this->_ion_order_by = NULL;
        }

        $this->response = $this->db->get($this->tables['users']);

        return $this;
    }
}