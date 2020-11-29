<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ruangan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ruangan_model');
        $this->load->library('form_validation');
        $this->rbac->check_module_access();
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'ruangan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'ruangan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'ruangan/index.html';
            $config['first_url'] = base_url() . 'ruangan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Ruangan_model->total_rows($q);
        $ruangan = $this->Ruangan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'ruangan_data' => $ruangan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Daftar Ruangan',
            'konten' => 'ruangan/ruang_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Ruangan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_ruang' => $row->id_ruang,
		'ruang' => $row->ruang,
		'kapasitas' => $row->kapasitas,
	    );
            $this->load->view('ruangan/ruang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ruangan'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Ruangan',
            'konten' => 'ruangan/ruang_form',
            'button' => 'Simpan',
            'action' => site_url('ruangan/create_action'),
	    'id_ruang' => set_value('id_ruang'),
	    'ruang' => set_value('ruang'),
	    'kapasitas' => set_value('kapasitas'),
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
		'ruang' => $this->input->post('ruang',TRUE),
		'kapasitas' => $this->input->post('kapasitas',TRUE),
	    );

            $this->Ruangan_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('ruangan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ruangan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Ruangan',
                'konten' => 'ruangan/ruang_form',
                'button' => 'Ubah',
                'action' => site_url('ruangan/update_action'),
		'id_ruang' => set_value('id_ruang', $row->id_ruang),
		'ruang' => set_value('ruang', $row->ruang),
		'kapasitas' => set_value('kapasitas', $row->kapasitas),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ruangan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_ruang', TRUE));
        } else {
            $data = array(
		'ruang' => $this->input->post('ruang',TRUE),
		'kapasitas' => $this->input->post('kapasitas',TRUE),
	    );

            $this->Ruangan_model->update($this->input->post('id_ruang', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('ruangan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ruangan_model->get_by_id($id);

        if ($row) {
            $this->Ruangan_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('ruangan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ruangan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('ruang', 'ruang', 'trim|required');
	$this->form_validation->set_rules('kapasitas', 'kapasitas', 'trim|required');

	$this->form_validation->set_rules('id_ruang', 'id_ruang', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Ruangan.php */
/* Location: ./application/controllers/Ruangan.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-09 19:23:12 */
/* https://jualkoding.com */