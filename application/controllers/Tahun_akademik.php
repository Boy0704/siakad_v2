<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tahun_akademik extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tahun_akademik_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'tahun_akademik/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tahun_akademik/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'tahun_akademik/index.html';
            $config['first_url'] = base_url() . 'tahun_akademik/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tahun_akademik_model->total_rows($q);
        $tahun_akademik = $this->Tahun_akademik_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tahun_akademik_data' => $tahun_akademik,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'tahun_akademik/tahun_akademik_list',
            'konten' => 'tahun_akademik/tahun_akademik_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Tahun_akademik_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_tahun_akademik' => $row->id_tahun_akademik,
		'kode_tahun' => $row->kode_tahun,
		'keterangan' => $row->keterangan,
		'batas_registrasi' => $row->batas_registrasi,
		'batas_krs' => $row->batas_krs,
		'aktif' => $row->aktif,
	    );
            $this->load->view('tahun_akademik/tahun_akademik_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tahun_akademik'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'tahun_akademik/tahun_akademik_form',
            'konten' => 'tahun_akademik/tahun_akademik_form',
            'button' => 'Simpan',
            'action' => site_url('tahun_akademik/create_action'),
	    'id_tahun_akademik' => set_value('id_tahun_akademik'),
	    'kode_tahun' => set_value('kode_tahun'),
	    'keterangan' => set_value('keterangan'),
        'mulai_aktif' => set_value('mulai_aktif'),
	    'batas_registrasi' => set_value('batas_registrasi'),
	    'batas_krs' => set_value('batas_krs'),
	    'aktif' => set_value('aktif'),
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
		'kode_tahun' => $this->input->post('kode_tahun',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
        'mulai_aktif' => $this->input->post('mulai_aktif',TRUE),
		'batas_registrasi' => $this->input->post('batas_registrasi',TRUE),
		'batas_krs' => $this->input->post('batas_krs',TRUE),
		'aktif' => $this->input->post('aktif',TRUE),
	    );

            $this->Tahun_akademik_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('tahun_akademik'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tahun_akademik_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'tahun_akademik/tahun_akademik_form',
                'konten' => 'tahun_akademik/tahun_akademik_form',
                'button' => 'Ubah',
                'action' => site_url('tahun_akademik/update_action'),
		'id_tahun_akademik' => set_value('id_tahun_akademik', $row->id_tahun_akademik),
		'kode_tahun' => set_value('kode_tahun', $row->kode_tahun),
		'keterangan' => set_value('keterangan', $row->keterangan),
        'mulai_aktif' => set_value('mulai_aktif', $row->mulai_aktif),
		'batas_registrasi' => set_value('batas_registrasi', $row->batas_registrasi),
		'batas_krs' => set_value('batas_krs', $row->batas_krs),
		'aktif' => set_value('aktif', $row->aktif),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tahun_akademik'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_tahun_akademik', TRUE));
        } else {
            $data = array(
		'kode_tahun' => $this->input->post('kode_tahun',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
        'mulai_aktif' => $this->input->post('mulai_aktif',TRUE),
		'batas_registrasi' => $this->input->post('batas_registrasi',TRUE),
		'batas_krs' => $this->input->post('batas_krs',TRUE),
		'aktif' => $this->input->post('aktif',TRUE),
	    );

            $this->Tahun_akademik_model->update($this->input->post('id_tahun_akademik', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('tahun_akademik'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tahun_akademik_model->get_by_id($id);

        if ($row) {
            $this->Tahun_akademik_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('tahun_akademik'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tahun_akademik'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_tahun', 'kode tahun', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
    $this->form_validation->set_rules('mulai_aktif', 'Mulai Aktif', 'trim|required');
	$this->form_validation->set_rules('batas_registrasi', 'batas registrasi', 'trim|required');
	$this->form_validation->set_rules('batas_krs', 'batas krs', 'trim|required');
	$this->form_validation->set_rules('aktif', 'aktif', 'trim|required');

	$this->form_validation->set_rules('id_tahun_akademik', 'id_tahun_akademik', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Tahun_akademik.php */
/* Location: ./application/controllers/Tahun_akademik.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-07 16:02:46 */
/* https://jualkoding.com */