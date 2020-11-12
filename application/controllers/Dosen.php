<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dosen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Dosen_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'dosen/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'dosen/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'dosen/index.html';
            $config['first_url'] = base_url() . 'dosen/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Dosen_model->total_rows($q);
        $dosen = $this->Dosen_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'dosen_data' => $dosen,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'dosen/dosen_list',
            'konten' => 'dosen/dosen_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Dosen_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_dosen' => $row->id_dosen,
		'nama' => $row->nama,
		'nidn' => $row->nidn,
		'nip' => $row->nip,
		'no_pegawai' => $row->no_pegawai,
		'jenis_kelamin' => $row->jenis_kelamin,
		'agama' => $row->agama,
		'tanggal_lahir' => $row->tanggal_lahir,
		'status' => $row->status,
		'id_jabatan' => $row->id_jabatan,
	    );
            $this->load->view('dosen/dosen_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dosen'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'dosen/dosen_form',
            'konten' => 'dosen/dosen_form',
            'button' => 'Simpan',
            'action' => site_url('dosen/create_action'),
	    'id_dosen' => set_value('id_dosen'),
	    'nama' => set_value('nama'),
	    'nidn' => set_value('nidn'),
	    'nip' => set_value('nip'),
	    'no_pegawai' => set_value('no_pegawai'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'agama' => set_value('agama'),
	    'tanggal_lahir' => set_value('tanggal_lahir'),
	    'status' => set_value('status'),
        'id_prodi' => set_value('id_prodi'),
	    'id_jabatan' => set_value('id_jabatan'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'nidn' => $this->input->post('nidn',TRUE),
		'nip' => $this->input->post('nip',TRUE),
		'no_pegawai' => $this->input->post('no_pegawai',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'agama' => $this->input->post('agama',TRUE),
		'tanggal_lahir' => $this->input->post('tanggal_lahir',TRUE),
        'status' => $this->input->post('status',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
		'id_jabatan' => $this->input->post('id_jabatan',TRUE),
	    );
            $this->db->trans_begin();
            $this->Dosen_model->insert($data);
            $this->db->insert('users', array(
                'nama' => $this->input->post('nama'),
                'username' => $retVal = ($this->input->post('nidn') != '') ? $this->input->post('nidn') : $this->input->post('no_pegawai'),
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'level' => '4',
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
                redirect('dosen','refresh');
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
                                        akun login berdasarkan nidn/no_pegawai dan password default(123456)
                                    </div>');
                redirect(site_url('dosen'));
            }

            
        }
    }
    
    public function update($id) 
    {
        $row = $this->Dosen_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'dosen/dosen_form',
                'konten' => 'dosen/dosen_form',
                'button' => 'Ubah',
                'action' => site_url('dosen/update_action'),
		'id_dosen' => set_value('id_dosen', $row->id_dosen),
		'nama' => set_value('nama', $row->nama),
		'nidn' => set_value('nidn', $row->nidn),
		'nip' => set_value('nip', $row->nip),
		'no_pegawai' => set_value('no_pegawai', $row->no_pegawai),
		'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
		'agama' => set_value('agama', $row->agama),
		'tanggal_lahir' => set_value('tanggal_lahir', $row->tanggal_lahir),
        'status' => set_value('status', $row->status),
		'id_prodi' => set_value('id_prodi', $row->id_prodi),
		'id_jabatan' => set_value('id_jabatan', $row->id_jabatan),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dosen'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_dosen', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'nidn' => $this->input->post('nidn',TRUE),
		'nip' => $this->input->post('nip',TRUE),
		'no_pegawai' => $this->input->post('no_pegawai',TRUE),
		'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
		'agama' => $this->input->post('agama',TRUE),
		'tanggal_lahir' => $this->input->post('tanggal_lahir',TRUE),
        'status' => $this->input->post('status',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
		'id_jabatan' => $this->input->post('id_jabatan',TRUE),
	    );

            

            $this->db->trans_begin();
            $this->Dosen_model->update($this->input->post('id_dosen', TRUE), $data);
            $this->db->where('keterangan', $this->input->post('id_dosen'));
            $this->db->where('level', 4);
            $this->db->update('users', array(
                'nama' => $this->input->post('nama'),
                'username' => $retVal = ($this->input->post('nidn') != '') ? $this->input->post('nidn') : $this->input->post('no_pegawai'),
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

                                        <strong>Info:</strong> Gagal diupdate !
                                    </div>');
                redirect('dosen','refresh');
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diupdate.<br>
                                        akun login login juga ikut terupdate.
                                    </div>');
                redirect(site_url('dosen'));
            }

            
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Dosen_model->get_by_id($id);

        if ($row) {
            $this->db->trans_begin();
            $this->Dosen_model->delete($id);
            //hapus akun dosen
            $this->db->where('keterangan', $id);
            $this->db->where('level', 4);
            $this->db->delete('users');

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', '<div class="alert alert-warning fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Gagal dihapus !
                                    </div>');
                redirect('dosen','refresh');
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus beserta data akun login.
                                    </div>');
                redirect(site_url('dosen'));
            }

           
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dosen'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	// $this->form_validation->set_rules('nidn', 'nidn', 'trim|required');
	// $this->form_validation->set_rules('nip', 'nip', 'trim|required');
	$this->form_validation->set_rules('no_pegawai', 'no pegawai', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('agama', 'agama', 'trim|required');
	// $this->form_validation->set_rules('tanggal_lahir', 'tanggal lahir', 'trim|required');
    $this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('id_prodi', 'prodi', 'trim|required');
	// $this->form_validation->set_rules('id_jabatan', 'id jabatan', 'trim|required');

	$this->form_validation->set_rules('id_dosen', 'id_dosen', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Dosen.php */
/* Location: ./application/controllers/Dosen.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-09 19:46:00 */
/* https://jualkoding.com */