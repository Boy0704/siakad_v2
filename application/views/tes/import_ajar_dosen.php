<form action="" method="POST" enctype="multipart/form-data">
	<select name="kode_tahun">
		<?php 
		$this->db->order_by('kode_tahun', 'desc');
		foreach ($this->db->get('tahun_akademik')->result() as $key => $value): ?>
			<option value="<?php echo $value->kode_tahun ?>"><?php echo $value->keterangan ?></option>
		<?php endforeach ?>
	</select>
	<select name="id_prodi">
		<?php 
		foreach ($this->db->get('prodi')->result() as $key => $value): ?>
			<option value="<?php echo $value->id_prodi ?>"><?php echo $value->prodi ?></option>
		<?php endforeach ?>
	</select>
	
	<input type="file" name="file_excel">
	<button type="submit">Upload</button>
</form>

<?php if ($sheet!=''): ?>
	<table border="1">
		<tr>
			<th>No.</th>
			<th>kode mk</th>
			<th>nama mk</th>
			<th>nidn</th>
			<th>nama</th>
			<th>prodi</th>
			<th>kelas</th>
		</tr>

		<?php
		$no = 1;
		$color = '';
		$color_ds = '';
		 foreach ($sheet as $rw):
		 	$nama_dosen = get_data('dosen','nidn',$rw['C'],'nama');
		 	$this->db->where('kode_semester', $kode_semester);
		 	$this->db->where('kode_mk', $rw['A']);
		 	$this->db->where('id_prodi', $id_prodi);
		 	$cek= $this->db->get('krs');
		 	if ($nama_dosen == '') {
		 		$color_ds = 'style="background: red"';
		 	} else {
		 		$color_ds = '';
		 	}

		 	if ($cek->num_rows() > 0) {
		 		$color = '';
		 	} else {
		 		$color = 'style="background: red"';
		 	}
		  ?>
		<tr >
			<td><?php echo $no; ?></td>
			<td <?php echo $color ?>><?php echo $rw['A']; ?></td>
			<td><?php echo $rw['B']; ?></td>
			<td <?php echo $color_ds ?>><?php echo $rw['C']; ?></td>
			<td><?php echo $rw['D']; ?></td>
			<td><?php echo $rw['E']; ?></td>
			<td><?php echo $rw['F']; ?></td>
		</tr>
		<?php $no++; endforeach ?>

	</table>

	<p>
		<a href="aksi_import_ajar_dosen?id_prodi=<?php echo $id_prodi ?>&kode_semester=<?php echo $kode_semester ?>">Import Sekarang</a>
	</p>
	

<?php endif ?>