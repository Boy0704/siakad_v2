<form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="file_excel">
	<button type="submit">Upload</button>
</form>

<?php if (isset($sheet) && $sheet!=''): ?>
	<table border="1">
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Kode mk</th>
			<th>Nama mk</th>
			<th>Nidn</th>
			<th>Dosen</th>
			<th>Kelas</th>
			<th>bobot</th>
			<th>Angka</th>
			<th>Huruf</th>
			<th>Indeks</th>
			<th>THN AKD</th>
		</tr>

		<?php
		$no = 1;
		$color1 = '';
		$color2 = '';
		 foreach ($sheet as $rw):
		 	$nim = get_data('mahasiswa','nim',$rw['A'],'nim');
		 	if ($nim == '') {
		 		$color1 = 'style="background: red"';
		 	} else {
		 		$color1 = '';
		 	}

		  ?>
		<tr >
			<td><?php echo $no; ?></td>
			<td <?php echo $color1 ?>><?php echo $rw['A']; ?></td>
			<td><?php echo $rw['B']; ?></td>
			<td><?php echo $rw['D']; ?></td>
			<td><?php echo $rw['E']; ?></td>
			<td><?php echo $rw['F']; ?></td>
			<td><?php echo $rw['G']; ?></td>
			<td><?php echo $rw['H']; ?></td>
			<td><?php echo $rw['I']; ?></td>
			<td><?php echo $rw['J']; ?></td>
			<td><?php echo $rw['K']; ?></td>
			<td><?php echo str_replace(':', '.', $rw['L']); ?></td>
			<td><?php echo $rw['M']; ?></td>
		</tr>
		<?php $no++; endforeach ?>

	</table>

	<p>
		<form action="aksi_import_khs" method="GET">
			<select name="id_prodi">
				<?php foreach ($this->db->get('prodi')->result() as $br): ?>
					<option value="<?php echo $br->id_prodi ?>"><?php echo $br->prodi ?></option>
				<?php endforeach ?>
			</select>
			<button type="submit">Import</button>
		</form>
	</p>
	

<?php endif ?>