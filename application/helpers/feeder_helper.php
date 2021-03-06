<?php

function token()
{
	$client = new nusoap_client(config_feeder('url').'/ws/live.php?wsdl', true);

	$proxy = $client->getProxy();
	$username = config_feeder('username');
	$password = config_feeder('password');
	$token = $proxy->GetToken($username, $password);
	return $token;
}

function simpan_error($data)
{
	$CI =& get_instance();
	$dt = array();
	array_push($dt, $data);
	$CI->db->query("DELETE FROM feeder_log_error");
	foreach ($dt as $rw) {
		$CI->db->insert('feeder_log_error', $rw);
	}
	return '1';
}

function config_feeder($select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM feeder_config where id_config='1' ");
	if ($data->num_rows() > 0) {
		$data = $data->row_array();
		return $data[$select];
	} else {
		return '';
	}
}

function alert_feeder($pesan,$type)
{
	return "<div class=\"alert alert-$type fade in alert-radius-bordered alert-shadowed\">
                <button class=\"close\" data-dismiss=\"alert\">
                    ×
                </button>
                <i class=\"fa-fw fa fa-info\"></i>

                $pesan
            </div>";
}

function getToken()
{
	header('Content-Type:application/json');
	# atur zona waktu sender server ke Jakarta (WIB / GMT+7)
	date_default_timezone_set("Asia/Jakarta");
	$curr_unix_time = time(); 
	$url = get_data('config_feeder','id_config','1','url').'/ws/live2.php';
	$headers = [
		'Content-Type:application/json',
		'Accept:application/json',
	];
	$post_raw_json = json_encode(array(
		"act" => "GetToken",
		"username" => get_data('config_feeder','id_config','1','username'),
		"password" => get_data('config_feeder','id_config','1','password'),
	));

	# Inisiasi CURL request
	$ch = curl_init();

	# atur CURL Options
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url, # URL endpoint
		CURLOPT_HTTPHEADER => $headers, # HTTP Headers
		CURLOPT_RETURNTRANSFER => 1, # return hasil curl_exec ke variabel, tidak langsung dicetak
		CURLOPT_FOLLOWLOCATION => 1, # atur flag followlocation untuk mengikuti bila ada url redirect di server penerima tetap difollow
		CURLOPT_CONNECTTIMEOUT => 60, # set connection timeout ke 60 detik, untuk mencegah request gantung saat server mati
		CURLOPT_TIMEOUT => 60, # set timeout ke 120 detik, untuk mencegah request gantung saat server hang
		CURLOPT_POST => 1, # set method request menjadi POST
		CURLOPT_POSTFIELDS => $post_raw_json, # attached post data dalam bentuk JSON String,
		CURLOPT_SSL_VERIFYPEER => false  
		// CURLOPT_VERBOSE => 1, # mode debug
		// CURLOPT_HEADER => 1, # cetak header
	));

	# eksekusi CURL request dan tampung hasil responsenya ke variabel $resp
	$resp = curl_exec($ch);

	# validasi curl request tidak error
	if (curl_errno($ch) == false) {
	# jika curl berhasil
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($http_code == 200) {
		  # http code === 200 berarti request sukses (harap pastikan server penerima mengirimkan http_code 200 jika berhasil)
		  return $resp;
		} else {
		  # selain itu request gagal (contoh: error 404 page not found)
		  // echo 'Error HTTP Code : '.$http_code."\n";
		  return $resp;
		}
	} else {
		# jika curl error (contoh: request timeout)
		# Daftar kode error : https://curl.haxx.se/libcurl/c/libcurl-errors.html
		return "Error while sending request, reason:".curl_error($ch);
	}

	# tutup CURL
	curl_close($ch);
}

function api_feeder($post=array())
{
	header('Content-Type:application/json');
	# atur zona waktu sender server ke Jakarta (WIB / GMT+7)
	date_default_timezone_set("Asia/Jakarta");
	$curr_unix_time = time(); 
	$url = get_data('config_feeder','id_config','1','url').'/ws/live2.php';
	$headers = [
		'Content-Type:application/json',
		'Accept:application/json',
	];
	$post_raw_json = json_encode(
		$post
	);

	# Inisiasi CURL request
	$ch = curl_init();

	# atur CURL Options
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url, # URL endpoint
		CURLOPT_HTTPHEADER => $headers, # HTTP Headers
		CURLOPT_RETURNTRANSFER => 1, # return hasil curl_exec ke variabel, tidak langsung dicetak
		CURLOPT_FOLLOWLOCATION => 1, # atur flag followlocation untuk mengikuti bila ada url redirect di server penerima tetap difollow
		CURLOPT_CONNECTTIMEOUT => 60, # set connection timeout ke 60 detik, untuk mencegah request gantung saat server mati
		CURLOPT_TIMEOUT => 60, # set timeout ke 120 detik, untuk mencegah request gantung saat server hang
		CURLOPT_POST => 1, # set method request menjadi POST
		CURLOPT_POSTFIELDS => $post_raw_json, # attached post data dalam bentuk JSON String,
		CURLOPT_SSL_VERIFYPEER => false  
		// CURLOPT_VERBOSE => 1, # mode debug
		// CURLOPT_HEADER => 1, # cetak header
	));

	# eksekusi CURL request dan tampung hasil responsenya ke variabel $resp
	$resp = curl_exec($ch);

	# validasi curl request tidak error
	if (curl_errno($ch) == false) {
	# jika curl berhasil
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($http_code == 200) {
		  # http code === 200 berarti request sukses (harap pastikan server penerima mengirimkan http_code 200 jika berhasil)
		  return $resp;
		} else {
		  # selain itu request gagal (contoh: error 404 page not found)
		  // echo 'Error HTTP Code : '.$http_code."\n";
		  return $resp;
		}
	} else {
		# jika curl error (contoh: request timeout)
		# Daftar kode error : https://curl.haxx.se/libcurl/c/libcurl-errors.html
		return "Error while sending request, reason:".curl_error($ch);
	}

	# tutup CURL
	curl_close($ch);
}
