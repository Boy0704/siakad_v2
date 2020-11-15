<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_feeder extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('feeder_helper');
	}

	
	public function index()
	{
		$hasil = getToken();
		$hasil = json_decode($hasil);

		$this->db->where('id_config', '1');
		$this->db->update('config_feeder', array('token'=>$hasil->data->token));
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
