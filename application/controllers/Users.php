<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'users/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'users/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'users/index.html';
            $config['first_url'] = base_url() . 'users/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Users_model->total_rows($q);
        $users = $this->Users_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'users_data' => $users,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Daftar User Pengguna',
            'konten' => 'users/users_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_user' => $row->id_user,
		'nama' => $row->nama,
		'username' => $row->username,
		'password' => $row->password,
		'level' => $row->level,
		'foto' => $row->foto,
		'keterangan' => $row->keterangan,
		'last_login' => $row->last_login,
		'online' => $row->online,
	    );
            $this->load->view('users/users_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah User Pengguna',
            'konten' => 'users/users_form',
            'button' => 'Simpan',
            'action' => site_url('users/create_action'),
	    'id_user' => set_value('id_user'),
	    'nama' => set_value('nama'),
	    'username' => set_value('username'),
	    'password' => set_value('password'),
	    'level' => set_value('level'),
	    'foto' => set_value('foto'),
	    'keterangan' => set_value('keterangan'),
	    'last_login' => set_value('last_login'),
	    'online' => set_value('online'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            $img = upload_gambar_biasa('user', 'image/user/', 'jpg|png|jpeg', 10000, 'foto');

            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => password_hash($this->input->post('password',TRUE), PASSWORD_DEFAULT),
		'level' => $this->input->post('level',TRUE),
		'foto' => $img,
        'id_prodi' => $this->input->post('id_prodi'),
		// 'keterangan' => $this->input->post('keterangan',TRUE),
		// 'last_login' => $this->input->post('last_login',TRUE),
		// 'online' => $this->input->post('online',TRUE),
	    );

            $this->Users_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('users'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah User Pengguna',
                'konten' => 'users/users_form',
                'button' => 'Ubah',
                'action' => site_url('users/update_action'),
		'id_user' => set_value('id_user', $row->id_user),
		'nama' => set_value('nama', $row->nama),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
		'level' => set_value('level', $row->level),
		'foto' => set_value('foto', $row->foto),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'last_login' => set_value('last_login', $row->last_login),
		'online' => set_value('online', $row->online),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_user', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => password_hash($this->input->post('password',TRUE), PASSWORD_DEFAULT),
		'level' => $this->input->post('level',TRUE),
		'foto' => $retVal = ($_FILES['foto']['name'] == '') ? $_POST['foto_old'] : upload_gambar_biasa('user', 'image/user/', 'jpeg|png|jpg|gif', 10000, 'foto'),
        'id_prodi'=>$this->input->post('id_prodi'),
		// 'keterangan' => $this->input->post('keterangan',TRUE),
		// 'last_login' => $this->input->post('last_login',TRUE),
		// 'online' => $this->input->post('online',TRUE),
	    );

            $this->Users_model->update($this->input->post('id_user', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('users'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $this->Users_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('users'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('username', 'username', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
	$this->form_validation->set_rules('level', 'level', 'trim|required');
	// $this->form_validation->set_rules('foto', 'foto', 'trim|required');
	// $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	// $this->form_validation->set_rules('last_login', 'last login', 'trim|required');
	// $this->form_validation->set_rules('online', 'online', 'trim|required');

	$this->form_validation->set_rules('id_user', 'id_user', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-10 04:45:21 */
/* https://jualkoding.com */