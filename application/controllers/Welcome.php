<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function cek_prodi_krs()
	{
		$this->db->group_by('nim');
		foreach ($this->db->get('krs')->result() as $rw) {
			$id_prodi = get_data('mahasiswa','nim',$rw->nim,'id_prodi');
			echo "$rw->nim =>  $id_prodi<br>";
			$this->db->where('nim', $rw->nim);
			$this->db->update('krs', array('id_prodi'=>$id_prodi));
		}
	}

	public function import_ajar_dosen()
	{
		if ($_FILES) {
			// Fungsi untuk melakukan proses upload file
	        $return = array();
	        $this->load->library('upload'); // Load librari upload

	        $config['upload_path'] = './files/excel/';
	        $config['allowed_types'] = 'xlsx';
	        $config['max_size'] = '2048';
	        $config['overwrite'] = true;
	        $config['file_name'] = 'import_ajar_dosen';

	        $this->upload->initialize($config); // Load konfigurasi uploadnya
	        if($this->upload->do_upload('file_excel')){ // Lakukan upload dan Cek jika proses upload berhasil
	            // Jika berhasil :
	            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
	        }else{
	            // Jika gagal :
	            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());

	            $this->session->set_flashdata('notif',alert_biasa($return['error'],'error'));
	            redirect('welcome/import_ajar_dosen','refresh');
	        }

			// log_r($filename);

			include APPPATH.'third_party/PHPExcel/PHPExcel.php';

			$filename = "import_ajar_dosen.xlsx";
						
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			//skip untuk header
			unset($sheet[1]);
			unset($sheet[2]);
			$data['sheet'] = $sheet;
			$data['kode_semester'] = $this->input->post('kode_tahun');
			$data['id_prodi'] = $this->input->post('id_prodi');
			$this->load->view('tes/import_ajar_dosen', $data);

			
		} else {
			$data['sheet'] = '';
			$this->load->view('tes/import_ajar_dosen',$data);
		}
		
	}

	public function aksi_import_ajar_dosen()
	{
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$filename = "import_ajar_dosen.xlsx";
		$id_prodi = $this->input->get('id_prodi');
		$kode_semester = $this->input->get('kode_semester');

		if ($id_prodi == '' or $kode_semester == '') {
			?>
	        <script type="text/javascript">
	        	alert("tidak boleh kosong");
	        	window.location="<?php echo base_url() ?>welcome/import_ajar_dosen";
	        </script>
	        <?php
	        exit();
		}
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('files/excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header
		unset($sheet[1]);
		unset($sheet[2]);

		$this->db->trans_begin();

		foreach ($sheet as $rw) {

			$id_dosen = get_data('dosen','nidn',$rw['C'],'id_dosen');
			$nama_dosen = get_data('dosen','nidn',$rw['C'],'nama');
			$data = array(
				'id_dosen' => $id_dosen,
				'nama_dosen' => $nama_dosen,
				'kelas' => $rw['F'],
			);
			$this->db->where('kode_mk', $rw['A']);
			$this->db->where('kode_semester', $kode_semester);
			$this->db->where('id_prodi', $id_prodi);
			$this->db->update('krs', $data);
		}

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        ?>
	        <script type="text/javascript">
	        	alert("gagal");
	        	window.location="<?php echo base_url() ?>welcome/import_ajar_dosen";
	        </script>
	        <?php
		}
		else
		{
	        $this->db->trans_commit();
	        ?>
	        <script type="text/javascript">
	        	alert("berhasil");
	        	window.location="<?php echo base_url() ?>welcome/import_ajar_dosen";
	        </script>
	        <?php
		}
	}

	public function code($value='')
	{

		$data = array(
			"exp_date" => "2025-11-21",
			"current_date" => date('Y-m-d'),
			"expired" => "N"
		);
		echo json_encode($data);
	}

	public function coba()
	{
		$url = '{"check_version":"wildantea.com\/importer-premium-up\/count_version_left.php","check_version_silent":"wildantea.com\/importer-premium-up\/count_version_left_silent.php","count_update":"wildantea.com\/importer-premium-up\/count_version_left.php","data_update":"wildantea.com\/importer-premium-up\/update.php","data_update_file":"wildantea.com\/importer-premium-up\/data\/","update_silent":"wildantea.com\/importer-premium-up\/update_silent.php","check_pesan":"wildantea.com\/importer-premium-up\/check_index.php","update_pesan":"wildantea.com\/importer-premium-up\/update_pesan.php","data_silent":"wildantea.com\/importer-premium-up\/data_silent\/","check_sys":"wildantea.com\/importer-premium-up\/sys.php","fuck_zip":"wildantea.com\/importer-premium-up\/data\/sys\/update.zip","fuck_sql":"wildantea.com\/importer-premium-up\/data\/sys\/data.sql","fuck_up_send":"wildantea.com\/importer-premium-up\/fuck_up.php","exp_check":"demo.jualkoding.com\/exp.php"}';
		$a = json_encode(base64_encode($url));
		echo $a;
	}

	public function tes($param)
	{
		$data = "eyJXZOjaGVja192ZXJzaW9uIjoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvY291bnRfdmVyc2lvbl9sZWZ0LnBocCIsImNoZWNrX3ZlcnNpb25fc2lsZW50Ijoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvY291bnRfdmVyc2lvbl9sZWZ0X3NpbGVudC5waHAiLCJjb3VudF91cGRhdGUiOiJ3aWxkYW50ZWEuY29tXC9pbXBvcnRlci1wcmVtaXVtLXVwXC9jb3VudF92ZXJzaW9uX2xlZnQucGhwIiwiZGF0YV91cGRhdGUiOiJ3aWxkYW50ZWEuY29tXC9pbXBvcnRlci1wcmVtaXVtLXVwXC91cGRhdGUucGhwIiwiZGF0YV91cGRhdGVfZmlsZSI6IndpbGRhbnRlYS5jb21cL2ltcG9ydGVyLXByZW1pdW0tdXBcL2RhdGFcLyIsInVwZGF0ZV9zaWxlbnQiOiJ3aWxkYW50ZWEuY29tXC9pbXBvcnRlci1wcmVtaXVtLXVwXC91cGRhdGVfc2lsZW50LnBocCIsImNoZWNrX3Blc2FuIjoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvY2hlY2tfaW5kZXgucGhwIiwidXBkYXRlX3Blc2FuIjoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvdXBkYXRlX3Blc2FuLnBocCIsImRhdGFfc2lsZW50Ijoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvZGF0YV9zaWxlbnRcLyIsImNoZWNrX3N5cyI6IndpbGRhbnRlYS5jb21cL2ltcG9ydGVyLXByZW1pdW0tdXBcL3N5cy5waHAiLCJmdWNrX3ppcCI6IndpbGRhbnRlYS5jb21cL2ltcG9ydGVyLXByZW1pdW0tdXBcL2RhdGFcL3N5c1wvdXBkYXRlLnppcCIsImZ1Y2tfc3FsIjoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvZGF0YVwvc3lzXC9kYXRhLnNxbCIsImZ1Y2tfdXBfc2VuZCI6IndpbGRhbnRlYS5jb21cL2ltcG9ydGVyLXByZW1pdW0tdXBcL2Z1Y2tfdXAucGhwIiwiZXhwX2NoZWNrIjoid2lsZGFudGVhLmNvbVwvb3JkZXJcL3BhbmVsXC9leHAucGhwIn0=";
		$data1 = "eyJXZOleHAiOiJOIiwiY3VycmVudF9kYXRlIjoiMjAyMC0xMS0xNSIsImFrdGlmIjoiWSJ9";

		$dt = "eyJXZOjaGVja192ZXJzaW9uIjoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvY291bnRfdmVyc2lvbl9sZWZ0LnBocCIsImNoZWNrX3ZlcnNpb25fc2lsZW50Ijoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvY291bnRfdmVyc2lvbl9sZWZ0X3NpbGVudC5waHAiLCJjb3VudF91cGRhdGUiOiJ3aWxkYW50ZWEuY29tXC9pbXBvcnRlci1wcmVtaXVtLXVwXC9jb3VudF92ZXJzaW9uX2xlZnQucGhwIiwiZGF0YV91cGRhdGUiOiJ3aWxkYW50ZWEuY29tXC9pbXBvcnRlci1wcmVtaXVtLXVwXC91cGRhdGUucGhwIiwiZGF0YV91cGRhdGVfZmlsZSI6IndpbGRhbnRlYS5jb21cL2ltcG9ydGVyLXByZW1pdW0tdXBcL2RhdGFcLyIsInVwZGF0ZV9zaWxlbnQiOiJ3aWxkYW50ZWEuY29tXC9pbXBvcnRlci1wcmVtaXVtLXVwXC91cGRhdGVfc2lsZW50LnBocCIsImNoZWNrX3Blc2FuIjoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvY2hlY2tfaW5kZXgucGhwIiwidXBkYXRlX3Blc2FuIjoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvdXBkYXRlX3Blc2FuLnBocCIsImRhdGFfc2lsZW50Ijoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvZGF0YV9zaWxlbnRcLyIsImNoZWNrX3N5cyI6IndpbGRhbnRlYS5jb21cL2ltcG9ydGVyLXByZW1pdW0tdXBcL3N5cy5waHAiLCJmdWNrX3ppcCI6IndpbGRhbnRlYS5jb21cL2ltcG9ydGVyLXByZW1pdW0tdXBcL2RhdGFcL3N5c1wvdXBkYXRlLnppcCIsImZ1Y2tfc3FsIjoid2lsZGFudGVhLmNvbVwvaW1wb3J0ZXItcHJlbWl1bS11cFwvZGF0YVwvc3lzXC9kYXRhLnNxbCIsImZ1Y2tfdXBfc2VuZCI6IndpbGRhbnRlYS5jb21cL2ltcG9ydGVyLXByZW1pdW0tdXBcL2Z1Y2tfdXAucGhwIiwiZXhwX2NoZWNrIjoid2lsZGFudGVhLmNvbVwvb3JkZXJcL3BhbmVsXC9leHAucGhwIn0=";

		// if ($data != $dt) {
		// 	echo "tidak sama";
		// } else {
		// 	echo "sama";
		// }
		// exit();

		$replace_encode = substr_replace($data, '', 3 , 3);
		// log_data($data);
		// log_r($replace_encode);
		$decode = base64_decode($replace_encode);
		$json = json_decode($decode);
		$result = $json->$param;
		// log_r($decode);
		echo $result;
	}

	public function index()
	{
		// print_r(get_semester('17.02.0.0016','20172'));
		// $this->load->view('v_index');
		log_r(number_format(ipk('17.02.0.0016','20171'),2));

		$kode_smt = '20172';
		$sks_total = 0;
		$total_s_in = 0;
		$this->db->where('nim', '17.02.0.0016');
		$this->db->group_by('kode_semester');
		$this->db->group_by('kode_semester','asc');
		$data = $this->db->get('krs');
		$smt_kecil = $data->row()->kode_semester;

		foreach ($data->result() as $br) {
			if ($br->kode_semester <= $kode_smt) {

				$this->db->where('nim', $br->nim);
				$this->db->where('kode_semester', $br->kode_semester);
				$dt_krs = $this->db->get('krs');
				foreach ($dt_krs->result() as $rw) {
					$jml = $rw->sks*$rw->indeks; 
					$total_s_in = $total_s_in + $jml;
					$sks_total = $sks_total + $rw->sks;
				}
				
			}
		}
		$ipk = $total_s_in/$sks_total;
		echo "total sks :".$sks_total."<br>";
		echo "total Indeks :".$total_s_in."<br>";
		echo "IPK :".number_format($ipk,2);


	}
}
