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
				'sks' => get_data('matakuliah','id_mk',$d_jadwal->id_mk,'sks_total'),
			);

			$this->db->trans_begin();

			$simpan = $this->db->insert('krs', $data);
			$this->db->where('id_jadwal', $d_jadwal->id_jadwal);
			$this->db->update('jadwal_kuliah', array('terisi'=>$d_jadwal->terisi+1));

			if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
		        $id_prodi = encode($id_prodi);
				$this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Matakuliah gagal ditambahkan di KRS
                                    </div>');
				redirect('krs/ambil_krs?id_prodi='.$id_prodi,'refresh');
			}
			else
			{
		        $this->db->trans_commit();
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

			$this->db->trans_begin();

			$this->db->where('id_jadwal', $id_jadwal);
			$d_jadwal = $this->db->get('jadwal_kuliah')->row();

			$this->db->where('id_jadwal', $id_jadwal);
			$this->db->where('nim', $this->session->userdata('username'));
			$delete = $this->db->delete('krs');
			$this->db->where('id_jadwal', $d_jadwal->id_jadwal);
			$this->db->update('jadwal_kuliah', array('terisi'=>$d_jadwal->terisi-1));
			if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
		        $id_prodi = encode($id_prodi);
				$this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Matakuliah gagal dibatalkan di KRS
                                    </div>');
				redirect('krs/ambil_krs?id_prodi='.$id_prodi,'refresh');
			}
			else
			{
		        $this->db->trans_commit();
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

	public function ajukan_krs()
	{
		$nim = $this->input->get('nim');
		$id_prodi = $this->input->get('id_prodi');
		$kode_semester = $this->input->get('kode_semester');
		$id_dosen = $this->input->get('id_dosen');

		if ($id_dosen == '') {
			$this->session->set_flashdata('notif', alert_biasa('Dosen PA belum diset!','error'));
			redirect('krs/krs_mahasiswa','refresh');
		}
		$data = array(
			'nim' => $nim,
			'id_prodi' => $id_prodi,
			'kode_semester' => $kode_semester,
			'id_dosen' => $id_dosen,
			'di_setujui' => 't',
			'create_at' => get_waktu(),
		);
		$simpan = $this->db->insert('temp_krs_pa', $data);
		if ($simpan) {
			$this->session->set_flashdata('notif', alert_biasa('Pengajuan berhasil, silahkan hubungi dosen PA untuk segera di setujui!','success'));
			redirect('krs/krs_mahasiswa','refresh');
		}

	}



}
