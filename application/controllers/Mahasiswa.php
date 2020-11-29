<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->rbac->check_module_access();
	}
	
	public function index()
	{
		$this->rbac->check_operation_access();
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
			'dosen_pa'=> '',
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
		$this->rbac->check_operation_access();
		$data = array(
			'konten' => 'mahasiswa/ubah',
			'judul_page' => 'Update Mahasiswa',
			'data_mhs' => $this->db->get_where('mahasiswa', array('id_mahasiswa'=>$id)),
		);
		$this->load->view('v_index',$data);
	}

	public function biodata_mahasiswa()
	{
		$this->rbac->check_operation_access();
		$data = array(
			'konten' => 'mahasiswa/biodata_mahasiswa',
			'judul_page' => 'Biodata Mahasiswa',
			'data_mhs' => $this->db->get_where('mahasiswa', array('nim'=>$this->session->userdata('username'))),
		);
		$this->load->view('v_index',$data);
	}

	public function update_action($id)
	{
		log_r($_POST);
	}

	public function update_biodata_mahasiswa()
	{
		// log_r($_POST);
		$this->db->where('nim', $this->session->userdata('username'));
		$update = $this->db->update('mahasiswa', $_POST);
		if ($update) {
			$this->session->set_flashdata('notif', alert_biasa('biodata kamu berhasil diupdate','success'));
			redirect('mahasiswa/biodata_mahasiswa','refresh');
		}
	}

	public function delete($id)
	{
		# code...
	}




}
