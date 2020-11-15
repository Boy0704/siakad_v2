<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

	
	public function absen_mahasiswa()
	{
		$abs_uts = (get_data('setting','id_setting','1','absen_uts') == 'y') ? 'y' : 't' ;
		$abs_uas = (get_data('setting','id_setting','1','absen_uas') == 'y') ? 'y' : 't' ;
		$data = array(
			'konten' => 'absensi/view_absensi_mahasiswa',
			'judul_page' => 'Absensi Ujian Mahasiswa',
			'abs_uts' => $abs_uts,
			'abs_uas' => $abs_uas,
		);
		$this->load->view('v_index',$data);
	}

	public function hadir_ujian($jenis_ujian)
	{
		$nim = $this->input->get('nim');
		$id_krs = $this->input->get('id_krs');
		if ($jenis_ujian == 'uts') {
			$data = array(
				'uts_mhs' => 'h',
				'date_uts_mhs' => get_waktu(),
			);
			$this->db->where('nim', $nim);
			$this->db->where('id_krs', $id_krs);
			$simpan = $this->db->update('absen', $data);
			if ($simpan) {
				$this->session->set_flashdata('notif', alert_biasa('absensi UTS kamu berhasil disimpan !','success'));
    			redirect('absensi/absen_mahasiswa','refresh');
			}
		} elseif($jenis_ujian == 'uas') {
			$data = array(
				'uas_mhs' => 'h',
				'date_uas_mhs' => get_waktu(),
			);
			$this->db->where('nim', $nim);
			$this->db->where('id_krs', $id_krs);
			$simpan = $this->db->update('absen', $data);
			if ($simpan) {
				$this->session->set_flashdata('notif', alert_biasa('absensi UAS kamu berhasil disimpan !','success'));
    			redirect('absensi/absen_mahasiswa','refresh');
			}
		}
	}

}
