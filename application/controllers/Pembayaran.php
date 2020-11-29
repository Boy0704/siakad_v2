<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->rbac->check_module_access();
	}

	public function index()
	{
		$data = array(
			'konten' => 'pembayaran/view',
			'judul_page' => 'Pembayaran Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function detail($id_pembayaran)
	{
		$data = array(
			'konten' => 'pembayaran/detail_pembayaran',
			'judul_page' => 'Detail Pembayaran Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function create()
	{
		if (!$_GET OR $_GET['nim'] == '') {
			$dt_delete = array();
			if (!empty($this->cart->contents())) {
				foreach ($this->cart->contents() as $rw) {
					array_push($dt_delete, array(
						'rowid' =>$rw['rowid'],
						'qty' => 0
					));
				}
				$this->cart->update($dt_delete);
			}
		}
		$data = array(
			'konten' => 'pembayaran/tambah_pembayaran',
			'judul_page' => 'Tambah Pembayaran Mahasiswa',
		);
		$this->load->view('v_index',$data);
	}

	public function simpan_pembayaran()
	{
		if ($_GET) {
			$nim = $this->input->get('nim');
			$periode = $this->input->get('periode');
			$tgl_bayar = get_waktu();

			$this->db->trans_begin();
			$this->db->insert('pembayaran', array(
				'nim' => $nim,
				'kode_semester' => $periode,
				'tanggal_bayar' => $tgl_bayar
			));
			$id_pembayaran = $this->db->insert_id();

			foreach ($this->cart->contents() as $rw) {
				$id_biaya = $rw['name'];
                $biaya = $rw['price'];
                $qty = $rw['qty'];

                $t_pot = hitung_potogan($nim,$id_biaya,$biaya,$qty);
                $subt = ($rw['qty'] * $rw['price']) - $t_pot;

				$data = array(
					'id_pembayaran' => $id_pembayaran,
					'nim' => $nim,
					'id_biaya' => $rw['name'],
					'tahun_berlaku' => $rw['options']['tahun_berlaku'],
					'qty'=>$rw['qty'],
					'nilai' => $rw['price'],
					'subtotal' => $subt,
				);
				$this->db->insert('pembayaran_detail', $data);
			}

			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->session->set_flashdata('message', alert_notif('Pembayaran gagal disimpan !','danger'));
				redirect('pembayaran','refresh');
			}
			else
			{
		        $this->db->trans_commit();
		        $this->session->set_flashdata('message', alert_notif('Pembayaran berhasil disimpan !','success'));
				redirect('pembayaran','refresh');
		    }
		}
	}

	public function aksi_pilih_biaya()
	{
		$ceklis = $this->input->post('ceklis');

		$dt_delete = array();
		if (!empty($this->cart->contents())) {
			foreach ($this->cart->contents() as $rw) {
				array_push($dt_delete, array(
					'rowid' =>$rw['rowid'],
					'qty' => 0
				));
			}
			$this->cart->update($dt_delete);
		}

		$data = array();
		foreach ($ceklis as $key => $value) {
			$nilai = get_data('biaya_pembayaran','id_nilai_biaya',$value,'nilai');
			$id_biaya = get_data('biaya_pembayaran','id_nilai_biaya',$value,'id_biaya');
			$tahun_berlaku = get_data('biaya_pembayaran','id_nilai_biaya',$value,'tahun_berlaku');
			array_push($data, 
				array(
	                'id'      => $value,
	                'qty'     => 1,
	                'price'   => $nilai,
	                'name'    => $id_biaya,
	                'options' => array('tahun_berlaku' => $tahun_berlaku),
		        )
			);
		}
		$this->cart->insert($data);
		redirect('pembayaran/create?'.param_get(),'refresh');
	}

	public function update_detail($rowid)
	{
		$qty = $this->input->post('qty');
		$data = array(
			'rowid' =>$rowid,
			'qty' => $qty,
		);
		$this->cart->update($data);
		redirect('pembayaran/create?'.param_get(),'refresh');
	}

	public function delete_detail($rowid)
	{
		$data = array(
			'rowid' =>$rowid,
			'qty' => 0
		);
		$this->cart->update($data);
		redirect('pembayaran/create?'.param_get(),'refresh');
	}

	public function delete_detail_all()
	{
		$dt_delete = array();
		if (!empty($this->cart->contents())) {
			foreach ($this->cart->contents() as $rw) {
				array_push($dt_delete, array(
					'rowid' =>$rw['rowid'],
					'qty' => 0
				));
			}
			$this->cart->update($dt_delete);
		}
		redirect('pembayaran/create?'.param_get(),'refresh');
	}

}

/* End of file Pembayaran.php */
/* Location: ./application/controllers/Pembayaran.php */