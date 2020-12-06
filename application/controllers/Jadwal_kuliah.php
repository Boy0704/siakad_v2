<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal_kuliah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_kuliah_model');
        $this->load->library('form_validation');
        $this->rbac->check_module_access();
    }

    public function jadwal_mahasiswa()
    {
        $this->rbac->check_operation_access();
        $data = array(
            'konten' => 'jadwal_kuliah/jadwal_mahasiswa',
            'judul_page' => 'Jadwal Kuliah Mahasiswa',
        );
        $this->load->view('v_index',$data);
    }

    public function index()
    {
        $this->rbac->check_operation_access();
        cek_semester_aktif('tahun_akademik');
        $data = array(
            'konten' => 'jadwal_kuliah/view',
            'judul_page' => 'Jadwal Kuliah',
        );
        $this->load->view('v_index',$data);
    }

    public function read($id) 
    {
        $row = $this->Jadwal_kuliah_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_jadwal' => $row->id_jadwal,
		'id_tahun_akademik' => $row->id_tahun_akademik,
		'id_mk' => $row->id_mk,
		'id_dosen' => $row->id_dosen,
		'kelas' => $row->kelas,
		'ruang' => $row->ruang,
		'hari' => $row->hari,
		'jam_mulai' => $row->jam_mulai,
		'jam_selesai' => $row->jam_selesai,
		'id_prodi' => $row->id_prodi,
		'semester' => $row->semester,
		'kapasitas' => $row->kapasitas,
		'terisi' => $row->terisi,
	    );
            $this->load->view('jadwal_kuliah/jadwal_kuliah_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jadwal_kuliah'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Jadwal Kuliah',
            'konten' => 'jadwal_kuliah/jadwal_kuliah_form',
            'button' => 'Simpan',
            'action' => site_url('jadwal_kuliah/create_action'),
	    'id_jadwal' => set_value('id_jadwal'),
	    'id_tahun_akademik' => set_value('id_tahun_akademik'),
	    'id_mk' => set_value('id_mk'),
	    'id_dosen' => set_value('id_dosen'),
	    'kelas' => set_value('kelas'),
	    'ruang' => set_value('ruang'),
	    'hari' => set_value('hari'),
	    'jam_mulai' => set_value('jam_mulai'),
	    'jam_selesai' => set_value('jam_selesai'),
	    'id_prodi' => set_value('id_prodi'),
	    'semester' => set_value('semester'),
	    'kapasitas' => set_value('kapasitas'),
	    'terisi' => set_value('terisi'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->where('ruang', $this->input->post('ruang'));
            $this->db->where('hari', $this->input->post('hari'));
            $this->db->where('jam_mulai', $this->input->post('jam_mulai'));
            $cek_jadwal_tabrakan = $this->db->get('jadwal_kuliah');
            if ($cek_jadwal_tabrakan->num_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> jadwal gagal di tambahkan <br>
                                            ruang : '.$this->input->post('ruang').'<br>
                                            hari : '.$this->input->post('hari').'<br>
                                            jam mulai : '.$this->input->post('jam_mulai').'<br>
                                            sudah terpakai.
                                    </div>');
                    redirect(site_url('jadwal_kuliah?id_prodi='.$this->input->post('id_prodi')));
            }

            $data = array(
		'id_tahun_akademik' => tahun_akademik_aktif('id_tahun_akademik'),
		'id_mk' => $this->input->post('id_mk',TRUE),
		'id_dosen' => $this->input->post('id_dosen',TRUE),
		'kelas' => $this->input->post('kelas',TRUE),
		'ruang' => $this->input->post('ruang',TRUE),
		'hari' => $this->input->post('hari',TRUE),
		'jam_mulai' => $this->input->post('jam_mulai',TRUE),
		'jam_selesai' => $this->input->post('jam_selesai',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
		'semester' => $this->input->post('semester',TRUE),
		'kapasitas' => $this->input->post('kapasitas',TRUE),
		'terisi' => $this->input->post('terisi',TRUE),
	    );

            $this->Jadwal_kuliah_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil disimpan
                                    </div>');
            redirect(site_url('jadwal_kuliah?id_prodi='.$this->input->post('id_prodi')));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jadwal_kuliah_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Jadwal Kuliah',
                'konten' => 'jadwal_kuliah/jadwal_kuliah_form',
                'button' => 'Ubah',
                'action' => site_url('jadwal_kuliah/update_action'),
		'id_jadwal' => set_value('id_jadwal', $row->id_jadwal),
		'id_tahun_akademik' => set_value('id_tahun_akademik', $row->id_tahun_akademik),
		'id_mk' => set_value('id_mk', $row->id_mk),
		'id_dosen' => set_value('id_dosen', $row->id_dosen),
		'kelas' => set_value('kelas', $row->kelas),
		'ruang' => set_value('ruang', $row->ruang),
		'hari' => set_value('hari', $row->hari),
		'jam_mulai' => set_value('jam_mulai', $row->jam_mulai),
		'jam_selesai' => set_value('jam_selesai', $row->jam_selesai),
		'id_prodi' => set_value('id_prodi', $row->id_prodi),
		'semester' => set_value('semester', $row->semester),
		'kapasitas' => set_value('kapasitas', $row->kapasitas),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jadwal_kuliah'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jadwal', TRUE));
        } else {
            $this->db->where('ruang', $this->input->post('ruang'));
            $this->db->where('hari', $this->input->post('hari'));
            $this->db->where('jam_mulai', $this->input->post('jam_mulai'));
            $this->db->where('id_jadwal!=', $this->input->post('id_jadwal'));
            $cek_jadwal_tabrakan = $this->db->get('jadwal_kuliah');
            if ($cek_jadwal_tabrakan->num_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> jadwal gagal di tambahkan <br>
                                            ruang : '.$this->input->post('ruang').'<br>
                                            hari : '.$this->input->post('hari').'<br>
                                            jam mulai : '.$this->input->post('jam_mulai').'<br>
                                            sudah terpakai.
                                    </div>');
                    redirect(site_url('jadwal_kuliah?id_prodi='.$this->input->post('id_prodi')));
            }

            $data = array(
		'id_tahun_akademik' => tahun_akademik_aktif('id_tahun_akademik'),
		'id_mk' => $this->input->post('id_mk',TRUE),
		'id_dosen' => $this->input->post('id_dosen',TRUE),
		'kelas' => $this->input->post('kelas',TRUE),
		'ruang' => $this->input->post('ruang',TRUE),
		'hari' => $this->input->post('hari',TRUE),
		'jam_mulai' => $this->input->post('jam_mulai',TRUE),
		'jam_selesai' => $this->input->post('jam_selesai',TRUE),
		'id_prodi' => $this->input->post('id_prodi',TRUE),
		'semester' => $this->input->post('semester',TRUE),
		'kapasitas' => $this->input->post('kapasitas',TRUE),
	    );

            $this->Jadwal_kuliah_model->update($this->input->post('id_jadwal', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil diubah
                                    </div>');
            redirect(site_url('jadwal_kuliah?id_prodi='.$this->input->post('id_prodi')));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jadwal_kuliah_model->get_by_id($id);

        if ($row) {
            $this->Jadwal_kuliah_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in alert-radius-bordered alert-shadowed">
                                        <button class="close" data-dismiss="alert">
                                            ×
                                        </button>
                                        <i class="fa-fw fa fa-info"></i>

                                        <strong>Info:</strong> Data Berhasil dihapus
                                    </div>');
            redirect(site_url('jadwal_kuliah'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jadwal_kuliah'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_mk', 'Matakuliah', 'trim|required');
	$this->form_validation->set_rules('id_dosen', 'Dosen', 'trim|required');
	$this->form_validation->set_rules('kelas', 'kelas', 'trim|required');
	$this->form_validation->set_rules('ruang', 'ruang', 'trim|required');
	$this->form_validation->set_rules('hari', 'hari', 'trim|required');
	$this->form_validation->set_rules('jam_mulai', 'jam mulai', 'trim|required');
	$this->form_validation->set_rules('jam_selesai', 'jam selesai', 'trim|required');
	$this->form_validation->set_rules('id_prodi', 'prodi', 'trim|required');
	$this->form_validation->set_rules('semester', 'semester', 'trim|required');
	$this->form_validation->set_rules('kapasitas', 'kapasitas', 'trim|required');

	$this->form_validation->set_rules('id_jadwal', 'id_jadwal', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Jadwal_kuliah.php */
/* Location: ./application/controllers/Jadwal_kuliah.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-11-11 16:51:39 */
/* https://jualkoding.com */