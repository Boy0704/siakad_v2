<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('level') != '1') {
			redirect('login','refresh');
		}
	}

	public function tes()
	{
		$kode_tahun= tahun_akademik_aktif('kode_tahun');
        $id_tahun_akademik= tahun_akademik_aktif('id_tahun_akademik');

		$this->db->select('a.nim,a.id_kelas');
        $this->db->from('mahasiswa a');
        $this->db->join('registrasi b', 'a.nim = b.nim', 'inner');
        $this->db->where('b.id_tahun_akademik', $id_tahun_akademik);
        $this->db->where('b.kode_semester', $kode_tahun);
        $getdatamhs = $this->db->get();
        foreach ($getdatamhs->result() as $mhs) {
        	$semester = get_semester($mhs->nim);
        	$this->db->trans_begin();
        	$this->db->where('nim', $mhs->nim);
        	$this->db->where('id_tahun_akademik', $id_tahun_akademik);
        	$this->db->where('kode_semester', $kode_tahun);
        	$this->db->update('registrasi', array('semester'=>$semester));
        	$this->db->where('nim', $mhs->nim);
        	$this->db->update('mahasiswa', array('semester_aktif'=>$semester));
        	if ($this->db->trans_status() === FALSE)
			{
		        $this->db->trans_rollback();
		        log_data("gagal $mhs->nim");
			}
			else
			{
		        $this->db->trans_commit();
		        log_data("berhasil $mhs->nim");
			}
        }
	}

	public function update_mulai_semester()
	{
		log_r("no aktif fitur !!!");
		$no = 1;
		foreach ($this->db->get('mahasiswa')->result() as $rw) {
			$ang = substr($rw->nim, 0,2);
			$this->db->where('kode_tahun', '20'.$ang.'1');
			$kode_tahun = $this->db->get('tahun_akademik')->row()->kode_tahun;
			
			$this->db->where('nim', $rw->nim);
			$this->db->update('mahasiswa', array('mulai_semester'=>$kode_tahun));
			$berhasil = $no.') '.$rw->nim.' - '.$kode_tahun;
			log_data($berhasil);
			$no++;
		}
	}

	public function import_kelas()
	{
		if ($_FILES) {
			$return = array();
	        $this->load->library('upload'); // Load librari upload

	        $config['upload_path'] = './files/excel/';
	        $config['allowed_types'] = 'xlsx';
	        $config['max_size'] = '2048';
	        $config['overwrite'] = true;
	        $config['file_name'] = 'import_kelas_mhs';

	        $this->upload->initialize($config); // Load konfigurasi uploadnya
	        if($this->upload->do_upload('file_excel')){ // Lakukan upload dan Cek jika proses upload berhasil
	            // Jika berhasil :
	            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
	        }else{
	            // Jika gagal :
	            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());

	            $this->session->set_flashdata('notif',alert_biasa($return['error'],'error'));
	            redirect('import/import_kelas','refresh');
	        }

			// log_r($filename);

			include APPPATH.'third_party/PHPExcel/PHPExcel.php';

			$filename = "import_kelas_mhs.xlsx";
						
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			//skip untuk header
			unset($sheet[1]);
			unset($sheet[2]);
			$data['sheet'] = $sheet;
			$this->load->view('tes/import_kelas_mhs', $data);
		} else {
			$this->load->view('tes/import_kelas_mhs');
		}
	}

	public function aksi_import_kelas_mhs()
	{
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$filename = "import_kelas_mhs.xlsx";
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header
		unset($sheet[1]);

		$this->db->trans_begin();

		foreach ($sheet as $rw) {
			$cek_nim = get_data('mahasiswa','nim',$rw['A'],'nim');
			$id_kelas = get_data('kelas','kelas',$rw['B'],'id_kelas');
			if ($cek_nim != '') {
				$this->db->where('nim', $rw['A']);
				$this->db->update('mahasiswa', array('id_kelas'=>$id_kelas));
			} else {

			}
			
		}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        $this->session->set_flashdata('notif', alert_biasa('gagal server,silahkan ulangi','error'));
			redirect('import/import_kelas','refresh');
		}
		else
		{
	        $this->db->trans_commit();
	        $this->session->set_flashdata('notif', alert_biasa('data kelas mahasiswa berhasil diimport','success'));
			redirect('import/import_kelas','refresh');
		}
	}
	
	public function import_mk_kurikulum()
	{
		$id_prodi = $this->input->get('id_prodi');
		$id_kurikulum = $this->input->get('id_kurikulum');
		if ($id_prodi == '' or $id_kurikulum =='') {
			$this->session->set_flashdata('notif', alert_biasa('silahkan pilih prodi dan kurikulum terlebih dahulu','error'));
			redirect('matakuliah','refresh');
		}

		// Fungsi untuk melakukan proses upload file
        $return = array();
        $this->load->library('upload'); // Load librari upload

        $config['upload_path'] = './files/excel/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '2048';
        $config['overwrite'] = true;
        $config['file_name'] = 'import_mk';

        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file_excel')){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());

            $this->session->set_flashdata('notif',alert_biasa($return['error'],'error'));
            redirect('matakuliah?id_prodi='.$id_prodi.'&id_kurikulum='.$id_kurikulum,'refresh');
        }

		// log_r($filename);

		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$filename = "import_mk.xlsx";
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header
		unset($sheet[1]);

		$this->db->trans_begin();

		foreach ($sheet as $rw) {
			$data = array(
				'kode_mk' => $rw['A'],
				'nama_mk' => $rw['B'],
				'jenis_mk' => $rw['C'],
				'sks_tm' => $rw['D'],
				'sks_prak' => $rw['E'],
				'sks_prak_la' => $rw['F'],
				'sks_simulasi' => $rw['G'],
				'sks_total' => $rw['D'] + $rw['E'] + $rw['F'] + $rw['G'],
				'metode_pembelajaran' => $rw['H'],
				'tgl_mulai_efektif' => $rw['I'],
				'tgl_akhir_efektif' => $rw['J'],
				'semester' => $rw['K'],
				'id_prodi' => $id_prodi,
				'id_kurikulum' => $id_kurikulum,
				
			);
			$this->db->insert('matakuliah', $data);
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
	        $this->session->set_flashdata('notif', alert_biasa('data matakuliah berhasil diimport','success'));
			redirect('matakuliah?id_prodi='.$id_prodi.'&id_kurikulum='.$id_kurikulum,'refresh');
		}

	}


	public function import_mk()
	{
		$id_prodi = $this->input->get('id_prodi');
		if ($id_prodi == '' ) {
			$this->session->set_flashdata('notif', alert_biasa('silahkan pilih prodi terlebih dahulu','error'));
			redirect('master_matakuliah','refresh');
		}

		// Fungsi untuk melakukan proses upload file
        $return = array();
        $this->load->library('upload'); // Load librari upload

        $config['upload_path'] = './files/excel/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '2048';
        $config['overwrite'] = true;
        $config['file_name'] = 'import_mk';

        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file_excel')){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());

            $this->session->set_flashdata('notif',alert_biasa($return['error'],'error'));
            redirect('matakuliah','refresh');
        }

		// log_r($filename);

		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$filename = "import_mk.xlsx";
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header
		unset($sheet[1]);

		$this->db->trans_begin();

		foreach ($sheet as $rw) {
			$data = array(
				'kode_mk' => $rw['A'],
				'nama_mk' => $rw['B'],
				'jenis_mk' => $rw['C'],
				'sks_tm' => $rw['D'],
				'sks_prak' => $rw['E'],
				'sks_prak_la' => $rw['F'],
				'sks_simulasi' => $rw['G'],
				'sks_total' => $rw['D'] + $rw['E'] + $rw['F'] + $rw['G'],
				'metode_pembelajaran' => $rw['H'],
				'tgl_mulai_efektif' => $rw['I'],
				'tgl_akhir_efektif' => $rw['J'],
				'semester' => $rw['K'],
				'id_prodi' => $id_prodi,
				
			);
			$this->db->insert('master_matakuliah', $data);
		}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        $this->session->set_flashdata('notif', alert_biasa('gagal server,silahkan ulangi','error'));
			redirect('master_matakuliah?id_prodi='.$id_prodi,'refresh');
		}
		else
		{
	        $this->db->trans_commit();
	        $this->session->set_flashdata('notif', alert_biasa('data matakuliah berhasil diimport','success'));
			redirect('master_matakuliah?id_prodi='.$id_prodi,'refresh');
		}

	}


	public function import_dosen()
	{
		$id_prodi = $this->input->post('id_prodi');
		if ($id_prodi == '' ) {
			$this->session->set_flashdata('notif', alert_biasa('silahkan pilih prodi terlebih dahulu','error'));
			redirect('dosen','refresh');
		}

		// Fungsi untuk melakukan proses upload file
        $return = array();
        $this->load->library('upload'); // Load librari upload

        $config['upload_path'] = './files/excel/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '2048';
        $config['overwrite'] = true;
        $config['file_name'] = 'import_dosen';

        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file_excel')){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());

            $this->session->set_flashdata('notif',alert_biasa($return['error'],'error'));
            redirect('dosen','refresh');
        }

		// log_r($filename);

		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$filename = "import_dosen.xlsx";
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header

		unset($sheet[1]);

		$this->db->trans_begin();

		foreach ($sheet as $rw) {
			$data = array(
				'nidn' => trim($rw['A']),
				'nip' => trim($rw['B']),
				'no_pegawai' => trim($rw['C']),
				'nama' => $rw['D'],
				'jenis_kelamin' => $rw['E'],
				'tempat_lahir' => $rw['F'],
				'tanggal_lahir' => $rw['G'],
				'id_prodi' => $id_prodi,
				
			);
			$this->db->insert('dosen', $data);
			$this->db->insert('users', array(
                'nama' => $rw['D'],
                'username' => $retVal = (trim($rw['A']) != '') ? trim($rw['A']) : trim($rw['C']),
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'level' => '4',
                'keterangan' => $this->db->insert_id(),
                'id_prodi' => $id_prodi,
            ));
		}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        $this->session->set_flashdata('notif', alert_biasa('gagal server,silahkan ulangi','error'));
			redirect('dosen?id_prodi='.$id_prodi,'refresh');
		}
		else
		{
	        $this->db->trans_commit();
	        $this->session->set_flashdata('notif', alert_biasa('data dosen berhasil diimport','success'));
			redirect('dosen?id_prodi='.$id_prodi,'refresh');
		}

	}

	public function import_mahasiswa()
	{
		// log_r($_FILES);
		$id_prodi = $this->input->post('id_prodi');
		if ($id_prodi == '' ) {
			$this->session->set_flashdata('notif', alert_biasa('silahkan pilih prodi terlebih dahulu','error'));
			redirect('mahasiswa','refresh');
		}

		// Fungsi untuk melakukan proses upload file
        $return = array();
        $this->load->library('upload'); // Load librari upload

        $config['upload_path'] = './files/excel/';
        $config['allowed_types'] = 'xlsx|';
        $config['max_size'] = '2048';
        $config['overwrite'] = true;
        $config['file_name'] = 'import_mahasiswa';

        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file_excel')){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());

            $this->session->set_flashdata('notif',alert_biasa($return['error'],'error'));
            redirect('mahasiswa?id_prodi='.$id_prodi,'refresh');
        }

		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$filename = "import_mahasiswa.xlsx";
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header

		unset($sheet[1]);

		$this->db->trans_begin();

		foreach ($sheet as $rw) {
			$kd_akt = substr($rw['A'], 0,2);
			$tahun_akt = '20'.$kd_akt;
			$data = array(
				'nim' => $rw['A'],
				'nama' => $rw['B'],
				'tempat_lahir' => $rw['C'],
				'tanggal_lahir' => $rw['D'],
				'jenis_kelamin' => $rw['E'],
				'nik' => $rw['F'],
				'agama' => $rw['G'],
				'nisn' => $rw['H'],
				'jalur_pendaftaran' => $rw['I'],
				'npwp' => $rw['J'],
				'kewarganegaraan' => $rw['K'],
				'jenis_pendaftaran' => $rw['L'],
				'tanggal_masuk_kuliah' => $rw['M'],
				'mulai_semester' => $rw['N'],
				'jalan' => $rw['O'],
				'rt' => $rw['P'],
				'rw' => $rw['Q'],
				'dusun' => $rw['R'],
				'kelurahan' => $rw['S'],
				'kecamatan' => $rw['T'],
				'kode_pos' => $rw['U'],
				'jenis_tinggal' => $rw['V'],
				'alat_transportasi' => $rw['W'],
				'telp_rumah' => $rw['X'],
				'no_hp' => $rw['Y'],
				'email' => $rw['Z'],
				'terima_kps' => $rw['AA'],
				'no_kps' => $rw['AB'],
				'nik_ayah' => $rw['AC'],
				'nama_ayah' => $rw['AD'],
				'tanggal_lahir_ayah' => $rw['AE'],
				'pendidikan_ayah' => $rw['AF'],
				'pekerjaan_ayah' => $rw['AG'],
				'penghasilan_ayah' => $rw['AH'],
				'nik_ibu' => $rw['AI'],
				'nama_ibu' => $rw['AJ'],
				'tanggal_lahir_ibu' => $rw['AK'],
				'pendidikan_ibu' => $rw['AL'],
				'pekerjaan_ibu' => $rw['AM'],
				'penghasilan_ibu' => $rw['AN'],
				'nama_wali' => $rw['AO'],
				'tanggal_lahir_wali' => $rw['AP'],
				'pendidikan_wali' => $rw['AQ'],
				'pekerjaan_wali' => $rw['AR'],
				'penghasilan_wali' => $rw['AS'],
				'id_prodi' => $id_prodi,
				'id_tahun_angkatan'=>get_data('tahun_angkatan','tahun_angkatan',$tahun_akt,'id_tahun_angkatan'),
				'jenis_pembiayaan'=> $rw['AU']
			);
			$this->db->insert('mahasiswa', $data);
			$this->db->insert('users', array(
                'nama' => $rw['B'],
                'username' => $rw['A'],
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'level' => '5',
                'keterangan' => $this->db->insert_id(),
                'id_prodi' => $id_prodi,
            ));
		}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        $this->session->set_flashdata('notif', alert_biasa('gagal server,silahkan ulangi','error'));
			redirect('mahasiswa?id_prodi='.$id_prodi,'refresh');
		}
		else
		{
	        $this->db->trans_commit();
	        $this->session->set_flashdata('notif', alert_biasa('data mahasiswa berhasil diimport','success'));
			redirect('mahasiswa?id_prodi='.$id_prodi,'refresh');
		}
	}

	public function import_krs($aksi='')
	{
		if ($aksi != 'yaya7778') {
			echo "salah perintah";
			exit();
		}
		
		$kode_semester = '20201';
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$filename = "import_krs_".$kode_semester."_ti.xlsx";
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header

		unset($sheet[1]);

		$this->db->trans_begin();

		foreach ($sheet as $rw) {
			$data = array(
				'nim' => $rw['A'],
				'kode_mk' => $rw['D'],
				'nama_mk' => $rw['E'],
				'kode_semester' => $kode_semester,
				'id_dosen' => get_data('dosen','nidn',$rw['F'],'id_dosen'),
				'nama_dosen' => $rw['G'],
				'kelas' => $rw['H'],
				'sks' => $rw['I'],
				'angka' => $rw['J'],
				'huruf' => $rw['K'],
				'indeks' => $rw['L'],
				'konfirmasi_pa' => 'y',
				'konfirmasi_nilai' => 'y',
				
			);
			// log_r($data);
			$this->db->insert('krs', $data);
			$id_krs = $this->db->insert_id();
			$this->db->insert('absen', array(
				'nim' => $rw['A'],
				'id_krs' => $id_krs,
			));
		}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        echo "gagal server";
		}
		else
		{
	        $this->db->trans_commit();
	        echo "krs berhasil disimpan $kode_semester ti";
		}

	}

	public function import_khs()
	{
		ini_set('memory_limit', '-1');
		if ($_FILES) {
			$return = array();
	        $this->load->library('upload'); // Load librari upload

	        $config['upload_path'] = './files/excel/';
	        $config['allowed_types'] = 'xlsx';
	        $config['max_size'] = '2048';
	        $config['overwrite'] = true;
	        $config['file_name'] = 'import_khs';

	        $this->upload->initialize($config); // Load konfigurasi uploadnya
	        if($this->upload->do_upload('file_excel')){ // Lakukan upload dan Cek jika proses upload berhasil
	            // Jika berhasil :
	            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
	        }else{
	            // Jika gagal :
	            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());

	            $this->session->set_flashdata('notif',alert_biasa($return['error'],'error'));
	            redirect('import/import_khs','refresh');
	        }

			// log_r($filename);

			include APPPATH.'third_party/PHPExcel/PHPExcel.php';

			$filename = "import_khs.xlsx";
						
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			//skip untuk header
			unset($sheet[1]);
			$data['sheet'] = $sheet;
			$this->load->view('tes/import_khs', $data);
		} else {
			$this->load->view('tes/import_khs');
		}
	}

	public function aksi_import_khs()
	{
		ini_set('memory_limit', '-1');
		$id_prodi = $this->input->get('id_prodi');
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$filename = "import_khs.xlsx";
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header
		unset($sheet[1]);

		$this->db->trans_begin();

		foreach ($sheet as $rw) {

			if ($rw['A'] != '' or !empty($rw['A'])) {
				$data = array(
					'nim' => $rw['A'],
					'kode_mk' => $rw['D'],
					'nama_mk' => $rw['E'],
					'kode_semester' => $rw['M'],
					'id_dosen' => $rw['F'] == '' ? '' : get_data('dosen','nidn',$rw['F'],'id_dosen'),
					'nama_dosen' => $rw['G'],
					'kelas' => $rw['H'],
					'sks' => $rw['I'],
					'angka' => $rw['J'],
					'huruf' => $rw['K'],
					'indeks' => str_replace(':', '.', $rw['L']),
					'id_prodi' => $id_prodi,
					'konfirmasi_pa' => 'y',
					'konfirmasi_nilai' => 'y',
					
				);
				$this->db->insert('krs', $data);
			}
			
		}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        $this->session->set_flashdata('notif', alert_biasa('gagal server,silahkan ulangi','error'));
			redirect('import/import_khs','refresh');
		}
		else
		{
	        $this->db->trans_commit();
	        $this->session->set_flashdata('notif', alert_biasa('data khs mahasiswa berhasil diimport','success'));
			redirect('import/import_khs','refresh');
		}
	}






}
