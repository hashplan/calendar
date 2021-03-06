<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Locations extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('location_m');
        $js_assets = array(
            array('admin/locations.js')
        );
        $this->carabiner->group('page_assets', array('js' => $js_assets));
    }

    public function index($page = 1, $limit = 50, $sort = 'city', $sort_type = 'ASC')
    {
        $this->metroareas($page, $limit, $sort, $sort_type);
    }

    public function metroareas($page = 1, $limit = 50, $sort = 'city', $sort_type = 'ASC'){
        Menu::setActive('admin/locations');
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $counters = $this->get_counters();

        //pagination
        $paged = new stdClass();
        $paged->current_page = $page;
        $paged->total_pages = ceil($counters['metroareas'] / $limit);
        $paged->items_on_page = $limit;
        $paged->has_previous = $page > 1;
        $paged->previous_page = $paged->has_previous ? $page - 1 : $page;
        $paged->total_rows = $counters['metroareas'];
        $paged->has_next = $paged->total_pages > $page;
        $paged->next_page = $paged->has_next ? $page + 1 : $page;
        $this->data['pagination'] = $this->get_paging($paged, 'admin/locations/');

        $options = array(
            'limit' => $limit,
            'offset' => $offset,
            'sort' => $sort,
            'sort_type' => $sort_type
        );
        $this->data['metros'] = $this->location_m->get_metro_areas($options);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode($this->data['metros']);
            die();
        }
        else {
            $js_assets = array(
                array('bootstrap-table.js'),
            );
            $css_assets = array(
                array('bootstrap-table.css'),
            );
            $this->carabiner->group('page_assets', array('js' => $js_assets, 'css' => $css_assets));
            $this->data['view'] = 'admin/locations/metroareas';
        }

        $this->_render_page();
    }

    public function metro_edit($id = false){

        if (!empty($id)) {
            $this->metroareaId = $id;
            $metro = $this->location_m->getMetroById($id);
            $this->data['title'] = 'Edit Metroarea #'.$this->metroareaId;
        } else {
            $this->metroareaId = 0;
            $this->data['title'] = 'Add Metroarea';
            $metro = new stdClass();
            $metro->city = '';
            $metro->stateid = 0;
            $metro->PollstarID = 0;
            $metro->Crawl = 0;
            $metro->picture_path = '';
            $metro->pollstar_id = 0;
            $metro->state_id = 0;
            $metro->state_name = '';
            $metro->country_id = 0;
            $metro->country_name = '';
        }

        $this->form_validation
            ->set_rules('city', 'Metroarea name', "trim|required|xss_clean||callback_check_unique_city_name[$id]")
            ->set_rules('state', 'State', 'trim|reuqired|integer')
            ->set_rules('pollstar_id', 'Pollstar Id', 'trim|integer');

        if($this->form_validation->run() == true){
            $post = $this->input->post();
            $post['id'] = $id;

            $this->metroarea_upload($post);
            redirect('admin/locations');
        } else {
            //validation_errors();
            //die("1111");
        }
        $this->data['metro'] = $metro;

        $options = array(
            'country_id' => $metro->country_id
        );
        $this->data['states'] = $this->location_m->get_states($options);
        $this->data['countries'] = $this->location_m->get_countries();
        $this->data['view'] = 'admin/locations/metro_edit';

        $this->_render_page();
    }


    public function get_states_list(){
        $post = $this->input->post();
        $options = array();
        if (!empty($post['country_id'])) $options['country_id'] = $post['country_id'];
        $states = $this->location_m->get_states($options);
        $states_list = array();
        foreach($states as $state){
            $states_list[$state->id] = $state->state;
        }
        if($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            echo json_encode($states_list);
            die();
        }
    }

    public function metroarea_upload($data)
    {
//        $metroareaId = $this->metroareaId;
//        $metro = $this->location_m->getMetroById($metroareaId);
        $this->load->library('image_lib');
        $original_path = FCPATH . 'assets/uploads/metroareas';
        $resized_path = FCPATH . 'assets/img/metroareas';
        $old_picture = '';
        if (isset($data['id']) && !empty($data['id']))
        {
            $metro = $this->location_m->getMetroById($data['id']);
            $old_picture = $metro->picture_path;
        }

        
        //config for original upload
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'max_size' => 20000, //2MB max
            'upload_path' => $original_path
        );

        //upload the image
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('metroareafile')) {
            $error = array('error' => $this->upload->display_errors());
        }
        else {
            $image_data = $this->upload->data();
        }

        if (isset($image_data) && !empty($image_data)) {
            //config for resize()
            $config = array(
                'source_image' => $image_data['full_path'],
                'new_image' => $resized_path,
                'maintain_ratio' => true,
                'width' => 1360,
                'height' => 350
            );

            //resize the image
            $this->image_lib->initialize($config);
            $this->image_lib->crop();

            $data['picture_path'] = $image_data['file_name'];

            $res = $this->location_m->save_metro($data);
            if ($res) {
                if (!empty($old_picture))
                {
                    unlink($original_path . '/' . $old_picture);
                    unlink($resized_path . '/' . $old_picture);
                }
                unlink($image_data['full_path']);
            }
        } else {
            $res = $this->location_m->save_metro($data);
            redirect(base_url('admin/locations'));
        }

    }

    public function check_unique_city_name($name, $id)
    {
        $result = $this->location_m->checkUniqueMetroName($name, $id);
        if (!$result) {
            $this->form_validation->set_message('check_unique_city_name', 'Metroarea with name "'.$name.'" is already exist.');
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function metro_remove($metroId) {
        $assignedCitiesExist = $this->location_m->checkCitiesAssignedToMetroarea($metroId);

        if ($assignedCitiesExist) {
            $this->session->set_flashdata('flash_message_type', 'error');
            $this->session->set_flashdata('flash_message', "Can't delete metroarea. Metroarea have assigned cities");
        } else {
            $res = $this->location_m->delete_metroarea($metroId);
            if ($res) {
                $this->session->set_flashdata('flash_message', "Metroarea deleted successfully");
            } else {
                $this->session->set_flashdata('flash_message', "Metroarea not deleted");
            }
        }
        
        redirect(base_url('admin/locations'));
    }

}