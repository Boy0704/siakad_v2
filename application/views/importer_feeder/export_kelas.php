<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Export_kelas.xls");
?>
<table border="1">
	<thead>
		<tr>
			<th style="background: red">Semester</th>
			<th style="background: red">Kode MK</th>
			<th>Nama MK</th>
			<th style="background: red">Kelas</th>
			<th >Bahasan</th>
			<th >Mulai Efektif</th>
			<th >Akhir Efektif</th>
			<th style="background: red">Kode Prodi</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($_GET): ?>
		
		<?php
		$id_prodi = $this->input->get('id_prodi');
		$periode = $this->input->get('periode');
		$this->db->where('id_prodi', $id_prodi);
		$this->db->where('kode_semester', $periode);
		$this->db->group_by('kode_mk');
		$this->db->group_by('kelas');
		$data = $this->db->get('krs');
		foreach ($data->result() as $rw):
			$kode_prodi = get_data('prodi','id_prodi',$id_prodi,'kode_prodi');
		 ?>
		<tr>
			<td><?php echo $rw->kode_semester ?></td>
			<td><?php echo $rw->kode_mk ?></td>
			<td><?php echo $rw->nama_mk ?></td>
			<td>
				<?php 
				$this->db->where('kelas', $rw->kelas);
				$cek_kls = $this->db->get('kelas');
				if ($cek_kls->num_rows() > 0) {
					echo $cek_kls->row()->kode_kelas;
				} else {
					echo $rw->kelas;
				}

				 ?>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo $kode_prodi ?></td>
		</tr>
		<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>