<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Master_menu_model');
        $this->load->library('form_validation');
        $this->rbac->check_module_access();
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'master_menu/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'master_menu/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'master_menu/index.html';
            $config['first_url'] = base_url() . 'master_menu/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Master_menu_model->total_rows($q);
        $master_menu = $this->Master_menu_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'master_menu_data' => $master_menu,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Master Menu',
            'konten' => 'master_menu/master_menu_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Master_menu_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_menu' => $row->id_menu,
		'nama_menu' => $row->nama_menu,
		'icon' => $row->icon,
		'link' => $row->link,
		'status' => $row->status,
		'parent' => $row->parent,
	    );
            $this->load->view('master_menu/master_menu_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_menu'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Master Menu',
            'konten' => 'master_menu/master_menu_form',
            'button' => 'Simpan',
            'action' => site_url('master_menu/create_action'),
	    'id_menu' => set_value('id_menu'),
	    'nama_menu' => set_value('nama_menu'),
	    'icon' => set_value('icon'),
	    'link' => set_value('link'),
	    'status' => set_value('status'),
	    'parent' => set_value('parent'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_menu' => $this->input->post('nama_menu',TRUE),
		'icon' => $this->input->post('icon',TRUE),
		'link' => $this->input->post('link',TRUE),
		'status' => $this->input->post('status',TRUE),
		'parent' => $this->input->post('parent',TRUE),
	    );

            $this->Master_menu_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('master_menu'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Master_menu_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Master Menu',
                'konten' => 'master_menu/master_menu_form',
                'button' => 'Ubah',
                'action' => site_url('master_menu/update_action'),
		'id_menu' => set_value('id_menu', $row->id_menu),
		'nama_menu' => set_value('nama_menu', $row->nama_menu),
		'icon' => set_value('icon', $row->icon),
		'link' => set_value('link', $row->link),
		'status' => set_value('status', $row->status),
		'parent' => set_value('parent', $row->parent),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_menu'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_menu', TRUE));
        } else {
            $data = array(
		'nama_menu' => $this->input->post('nama_menu',TRUE),
		'icon' => $this->input->post('icon',TRUE),
		'link' => $this->input->post('link',TRUE),
		'status' => $this->input->post('status',TRUE),
		'parent' => $this->input->post('parent',TRUE),
	    );

            $this->Master_menu_model->update($this->input->post('id_menu', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('master_menu'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Master_menu_model->get_by_id($id);

        if ($row) {
            $this->Master_menu_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('master_menu'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_menu'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_menu', 'nama menu', 'trim|required');
	// $this->form_validation->set_rules('icon', 'icon', 'trim|required');
	$this->form_validation->set_rules('link', 'link', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id_menu', 'id_menu', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Master_menu.php */
/* Location: ./application/controllers/Master_menu.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-06 09:52:45 */
/* https://jualkoding.com */