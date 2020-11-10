<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Level extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Level_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'level/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'level/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'level/index.html';
            $config['first_url'] = base_url() . 'level/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Level_model->total_rows($q);
        $level = $this->Level_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'level_data' => $level,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'level/level_list',
            'konten' => 'level/level_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Level_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_level' => $row->id_level,
		'level' => $row->level,
	    );
            $this->load->view('level/level_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'level/level_form',
            'konten' => 'level/level_form',
            'button' => 'Simpan',
            'action' => site_url('level/create_action'),
	    'id_level' => set_value('id_level'),
	    'level' => set_value('level'),
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
		'level' => $this->input->post('level',TRUE),
	    );

            $this->Level_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('level'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'level/level_form',
                'konten' => 'level/level_form',
                'button' => 'Ubah',
                'action' => site_url('level/update_action'),
		'id_level' => set_value('id_level', $row->id_level),
		'level' => set_value('level', $row->level),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_level', TRUE));
        } else {
            $data = array(
		'level' => $this->input->post('level',TRUE),
	    );

            $this->Level_model->update($this->input->post('id_level', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('level'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $this->Level_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('level'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('level', 'level', 'trim|required');

	$this->form_validation->set_rules('id_level', 'id_level', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Level.php */
/* Location: ./application/controllers/Level.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-06 15:54:38 */
/* https://jualkoding.com */