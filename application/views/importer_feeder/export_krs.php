<?php 
if ($_GET) {
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Export_KRS.xls");
 ?>

<table border="1">
	<tr>
		<td style="background-color: red">NIM</td>
		<td>NAMA</td>
		<td style="background-color: red">SEMESTER</td>
		<td style="background-color: red">KODE MK</td>
		<td>NAMA MK</td>
		<td style="background-color: red">KELAS</td>
		<td style="background-color: red">KODE PRODI</td>
	</tr>
	<?php 
	$id_prodi = $this->input->get('id_prodi');
	$periode = $this->input->get('periode');

	$this->db->where('id_prodi', $id_prodi);
	$this->db->where('kode_semester', $periode);
	foreach ($this->db->get('krs')->result() as $rw) {
	 ?>
	<tr>
		<td><?php echo $rw->nim ?></td>
		<td><?php echo get_data('mahasiswa','nim',$rw->nim,'nama') ?></td>
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
		<td><?php echo get_data('prodi','id_prodi',$rw->id_prodi,'kode_prodi') ?></td>
	</tr>
	<?php } ?>
</table>

<?php } ?>