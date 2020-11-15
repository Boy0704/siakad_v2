<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->rbac->check_module_access();
	}
	
	public function cetak_krs($nim='',$kode_semester='')
	{
		if ($nim == '' or $kode_semester=='') {
			$this->session->set_flashdata('notif', alert_biasa('nim atau kode semester tidak boleh kosong','error'));
			redirect('krs/krs_mahasiswa','refresh');
		}
		$this->load->view('cetak/cetak_krs');
	}

	public function cetak_kum($nim='',$kode_semester='',$jenis_ujian='')
	{
		if ($nim == '' or $kode_semester=='' or $jenis_ujian =='') {
			$this->session->set_flashdata('notif', alert_biasa('nim atau kode semester tidak boleh kosong','error'));
			redirect('absensi/absen_mahasiswa','refresh');
		}
		$data['nim'] = $nim;
		$data['kode_semester'] = $kode_semester;
		$data['jenis_ujian'] = $jenis_ujian;
		$this->load->view('cetak/cetak_kum',$data);
	}
}
