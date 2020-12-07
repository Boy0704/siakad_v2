<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tanda_tangan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tanda_tangan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'tanda_tangan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tanda_tangan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'tanda_tangan/index.html';
            $config['first_url'] = base_url() . 'tanda_tangan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tanda_tangan_model->total_rows($q);
        $tanda_tangan = $this->Tanda_tangan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tanda_tangan_data' => $tanda_tangan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Set Tanda Tangan',
            'konten' => 'tanda_tangan/tanda_tangan_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Tanda_tangan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_tanda_tangan' => $row->id_tanda_tangan,
		'jenis_cetak' => $row->jenis_cetak,
		'judul_atas' => $row->judul_atas,
		'nama' => $row->nama,
		'bawah_nama' => $row->bawah_nama,
	    );
            $this->load->view('tanda_tangan/tanda_tangan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tanda_tangan'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Tanda Tangan',
            'konten' => 'tanda_tangan/tanda_tangan_form',
            'button' => 'Simpan',
            'action' => site_url('tanda_tangan/create_action'),
	    'id_tanda_tangan' => set_value('id_tanda_tangan'),
	    'jenis_cetak' => set_value('jenis_cetak'),
	    'judul_atas' => set_value('judul_atas'),
	    'nama' => set_value('nama'),
	    'bawah_nama' => set_value('bawah_nama'),
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
		'jenis_cetak' => $this->input->post('jenis_cetak',TRUE),
		'judul_atas' => $this->input->post('judul_atas',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'bawah_nama' => $this->input->post('bawah_nama',TRUE),
	    );

            $this->Tanda_tangan_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('tanda_tangan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tanda_tangan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Tanda Tangan',
                'konten' => 'tanda_tangan/tanda_tangan_form',
                'button' => 'Ubah',
                'action' => site_url('tanda_tangan/update_action'),
		'id_tanda_tangan' => set_value('id_tanda_tangan', $row->id_tanda_tangan),
		'jenis_cetak' => set_value('jenis_cetak', $row->jenis_cetak),
		'judul_atas' => set_value('judul_atas', $row->judul_atas),
		'nama' => set_value('nama', $row->nama),
		'bawah_nama' => set_value('bawah_nama', $row->bawah_nama),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tanda_tangan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_tanda_tangan', TRUE));
        } else {
            $data = array(
		'jenis_cetak' => $this->input->post('jenis_cetak',TRUE),
		'judul_atas' => $this->input->post('judul_atas',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'bawah_nama' => $this->input->post('bawah_nama',TRUE),
	    );

            $this->Tanda_tangan_model->update($this->input->post('id_tanda_tangan', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('tanda_tangan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tanda_tangan_model->get_by_id($id);

        if ($row) {
            $this->Tanda_tangan_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('tanda_tangan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tanda_tangan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jenis_cetak', 'jenis cetak', 'trim|required');
	$this->form_validation->set_rules('judul_atas', 'judul atas', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('bawah_nama', 'bawah nama', 'trim|required');

	$this->form_validation->set_rules('id_tanda_tangan', 'id_tanda_tangan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Tanda_tangan.php */
/* Location: ./application/controllers/Tanda_tangan.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-12-06 04:02:37 */
/* https://jualkoding.com */