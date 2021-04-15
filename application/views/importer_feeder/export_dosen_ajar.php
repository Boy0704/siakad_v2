<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Export_dosen_ajar.xls");
?>
<table border="1">
	<thead>
		<tr>
			<th style="background: red">Semester</th>
			<th style="background: red">NIDN</th>
			<th>Nama Dosen</th>
			<th style="background: red">Kode MK</th>
			<th style="background: red">Kelas</th>
			<th style="background: red">Tatap Muka</th>
			<th >Tatap Muka Realisasi</th>
			<th style="background: red">Kode Prodi</th>
			<th>SKS AJAR</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($_GET): ?>
		
		<?php
		$id_prodi = $this->input->get('id_prodi');
		$periode = $this->input->get('periode');
		$this->db->where('id_prodi', $id_prodi);
		$this->db->where('kode_semester', $periode);
		$this->db->group_by('id_dosen');
		$data = $this->db->get('krs');
		foreach ($data->result() as $rw):
			$kode_prodi = get_data('prodi','id_prodi',$id_prodi,'kode_prodi');
			$nidn = get_data('dosen','id_dosen',$rw->id_dosen,'nidn');
		 ?>
		<tr>
			<td><?php echo $rw->kode_semester ?></td>
			<td><?php echo $nidn ?></td>
			<td><?php echo $rw->nama_dosen ?></td>
			<td><?php echo $rw->kode_mk ?></td>
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
			<td><?php echo '16' ?></td>
			<td><?php echo $kode_prodi ?></td>
			<td><?php echo $rw->sks ?></td>
		</tr>
		<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>