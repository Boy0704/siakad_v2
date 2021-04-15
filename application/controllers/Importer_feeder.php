<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_feeder extends CI_Controller {

	public function index()
	{
		$data = array(
			'konten' => 'importer_feeder/view',
			'judul_page' => 'Download Importer Feeder',
		);
		$this->load->view('v_index',$data);
	}

	public function data_akm()
	{
		$this->load->view('importer_feeder/export_akm');
	}

	public function data_mahasiswa()
	{
		$this->load->view('importer_feeder/export_mahasiswa');
	}

	public function matkul_kurikulum()
	{
		$this->load->view('importer_feeder/export_matkul_kurikulum');
	}

	public function data_kelas()
	{
		$this->load->view('importer_feeder/export_kelas');
	}

	public function dosen_ajar()
	{
		$this->load->view('importer_feeder/export_dosen_ajar');
	}

	public function data_krs()
	{
		$this->load->view('importer_feeder/export_krs');
	}

	public function data_khs()
	{
		$this->load->view('importer_feeder/export_khs');
	}

}

/* End of file Importer_feeder.php */
/* Location: ./application/controllers/Importer_feeder.php */