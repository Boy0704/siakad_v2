<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}

	
	public function krs_mahasiswa()
	{
		cek_semester_aktif('app');
		cek_registrasi_mahasiswa('app',$this->session->userdata('username'),tahun_akademik_aktif('kode_tahun'));
		$data = array(
			'konten' => 'krs/krs_mahasiswa',
			'judul_page' => 'KRS Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function ambil_krs()
	{
		$id_prodi = $this->input->get('id_prodi');
		$id_prodi = decode($id_prodi);
		$id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');

		if ($id_prodi == '') {
			$this->session->set_flashdata('notif', alert_biasa('kesalahan prodi tidak diset!','error'));
			redirect('krs/krs_mahasiswa','refresh');
		}
		$this->db->select('semester');
		$this->db->where('id_prodi', $id_prodi);
		$this->db->where('id_tahun_akademik', $id_tahun_akademik);
		$this->db->order_by('semester', 'asc');
		$this->db->group_by('semester');
		$smt = $this->db->get('jadwal_kuliah');
		$data = array(
			'smt' => $smt,
			'id_tahun_akademik'=> $id_tahun_akademik,
			'konten' => 'krs/ambil_krs',
			'judul_page' => 'Pilih Matakuliah',
		);
		$this->load->view('v_index',$data);

	}

	public function aksi_ambil_krs($id_jadwal,$aksi)
	{
		$id_prodi = $this->input->get('id_prodi');
		$id_prodi = decode($id_prodi);
		$id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');
		$kode_tahun = tahun_akademik_aktif('kode_tahun');

		if ($id_prodi == '') {
			$this->session->set_flashdata('notif', alert_biasa('kesalahan prodi tidak diset!','error'));
			redirect('krs/krs_mahasiswa','refresh');
		}

		if ($aksi == 'ambil') {
			$this->db->where('id_jadwal', $id_jadwal);
			$d_jadwal = $this->db->get('jadwal_kuliah')->row();

			$data = array(
				'nim' => $this->session->userdata('username'),
				'id_jadwal' => $d_jadwal->id_jadwal,
				'id_mk' => $d_jadwal->id_mk,
				'kode_mk' => get_data('matakuliah','id_mk',$d_jadwal->id_mk,'kode_mk'),
				'nama_mk' => get_data('matakuliah','id_mk',$d_jadwal->id_mk,'nama_mk'),
				'id_tahun_akademik' => $id_tahun_akademik,
				'kode_semester' => $kode_tahun,
				'semester' => $d_jadwal->semester,
				'id_dosen' => $d_jadwal->id_dosen,
				'nama_dosen' => get_data('dosen','id_dosen',$d_jadwal->id_dosen,'nama'),
				'kelas' => $d_jadwal->kelas,
			);
			$simpan = $this->db->insert('krs', $data);
			if ($simpan) {
				$id_prodi = encode($id_prodi);
				$this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Matakuliah berhasil ditambahkan di KRS
                                    </div>');
				redirect('krs/ambil_krs?id_prodi='.$id_prodi,'refresh');
			}

		} elseif ($aksi == 'batal') {
			$this->db->where('id_jadwal', $id_jadwal);
			$this->db->where('nim', $this->session->userdata('username'));
			$delete = $this->db->delete('krs');
			if ($delete) {
				$id_prodi = encode($id_prodi);
				$this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Matakuliah berhasil dibatalkan di KRS
                                    </div>');
				redirect('krs/ambil_krs?id_prodi='.$id_prodi,'refresh');
			}
		}
	}



}
