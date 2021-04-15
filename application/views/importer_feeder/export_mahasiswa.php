<?php 
if ($_GET) {
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Export_Mahasiswa_Feeder.xls");
 ?>

<table border="1">
	<tr>
		<td style="background-color: red">NIM</td>
		<td style="background-color: red">NAMA</td>
		<td style="background-color: red">TEMPAT LAHIR</td>
		<td style="background-color: red">TANGGAL LAHIR</td>
		<td style="background-color: red">JENIS KELAMIN</td>
		<td style="background-color: red">NIK</td>
		<td style="background-color: red">AGAMA</td>
		<td>NISN</td>
		<td>JALUR PENDAFTARAN</td>
		<td>NPWP</td>
		<td style="background-color: red">KEWARGANEGARAAN</td>
		<td style="background-color: red">JENIS PENDAFTARAN</td>
		<td style="background-color: red">TANGGAL MASUK KULIAH</td>
		<td style="background-color: red">MULAI SEMESTER</td>
		<td>JALAN</td>
		<td>RT</td>
		<td>RW</td>
		<td>NAMA DUSUN</td>
		<td style="background-color: red">KELURAHAN</td>
		<td style="background-color: red">KECAMATAN</td>
		<td>KODE POS</td>
		<td>JENIS TINGGAL</td>
		<td>ALAT TRANSPORTASI</td>
		<td>TELP RUMAH</td>
		<td>NO HP</td>
		<td>EMAIL</td>
		<td style="background-color: red">TERIMA KPS</td>
		<td>NO KPS</td>
		<td>NIK AYAH</td>
		<td>NAMA AYAH</td>
		<td>TGL LAHIR AYAH</td>
		<td>PENDIDIKAN AYAH</td>
		<td>PEKERJAAN AYAH</td>
		<td>PENGHASILAN AYAH</td>
		<td>NIK IBU </td>
		<td style="background-color: red">NAMA IBU</td>
		<td>TGL LAHIR IBU</td>
		<td>PENDIDIKAN IBU</td>
		<td>PEKERJAAN IBU</td>
		<td>PENGHASILAN IBU</td>
		<td>NAMA WALI</td>
		<td>TANGGAL LAHIR WALI</td>
		<td>PENDIDIKAN WALI</td>
		<td>PEKERJAAN WALI</td>
		<td>PENGHASILAN WALI</td>
		<td style="background-color: red">KODE PRODI</td>
		<td>JENIS PEMBIAYAAN</td>
		<td>JUMLAH BIAYA MASUK</td>
	</tr>
	<?php 
	$id_prodi = $this->input->get('id_prodi');
	$id_tahun_angkatan = $this->input->get('angkatan');

	
	$this->db->where('id_prodi', $id_prodi);
	$this->db->where('id_tahun_angkatan', $id_tahun_angkatan);
	foreach ($this->db->get('mahasiswa')->result() as $rw) {
	 ?>
	<tr>
		<td><?php echo $rw->nim ?></td>
		<td><?php echo $rw->nama ?></td>
		<td><?php echo $rw->tempat_lahir ?></td>
		<td><?php echo $rw->tanggal_lahir ?></td>
		<td><?php echo $rw->jenis_kelamin ?></td>
		<td><?php echo $rw->nik ?></td>
		<td><?php echo $rw->agama ?></td>
		<td><?php echo $rw->nisn ?></td>
		<td><?php echo $rw->jalur_pendaftaran ?></td>
		<td><?php echo $rw->npwp ?></td>
		<td><?php echo $rw->kewarganegaraan ?></td>
		<td><?php echo $rw->jenis_pendaftaran ?></td>
		<td><?php echo $rw->tanggal_masuk_kuliah ?></td>
		<td><?php echo $rw->mulai_semester; ?></td>
		<td><?php echo $rw->jalan; ?></td>
		<td><?php echo $rw->rt ?></td>
		<td><?php echo $rw->rw ?></td>
		<td><?php echo $rw->dusun ?></td>
		<td><?php echo $rw->kelurahan ?></td>
		<td><?php echo $rw->kecamatan; ?></td>
		<td><?php echo $rw->kode_pos; ?></td>
		<td><?php echo $rw->jenis_tinggal; ?></td>
		<td><?php echo $rw->alat_transportasi; ?></td>
		<td><?php echo $rw->telp_rumah; ?></td>
		<td><?php echo $rw->no_hp; ?></td>
		<td><?php echo $rw->email; ?></td>
		<td><?php echo $rw->terima_kps; ?></td>
		<td><?php echo $rw->no_kps; ?></td>
		<td><?php echo $rw->nik_ayah; ?></td>
		<td><?php echo $rw->nama_ayah; ?></td>
		<td><?php echo $rw->tanggal_lahir_ayah; ?></td>
		<td><?php echo $rw->pendidikan_ayah; ?></td>
		<td><?php echo $rw->pekerjaan_ayah; ?></td>
		<td><?php echo $rw->penghasilan_ayah; ?></td>
		<td><?php echo $rw->nik_ibu; ?></td>
		<td><?php echo $rw->nama_ibu ?></td>
		<td><?php echo $rw->tanggal_lahir_ibu; ?></td>
		<td><?php echo $rw->pendidikan_ibu; ?></td>
		<td><?php echo $rw->pekerjaan_ibu; ?></td>
		<td><?php echo $rw->penghasilan_ibu; ?></td>
		<td><?php echo $rw->nama_wali; ?></td>
		<td><?php echo $rw->tanggal_lahir_wali; ?></td>
		<td><?php echo $rw->pendidikan_wali; ?></td>
		<td><?php echo $rw->pekerjaan_wali; ?></td>
		<td><?php echo $rw->penghasilan_wali; ?></td>
		<td><?php echo get_data('prodi','id_prodi',$rw->id_prodi,'kode_prodi') ?></td>
		<td><?php echo $rw->jenis_pembiayaan; ?></td>
		<td><?php echo $rw->jumlah_biaya_masuk; ?></td>
	</tr>
	<?php } ?>
</table>

<?php } ?>