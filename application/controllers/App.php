<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->rbac->check_module_access();
	}

	public function index()
	{
		if ($this->session->userdata('level') == '') {
			redirect('login','refresh');
		}
		$data = array(
			'konten' => 'home',
			'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index',$data);
	}

	public function setting()
	{
		// $this->rbac->check_operation_access();

		if ($_POST) {
			$img = upload_gambar_biasa('logo', 'image/', 'jpg|png|jpeg', 10000, 'logo');
			$data = array(
				'nama_kampus' => $this->input->post('nama_kampus'),
				'alamat' => $this->input->post('alamat'),
				'kop' => $this->input->post('kop'),
				'logo' => $retVal = ($_FILES['logo']['name'] == '') ? $_POST['logo_old'] : $img,
			);

			$this->db->where('id_setting', 1);
			$update = $this->db->update('setting', $data);

			if ($update) {
				$this->session->set_flashdata('notif', alert_biasa('data berhasil diupdate','success'));
				redirect('app/setting','refresh');
			}
		} else {
			$data = array(
				'konten' => 'setting/update',
				'judul_page' => 'Setting Aplikasi',
				'data' => $this->db->get('setting'),
			);
			$this->load->view('v_index',$data);
		}
	}

	public function get_master_menu()
	{
		$id_menu = $this->input->post('id_menu');
		$rw = $this->db->get_where('master_menu', array('id_menu'=>$id_menu))->row();
		echo json_encode($rw);
	}

	public function simpan_menu_level()
	{
		$data = $this->input->post('data');
		$data_dihapus = $this->input->post('data_dihapus');
		$id_level = $this->input->post('id_level');
		$dt = json_decode($data);
		$dt_hapus = json_decode($data_dihapus);

		// log_r($_POST);
		$this->db->trans_begin();

		$this->db->where('level', $id_level);
		$this->db->delete('master_menu_level');

		$this->db->where('level', $id_level);
		$this->db->delete('module_access');

		

		foreach ($dt as $key => $value) {
			$id_parent = $dt[$key]->id;
			$nama_parent = $dt[$key]->nama;

			$this->db->where('nama_menu', $nama_parent);
			$mn = $this->db->get('master_menu')->row();

			$id_pr = 0;
			$this->db->where('nama_menu', $nama_parent);
			$this->db->where('level', $id_level);
			$cek_pr = $this->db->get('master_menu_level');

			if ($cek_pr->num_rows() > 0) {
				
				$this->db->where('nama_menu', $nama_parent);
				$this->db->where('level', $id_level);
				$this->db->update('master_menu_level', array('urutan'=>$key+1));

			} else {

				$this->db->insert('master_menu_level', array(
					'nama_menu' =>$mn->nama_menu,
					'icon'=>$mn->icon,
					'link'=>$mn->link,
					'status'=>$mn->status,
					'urutan'=>$key+1,
					'level'=>$id_level,
					'aktif'=>'y',
				));
				$id_pr = $this->db->insert_id();

				if ($mn->link !='#') {
					if ( strpos($mn->link, '/') ) {
						$link = explode('/', $mn->link);
						$module = $link[0];
						$operation = $link[1];
					} else {
						$module = $mn->link;
						$operation = 'index';
					}
					

					$this->db->insert('module_access', array(
						'level' => $id_level,
						'module' => $module,
						'operation' => $operation,
					));
				}

			}

			

			if (isset($dt[$key]->children)) {
				$chil = $dt[$key]->children;
				foreach ($chil as $key2 => $value) {
					$id_child = $chil[$key2]->id;
					$nama_child = $chil[$key2]->nama;

					$this->db->where('nama_menu', $nama_child);
					$submn = $this->db->get('master_menu')->row();

					$this->db->where('nama_menu', $nama_child);
					$this->db->where('level', $id_level);
					$cek_child = $this->db->get('master_menu_level');

					if ($cek_child->num_rows() > 0) {
						
						$this->db->where('nama_menu', $nama_child);
						$this->db->where('level', $id_level);
						$this->db->update('master_menu_level', array('urutan'=>$key2+1));

					} else {

						$this->db->insert('master_menu_level', array(
							'nama_menu' =>$submn->nama_menu,
							'icon'=>$submn->icon,
							'link'=>$submn->link,
							'status'=>$submn->status,
							'parent'=>$id_pr,
							'urutan'=>$key2+1,
							'level'=>$id_level,
							'aktif'=>'y',
						));

						if ($submn->link !='#') {
							if ( strpos($submn->link, '/') ) {
								$link = explode('/', $submn->link);
								$module = $link[0];
								$operation = $link[1];
							} else {
								$module = $submn->link;
								$operation = 'index';
							}

							$this->db->insert('module_access', array(
								'level' => $id_level,
								'module' => $module,
								'operation' => $operation,
							));
						}

					}

				}
			}


			

		}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        echo "gagal server";
		}
		else
		{
		        $this->db->trans_commit();
		        echo "menu berhasil disimpan";
		}
		
		
	}

	public function set_aktif_submenu()
	{
		$id = $this->input->post('id');
		$this->session->set_userdata(array('submn_parent'=>$id));
		echo "1";
	}

	public function set_clear_submenu()
	{
		$this->session->unset_userdata('submn_parent');
	}

	public function filter_kurikulum_prodi($id_prodi)
	{
		if ($this->session->userdata('level') == '') {
			redirect('login','refresh');
		}
		?>
		<select name="id_kurikulum" id="id_kurikulum" style="width:100%;">
                <option value="">--Pilih Kurikulum --</option>
		<?php

			$this->db->where('id_prodi', $id_prodi);
			foreach ($this->db->get('kurikulum')->result() as $rw) {
			?>
			
                <option value="<?php echo $rw->id_kurikulum ?>"><?php echo '['.$rw->mulai_berlaku.'] '.$rw->kurikulum ?></option>

            <?php } ?>
                
        </select>    
		<?php

	}

	public function get_select_semester($id_prodi)
	{
		$this->db->where('id_prodi', $id_prodi);
		$tot_semester  = $this->db->get('prodi')->row()->jumlah_semester;

		?>
		<select name="semester" id="semester" style="width:100%;">
			<option value="">--Pilih Semester --</option>
			<?php 
            for ($i=1; $i <= $tot_semester ; $i++) { 
             ?>
             <option value="<?php echo $i ?>"><?php echo $i ?></option>
           	<?php } ?>
		</select>


		<?php 
	}

	public function aktifkan_thn_akademik($id_tahun_akademik)
	{
		$this->db->query("UPDATE tahun_akademik SET aktif='t'");
		$this->db->where('id_tahun_akademik', $id_tahun_akademik);
		$this->db->update('tahun_akademik', array('aktif'=>'y'));
		redirect('tahun_akademik','refresh');
	}

	public function set_online_user($status)
	{
		$this->db->where('id_user', $this->session->userdata('id_user'));
		$this->db->update('users', array('online'=>$status));
	}

	public function reset_password($id_user)
	{
		$password = password_hash('123456', PASSWORD_DEFAULT);
		$this->db->where('id_user', $id_user);
		$this->db->update('users', array('password'=>$password));
		$this->session->set_flashdata('notif', alert_biasa('Password berhasil direset','success'));
		redirect('users','refresh');
	}

	public function clear_tabel()
	{
		$this->db->trans_begin();

		$this->db->truncate('registrasi');
		$this->db->truncate('dosen');
		$this->db->truncate('jadwal_kuliah');
		$this->db->truncate('kelas');
		$this->db->truncate('khs');
		$this->db->truncate('kurikulum');
		$this->db->truncate('mahasiswa');
		$this->db->truncate('matakuliah');
		$this->db->truncate('master_matakuliah');
		$this->db->truncate('prodi');
		$this->db->truncate('ruang');
		$this->db->truncate('skala_nilai');
		$this->db->truncate('absen');
		$this->db->truncate('absen_detail');
		$this->db->truncate('tahun_akademik');
		$this->db->truncate('tahun_angkatan');

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        $this->session->set_flashdata('notif', alert_biasa('gagal server,silahkan ulangi','error'));
			redirect('app/setting','refresh');
		}
		else
		{
	        $this->db->trans_commit();
	        $this->session->set_flashdata('notif', alert_biasa('data tabel berhasil direset','success'));
			redirect('app/setting','refresh');
		}
	}

	public function set_kurikulum_from_mk()
	{
		$id_prodi = $this->input->get('id_prodi');
		$id_kurikulum = $this->input->get('id_kurikulum');
		$jenis = $this->input->get('jenis');

		if ($id_prodi == '' or $id_kurikulum == '' or $jenis == '') {
			$this->session->set_flashdata('notif', alert_biasa('silahkan pilih prodi dan kurikulum terlebih dahulu','error'));
			redirect('matakuliah','refresh');
		}

		if ($jenis == 'ganjil') {
			$cek_mk = $this->db->query("SELECT * from master_matakuliah where id_prodi='$id_prodi' and semester%2=1");
		} elseif ($jenis == 'genap') {
			$cek_mk = $this->db->query("SELECT * from master_matakuliah where id_prodi='$id_prodi' and semester%2=0");
		}

		if ($cek_mk->num_rows() > 0) {
			$this->db->trans_begin();

			foreach ($cek_mk->result() as $rw) {

				$this->db->where('kode_mk', $rw->kode_mk);
				$this->db->where('nama_mk', $rw->nama_mk);
				$this->db->where('id_prodi', $id_prodi);
				$this->db->where('id_kurikulum', $id_kurikulum);
				$cek_mk_kr = $this->db->get('matakuliah');
				if ($cek_mk_kr->num_rows() > 0) {
					// abaikan
				} else {
					$data = array(
						'kode_mk' => $rw->kode_mk,
						'nama_mk' => $rw->nama_mk,
						'jenis_mk' => $rw->jenis_mk,
						'sks_tm' => $rw->sks_tm,
						'sks_prak' => $rw->sks_prak,
						'sks_prak_la' => $rw->sks_prak_la,
						'sks_simulasi' => $rw->sks_simulasi,
						'sks_total' => $rw->sks_tm + $rw->sks_prak + $rw->sks_prak_la + $rw->sks_simulasi,
						'metode_pembelajaran' => $rw->metode_pembelajaran,
						'tgl_mulai_efektif' => $rw->tgl_mulai_efektif,
						'tgl_akhir_efektif' => $rw->tgl_akhir_efektif,
						'semester' => $rw->semester,
						'id_prodi' => $id_prodi,
						'id_kurikulum' => $id_kurikulum,
						
					);
					$this->db->insert('matakuliah', $data);
				}
				
			}

			if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
		        $this->session->set_flashdata('notif', alert_biasa('gagal server,silahkan ulangi','error'));
				redirect('matakuliah?id_prodi='.$id_prodi.'&id_kurikulum='.$id_kurikulum,'refresh');
			}
			else
			{
		        $this->db->trans_commit();
		        $this->session->set_flashdata('notif', alert_biasa('data matakuliah kurikulum berhasil ditambahkan','success'));
				redirect('matakuliah?id_prodi='.$id_prodi.'&id_kurikulum='.$id_kurikulum,'refresh');
			}
		}

	}


	public function set_jadwal_from_kr()
	{
		$id_prodi = $this->input->get('id_prodi');

		if ($id_prodi == '') {
			$this->session->set_flashdata('notif', alert_biasa('silahkan pilih prodi terlebih dahulu','error'));
			redirect('jadwal_kuliah','refresh');
		}

		$this->db->where('mulai_berlaku', tahun_akademik_aktif('kode_tahun'));
		$cek_id_kurikulum = $this->db->get('kurikulum');
		if ($cek_id_kurikulum->num_rows() == 0) {
			$this->session->set_flashdata('notif', alert_biasa('tidak ada kurikulum di semester '.tahun_akademik_aktif('kode_tahun').' ini','error'));
			redirect('jadwal_kuliah?id_prodi='.$id_prodi,'refresh');
		}

		$id_kurikulum = $cek_id_kurikulum->row()->id_kurikulum;
		$id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');

		if (jenis_semester_aktif() == 'ganjil') {
			$cek_mk = $this->db->query("SELECT * from matakuliah where id_prodi='$id_prodi' and id_kurikulum='$id_kurikulum' and semester%2=1");
		} elseif (jenis_semester_aktif() == 'genap') {
			$cek_mk = $this->db->query("SELECT * from matakuliah where id_prodi='$id_prodi' and id_kurikulum='$id_kurikulum' and semester%2=0");
		}

		if ($cek_mk->num_rows() > 0) {
			$this->db->trans_begin();

			foreach ($cek_mk->result() as $rw) {

				$this->db->where('id_mk', $rw->id_mk);
				$this->db->where('id_tahun_akademik', $id_tahun_akademik);
				$this->db->where('id_prodi', $id_prodi);
				$this->db->where('semester', $rw->semester);
				$cek_mk_kr = $this->db->get('jadwal_kuliah');
				if ($cek_mk_kr->num_rows() > 0) {
					// abaikan
				} else {
					$data = array(
						'id_tahun_akademik' => $id_tahun_akademik,
						'id_mk' => $rw->id_mk,
						'semester' => $rw->semester,
						'id_prodi' => $id_prodi,
						
					);
					$this->db->insert('jadwal_kuliah', $data);
				}
				
			}

			if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
		        $this->session->set_flashdata('notif', alert_biasa('gagal server,silahkan ulangi','error'));
				redirect('jadwal_kuliah?id_prodi='.$id_prodi,'refresh');
			}
			else
			{
		        $this->db->trans_commit();
		        $this->session->set_flashdata('notif', alert_biasa('data jadwal_kuliah berhasil ditambahkan','success'));
				redirect('jadwal_kuliah?id_prodi='.$id_prodi,'refresh');
			}
		}
	}

	public function get_jam_selesai_kuliah($jam_mulai,$waktu_kuliah)
    {
        $minutes_to_add = $waktu_kuliah * 40;

        $time = new DateTime('2011-11-17 '.$jam_mulai);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

        $stamp = $time->format('H:i');

        echo $stamp;

    }

    public function get_sks_mk($id_mk)
    {
    	$sks = get_data('matakuliah','id_mk',$id_mk,'sks_tm');
    	$semester = get_data('matakuliah','id_mk',$id_mk,'semester');
    	echo json_encode(array('sks'=>$sks,'semester'=>$semester));
    }

    public function get_kapasitas_ruang()
    {
    	$ruang = $this->input->get('ruang');
    	$kapasitas = get_data('ruang','ruang',$ruang,'kapasitas');
    	echo $kapasitas;
    }

    public function akses_absen_ujian($jns,$n)
    {
    	if ($jns == 'uts') {
    		$this->db->where('id_setting', '1');
    		$this->db->update('setting', array('absen_uts'=>$n));
    	} else {
    		$this->db->where('id_setting', '1');
    		$this->db->update('setting', array('absen_uas'=>$n));
    	}
    	$this->session->set_flashdata('notif', alert_biasa('Akses Ujian berhasil','success'));
    	redirect('app/setting','refresh');
    }

    public function get_list_nim($id_prodi)
    {
    	?>
		<select name="nim" id="nim" style="width:100%;">
                <option value="">--Pilih Nim --</option>
		<?php
			$this->db->select('a.nim,a.nama');
			$this->db->from('mahasiswa a');
			$this->db->join('tahun_angkatan b', 'a.id_tahun_angkatan = b.id_tahun_angkatan', 'inner');
			$this->db->where('a.id_prodi', $id_prodi);
			$this->db->order_by('b.tahun_angkatan', 'asc');
			foreach ($this->db->get()->result() as $rw) {
			?>
			
                <option value="<?php echo $rw->nim ?>"><?php echo '['.$rw->nim.'] '.$rw->nama ?></option>

            <?php } ?>
                
        </select>    
		<?php
    }







}
