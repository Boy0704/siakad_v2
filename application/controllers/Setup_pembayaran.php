<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_pembayaran extends CI_Controller {

	public function index()
	{
		$data = array(
			'konten' => 'Setup_pembayaran/view',
			'judul_page' => 'Setup Biaya Pembayaran',
		);
		$this->load->view('v_index',$data);
	}

	public function setup($tahun)
	{
		$data_biaya = $this->db->get('biaya');
		foreach ($data_biaya->result() as $rw) {
			$this->db->insert('Biaya_pembayaran', array(
				'id_biaya' => $rw->id_biaya,
				'nilai'=> 0,
				'tahun_berlaku' => $tahun,
				'id_prodi' => $rw->id_prodi,
			));
		}
		$this->session->set_flashdata('message', alert_notif("Biaya Pembayaran Tahun $tahun berhasil digenerate",'success'));
		redirect('Setup_pembayaran?tahun_angkatan='.$tahun,'refresh');
	}

	public function update_biaya($id_nilai_biaya)
	{
		if ($_POST) {
			$nilai = $this->input->post('nilai');
			$this->db->where('id_nilai_biaya', $id_nilai_biaya);
			$update = $this->db->update('biaya_pembayaran', array('nilai'=>$nilai));
			if ($update) {
				$this->session->set_flashdata('message', alert_notif("biaya berhasil diupdate",'success'));
				redirect('Setup_pembayaran?'.param_get(),'refresh');
			}
		}
	}

	public function hapus_massal($tahun)
	{
		$this->db->where('tahun_berlaku', $tahun);
		$delete = $this->db->delete('biaya_pembayaran');
		if ($delete) {
			$this->session->set_flashdata('message', alert_notif("biaya berhasil dihapus",'success'));
			redirect('Setup_pembayaran?'.param_get(),'refresh');
		}
	}

	public function set_tampilkan($id,$val)
	{
		$this->db->where('id_nilai_biaya', $id);
		$update = $this->db->update('biaya_pembayaran', array('tampilkan'=>$val));
		if ($update) {
			if ($val=='y') {
				echo "Ya";
			} else {
				echo "Tidak";
			}
		}
	}


}

/* End of file Biaya_pembayaran.php */
/* Location: ./application/controllers/Biaya_pembayaran.php */