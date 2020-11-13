<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen_pa extends CI_Controller {

	
	public function index()
	{
		$data = array(
			'konten' => 'dosen_pa/view',
			'judul_page' => 'Daftar Mahasiswa Bimbingan',
		);
		$this->load->view('v_index',$data);
	}

	public function detail_krs()
	{
		$nim = $this->input->get('nim');
		$kode_semester = $this->input->get('kode_semester');

		$data = array(
			'konten' => 'dosen_pa/detail_krs',
			'judul_page' => "Detail KRS",
			'nim' => $nim,
			'kode_semester' => $kode_semester,
		);
		$this->load->view('v_index',$data);

	}

	public function setujui()
	{
		$nim = $this->input->get('nim');
		$kode_semester = $this->input->get('kode_semester');
		$id_prodi = $this->input->get('id_prodi');

		$this->db->trans_begin();

		$this->db->where('nim', $nim);
		$this->db->where('kode_semester', $kode_semester);
		$this->db->update('temp_krs_pa', array('di_setujui'=>'y','update_at'=>get_waktu()));

		$this->db->where('nim', $nim);
		$this->db->where('kode_semester', $kode_semester);
		$this->db->update('krs', array('konfirmasi_pa'=>'y'));

		if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', alert_notif('Gagal server','danger'));
            redirect('dosen_pa?id_prodi='.$id_prodi.'&kode_tahun='.$kode_semester,'refresh');
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', alert_notif('Berhasil di setujui!','success'));
            redirect('dosen_pa?id_prodi='.$id_prodi.'&kode_tahun='.$kode_semester,'refresh');
        }
	}

	public function batalkan()
	{
		$nim = $this->input->get('nim');
		$kode_semester = $this->input->get('kode_semester');
		$id_prodi = $this->input->get('id_prodi');

		$this->db->trans_begin();

		$this->db->where('nim', $nim);
		$this->db->where('kode_semester', $kode_semester);
		$this->db->update('temp_krs_pa', array('di_setujui'=>'t','update_at'=>get_waktu()));

		$this->db->where('nim', $nim);
		$this->db->where('kode_semester', $kode_semester);
		$this->db->update('krs', array('konfirmasi_pa'=>'t'));

		if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', alert_notif('Gagal server','danger'));
            redirect('dosen_pa?id_prodi='.$id_prodi.'&kode_tahun='.$kode_semester,'refresh');
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', alert_notif('Berhasil di dibatalkan!','success'));
            redirect('dosen_pa?id_prodi='.$id_prodi.'&kode_tahun='.$kode_semester,'refresh');
        }
	}

}
