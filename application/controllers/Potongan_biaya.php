<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Potongan_biaya extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Potongan_biaya_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'potongan_biaya/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'potongan_biaya/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'potongan_biaya/index.html';
            $config['first_url'] = base_url() . 'potongan_biaya/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Potongan_biaya_model->total_rows($q);
        $potongan_biaya = $this->Potongan_biaya_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'potongan_biaya_data' => $potongan_biaya,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Daftar Potongan Mahasiswa',
            'konten' => 'potongan_biaya/potongan_biaya_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Potongan_biaya_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_potongan' => $row->id_potongan,
		'nim' => $row->nim,
		'id_biaya' => $row->id_biaya,
		'jumlah' => $row->jumlah,
		'jenis_potongan' => $row->jenis_potongan,
		'berlaku' => $row->berlaku,
		'batas_tanggal' => $row->batas_tanggal,
	    );
            $this->load->view('potongan_biaya/potongan_biaya_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('potongan_biaya'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Potongan',
            'konten' => 'potongan_biaya/potongan_biaya_form',
            'button' => 'Simpan',
            'action' => site_url('potongan_biaya/create_action'),
	    'id_potongan' => set_value('id_potongan'),
	    'nim' => set_value('nim'),
	    'id_biaya' => set_value('id_biaya'),
	    'jumlah' => set_value('jumlah'),
	    'jenis_potongan' => set_value('jenis_potongan'),
	    'berlaku' => set_value('berlaku'),
	    'batas_tanggal' => set_value('batas_tanggal'),
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
		'nim' => $this->input->post('nim',TRUE),
		'id_biaya' => $this->input->post('id_biaya',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
		'jenis_potongan' => $this->input->post('jenis_potongan',TRUE),
		'berlaku' => $this->input->post('berlaku',TRUE),
		'batas_tanggal' => $this->input->post('batas_tanggal',TRUE),
	    );

            $this->Potongan_biaya_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('potongan_biaya'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Potongan_biaya_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Potongan',
                'konten' => 'potongan_biaya/potongan_biaya_form',
                'button' => 'Ubah',
                'action' => site_url('potongan_biaya/update_action'),
		'id_potongan' => set_value('id_potongan', $row->id_potongan),
		'nim' => set_value('nim', $row->nim),
		'id_biaya' => set_value('id_biaya', $row->id_biaya),
		'jumlah' => set_value('jumlah', $row->jumlah),
		'jenis_potongan' => set_value('jenis_potongan', $row->jenis_potongan),
		'berlaku' => set_value('berlaku', $row->berlaku),
		'batas_tanggal' => set_value('batas_tanggal', $row->batas_tanggal),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('potongan_biaya'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_potongan', TRUE));
        } else {
            $data = array(
		'nim' => $this->input->post('nim',TRUE),
		'id_biaya' => $this->input->post('id_biaya',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
		'jenis_potongan' => $this->input->post('jenis_potongan',TRUE),
		'berlaku' => $this->input->post('berlaku',TRUE),
		'batas_tanggal' => $this->input->post('batas_tanggal',TRUE),
	    );

            $this->Potongan_biaya_model->update($this->input->post('id_potongan', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('potongan_biaya'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Potongan_biaya_model->get_by_id($id);

        if ($row) {
            $this->Potongan_biaya_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('potongan_biaya'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('potongan_biaya'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nim', 'nim', 'trim|required');
	$this->form_validation->set_rules('id_biaya', 'id biaya', 'trim|required');
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');
	$this->form_validation->set_rules('jenis_potongan', 'jenis potongan', 'trim|required');
	$this->form_validation->set_rules('berlaku', 'berlaku', 'trim|required');
	// $this->form_validation->set_rules('batas_tanggal', 'batas tanggal', 'trim|required');

	$this->form_validation->set_rules('id_potongan', 'id_potongan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Potongan_biaya.php */
/* Location: ./application/controllers/Potongan_biaya.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-28 02:34:18 */
/* https://jualkoding.com */