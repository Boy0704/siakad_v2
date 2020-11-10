<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tahun_angkatan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tahun_angkatan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'tahun_angkatan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tahun_angkatan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'tahun_angkatan/index.html';
            $config['first_url'] = base_url() . 'tahun_angkatan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tahun_angkatan_model->total_rows($q);
        $tahun_angkatan = $this->Tahun_angkatan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tahun_angkatan_data' => $tahun_angkatan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'tahun_angkatan/tahun_angkatan_list',
            'konten' => 'tahun_angkatan/tahun_angkatan_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Tahun_angkatan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_tahun_angkatan' => $row->id_tahun_angkatan,
		'tahun_angkatan' => $row->tahun_angkatan,
		'aktif' => $row->aktif,
	    );
            $this->load->view('tahun_angkatan/tahun_angkatan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tahun_angkatan'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'tahun_angkatan/tahun_angkatan_form',
            'konten' => 'tahun_angkatan/tahun_angkatan_form',
            'button' => 'Simpan',
            'action' => site_url('tahun_angkatan/create_action'),
	    'id_tahun_angkatan' => set_value('id_tahun_angkatan'),
	    'tahun_angkatan' => set_value('tahun_angkatan'),
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
		'tahun_angkatan' => $this->input->post('tahun_angkatan',TRUE),
		'aktif' => $this->input->post('aktif',TRUE),
	    );

            $this->Tahun_angkatan_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('tahun_angkatan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tahun_angkatan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'tahun_angkatan/tahun_angkatan_form',
                'konten' => 'tahun_angkatan/tahun_angkatan_form',
                'button' => 'Ubah',
                'action' => site_url('tahun_angkatan/update_action'),
		'id_tahun_angkatan' => set_value('id_tahun_angkatan', $row->id_tahun_angkatan),
		'tahun_angkatan' => set_value('tahun_angkatan', $row->tahun_angkatan),
		'aktif' => set_value('aktif', $row->aktif),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tahun_angkatan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_tahun_angkatan', TRUE));
        } else {
            $data = array(
		'tahun_angkatan' => $this->input->post('tahun_angkatan',TRUE),
		'aktif' => $this->input->post('aktif',TRUE),
	    );

            $this->Tahun_angkatan_model->update($this->input->post('id_tahun_angkatan', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('tahun_angkatan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tahun_angkatan_model->get_by_id($id);

        if ($row) {
            $this->Tahun_angkatan_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('tahun_angkatan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tahun_angkatan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tahun_angkatan', 'tahun angkatan', 'trim|required');
	$this->form_validation->set_rules('aktif', 'aktif', 'trim|required');

	$this->form_validation->set_rules('id_tahun_angkatan', 'id_tahun_angkatan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Tahun_angkatan.php */
/* Location: ./application/controllers/Tahun_angkatan.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-09 19:17:18 */
/* https://jualkoding.com */