<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {

	
	public function krs()
	{
		$this->load->view('cetak/cetak_krs');
	}
}
