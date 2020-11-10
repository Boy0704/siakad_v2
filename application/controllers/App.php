<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	
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

		

		$this->db->trans_begin();

		$this->db->where('level', $id_level);
		$this->db->delete('master_menu_level');

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

	public function aktifkan_thn_akademik($id_tahun_akademik)
	{
		$this->db->query("UPDATE tahun_akademik SET aktif='t'");
		$this->db->where('id_tahun_akademik', $id_tahun_akademik);
		$this->db->update('tahun_akademik', array('aktif'=>'y'));
		redirect('tahun_akademik','refresh');
	}







}
