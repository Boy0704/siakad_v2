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

	public function cetak_khs($nim='',$kode_semester='')
	{
		if ($nim == '' or $kode_semester=='') {
			$this->session->set_flashdata('notif', alert_biasa('nim atau kode semester tidak boleh kosong','error'));
			redirect('krs/khs_mahasiswa','refresh');
		}
		$data['nim'] = $nim;
		$data['kode_semester'] = $kode_semester;
		$this->load->view('cetak/cetak_khs',$data);
	}

	public function cetak_slip($id_pembayaran)
	{
		$this->load->view('cetak/cetak_kwitansi');
	}

	public function cetak_report_pembayaran()
	{
		$data = array(
			'konten' => 'cetak/cetak_report_pembayaran',
			'judul_page' => 'Cetak Laporan Pembayaran',
		);
		$this->load->view('v_index',$data);
	}

	public function cetak_rhs($nim='')
	{
		if ($nim == '') {
			$this->session->set_flashdata('notif', alert_biasa('nim tidak boleh kosong','error'));
			redirect('app','refresh');
		}
		$data['nim'] = $nim;
		$this->load->view('cetak/cetak_rhs',$data);
	}

}
