<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_feeder extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('feeder_helper');

		include APPPATH.'third_party/nusoap/nusoap.php';
		include APPPATH.'third_party/nusoap/class.wsdlcache.php';
	}

	public function index()
	{
		if ($_POST) {
			$this->db->where('id_config', 1);
			$this->db->update('feeder_config', $_POST);
			$this->session->set_flashdata('notif', alert_biasa('Setting koneksi berhasil disimpan','success'));
                redirect('api_feeder','refresh');
		} else {
			$data = array(
				'konten' => 'feeder/view',
				'judul_page' => 'Sync Feeder Dikti',
			);
			$this->load->view('v_index',$data);
		}
		
	}

	public function tes_konek()
	{
		$client = new nusoap_client(config_feeder('url').'/ws/live.php?wsdl', true);
		$proxy = $client->getProxy();
		$username = config_feeder('username');
		$gettoken = token();

		if (strstr($gettoken, 'ERROR:')) {
			$this->session->set_flashdata('message', alert_feeder($gettoken,'danger'));
				redirect('api_feeder','refresh');
		} else {
			$sp=$proxy->GetRecord($gettoken,'satuan_pendidikan',"npsn='$username'");
			$sp = json_decode(json_encode($sp['result']));
			$id_sp = $sp->id_sp;
			$sms = $proxy->GetRecordSet($gettoken,'sms',"id_sp='$id_sp'",'',10,0);
			$get_mk = $proxy->GetRecordSet($gettoken,'mata_kuliah',"id_sp='$id_sp'",'',0,0);
			$get_kuri = $proxy->GetRecordSet($gettoken,'kurikulum','','',0,0);

			$prodi = json_decode(json_encode($sms['result']));
			$mk = json_decode(json_encode($get_mk['result']));
			$kurikulum = json_decode(json_encode($get_kuri['result']));

			$this->db->query("DELETE FROM feeder_sms");

			foreach ($prodi as $rw) {
				$this->db->insert('feeder_sms', array(
					'id_sms' => $rw->id_sms,
					'nm_lemb' => $rw->nm_lemb,
					'kode_prodi' => $rw->id_jur,
					'id_sp' => $rw->id_sp,
					'id_jenj_didik' => $rw->id_jenj_didik,
				));
			}

			$this->db->query("DELETE FROM feeder_mk");
			foreach ($mk as $rw) {
				$this->db->insert('feeder_mk', array(
					'id_mk' => $rw->id_mk,
					'id_sms' => $rw->id_sms,
					'kode_mk' => $rw->kode_mk,
					'nm_mk' => $rw->nm_mk,
					'jns_mk' => $rw->jns_mk,
					'kel_mk' => $rw->kel_mk,
				));
			}

			$this->db->query("DELETE FROM feeder_kurikulum");
			foreach ($kurikulum as $rw) {
				$this->db->insert('feeder_kurikulum', array(
					'id_kurikulum_sp' => $rw->id_kurikulum_sp,
					'id_sms' => $rw->id_sms,
					'id_smt' => $rw->id_smt,
					'nm_kurikulum_sp' => $rw->nm_kurikulum_sp,
				));
			}

			$this->session->set_flashdata('message', alert_feeder("berhasil terkoneksi",'success'));
				redirect('api_feeder','refresh');
		}
	}

	public function mahasiswa()
	{
		$client = new nusoap_client(config_feeder('url').'/ws/live.php?wsdl', true);
		$proxy = $client->getProxy();

		$gettoken = token();

		$aksi = 'insert';
		$id_tahun_angkatan = $this->input->post('id_tahun_angkatan');
		$id_prodi = $this->input->post('id_prodi');
		$kode_prodi = get_data('prodi','id_prodi',$id_prodi,'kode_prodi');
		$prodi = get_data('prodi','id_prodi',$id_prodi,'prodi');
		$tahun_angkatan = get_data('tahun_angkatan','id_tahun_angkatan',$id_tahun_angkatan,'tahun_angkatan');

		$this->db->query("DELETE FROM feeder_log_error_mahasiswa");

		if ($aksi == 'insert') {

			$this->db->where('id_tahun_angkatan', $id_tahun_angkatan);
			$this->db->where('id_prodi', $id_prodi);
			$mhs = $this->db->get('mahasiswa');

			foreach ($mhs->result() as $rw) {

				$this->db->where('nim', $rw->nim);
				$this->db->where('sync_mahasiswa', '1');
				$this->db->where('sync_mahasiswa_pt', null);
				$cek_feeder_mhs = $this->db->get('feeder_mahasiswa');
				if ($cek_feeder_mhs->num_rows() > 0) {
					
					$id_pd = get_data('feeder_mahasiswa','nim',$rw->nim,'id_pd');
					$id_sp = get_data('feeder_sms','kode_prodi',$kode_prodi,'id_sp');
					$id_sms = get_data('feeder_sms','kode_prodi',$kode_prodi,'id_sms');

					$data_mhs_pt = array(
						'id_pd'=> $id_pd,
						'id_sp'=> $id_sp,
						'id_sms'=>$id_sms,
						'nipd' => $rw->nim,
						'tgl_masuk_sp'=> $rw->tanggal_masuk_kuliah,
						'tgl_create' => get_waktu(),
						'mulai_smt' => $rw->mulai_semester,
						'id_jns_daftar' => $rw->jenis_pendaftaran,
						'id_jalur_masuk' => $rw->jalur_pendaftaran,
						'id_pembiayaan' => $rw->jenis_pembiayaan,
						'biaya_masuk_kuliah' => 0,
					);

					$result_mhs_pt = $proxy->InsertRecord($gettoken,'mahasiswa_pt',json_encode($data_mhs_pt));
					if ($result_mhs_pt['error_code'] == 0 && $result_mhs_pt['result']['error_code'] == 0) {
						// insert berhasil sync
						$this->db->where('nim', $rw->nim);
						$this->db->update('feeder_mahasiswa', array(
							'sync_mahasiswa_pt' => '1',
						));
					} else {
						$this->db->insert('feeder_log_error_mahasiswa', array(
							'nim' => $rw->nim,
							'error_code'=>$result_mhs_pt['result']['error_code'],
							'error_desc'=>$result_mhs_pt['result']['error_desc'],
						));
					}

				} else {

					$data_mhs = array(
						'nm_pd' => $rw->nama,
						'jk' => $rw->jenis_kelamin,
						'jln' => $rw->jalan,
						'rt' => $rw->rt,
						'rw' => $rw->rw,
						'nm_dsn' => $rw->dusun,
						'ds_kel' => $rw->kelurahan,
						'kode_pos' => $rw->kode_pos,
						'nisn' => '',
						'nik' => $rw->nik,
						'tmpt_lahir' => $rw->tempat_lahir,
						'tgl_lahir' => $rw->tanggal_lahir,
						'nm_ayah' => $rw->nama_ayah,
						'tgl_lahir_ayah' => $rw->tanggal_lahir_ayah,
						'nik_ayah' => $rw->nik_ayah,
						'id_jenjang_pendidikan_ayah' => $rw->pendidikan_ayah,
						'id_pekerjaan_ayah' => $rw->pekerjaan_ayah,
						'id_penghasilan_ayah' => $rw->penghasilan_ayah,
						'nm_ibu_kandung' => $rw->nama_ibu,
						'tgl_lahir_ibu' => $rw->tanggal_lahir_ibu,
						'nik_ibu' => $rw->nik_ibu,
						'id_jenjang_pendidikan_ibu' => $rw->pendidikan_ibu,
						'id_pekerjaan_ibu' => $rw->pekerjaan_ibu,
						'id_penghasilan_ibu' => $rw->penghasilan_ibu,
						'nm_wali' => $rw->nama_wali,
						'tgl_lahir_wali' => $rw->tanggal_lahir_wali,
						'id_jenjang_pendidikan_wali' => $rw->pendidikan_wali,
						'id_pekerjaan_wali' => $rw->pekerjaan_wali,
						'id_penghasilan_wali' => $rw->penghasilan_wali,
						'no_tel_rumah' => $rw->telp_rumah,
						'no_hp' => $rw->no_hp,
						'email' => $rw->email,
						'a_terima_kps' => $rw->terima_kps,
						'no_kps' => $rw->no_kps,
						'npwp' => $rw->npwp,
						'id_wil' => $rw->kecamatan,
						'id_jns_tinggal' => $rw->jenis_tinggal,
						'id_agama' => $rw->agama,
						'id_alat_transport' => $rw->alat_transportasi,
						'kewarganegaraan' => $rw->kewarganegaraan,
						'id_kebutuhan_khusus_ayah' => 0,
						'id_kebutuhan_khusus_ibu' => 0,
						'id_kebutuhan_khusus_mahasiswa' => 0,
						'id_kk' => 0,
					);
					$result_mhs = $proxy->InsertRecord($gettoken,'mahasiswa',json_encode($data_mhs));
					if ($result_mhs['error_code'] == 0 && $result_mhs['result']['error_code'] == 0) {

						$id_pd = $result_mhs['result']['id_pd'];
						$id_sp = get_data('feeder_sms','kode_prodi',$kode_prodi,'id_sp');
						$id_sms = get_data('feeder_sms','kode_prodi',$kode_prodi,'id_sms');

						// insert berhasil sync
						$this->db->insert('feeder_mahasiswa', array(
							'id_mhs' => $rw->id_mahasiswa,
							'nim' => $rw->nim,
							'id_pd'=>$id_pd,
							'sync_mahasiswa' => '1',
						));

						$data_mhs_pt = array(
							'id_pd'=> $id_pd,
							'id_sp'=> $id_sp,
							'id_sms'=>$id_sms,
							'nipd' => $rw->nim,
							'tgl_masuk_sp'=> $rw->tanggal_masuk_kuliah,
							'tgl_create' => get_waktu(),
							'mulai_smt' => $rw->mulai_semester,
							'id_jns_daftar' => $rw->jenis_pendaftaran,
							'id_jalur_masuk' => $rw->jalur_pendaftaran,
							'id_pembiayaan' => $rw->jenis_pembiayaan,
							'biaya_masuk_kuliah' => 0,
						);

						$result_mhs_pt = $proxy->InsertRecord($gettoken,'mahasiswa_pt',json_encode($data_mhs_pt));
						if ($result_mhs_pt['error_code'] == 0 && $result_mhs_pt['result']['error_code'] == 0) {
							// insert berhasil sync
							$this->db->where('nim', $rw->nim);
							$this->db->update('feeder_mahasiswa', array(
								'sync_mahasiswa_pt' => '1',
							));
						} else {
							$this->db->insert('feeder_log_error_mahasiswa', array(
								'nim' => $rw->nim,
								'error_code'=>$result_mhs_pt['result']['error_code'],
								'error_desc'=>$result_mhs_pt['result']['error_desc'],
							));
						}

					} else {
						$this->db->insert('feeder_log_error_mahasiswa', array(
							'nim' => $rw->nim,
							'error_code'=>$result_mhs['result']['error_code'],
							'error_desc'=>$result_mhs['result']['error_desc'],
						));
					}

				}

			}

			

		} elseif ($aksi == 'update') {
			# code...
		} else {
			$this->session->set_flashdata('message', alert_feeder("Perintah tidak dikenali",'danger'));
				redirect('api_feeder?active=data_utama','refresh');
		}

		if ($this->db->get('feeder_log_error_mahasiswa')->num_rows() > 0) {
			$this->session->set_flashdata('message', alert_feeder('Ops.. ada error <button class="btn btn-success" id="lihatLogMahasiswa">Lihat Log</button>','danger'));
			redirect('api_feeder?active=data_utama','refresh');
		} else {
			$this->session->set_flashdata('message', alert_feeder("Data Mahasiswa Prodi $prodi dan tahun angkatan $tahun_angkatan berhasil di syncron",'success'));
			redirect('api_feeder?active=data_utama','refresh');
		}
	}

	public function kurikulum()
	{
		$client = new nusoap_client(config_feeder('url').'/ws/live.php?wsdl', true);
		$proxy = $client->getProxy();

		$gettoken = token();

		$aksi = 'insert';
		$periode = $this->input->post('periode');
		$id_prodi = $this->input->post('id_prodi');
		$kode_prodi = get_data('prodi','id_prodi',$id_prodi,'kode_prodi');
		$jumlah_semester = get_data('prodi','id_prodi',$id_prodi,'jumlah_semester');

		if ($aksi == 'insert') {
			$this->db->where('id_prodi', $id_prodi);
			$this->db->where('mulai_berlaku', $periode);
			$kurikulum = $this->db->get('kurikulum')->row();

			$data = array(
				'id_sms' => get_data('feeder_sms','kode_prodi',$kode_prodi,'id_sms'),
				'id_jenj_didik' => get_data('feeder_sms','kode_prodi',$kode_prodi,'id_jenj_didik'),
				'id_smt' => $kurikulum->mulai_berlaku,
				'nm_kurikulum_sp' => $kurikulum->kurikulum,
				'jml_sem_normal' => $jumlah_semester,
				'jml_sks_lulus' => $kurikulum->total_sks,
				'jml_sks_wajib' => $kurikulum->sks_wajib,			
				'jml_sks_pilihan' => $kurikulum->sks_pilihan,			
			);

			$result = $proxy->InsertRecord($gettoken,'kurikulum',json_encode($data));
			// log_r($result['result']);
			if ($result['error_code'] == 0 && $result['result']['error_code'] == 0) {
				$this->session->set_flashdata('message', alert_feeder("$kurikulum->kurikulum berhasil sync ke feeder",'success'));
				redirect('api_feeder?active=perkuliahan','refresh');
			} else {
				simpan_error($result['result']);
				$this->session->set_flashdata('message', alert_feeder('Ops.. ada error <button class="btn btn-success" id="lihatLog">Lihat Log</button>','danger'));
				redirect('api_feeder?active=perkuliahan','refresh');
			}
			

		} elseif ($aksi == 'update') {
			# code...
		} else {
			$this->session->set_flashdata('message', alert_feeder("Perintah tidak dikenali",'danger'));
				redirect('api_feeder?active=perkuliahan','refresh');
		}
	}


	public function get_data($aksi,$filter="",$limit="",$offset="")
	{
		$post = array(
			'act' => $aksi,
			"token" => get_data('config_feeder','id_config','1','token'),
			"filter" => "id_prodi='ab4d5343-5710-40dd-85fe-64f497b559bb'",
			"limit" =>$limit,
			"offset" => $offset,
		);
		$hasil = api_feeder($post);
		echo $hasil;
	}


}
