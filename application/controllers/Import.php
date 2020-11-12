<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

	
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






}
