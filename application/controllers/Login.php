<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function index()
	{
		$this->load->view('login');
	}

	public function auth()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if ($_POST) {
			$this->db->where('username', $username);
			$cek = $this->db->get('users');
			if ($cek->num_rows() == 0) {
				$this->session->set_flashdata('message', alert_biasa('Gagal Login!\n username tidak ditemukan','warning'));
				redirect('login','refresh');
			} else {
				$users = $cek->row();
				if (password_verify($password, $users->password)) {
					// jika berhasil login
					$sess_data['id_user'] = $users->id_user;
					$sess_data['nama'] = $users->nama;
					$sess_data['username'] = $users->username;
					$sess_data['foto'] = $users->foto;
					$sess_data['level'] = $users->level;
					$sess_data['keterangan'] = $users->keterangan;
					$this->session->set_userdata($sess_data);

					// update last login
					$this->db->where('id_user', $users->id_user);
					$up_last = $this->db->update('users', array('last_login'=>get_waktu()));

					if ($up_last) {
						redirect('app','refresh');
					} else {
						$this->session->set_flashdata('message', alert_biasa('Gagal Login!\n ada kesalahan server','warning'));
						redirect('login','refresh');
					}

				} else {
					$this->session->set_flashdata('message', alert_biasa('Gagal Login!\n password kamu salah','warning'));
					redirect('login','refresh');
				}
			}
		}
	}

	public function auth_pass()
	{
		# code...
	}

	function logout()
	{

		//simpan log
		// $this->db->insert('log_user', array(
		// 	'id_user' => $this->session->userdata('id_user'),
		// 	'nama' => $this->session->userdata('nama'),
		// 	'level' => $this->session->userdata('level'),
		// 	'date_at' => get_waktu(),
		// 	'status' => 'logout',
		// ));

		// $this->db->where('id_user', $this->session->userdata('id_user'));
		// $this->db->update('a_user', array('status_login'=>'0'));


		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('level');
		session_destroy();
		redirect('login','refresh');
	}

}
