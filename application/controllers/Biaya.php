<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Biaya extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Biaya_model');
        $this->load->library('form_validation');
        $this->rbac->check_module_access();
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'biaya/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'biaya/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'biaya/index.html';
            $config['first_url'] = base_url() . 'biaya/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Biaya_model->total_rows($q);
        $biaya = $this->Biaya_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'biaya_data' => $biaya,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Daftar Biaya',
            'konten' => 'biaya/biaya_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Biaya_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_biaya' => $row->id_biaya,
		'nama_biaya' => $row->nama_biaya,
        'id_jenis_biaya' => $row->id_jenis_biaya,
		'id_prodi' => $row->id_prodi,
	    );
            $this->load->view('biaya/biaya_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('biaya'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Biaya',
            'konten' => 'biaya/biaya_form',
            'button' => 'Simpan',
            'action' => site_url('biaya/create_action'),
	    'id_biaya' => set_value('id_biaya'),
	    'nama_biaya' => set_value('nama_biaya'),
        'id_jenis_biaya' => set_value('id_jenis_biaya'),
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
		'nama_biaya' => $this->input->post('nama_biaya',TRUE),
        'id_jenis_biaya' => $this->input->post('id_jenis_biaya',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
	    );

            $this->Biaya_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('biaya'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Biaya_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Biaya',
                'konten' => 'biaya/biaya_form',
                'button' => 'Ubah',
                'action' => site_url('biaya/update_action'),
		'id_biaya' => set_value('id_biaya', $row->id_biaya),
		'nama_biaya' => set_value('nama_biaya', $row->nama_biaya),
        'id_jenis_biaya' => set_value('id_jenis_biaya', $row->id_jenis_biaya),
		'id_prodi' => set_value('id_prodi', $row->id_prodi),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('biaya'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_biaya', TRUE));
        } else {
            $data = array(
		'nama_biaya' => $this->input->post('nama_biaya',TRUE),
        'id_jenis_biaya' => $this->input->post('id_jenis_biaya',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
	    );

            $this->Biaya_model->update($this->input->post('id_biaya', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('biaya'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Biaya_model->get_by_id($id);

        if ($row) {
            $this->Biaya_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('biaya'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('biaya'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_biaya', 'nama biaya', 'trim|required');
    $this->form_validation->set_rules('id_jenis_biaya', 'jenis biaya', 'trim|required');
	$this->form_validation->set_rules('id_prodi', 'Prodi', 'trim|required');

	$this->form_validation->set_rules('id_biaya', 'id_biaya', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Biaya.php */
/* Location: ./application/controllers/Biaya.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-25 11:09:42 */
/* https://jualkoding.com */