<?php 
function penyebut($nilai) {
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " ". $huruf[$nilai];
	} else if ($nilai <20) {
		$temp = penyebut($nilai - 10). " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
	}     
	return $temp;
}

function terbilang($nilai) {
	if($nilai<0) {
		$hasil = "minus ". trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}     		
	return $hasil;
}

function hitung_potogan($nim,$id_biaya,$biaya,$qty)
{
	$CI =& get_instance();
	$CI->db->where('nim', $nim);
    $CI->db->where('id_biaya', $id_biaya);
    $potongan = $CI->db->get('potongan_biaya');
    if ($potongan->num_rows() > 0) {
    	$pot = $potongan->row();
    	// potongan yg berlaku berdasarkan tanggal tertentu
    	if ($pot->berlaku == '1') {
    		if ($pot->jenis_potongan == 'persen') {
    			$n_persen = $pot->jumlah / 100;
    			$t_pot = $biaya * $n_persen * $qty;
    		} else {
    			$t_pot = $pot->jumlah * $qty;
    		}
    	} elseif ($pot->berlaku == '2') {
    		if ( strtotime(date('Y-m-d')) > strtotime($pot->batas_tanggal) ) {
    			$t_pot  = 0;
    		} else {
    			if ($pot->jenis_potongan == 'persen') {
        			$n_persen = $pot->jumlah / 100;
        			$t_pot = $biaya * $n_persen * $qty;
        		} else {
        			$t_pot = $pot->jumlah;
        		}
    		}
    	}
    } else {
    	$t_pot = 0;
    }
    return $t_pot;
}

function cek_skala_nilai($select,$angka,$prodi='')
{
	$CI =& get_instance();

	// $data = '';
	if ($prodi != '') {
		$CI->db->where('id_prodi', $prodi);
	}
	$skala  = $CI->db->get('skala_nilai');
	if ($skala->num_rows() > 0) {
		foreach ($skala->result() as $rw) {
			if ($rw->min >= $angka && $rw->max <= $angka) {
				$data = array(
					'nilai_huruf'=>$rw->nilai_huruf,
					'nilai_indeks'=>$rw->nilai_indeks,
				);
			}
		}
	} else {
		$data = array(
				'nilai_huruf'=>'',
				'nilai_indeks'=>'',
			);
	}

	return $CI->db->last_query();
}

function param_get()
{
	$url = parse_url($_SERVER['REQUEST_URI']);
	return $url['query'];
}

function ipk($nim,$kode_semester)
{
	$CI =& get_instance();
	$kode_smt = $kode_semester;
	$sks_total = 0;
	$total_s_in = 0;
	$CI->db->where('nim', $nim);
	$CI->db->group_by('kode_semester');
	$CI->db->group_by('kode_semester','asc');
	$data = $CI->db->get('krs');
	$smt_kecil = $data->row()->kode_semester;

	foreach ($data->result() as $br) {
		if ($br->kode_semester <= $kode_smt) {

			$CI->db->where('nim', $br->nim);
			$CI->db->where('kode_semester', $br->kode_semester);
			$dt_krs = $CI->db->get('krs');
			foreach ($dt_krs->result() as $rw) {
				$jml = $rw->sks*$rw->indeks; 
				$total_s_in = $total_s_in + $jml;
				$sks_total = $sks_total + $rw->sks;
			}
			
		}
	}
	$ipk = $total_s_in/$sks_total;
	// echo "total sks :".$sks_total."<br>";
	// echo "total Indeks :".$total_s_in."<br>";
	// echo "IPK :".number_format($ipk,2);
	return $ipk;
}

function sks_total($nim,$kode_semester)
{
	$CI =& get_instance();
	$kode_smt = $kode_semester;
	$sks_total = 0;

	$CI->db->where('nim', $nim);
	$CI->db->group_by('kode_semester');
	$CI->db->group_by('kode_semester','asc');
	$data = $CI->db->get('krs');
	$smt_kecil = $data->row()->kode_semester;

	foreach ($data->result() as $br) {
		if ($br->kode_semester <= $kode_smt) {

			$CI->db->where('nim', $br->nim);
			$CI->db->where('kode_semester', $br->kode_semester);
			$dt_krs = $CI->db->get('krs');
			foreach ($dt_krs->result() as $rw) {
				$sks_total = $sks_total + $rw->sks;
			}
			
		}
	}
	return $sks_total;
}

function ips($nim,$kode_semester)
{
	$CI =& get_instance();
	$sks_total = 0;
	$total_s_in = 0;

	$CI->db->where('nim', $nim);
	$CI->db->where('kode_semester', $kode_semester);
	$dt_krs = $CI->db->get('krs');
	foreach ($dt_krs->result() as $rw) {
		$jml = $rw->sks*$rw->indeks; 
		$total_s_in = $total_s_in + $jml;
		$sks_total = $sks_total + $rw->sks;
	}
	if ($total_s_in == 0) {
		return 0;
	} else {
		$ips = $total_s_in/$sks_total;
		return $ips;
	}
	
}

function sks_semester($nim,$kode_semester)
{
	$CI =& get_instance();
	$sks_total = 0;

	$CI->db->where('nim', $nim);
	$CI->db->where('kode_semester', $kode_semester);
	$dt_krs = $CI->db->get('krs');
	foreach ($dt_krs->result() as $rw) {
		$sks_total = $sks_total + $rw->sks;
	}
	return $sks_total;
}

function get_semester($nim,$kode_semester=null)
{
	$CI =& get_instance();
	$tahun_akademik_aktif = tahun_akademik_aktif('kode_tahun');
	$kode_semester = ($kode_semester == '') ? $tahun_akademik_aktif : $kode_semester;
	$mulai_semester = get_data('mahasiswa','nim',$nim,'mulai_semester');
	$data = $CI->db->query("SELECT kode_tahun FROM tahun_akademik WHERE kode_tahun BETWEEN '$mulai_semester' AND '$tahun_akademik_aktif' ORDER BY kode_tahun ASC");
	$arr= [];
	$no = 1;

	foreach ($data->result() as $key => $value) {
		array_push($arr, $value->kode_tahun);
		$no++;
	}

	$key = array_search($kode_semester, $arr);
	return $key+1;

	
}
function pengajuan_krs($nim)
{
	$CI =& get_instance();
	$CI->db->where('kode_semester', tahun_akademik_aktif('kode_tahun'));
	$CI->db->where('nim', $nim);
	$cek = $CI->db->get('temp_krs_pa');
	if ($cek->num_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function setuju_dosen_pa($nim)
{
	$CI =& get_instance();
	$CI->db->where('kode_semester', tahun_akademik_aktif('kode_tahun'));
	$CI->db->where('nim', $nim);
	$CI->db->where('konfirmasi_pa', 'y');
	$cek = $CI->db->get('krs');
	if ($cek->num_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function data_registarasi($nim,$periode,$check=false)
{
	$CI =& get_instance();
	$CI->db->where('nim', $nim);
	$CI->db->where('kode_semester', $periode);
	$cek = $CI->db->get('registrasi');

	$hasil_cek = 0;
	$data = '';
	if ($cek->num_rows() > 0) {
		$hasil_cek = 1;
		$data = $cek->row();
	} else {
		$hasil_cek = 0;
		$data = '';
	}

	if ($check) {
		return $hasil_cek;
	} else {
		return $data;
	}
}

function cek_registrasi_mahasiswa($redirect,$nim,$periode)
{
	$CI =& get_instance();
	$cek = data_registarasi($nim,$periode,TRUE);
	if ($cek == 0) {
		$CI->session->set_flashdata('notif', alert_biasa('kamu belum diregistrasikan di semester ini!','error'));
		redirect($redirect,'refresh');
	}
}

function cek_semester_aktif($redirect)
{
	$CI =& get_instance();
	$CI->db->where('aktif', 'y');
	$cek = $CI->db->get('tahun_akademik');
	if ($cek->num_rows() == 0) {
		$CI->session->set_flashdata('notif', alert_biasa('silahkan aktifkan tahun akademik terlebih dahulu!','error'));
		redirect($redirect,'refresh');
	}
}

function jenis_semester_aktif()
{
	$CI =& get_instance();
	$tahun = tahun_akademik_aktif('kode_tahun');
	if (substr($tahun,4,1) == '1') {
		return 'ganjil';
	} else {
		return 'genap';
	}
}

function jenis_perkuliahan()
{
	$CI =& get_instance();
	$CI->db->select('jenis_perkuliahan');
	$CI->db->where('aktif', 'y');
	$data = $CI->db->get('jenis_perkuliahan')->row_array();
	return $data['jenis_perkuliahan'];
}

function tahun_akademik_aktif($select)
{
	$CI =& get_instance();
	$CI->db->select($select);
	$CI->db->where('aktif', 'y');
	$data = $CI->db->get('tahun_akademik')->row_array();
	return $data[$select];
}

function superman()
{
  if (strpos(siteURL(),'://localhost')){
    return true;
  }else {
    return false;
  }
}

function siteURL() {
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'] . '/';
  return $protocol . $domainName;
}

function api($value)
{
	if ($value == 'login_fb') {
		return '255436962206721, 07348b9734248bb5d93b4a4a40c012d8';
	} elseif ($value == 'login_google') {
		return '514260896239-7gsm0vuljlcpf2m1qs1qr308isotqe64.apps.googleusercontent.com, H_JIU-RVp23IyVJ32lUNuqK9';
	}
}

function kirim_email($subject,$pesan,$email_to)
{
	$CI =& get_instance();
	$config = [
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'protocol'  => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_user' => get_data('setting','nama','email_pengirim','value'),  // Email gmail
        'smtp_pass'   => get_data('setting','nama','password_pengirim','value'),  // Password gmail
        'smtp_crypto' => 'tls',
        'smtp_port'   => 587,
        'crlf'    => "\r\n",
        'newline' => "\r\n"
    ];

    // Load library email dan konfigurasinya
    $CI->email->initialize($config);  
  
	$CI->email->set_newline("\r\n"); 

    // Email dan nama pengirim
    $CI->email->from('test@dokterarief.com', 'Klinik Dokter');

    // Email penerima
    $CI->email->to($email_to); // Ganti dengan email tujuan

    // Lampiran email, isi dengan url/path file
    // $CI->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

    // Subject email
    $CI->email->subject($subject);

    // Isi email
    $CI->email->message($pesan);

    // Tampilkan pesan sukses atau error
    if ($CI->email->send()) {
        return 'Sukses! email berhasil dikirim.';
    } else {
    	
    	return $CI->email->print_debugger();
    }
}

function list_date() {

	$tgl1 = date('Y-m-d');// pendefinisian tanggal awal
	$tgl2 = date('Y-m-d', strtotime('+7 days', strtotime($tgl1)));

    $start    = new DateTime($tgl1);
	$end      = new DateTime($tgl2);
	$interval = DateInterval::createFromDateString('1 day');
	$period   = new DatePeriod($start, $interval, $end);

	// foreach ($period as $dt)
	// {
	//     echo $dt->format("l Y-m-d");
	//     echo "<br>";
	// }

	return $period;
}

function cek_hari($date)
{
	$daftar_hari = array(
		'Sunday' => 'Minggu',
		'Monday' => 'Senin',
		'Tuesday' => 'Selasa',
		'Wednesday' => 'Rabu',
		'Thursday' => 'Kamis',
		'Friday' => 'Jumat',
		'Saturday' => 'Sabtu'
	);
	$namahari = date('l', strtotime($date));

	return $daftar_hari[$namahari];
}

function no_urut_slip()
{
	error_reporting(0);
	$CI =& get_instance();
	$CI->db->like('tanggal_bayar', date('Y-m'), 'AFTER');
	$total = $CI->db->get('pembayaran')->num_rows();
	$total++;

	// $huruf = "ANT";
	// $kode = $huruf. sprintf("%03s", $urutan);

	return sprintf("%03s", $total);

}

function hitung_umur($tgl_lahir)
{
	// tanggal lahir
	$tanggal = new DateTime($tgl_lahir);

	// tanggal hari ini
	$today = new DateTime('today');

	// tahun
	$y = $today->diff($tanggal)->y;

	// bulan
	$m = $today->diff($tanggal)->m;

	// hari
	$d = $today->diff($tanggal)->d;
	//echo "Umur: " . $y . " tahun " . $m . " bulan " . $d . " hari";

	return $y . " tahun " . $m . " bulan " . $d . " hari";
}



// function create_random($length)
// {
//     $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
//     $string = '';
//     for($i = 0; $i < $length; $i++) {
//         $pos = rand(0, strlen($data)-1);
//         $string .= $data{$pos};
//     }
//     return $string;
// }

function upload_gambar_biasa($nama_gambar, $lokasi_gambar, $tipe_gambar, $ukuran_gambar, $name_file_form)
{
    $CI =& get_instance();
    $nmfile = $nama_gambar."_".time();
    $config['upload_path'] = './'.$lokasi_gambar;
    $config['allowed_types'] = $tipe_gambar;
    $config['max_size'] = $ukuran_gambar;
    $config['file_name'] = $nmfile;
    // load library upload
    $CI->load->library('upload', $config);
    // upload gambar 1
    if ( ! $CI->upload->do_upload($name_file_form)) {
    	return $CI->upload->display_errors();
    } else {
	    $result1 = $CI->upload->data();
	    $result = array('gambar'=>$result1);
	    $dfile = $result['gambar']['file_name'];
	    
	    return $dfile;
	}	
}



function get_waktu()
{
	date_default_timezone_set('Asia/Jakarta');
	return date('Y-m-d H:i:s');
}
function select_option($name, $table, $field, $pk, $selected = null,$class = null, $extra = null, $option_tamabahan = null) {
    $ci = & get_instance();
    $cmb = "<select name='$name' class='form-control $class  ' $extra>";
    $cmb .= $option_tamabahan;
    $data = $ci->db->get($table)->result();
    foreach ($data as $row) {
        $cmb .="<option value='" . $row->$pk . "'";
        $cmb .= $selected == $row->$pk ? 'selected' : '';
        $cmb .=">" . strtoupper($row->$field ). "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function get_setting($select)
{
	return 'KLINIK DOKTER';
}

function get_data($tabel,$primary_key,$id,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM $tabel where $primary_key='$id' ");
	if ($data->num_rows() > 0) {
		$data = $data->row_array();
		return $data[$select];
	} else {
		return '';
	}
}

function get_produk($barcode,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM produk where barcode1='$barcode' or barcode2='$barcode' ")->row_array();
	return $data[$select];
}

function alert_notif($pesan,$type)
{
	return "<div class=\"alert alert-$type fade in alert-radius-bordered alert-shadowed\">
                                        <button class=\"close\" data-dismiss=\"alert\">
                                            ×
                                        </button>
                                        <i class=\"fa-fw fa fa-info\"></i>

                                        <strong>Info:</strong> $pesan
                                    </div>";
}

function alert_biasa($pesan,$type)
{
	return 'swal("'.$pesan.'", "You clicked the button!", "'.$type.'");';
}

function alert_tunggu($pesan,$type)
{
	return '
	swal("Silahkan Tunggu!", {
	  button: false,
	  icon: "info",
	});
	';
}

function selisih_waktu($start_date)
{
	date_default_timezone_set('Asia/Jakarta');
	$waktuawal  = date_create($start_date); //waktu di setting

	$waktuakhir = date_create(date('Y-m-d H:i:s')); //2019-02-21 09:35 waktu sekarang

	//Membandingkan
	$date1 = new DateTime($start_date);
	$date2 = new DateTime(date('Y-m-d H:i:s'));
	if ($date2 < $date1) {
	    $diff  = date_diff($waktuawal, $waktuakhir);
		return $diff->d . ' hari '.$diff->h . ' jam lagi ';
	} else {
		return 'berlangsung';
	}

	

	// echo 'Selisih waktu: ';

	// echo $diff->y . ' tahun, ';

	// echo $diff->m . ' bulan, ';

	// echo $diff->d . ' hari, ';

	// echo $diff->h . ' jam, ';

	// echo $diff->i . ' menit, ';

	// echo $diff->s . ' detik, ';
}



function filter_string($n)
{
	$hasil = str_replace('"', "'", $n);
	return $hasil;
}

function cek_nilai_lulus()
{	
	$CI 	=& get_instance();
	$nilai = $CI->db->query("SELECT sum(nilai_lulus) as lulus FROM mapel ")->row()->lulus;
	return $nilai;
}



function log_r($string = null, $var_dump = false)
{
    if ($var_dump) {
        var_dump($string);
    } else {
        echo "<pre>";
        print_r($string);
    }
    exit;
}

function log_data($string = null, $var_dump = false)
{
    if ($var_dump) {
        var_dump($string);
    } else {
        echo "<pre>";
        print_r($string);
    }
    // exit;
}

// ==========================================
// Encrypt
function encode($string='',$base='')
{ 
	error_reporting(0);
  // $CI = &get_instance();
  // if ($base=='64') {
  //   $cryptKey = $CI->config->item('encryption_key');
  //   $id = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5( $cryptKey), $string, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
  // }else {
  //   $id = $CI->encrypt->encode($string);
  // }
  // $id = str_replace("/", "==11==", $id);
  // $id = str_replace("+", "==22==", $id);
	$id = base64_encode($string);
  return $id;
}

// Decrypt
function decode($string='',$base='')
{ 
	// error_reporting(0);
  // $CI = &get_instance();
  // $id = str_replace("==11==", "/", $string);
  // $id = str_replace("==22==", "+", $id);
  // if ($base=='64') {
  //   $string = $id;
  //   $cryptKey = $CI->config->item('encryption_key');
  //   $id = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
  // }else {
  //   $id = $CI->encrypt->decode($id);
  // }
	$id = base64_decode($string);
  return $id;
}
// ==========================================