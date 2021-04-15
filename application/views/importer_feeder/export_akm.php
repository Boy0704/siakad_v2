<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Export_data_akm.xls");
?>
<table border="1">
	<thead>
		<tr>
			<th style="background: red">NIM</th>
			<th>NAMA</th>
			<th style="background: red">SEMESTER</th>
			<th style="background: red">SKS</th>
			<th style="background: red">IPS</th>
			<th style="background: red">SKS KOMULATIF</th>
			<th style="background: red">IPK</th>
			<th style="background: red">STATUS</th>
			<th style="background: red">KODE PRODI</th>
			<th style="background: red">BIAYA KULIAH SEMESTER</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($_GET): ?>
		
		<?php
		$id_prodi = $this->input->get('id_prodi');
		$periode = $this->input->get('periode');
		$this->db->select('a.*,b.id_prodi');
		$this->db->from('akm_mahasiswa a');
		$this->db->join('mahasiswa b', 'a.nim = b.nim', 'inner');
		$this->db->where('a.kode_semester', $periode);
		$this->db->where('b.id_prodi', $id_prodi);
		$data = $this->db->get();
		foreach ($data->result() as $rw):
			$kode_prodi = get_data('prodi','id_prodi',$rw->id_prodi,'kode_prodi');
		 ?>
		<tr>
			<td><?php echo $rw->nim ?></td>
			<td><?php echo $rw->nama ?></td>
			<td><?php echo $rw->kode_semester ?></td>
			<td><?php echo sks_semester($rw->nim,$rw->kode_semester) ?></td>
			<td><?php echo number_format(ips($rw->nim,$rw->kode_semester),2) ?></td>
			<td><?php echo sks_total($rw->nim,$rw->kode_semester) ?></td>
			<td><?php echo number_format(ipk($rw->nim,$rw->kode_semester),2) ?></td>
			<td><?php echo $rw->id_stat_mhs ?></td>
			<td><?php echo $kode_prodi ?></td>
			<td><?php echo biaya_kuliah_semester($rw->nim,$rw->kode_semester) ?></td>
		</tr>
		<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>