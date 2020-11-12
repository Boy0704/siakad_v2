<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Matakuliah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Matakuliah_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array(
            'konten' => 'matakuliah/view',
            'judul_page' => 'Matakuliah',
        );
        $this->load->view('v_index',$data);

        // $q = urldecode($this->input->get('q', TRUE));
        // $start = intval($this->input->get('start'));
        
        // if ($q <> '') {
        //     $config['base_url'] = base_url() . 'matakuliah/index.html?q=' . urlencode($q);
        //     $config['first_url'] = base_url() . 'matakuliah/index.html?q=' . urlencode($q);
        // } else {
        //     $config['base_url'] = base_url() . 'matakuliah/index.html';
        //     $config['first_url'] = base_url() . 'matakuliah/index.html';
        // }

        // $config['per_page'] = 10;
        // $config['page_query_string'] = TRUE;
        // $config['total_rows'] = $this->Matakuliah_model->total_rows($q);
        // $matakuliah = $this->Matakuliah_model->get_limit_data($config['per_page'], $start, $q);

        // $this->load->library('pagination');
        // $this->pagination->initialize($config);

        // $data = array(
        //     'matakuliah_data' => $matakuliah,
        //     'q' => $q,
        //     'pagination' => $this->pagination->create_links(),
        //     'total_rows' => $config['total_rows'],
        //     'start' => $start,
        //     'judul_page' => 'matakuliah/matakuliah_list',
        //     'konten' => 'matakuliah/matakuliah_list',
        // );
        // $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Matakuliah_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_mk' => $row->id_mk,
		'kode_mk' => $row->kode_mk,
		'nama_mk' => $row->nama_mk,
		'jenis_mk' => $row->jenis_mk,
		'sks_tm' => $row->sks_tm,
		'sks_prak' => $row->sks_prak,
		'sks_prak_la' => $row->sks_prak_la,
		'sks_total' => $row->sks_total,
		'metode_pembelajaran' => $row->metode_pembelajaran,
		'tgl_mulai_efektif' => $row->tgl_mulai_efektif,
		'tgl_akhir_efektif' => $row->tgl_akhir_efektif,
		'semester' => $row->semester,
		'id_prodi' => $row->id_prodi,
		'id_kurikulum' => $row->id_kurikulum,
	    );
            $this->load->view('matakuliah/matakuliah_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matakuliah'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'matakuliah/matakuliah_form',
            'konten' => 'matakuliah/matakuliah_form',
            'button' => 'Simpan',
            'action' => site_url('matakuliah/create_action'),
	    'id_mk' => set_value('id_mk'),
	    'kode_mk' => set_value('kode_mk'),
	    'nama_mk' => set_value('nama_mk'),
	    'jenis_mk' => set_value('jenis_mk'),
	    'sks_tm' => set_value('sks_tm'),
	    'sks_prak' => set_value('sks_prak'),
        'sks_prak_la' => set_value('sks_prak_la'),
	    'sks_simulasi' => set_value('sks_simulasi'),
	    'sks_total' => set_value('sks_total'),
	    'metode_pembelajaran' => set_value('metode_pembelajaran'),
	    'tgl_mulai_efektif' => set_value('tgl_mulai_efektif'),
	    'tgl_akhir_efektif' => set_value('tgl_akhir_efektif'),
	    'semester' => set_value('semester'),
	    'id_prodi' => set_value('id_prodi'),
	    'id_kurikulum' => set_value('id_kurikulum'),
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
		'kode_mk' => $this->input->post('kode_mk',TRUE),
		'nama_mk' => $this->input->post('nama_mk',TRUE),
		'jenis_mk' => $this->input->post('jenis_mk',TRUE),
		'sks_tm' => $this->input->post('sks_tm',TRUE),
		'sks_prak' => $this->input->post('sks_prak',TRUE),
        'sks_prak_la' => set_value('sks_prak_la'),
		'sks_simulasi' => $this->input->post('sks_simulasi',TRUE),
		'sks_total' => $this->input->post('sks_total',TRUE),
		'metode_pembelajaran' => $this->input->post('metode_pembelajaran',TRUE),
		'tgl_mulai_efektif' => $this->input->post('tgl_mulai_efektif',TRUE),
		'tgl_akhir_efektif' => $this->input->post('tgl_akhir_efektif',TRUE),
		'semester' => $this->input->post('semester',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
		'id_kurikulum' => $this->input->post('id_kurikulum',TRUE),
	    );

            $this->Matakuliah_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('matakuliah'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Matakuliah_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'matakuliah/matakuliah_form',
                'konten' => 'matakuliah/matakuliah_form',
                'button' => 'Ubah',
                'action' => site_url('matakuliah/update_action'),
		'id_mk' => set_value('id_mk', $row->id_mk),
		'kode_mk' => set_value('kode_mk', $row->kode_mk),
		'nama_mk' => set_value('nama_mk', $row->nama_mk),
		'jenis_mk' => set_value('jenis_mk', $row->jenis_mk),
		'sks_tm' => set_value('sks_tm', $row->sks_tm),
		'sks_prak' => set_value('sks_prak', $row->sks_prak),
        'sks_prak_la' => set_value('sks_prak_la', $row->sks_prak_la),
		'sks_simulasi' => set_value('sks_simulasi', $row->sks_simulasi),
		'sks_total' => set_value('sks_total', $row->sks_total),
		'metode_pembelajaran' => set_value('metode_pembelajaran', $row->metode_pembelajaran),
		'tgl_mulai_efektif' => set_value('tgl_mulai_efektif', $row->tgl_mulai_efektif),
		'tgl_akhir_efektif' => set_value('tgl_akhir_efektif', $row->tgl_akhir_efektif),
		'semester' => set_value('semester', $row->semester),
		'id_prodi' => set_value('id_prodi', $row->id_prodi),
		'id_kurikulum' => set_value('id_kurikulum', $row->id_kurikulum),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matakuliah'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_mk', TRUE));
        } else {
            $data = array(
		'kode_mk' => $this->input->post('kode_mk',TRUE),
		'nama_mk' => $this->input->post('nama_mk',TRUE),
		'jenis_mk' => $this->input->post('jenis_mk',TRUE),
		'sks_tm' => $this->input->post('sks_tm',TRUE),
		'sks_prak' => $this->input->post('sks_prak',TRUE),
        'sks_prak_la' => $this->input->post('sks_prak_la',TRUE),
		'sks_simulasi' => $this->input->post('sks_simulasi',TRUE),
		'sks_total' => $this->input->post('sks_total',TRUE),
		'metode_pembelajaran' => $this->input->post('metode_pembelajaran',TRUE),
		'tgl_mulai_efektif' => $this->input->post('tgl_mulai_efektif',TRUE),
		'tgl_akhir_efektif' => $this->input->post('tgl_akhir_efektif',TRUE),
		'semester' => $this->input->post('semester',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
		'id_kurikulum' => $this->input->post('id_kurikulum',TRUE),
	    );

            $this->Matakuliah_model->update($this->input->post('id_mk', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('matakuliah'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Matakuliah_model->get_by_id($id);

        if ($row) {
            $this->Matakuliah_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('matakuliah'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matakuliah'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_mk', 'kode mk', 'trim|required');
	$this->form_validation->set_rules('nama_mk', 'nama mk', 'trim|required');
	$this->form_validation->set_rules('jenis_mk', 'jenis mk', 'trim|required');
	$this->form_validation->set_rules('sks_tm', 'sks tm', 'trim|required');
	$this->form_validation->set_rules('sks_prak', 'sks prak', 'trim|required');
    $this->form_validation->set_rules('sks_prak_la', 'sks prak la', 'trim|required');
	$this->form_validation->set_rules('sks_simulasi', 'sks simulasi', 'trim|required');
	$this->form_validation->set_rules('sks_total', 'sks total', 'trim|required');
	// $this->form_validation->set_rules('metode_pembelajaran', 'metode pembelajaran', 'trim|required');
	// $this->form_validation->set_rules('tgl_mulai_efektif', 'tgl mulai efektif', 'trim|required');
	// $this->form_validation->set_rules('tgl_akhir_efektif', 'tgl akhir efektif', 'trim|required');
	$this->form_validation->set_rules('semester', 'semester', 'trim|required');
	$this->form_validation->set_rules('id_prodi', 'prodi', 'trim|required');
	$this->form_validation->set_rules('id_kurikulum', 'kurikulum', 'trim|required');

	$this->form_validation->set_rules('id_mk', 'id_mk', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Matakuliah.php */
/* Location: ./application/controllers/Matakuliah.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-09 19:18:56 */
/* https://jualkoding.com */