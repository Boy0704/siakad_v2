<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prodi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Prodi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'prodi/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'prodi/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'prodi/index.html';
            $config['first_url'] = base_url() . 'prodi/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Prodi_model->total_rows($q);
        $prodi = $this->Prodi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'prodi_data' => $prodi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'prodi/prodi_list',
            'konten' => 'prodi/prodi_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Prodi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_prodi' => $row->id_prodi,
		'kode_prodi' => $row->kode_prodi,
		'prodi' => $row->prodi,
		'sks_lulus' => $row->sks_lulus,
		'ketua_prodi' => $row->ketua_prodi,
		'aktif' => $row->aktif,
	    );
            $this->load->view('prodi/prodi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('prodi'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'prodi/prodi_form',
            'konten' => 'prodi/prodi_form',
            'button' => 'Simpan',
            'action' => site_url('prodi/create_action'),
	    'id_prodi' => set_value('id_prodi'),
	    'kode_prodi' => set_value('kode_prodi'),
	    'prodi' => set_value('prodi'),
	    'sks_lulus' => set_value('sks_lulus'),
        'ketua_prodi' => set_value('ketua_prodi'),
        'jenjang' => set_value('jenjang'),
	    'jumlah_semester' => set_value('jumlah_semester'),
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
		'kode_prodi' => $this->input->post('kode_prodi',TRUE),
		'prodi' => $this->input->post('prodi',TRUE),
		'sks_lulus' => $this->input->post('sks_lulus',TRUE),
        'ketua_prodi' => $this->input->post('ketua_prodi',TRUE),
        'jenjang' => $this->input->post('jenjang',TRUE),
		'jumlah_semester' => $this->input->post('jumlah_semester',TRUE),
		'aktif' => $this->input->post('aktif',TRUE),
	    );

            $this->Prodi_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('prodi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Prodi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'prodi/prodi_form',
                'konten' => 'prodi/prodi_form',
                'button' => 'Ubah',
                'action' => site_url('prodi/update_action'),
		'id_prodi' => set_value('id_prodi', $row->id_prodi),
		'kode_prodi' => set_value('kode_prodi', $row->kode_prodi),
		'prodi' => set_value('prodi', $row->prodi),
		'sks_lulus' => set_value('sks_lulus', $row->sks_lulus),
        'ketua_prodi' => set_value('ketua_prodi', $row->ketua_prodi),
        'jenjang' => set_value('jenjang', $row->jenjang),
		'jumlah_semester' => set_value('jumlah_semester', $row->jumlah_semester),
		'aktif' => set_value('aktif', $row->aktif),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('prodi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_prodi', TRUE));
        } else {
            $data = array(
		'kode_prodi' => $this->input->post('kode_prodi',TRUE),
		'prodi' => $this->input->post('prodi',TRUE),
		'sks_lulus' => $this->input->post('sks_lulus',TRUE),
        'ketua_prodi' => $this->input->post('ketua_prodi',TRUE),
        'jenjang' => $this->input->post('jenjang',TRUE),
		'jumlah_semester' => $this->input->post('jumlah_semester',TRUE),
		'aktif' => $this->input->post('aktif',TRUE),
	    );

            $this->Prodi_model->update($this->input->post('id_prodi', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('prodi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Prodi_model->get_by_id($id);

        if ($row) {
            $this->Prodi_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('prodi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('prodi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_prodi', 'kode prodi', 'trim|required');
	$this->form_validation->set_rules('prodi', 'prodi', 'trim|required');
	// $this->form_validation->set_rules('sks_lulus', 'sks lulus', 'trim|required');
    $this->form_validation->set_rules('ketua_prodi', 'ketua prodi', 'trim|required');
	$this->form_validation->set_rules('jumlah_semester', 'Jumlah Semester', 'trim|required');
	$this->form_validation->set_rules('aktif', 'aktif', 'trim|required');

	$this->form_validation->set_rules('id_prodi', 'id_prodi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Prodi.php */
/* Location: ./application/controllers/Prodi.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-07 16:02:17 */
/* https://jualkoding.com */