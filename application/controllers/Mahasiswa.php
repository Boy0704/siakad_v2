<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	
	public function index()
	{
		$data = array(
			'konten' => 'mahasiswa/view',
			'judul_page' => 'Data Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function create()
	{
		$data = array(
			'jenis_kelamin'=> '',
			'id_prodi'=> '',
			'id_tahun_angkatan'=> '',
			'jalur_pendaftaran'=> '',
			'jenis_pendaftaran'=> '',
			'konten' => 'mahasiswa/tambah',
			'judul_page' => 'Tambah Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function create_action()
	{
		
		$this->db->trans_begin();
        $this->db->insert('mahasiswa', $_POST);
        $this->db->insert('users', array(
            'nama' => $this->input->post('nama'),
            'username' => $this->input->post('nim'),
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'level' => '5',
            'keterangan' => $this->db->insert_id(),
            'id_prodi' => $this->input->post('id_prodi'),
        ));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-warning fade in alert-radius-bordered alert-shadowed">
                                    <button class="close" data-dismiss="alert">
                                        ×
                                    </button>
                                    <i class="fa-fw fa fa-info"></i>

                                    <strong>Info:</strong> Gagal simpan !
                                </div>');
            redirect(site_url('mahasiswa?id_prodi='.$this->input->get('id_prodi').'&id_tahun_angkatan='.$this->input->get('id_tahun_angkatan')));
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                    <button class="close" data-dismiss="alert">
                                        ×
                                    </button>
                                    <i class="fa-fw fa fa-info"></i>

                                    <strong>Info:</strong> Data Berhasil disimpan.<br>
                                    akun login berdasarkan nim dan password default(123456)
                                </div>');
            redirect(site_url('mahasiswa?id_prodi='.$this->input->get('id_prodi').'&id_tahun_angkatan='.$this->input->get('id_tahun_angkatan')));
        }

	}

	public function update($id)
	{
		$data = array(
			'konten' => 'mahasiswa/ubah',
			'judul_page' => 'Update Mahasiswa',
		);
	}

	public function update_action($id)
	{
		# code...
	}

	public function delete($id)
	{
		# code...
	}




}
