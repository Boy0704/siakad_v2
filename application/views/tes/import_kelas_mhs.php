<form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="file_excel">
	<button type="submit">Upload</button>
</form>

<?php if (isset($sheet) && $sheet!=''): ?>
	<table border="1">
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>kelas</th>
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

		 	$kelas = get_data('kelas','kelas',$rw['B'],'kelas');
		 	if ($kelas == '') {
		 		$color2 = 'style="background: red"';
		 	} else {
		 		$color2 = '';
		 	}
		  ?>
		<tr >
			<td><?php echo $no; ?></td>
			<td <?php echo $color1 ?>><?php echo $rw['A']; ?></td>
			<td <?php echo $color2 ?>><?php echo $rw['B']; ?></td>
		</tr>
		<?php $no++; endforeach ?>

	</table>

	<p>
		<a href="aksi_import_kelas_mhs">Import Sekarang</a>
	</p>
	

<?php endif ?>