<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kurikulum extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kurikulum_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kurikulum/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kurikulum/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kurikulum/index.html';
            $config['first_url'] = base_url() . 'kurikulum/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kurikulum_model->total_rows($q);
        $kurikulum = $this->Kurikulum_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kurikulum_data' => $kurikulum,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Daftar Kurikulum',
            'konten' => 'kurikulum/kurikulum_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Kurikulum_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_kurikulum' => $row->id_kurikulum,
		'kode_kurikulum' => $row->kode_kurikulum,
		'kurikulum' => $row->kurikulum,
		'mulai_berlaku' => $row->mulai_berlaku,
		'sks_wajib' => $row->sks_wajib,
		'sks_pilihan' => $row->sks_pilihan,
		'total_sks' => $row->total_sks,
		'id_prodi' => $row->id_prodi,
	    );
            $this->load->view('kurikulum/kurikulum_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kurikulum'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Kurikulum',
            'konten' => 'kurikulum/kurikulum_form',
            'button' => 'Simpan',
            'action' => site_url('kurikulum/create_action'),
	    'id_kurikulum' => set_value('id_kurikulum'),
	    'kode_kurikulum' => set_value('kode_kurikulum'),
	    'kurikulum' => set_value('kurikulum'),
	    'mulai_berlaku' => set_value('mulai_berlaku'),
	    'sks_wajib' => set_value('sks_wajib'),
	    'sks_pilihan' => set_value('sks_pilihan'),
	    'total_sks' => set_value('total_sks'),
	    'id_prodi' => set_value('id_prodi'),
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
		'kode_kurikulum' => $this->input->post('kode_kurikulum',TRUE),
		'kurikulum' => $this->input->post('kurikulum',TRUE),
		'mulai_berlaku' => $this->input->post('mulai_berlaku',TRUE),
		'sks_wajib' => $this->input->post('sks_wajib',TRUE),
		'sks_pilihan' => $this->input->post('sks_pilihan',TRUE),
		'total_sks' => $this->input->post('total_sks',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
	    );

            $this->Kurikulum_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('kurikulum'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kurikulum_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Kurikulum',
                'konten' => 'kurikulum/kurikulum_form',
                'button' => 'Ubah',
                'action' => site_url('kurikulum/update_action'),
		'id_kurikulum' => set_value('id_kurikulum', $row->id_kurikulum),
		'kode_kurikulum' => set_value('kode_kurikulum', $row->kode_kurikulum),
		'kurikulum' => set_value('kurikulum', $row->kurikulum),
		'mulai_berlaku' => set_value('mulai_berlaku', $row->mulai_berlaku),
		'sks_wajib' => set_value('sks_wajib', $row->sks_wajib),
		'sks_pilihan' => set_value('sks_pilihan', $row->sks_pilihan),
		'total_sks' => set_value('total_sks', $row->total_sks),
		'id_prodi' => set_value('id_prodi', $row->id_prodi),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kurikulum'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kurikulum', TRUE));
        } else {
            $data = array(
		'kode_kurikulum' => $this->input->post('kode_kurikulum',TRUE),
		'kurikulum' => $this->input->post('kurikulum',TRUE),
		'mulai_berlaku' => $this->input->post('mulai_berlaku',TRUE),
		'sks_wajib' => $this->input->post('sks_wajib',TRUE),
		'sks_pilihan' => $this->input->post('sks_pilihan',TRUE),
		'total_sks' => $this->input->post('total_sks',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
	    );

            $this->Kurikulum_model->update($this->input->post('id_kurikulum', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('kurikulum'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kurikulum_model->get_by_id($id);

        if ($row) {
            $this->Kurikulum_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('kurikulum'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kurikulum'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_kurikulum', 'kode kurikulum', 'trim|required');
	$this->form_validation->set_rules('kurikulum', 'kurikulum', 'trim|required');
	$this->form_validation->set_rules('mulai_berlaku', 'mulai berlaku', 'trim|required');
	$this->form_validation->set_rules('sks_wajib', 'sks wajib', 'trim|required');
	$this->form_validation->set_rules('sks_pilihan', 'sks pilihan', 'trim|required');
	$this->form_validation->set_rules('total_sks', 'total sks', 'trim|required');
	$this->form_validation->set_rules('id_prodi', 'prodi', 'trim|required');

	$this->form_validation->set_rules('id_kurikulum', 'kurikulum', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kurikulum.php */
/* Location: ./application/controllers/Kurikulum.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-09 19:18:24 */
/* https://jualkoding.com */