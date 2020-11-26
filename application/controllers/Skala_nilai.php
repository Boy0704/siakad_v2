<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Skala_nilai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Skala_nilai_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'skala_nilai/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'skala_nilai/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'skala_nilai/index.html';
            $config['first_url'] = base_url() . 'skala_nilai/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Skala_nilai_model->total_rows($q);
        $skala_nilai = $this->Skala_nilai_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'skala_nilai_data' => $skala_nilai,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'skala_nilai/skala_nilai_list',
            'konten' => 'skala_nilai/skala_nilai_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Skala_nilai_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_skala' => $row->id_skala,
		'nilai_huruf' => $row->nilai_huruf,
		'nilai_indeks' => $row->nilai_indeks,
		'min' => $row->min,
		'max' => $row->max,
		'tgl_mulai_efektif' => $row->tgl_mulai_efektif,
		'tgl_akhir_efektif' => $row->tgl_akhir_efektif,
		'id_prodi' => $row->id_prodi,
	    );
            $this->load->view('skala_nilai/skala_nilai_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('skala_nilai'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'skala_nilai/skala_nilai_form',
            'konten' => 'skala_nilai/skala_nilai_form',
            'button' => 'Simpan',
            'action' => site_url('skala_nilai/create_action'),
	    'id_skala' => set_value('id_skala'),
	    'nilai_huruf' => set_value('nilai_huruf'),
	    'nilai_indeks' => set_value('nilai_indeks'),
	    'min' => set_value('min'),
	    'max' => set_value('max'),
	    'tgl_mulai_efektif' => set_value('tgl_mulai_efektif'),
	    'tgl_akhir_efektif' => set_value('tgl_akhir_efektif'),
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
		'nilai_huruf' => $this->input->post('nilai_huruf',TRUE),
		'nilai_indeks' => $this->input->post('nilai_indeks',TRUE),
		'min' => $this->input->post('min',TRUE),
		'max' => $this->input->post('max',TRUE),
		'tgl_mulai_efektif' => $this->input->post('tgl_mulai_efektif',TRUE),
		'tgl_akhir_efektif' => $this->input->post('tgl_akhir_efektif',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
	    );

            $this->Skala_nilai_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('skala_nilai'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Skala_nilai_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'skala_nilai/skala_nilai_form',
                'konten' => 'skala_nilai/skala_nilai_form',
                'button' => 'Ubah',
                'action' => site_url('skala_nilai/update_action'),
		'id_skala' => set_value('id_skala', $row->id_skala),
		'nilai_huruf' => set_value('nilai_huruf', $row->nilai_huruf),
		'nilai_indeks' => set_value('nilai_indeks', $row->nilai_indeks),
		'min' => set_value('min', $row->min),
		'max' => set_value('max', $row->max),
		'tgl_mulai_efektif' => set_value('tgl_mulai_efektif', $row->tgl_mulai_efektif),
		'tgl_akhir_efektif' => set_value('tgl_akhir_efektif', $row->tgl_akhir_efektif),
		'id_prodi' => set_value('id_prodi', $row->id_prodi),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('skala_nilai'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_skala', TRUE));
        } else {
            $data = array(
		'nilai_huruf' => $this->input->post('nilai_huruf',TRUE),
		'nilai_indeks' => $this->input->post('nilai_indeks',TRUE),
		'min' => $this->input->post('min',TRUE),
		'max' => $this->input->post('max',TRUE),
		'tgl_mulai_efektif' => $this->input->post('tgl_mulai_efektif',TRUE),
		'tgl_akhir_efektif' => $this->input->post('tgl_akhir_efektif',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
	    );

            $this->Skala_nilai_model->update($this->input->post('id_skala', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('skala_nilai'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Skala_nilai_model->get_by_id($id);

        if ($row) {
            $this->Skala_nilai_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('skala_nilai'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('skala_nilai'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nilai_huruf', 'nilai huruf', 'trim|required');
	$this->form_validation->set_rules('nilai_indeks', 'nilai indeks', 'trim|required');
	$this->form_validation->set_rules('min', 'min', 'trim|required');
	$this->form_validation->set_rules('max', 'max', 'trim|required');
	// $this->form_validation->set_rules('tgl_mulai_efektif', 'tgl mulai efektif', 'trim|required');
	// $this->form_validation->set_rules('tgl_akhir_efektif', 'tgl akhir efektif', 'trim|required');
	// $this->form_validation->set_rules('id_prodi', 'id prodi', 'trim|required');

	$this->form_validation->set_rules('id_skala', 'id_skala', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Skala_nilai.php */
/* Location: ./application/controllers/Skala_nilai.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-10 03:02:05 */
/* https://jualkoding.com */