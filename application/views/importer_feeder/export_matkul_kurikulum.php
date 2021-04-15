<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Export_matkul_kurikulum.xls");
?>
<table border="1">
	<thead>
		<tr>
			<th style="background: red">Kode Mk</th>
			<th>Nama MK</th>
			<th style="background: red">Jenis MK</th>
			<th style="background: red">SKS Tatap Muka</th>
			<th style="background: red">SKS Praktek</th>
			<th style="background: red">SKS Prak Lap</th>
			<th style="background: red">SKS Simulasi</th>
			<th >Mulai Efektif</th>
			<th >Akhir Efektif</th>
			<th style="background: red">Semester</th>
			<th style="background: red">Kode Prodi</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($_GET): ?>
		
		<?php
		$id_prodi = $this->input->get('id_prodi');
		$id_kurikulum = $this->input->get('id_kurikulum');
		$this->db->where('id_prodi', $id_prodi);
		$this->db->where('id_kurikulum', $id_kurikulum);
		$data = $this->db->get('matakuliah');
		foreach ($data->result() as $rw):
			$kode_prodi = get_data('prodi','id_prodi',$id_prodi,'kode_prodi');
		 ?>
		<tr>
			<td><?php echo $rw->kode_mk ?></td>
			<td><?php echo $rw->nama_mk ?></td>
			<td><?php echo $rw->jenis_mk ?></td>
			<td><?php echo $rw->sks_tm ?></td>
			<td><?php echo $rw->sks_prak ?></td>
			<td><?php echo $rw->sks_prak_la ?></td>
			<td><?php echo $rw->sks_simulasi ?></td>
			<td><?php echo $rw->tgl_mulai_efektif ?></td>
			<td><?php echo $rw->tgl_akhir_efektif ?></td>
			<td><?php echo $rw->semester ?></td>
			<td><?php echo $kode_prodi ?></td>
		</tr>
		<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>