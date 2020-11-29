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

	public function simpan_kehadiran()
	{
		$id_prodi = $this->input->post('id_prodi');
		$kode_mk = $this->input->post('kode_mk');
		$kode_semester = $this->input->post('kode_semester');
		$kelas = $this->input->post('kelas');
		$id_dosen = $this->input->post('id_dosen');
		$tanggal = $this->input->post('tanggal');

		$this->db->where('kode_mk', $kode_mk);
        $this->db->where('kode_semester', $kode_semester);
        $this->db->where('id_prodi', $id_prodi);
        $this->db->where('kelas', $kelas);
        $this->db->where('id_dosen', $id_dosen);
        $this->db->where('tanggal', date('Y-m-d'));
        $abs_dosen = $this->db->get('absen_dosen');
        if ($abs_dosen->num_rows() > 0) {
        	$id_absen_dosen = $abs_dosen->row()->id_absen_dosen;
        	$this->db->where('id_absen_dosen', $id_absen_dosen);
        	$simpan = $this->db->update('absen_dosen', $_POST);
        } else {
        	$simpan = $this->db->insert('absen_dosen', $_POST);
        }

        if ($simpan) {
			$this->session->set_flashdata('message', alert_notif('Data Pembahasan berhasil disimpan !','success'));
			redirect('Kelas_ajar/absensi_mahasiswa?'.param_get(),'refresh');
		}

		
	}

	public function absen_mhs()
	{
		$id_krs = $this->input->post('id_krs');
		$id_absen_dosen = $this->input->post('id_absen_dosen');
		$nim = $this->input->post('nim');
		$kehadiran = $this->input->post('kehadiran');

		if ($kehadiran == 'a') {
			$status = 'Alfa';
		} elseif ($kehadiran == 'h') {
			$status = 'Hadir';
		} elseif ($kehadiran == 'i') {
			$status = 'Izin';
		} elseif ($kehadiran == 's') {
			$status = 'Sakit';
		} else {
			$status = '';
		}

		$this->db->where('id_krs', $id_krs);
		$this->db->where('id_absen_dosen', $id_absen_dosen);
		$this->db->where('nim', $nim);
		$cek = $this->db->get('absen_mahasiswa');
		if ($cek->num_rows() > 0) {
			$this->db->where('id_krs', $id_krs);
			$this->db->where('id_absen_dosen', $id_absen_dosen);
			$this->db->where('nim', $nim);
        	$simpan = $this->db->update('absen_mahasiswa', array('kehadiran'=>$kehadiran));
		} else {
			$simpan = $this->db->insert('absen_mahasiswa', $_POST);
		}

		if ($simpan) {
			?>
			<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                    <button class="close" data-dismiss="alert">
                        ×
                    </button>
                    <i class="fa-fw fa fa-info"></i>

                    <strong>Info:</strong> Mahasiswa dengan nim <?php echo $nim ?> diset <?php echo $status ?> !
                </div>
			<?php
		}

	}

	public function get_select_mk($id_prodi)
	{
		$kode_semester = tahun_akademik_aktif('kode_tahun');
		$this->db->where('id_prodi', $id_prodi);
		$this->db->where('id_dosen', $this->session->userdata('keterangan'));
		$this->db->where('kode_semester', $kode_semester );
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

	public function get_select_kelas($id_prodi,$kode_mk)
	{
		$kode_semester = tahun_akademik_aktif('kode_tahun');
		$this->db->select('kelas');
		$this->db->where('id_prodi', $id_prodi);
		$this->db->where('kode_mk', $kode_mk);
		$this->db->where('id_dosen', $this->session->userdata('keterangan'));
		$this->db->where('kode_semester', $kode_semester );
		$this->db->group_by('kelas');
		$data = $this->db->get('krs');

		?>
		<select name="kelas" id="kelas" style="width:100%;">
			<option value="">--Semua Kelas --</option>
			<?php foreach ($data->result() as $rw): ?>
				<option value="<?php echo $rw->kelas ?>"><?php echo $rw->kelas ?></option>
			<?php endforeach ?>
		</select>


		<?php 
	}

}

/* End of file Kelas_ajar.php */
/* Location: ./application/controllers/Kelas_ajar.php */