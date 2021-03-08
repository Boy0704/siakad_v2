<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->rbac->check_module_access();
	}

	public function index()
	{
		$this->rbac->check_operation_access();

		$data = array(
			'konten' => 'krs/view_krs',
			'judul_page' => 'Data KRS',
		);
		$this->load->view('v_index',$data);
	}

	public function khs()
	{
		$this->rbac->check_operation_access();

		$data = array(
			'konten' => 'krs/view_khs',
			'judul_page' => 'Data KHS',
		);
		$this->load->view('v_index',$data);
	}

	public function delete_krs($id_krs)
	{
		$this->db->where('id_krs', $id_krs);
		$delete = $this->db->delete('krs');
		if ($delete) {
			$this->session->set_flashdata('notif', alert_biasa('Krs mahasiswa berhasil dihapus !','success'));
			redirect('krs?'.param_get(),'refresh');
		} 
	}

	public function delete_khs($id_krs)
	{
		$this->db->where('id_krs', $id_krs);
		$delete = $this->db->delete('krs');
		if ($delete) {
			$this->session->set_flashdata('notif', alert_biasa('KHS mahasiswa berhasil dihapus !','success'));
			redirect('krs/khs?'.param_get(),'refresh');
		} 
	}

	public function input_nilai_mahasiswa()
	{
		$this->rbac->check_operation_access();

		$data = array(
			'konten' => 'krs/input_nilai_mahasiswa',
			'judul_page' => 'Input Nilai Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function tambah_krs()
	{
		if ($_POST) {
			$nim = $this->input->post('nim');
			$id_jadwal = $this->input->post('id_jadwal');

			$this->db->where('id_jadwal', $id_jadwal);
			$d_jadwal = $this->db->get('jadwal_kuliah')->row();
			$id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');
			$kode_tahun = tahun_akademik_aktif('kode_tahun');

			$data = array(
				'nim' => $nim,
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
				'id_prodi' => $d_jadwal->id_prodi,
			);

			//cek_kuota kelas
			$this->db->where('id_mk', $d_jadwal->id_mk);
			$this->db->where('id_prodi', $d_jadwal->id_prodi);
			$this->db->where('kelas', $d_jadwal->kelas);
			$this->db->where('kode_semester', $kode_tahun);
			$total_terisi = $this->db->get('krs');

			$kapasitas = get_data('jadwal_kuliah','id_jadwal',$d_jadwal->id_jadwal,'kapasitas');
			if ($kapasitas == '') {
				$kapasitas = 0;
			}
			if ($total_terisi->num_rows() == $kapasitas) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Kapasitas kelas sudah penuh !
                                    </div>');
				redirect('krs?'.param_get(),'refresh');
			}

			$this->db->trans_begin();

			$simpan = $this->db->insert('krs', $data);
			$id_krs = $this->db->insert_id();

			//simpan absensi
			$dt_absen = array(
				'nim' => $this->session->userdata('username'),
				'id_krs' => $id_krs,
			);
			$this->db->insert('absen', $dt_absen);

			$this->db->where('id_jadwal', $d_jadwal->id_jadwal);
			$this->db->update('jadwal_kuliah', array('terisi'=>$d_jadwal->terisi+1));

			if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
				$this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Matakuliah gagal ditambahkan di KRS
                                    </div>');
				redirect('krs?'.param_get(),'refresh');
			}
			else
			{
		        $this->db->trans_commit();
				$this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Matakuliah berhasil ditambahkan di KRS
                                    </div>');
				redirect('krs?'.param_get(),'refresh');
			}

		} else {
			$data = array(
				'konten' => 'krs/tambah_krs',
				'judul_page' => 'Tambah Krs Manual',
			);
			$this->load->view('v_index',$data);
		}
	}

	public function tambah_khs()
	{
		if ($_POST) {
			$nim = $this->input->post('nim');
			$id_mk = $this->input->post('id_mk');
			$kode_tahun = $this->input->post('periode');
			$n_angka = $this->input->post('nilai');
			$id_prodi = $this->input->get('id_prodi');


			$skala  = $this->db->get('skala_nilai');
			$nilai_huruf = '';
			$nilai_indeks = '';
			if ($skala->num_rows() > 0) {
				foreach ($skala->result() as $rw) {
					if ($rw->min <= $n_angka && $rw->max >= $n_angka) {
						$nilai_huruf = $rw->nilai_huruf;
						$nilai_indeks = $rw->nilai_indeks;
					}
				}
			} else {
				$nilai_huruf = '';
				$nilai_indeks = '';
			}

			$data = array(
				'nim' => $nim,
				'id_mk' => $id_mk,
				'kode_mk' => get_data('master_matakuliah','id_mk',$id_mk,'kode_mk'),
				'nama_mk' => get_data('master_matakuliah','id_mk',$id_mk,'nama_mk'),
				'kode_semester' => $kode_tahun,
				'semester' => get_data('master_matakuliah','id_mk',$id_mk,'semester'),
				'sks' => get_data('master_matakuliah','id_mk',$id_mk,'sks_total'),
				'id_prodi' => $id_prodi,
				'angka' => $n_angka,
				'indeks' => $nilai_indeks,
				'huruf' => $nilai_huruf,
				'konfirmasi_pa' => 'y',
				'konfirmasi_nilai' => 'y'
			);

			
			$this->db->trans_begin();

			$simpan = $this->db->insert('krs', $data);
			if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
				$this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Matakuliah gagal ditambahkan di KHS
                                    </div>');
				redirect('krs/khs?'.param_get(),'refresh');
			}
			else
			{
		        $this->db->trans_commit();
				$this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Matakuliah berhasil ditambahkan di KHS
                                    </div>');
				redirect('krs/khs?'.param_get(),'refresh');
			}

		} else {
			$data = array(
				'konten' => 'krs/tambah_khs',
				'judul_page' => 'Tambah KHS Manual',
			);
			$this->load->view('v_index',$data);
		}
	}

	public function simpan_nilai_mahasiswa($id_krs)
	{
		$kehadiran = $this->input->post('kehadiran');
		$latihan = $this->input->post('latihan');
		$uts = $this->input->post('uts');
		$uas = $this->input->post('uas');

		$n_angka = ($kehadiran * 0.1) + ($latihan * 0.2) + ($uts * 0.30) + ($uas * 0.4);

		$id_prodi = get_data('krs','id_krs',$id_krs,'id_prodi');

		if ($n_angka > 0) {
			// jika id_prodi kosong, berlaku untuk semua
			$skala  = $this->db->get('skala_nilai');
			$nilai_huruf = '';
			$nilai_indeks = '';
			if ($skala->num_rows() > 0) {
				foreach ($skala->result() as $rw) {
					if ($rw->min <= $n_angka && $rw->max >= $n_angka) {
						$nilai_huruf = $rw->nilai_huruf;
						$nilai_indeks = $rw->nilai_indeks;
					}
				}
			} else {
				$nilai_huruf = '';
				$nilai_indeks = '';
			}
			
			$this->db->where('id_krs', $id_krs);
			$this->db->update('krs', array(
				'kehadiran' => $kehadiran,
				'latihan' => $latihan,
				'uts' => $uts,
				'uas' => $uas,
				'angka' => $n_angka,
				'huruf' => $nilai_huruf,
				'indeks' => $nilai_indeks,
			));

		}

		$this->session->set_flashdata('notif', alert_biasa('Nilai Mahasiswa berhasil di update','success'));
			redirect('krs/input_nilai_mahasiswa?'.param_get(),'refresh');

	}

	public function simpan_nilai_admin($id_krs)
	{
		$n_angka = $this->input->post('n_angka');

		$id_prodi = get_data('krs','id_krs',$id_krs,'id_prodi');

		if ($n_angka > 0) {
			// jika id_prodi kosong, berlaku untuk semua
			$skala  = $this->db->get('skala_nilai');
			$nilai_huruf = '';
			$nilai_indeks = '';
			if ($skala->num_rows() > 0) {
				foreach ($skala->result() as $rw) {
					if ($rw->min <= $n_angka && $rw->max >= $n_angka) {
						$nilai_huruf = $rw->nilai_huruf;
						$nilai_indeks = $rw->nilai_indeks;
					}
				}
			} else {
				$nilai_huruf = '';
				$nilai_indeks = '';
			}
			
			$this->db->where('id_krs', $id_krs);
			$update = $this->db->update('krs', array(
				'angka' => $n_angka,
				'huruf' => $nilai_huruf,
				'indeks' => $nilai_indeks,
			));

			if ($update) {
				echo json_encode(array(
					'kode' => 1, 
					'pesan' => 'nilai berhasil diupdate',
					'huruf' => $nilai_huruf,
					'indeks' => $nilai_indeks
				));
			} else {
				echo json_encode(array('kode' => 0, 'pesan' => 'nilai gagal diupdate'));
			}

		}

		

	}

	
	public function krs_mahasiswa()
	{
		$this->rbac->check_operation_access();

		cek_semester_aktif('app');
		cek_registrasi_mahasiswa('app',$this->session->userdata('username'),tahun_akademik_aktif('kode_tahun'));
		$data = array(
			'konten' => 'krs/krs_mahasiswa',
			'judul_page' => 'KRS Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function khs_mahasiswa()
	{
		$this->rbac->check_operation_access();

		$data = array(
			'konten' => 'krs/khs_mahasiswa',
			'judul_page' => 'KHS Mahasiswa',
		);
		$this->db->where('nim', $this->session->userdata('username'));
		$this->db->group_by('kode_semester');
		$this->db->order_by('kode_semester','asc');
		$data['semester'] = $this->db->get('krs');
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
				'id_prodi' => $d_jadwal->id_prodi,
			);

			//cek_kuota kelas
			$this->db->where('id_mk', $d_jadwal->id_mk);
			$this->db->where('id_prodi', $d_jadwal->id_prodi);
			$this->db->where('kelas', $d_jadwal->kelas);
			$this->db->where('kode_semester', $kode_tahun);
			$total_terisi = $this->db->get('krs');

			$kapistas = get_data('jadwal_kuliah','id_jadwal',$d_jadwal->id_jadwal,'kapasitas');
			if ($kapasitas == '') {
				$kapasitas = 0;
			}
			if ($total_terisi->num_rows() == $kapasitas) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Kapasitas kelas sudah penuh !
                                    </div>');
				redirect('krs/ambil_krs?id_prodi='.$id_prodi,'refresh');
			}

			$this->db->trans_begin();

			$simpan = $this->db->insert('krs', $data);
			$id_krs = $this->db->insert_id();

			//simpan absensi
			$dt_absen = array(
				'nim' => $this->session->userdata('username'),
				'id_krs' => $id_krs,
			);
			$this->db->insert('absen', $dt_absen);

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

			//dapatkan id_krs
			$this->db->where('id_jadwal', $id_jadwal);
			$this->db->where('nim', $this->session->userdata('username'));
			$id_krs = $this->db->get('krs')->row()->id_krs;
			//hapus krs
			$this->db->where('id_jadwal', $id_jadwal);
			$this->db->where('nim', $this->session->userdata('username'));
			$delete = $this->db->delete('krs');

			// hapus absen
			$this->db->where('nim', $this->session->userdata('username'));
			$this->db->where('id_krs', $id_krs);
			$this->db->delete('absen');

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
