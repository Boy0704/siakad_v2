<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {

	
	public function cetak_krs($nim,$kode_semester)
	{
		if ($nim == '' or $kode_semester=='') {
			$this->session->set_flashdata('notif', alert_biasa('nim atau kode semester tidak boleh kosong','error'));
			redirect('krs/krs_mahasiswa','refresh');
		}
		$this->load->view('cetak/cetak_krs');
	}
}
