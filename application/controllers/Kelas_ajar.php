<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_ajar extends CI_Controller {

	public function index()
	{
		$data = array(
			'konten' => 'ajar_dosen/view',
			'judul_page' => 'Kelas Ajar Dosen',
		);
		$this->load->view('v_index',$data);
	}

	public function absensi_mahasiswa()
	{
		$data = array(
			'konten' => 'ajar_dosen/absensi_kehadiran',
			'judul_page' => 'Absensi Kehadiran Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function get_select_mk($id_prodi)
	{
		$this->db->where('id_prodi', $id_prodi);
		$this->db->where('id_dosen', $this->session->userdata('keterangan'));
		$this->db->group_by('kode_mk');
		$data = $this->db->get('krs');

		?>
		<select name="kode_mk" id="kode_mk" style="width:100%;">
			<option value="">--Pilih MK --</option>
			<?php foreach ($data->result() as $rw): ?>
				<option value="<?php echo $rw->kode_mk ?>"><?php echo $rw->kode_mk.' - '. $rw->nama_mk ?></option>
			<?php endforeach ?>
		</select>


		<?php 
	}

}

/* End of file Kelas_ajar.php */
/* Location: ./application/controllers/Kelas_ajar.php */