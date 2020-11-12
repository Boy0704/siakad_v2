<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller {

	
	public function index()
	{
		$data = array(
			'konten' => 'registrasi/view',
			'judul_page' => 'Registrasi Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function aksi_registrasi($aksi)
	{
		$id_prodi = $this->input->get('id_prodi');
		$id_tahun_angkatan = $this->input->get('id_tahun_angkatan');
		$id_mahasiswa = $this->input->get('id_mahasiswa');
		$id_tahun_akademik = $this->input->get('id_tahun_akademik');
		$kode_semester = $this->input->get('kode_semester');
		$semester = $this->input->get('semester');
		if ($aksi == 'registrasi') {
			$nim = get_data('mahasiswa','id_mahasiswa',$id_mahasiswa,'nim');
			$data = array(
				'nim' => $nim,
				'tanggal_registrasi' => get_waktu(),
				'id_tahun_akademik' => $id_tahun_akademik,
				'kode_semester' => $kode_semester,
				'semester' => $semester,
			);
			$this->db->trans_begin();
			$this->db->insert('registrasi', $data);
			$this->db->where('id_mahasiswa', $id_mahasiswa);
			$this->db->update('mahasiswa', array('semester_aktif'=>$semester));
			if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
		        $this->session->set_flashdata('message', '<div class="alert alert-warning fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Gagal server
                                    </div>');
		        
				redirect('registrasi?id_prodi='.$id_prodi.'&id_tahun_angkatan='.$id_tahun_angkatan,'refresh');
			}
			else
			{
		        $this->db->trans_commit();
		        $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Mahasiswa berhasil diregistrasikan
                                    </div>');
				redirect('registrasi?id_prodi='.$id_prodi.'&id_tahun_angkatan='.$id_tahun_angkatan,'refresh');
			}
		} elseif ($aksi == 'batal_registrasi') {
			
			$this->db->trans_begin();
			$nim = get_data('mahasiswa','id_mahasiswa',$id_mahasiswa,'nim');
			$semester_aktif = get_data('mahasiswa','id_mahasiswa',$id_mahasiswa,'semester_aktif');
			$this->db->where('nim', $nim);
			$this->db->where('id_tahun_akademik', $id_tahun_akademik);
			$this->db->delete('registrasi');

			$this->db->where('id_mahasiswa', $id_mahasiswa);
			$this->db->update('mahasiswa', array('semester_aktif'=>$semester_aktif-1));
			if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
		        $this->session->set_flashdata('message', '<div class="alert alert-warning fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Gagal server
                                    </div>');
		        
				redirect('registrasi?id_prodi='.$id_prodi.'&id_tahun_angkatan='.$id_tahun_angkatan,'refresh');
			}
			else
			{
		        $this->db->trans_commit();
		        $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Registrasi mahasiswa sudah dibatalkan
                                    </div>');
				redirect('registrasi?id_prodi='.$id_prodi.'&id_tahun_angkatan='.$id_tahun_angkatan,'refresh');
			}
		}
	}


}
