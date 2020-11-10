<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kelas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kelas_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kelas/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kelas/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kelas/index.html';
            $config['first_url'] = base_url() . 'kelas/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kelas_model->total_rows($q);
        $kelas = $this->Kelas_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kelas_data' => $kelas,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'kelas/kelas_list',
            'konten' => 'kelas/kelas_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Kelas_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_kelas' => $row->id_kelas,
		'kelas' => $row->kelas,
	    );
            $this->load->view('kelas/kelas_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'kelas/kelas_form',
            'konten' => 'kelas/kelas_form',
            'button' => 'Simpan',
            'action' => site_url('kelas/create_action'),
	    'id_kelas' => set_value('id_kelas'),
	    'kelas' => set_value('kelas'),
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
		'kelas' => $this->input->post('kelas',TRUE),
	    );

            $this->Kelas_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('kelas'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kelas_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'kelas/kelas_form',
                'konten' => 'kelas/kelas_form',
                'button' => 'Ubah',
                'action' => site_url('kelas/update_action'),
		'id_kelas' => set_value('id_kelas', $row->id_kelas),
		'kelas' => set_value('kelas', $row->kelas),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kelas', TRUE));
        } else {
            $data = array(
		'kelas' => $this->input->post('kelas',TRUE),
	    );

            $this->Kelas_model->update($this->input->post('id_kelas', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('kelas'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kelas_model->get_by_id($id);

        if ($row) {
            $this->Kelas_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('kelas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kelas', 'kelas', 'trim|required');

	$this->form_validation->set_rules('id_kelas', 'id_kelas', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kelas.php */
/* Location: ./application/controllers/Kelas.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-09 19:21:00 */
/* https://jualkoding.com */