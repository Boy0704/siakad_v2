

<html>

<head>
	<title>Cetak Laporan KRS</title>
	<base href="<?php echo base_url() ?>">
	<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
	<link href="assets/css/font-awesome.min.css" rel="stylesheet" />
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<style>
		body {
			margin: 0 auto;
		}

		body,
		td,
		th {
			font-family: 'Source Sans Pro', sans-serif;
			font-size: 12px;
		}

		th {
			text-align: center;
		}

		.nama_pt {
			font-size: 20px;
			font-weight: bold;
			line-height: 1.1;
			vertical-align: middle;
			text-align: center;
		}

		.info_pt {
			vertical-align: middle;
			text-align: center;
		}

		.kop {
			border-spacing: 0;
			border-collapse: collapse;
			border-bottom-style: double;
		}

		.side {
			width: 8%;
		}

		.img {
			width: 80px;
		}

		@media screen {
			.kop-width {
				width: 70%;
			}
		}

		@media print {
			.kop-width {
				width: 100%;
			}
		}

		@media screen {


			.kop-logo {
				width: 70%;
				margin: 0 auto;
			}

			.kop-logo img {
				width: 100%;
			}
			.custom-kop-html table{
				width: 70% !important;
				text-align: center !important;
			}
		}

		@media print {

			.kop-logo {
				width: 100% !important;
			}

			.kop-logo img {
				width: 100%;
			}
		}
	</style>
</head>

<body>
			<nav class="navbar navbar-default">
			<div class="container">
				<p class="navbar-brand">Cetak Laporan KRS</p>
				<button type="button" class="btn btn-primary btn-flat navbar-btn navbar-right" onclick="window.print(); return false;"><i class="fa fa-print"></i> Cetak</button>
			</div>
		</nav>

	

				<table width="70%" align="center" class="kop kop-width">
			<tr>
				<td class="side"></td>
				<td class="img" rowspan="3">
											<img src="image/<?php echo get_data('setting','id_setting','1','logo') ?>" alt="logo" class="logo-default" height="80">
									</td>
				<td colspan="5" class="nama_pt">
					<!-- STMIK MUHAMMADIYAH PAGUYANGAN BREBES -->
					STMIK MUHAMMADIYAH PAGUYANGAN BREBES				</td>
				<td class="side"></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="5" class="info_pt">
					<!-- Alamat : Jalan Raya Paguyangan KM.01 Paguyangan -->
					Alamat : Jalan Raya Paguyangan KM.01 Paguyangan				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="5" class="info_pt">
					<!-- Kodepos : 52276, Telepon : 02894403691 -->
					Kodepos : 52276, 					Telepon : 02894403691				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td colspan="5" style="border-bottom:1px solid black; padding-bottom: 8px;" class="info_pt">
					<!-- Website : stmikmpb.ac.id, Email : cs@stmikmpb.ac.id, Faximile : 02894403691 -->
					Website : stmikmpb.ac.id | 					Email : cs@stmikmpb.ac.id | 					Faximile : 02894403691				</td>
				<td></td>
			</tr>
		</table>
	<br/>
<style type="text/css">
@media screen{
	.table-name{
		width: 70%;
	}
	.table-bordereds{
		border-collapse: collapse;
		width: 70%;
	}
	.table-bordereds td,
	.table-bordereds th {
	    border: 1px solid #000!important;
	}

	.table-sign{
		width: 70%;
		margin-right: 15%;
	}
}
@media print{
	@page{
		size: A4 portrait landscape;
	}
	.table-bordereds{
		border-collapse: collapse;
		width: 100%;
	}
	.table-bordereds td,
	.table-bordereds th {
	    border: 1px solid #000!important;
	}

	.table-sign{
		width: 100%;
		margin-right: 0%;
	}

	.table-name{
		width: 100%;
	}
}
</style>

<?php 
$nim = $this->uri->segment(3);
$kode_semester = $this->uri->segment(4);
$this->db->where('nim', $nim);
$data_mhs = $this->db->get('mahasiswa')->row();

?>
<table align="center" class="table-name">
    <tr>
        <td align="center" colspan="8" style="font-size: 16px;">
        	<strong><u>KARTU RENCANA STUDI (KRS)</u></strong>
        </td>
    </tr>
    <tr>
    	<td colspan="8">&nbsp</td>
    </tr>
    <tr>
        <td align="left" width="20%" colspan="2" ><strong>Nama Mahasiswa</strong></td>
        <td align="left" width="30%" colspan="2"><strong>:</strong> <?php echo $data_mhs->nama ?></td>
        <td align="left" width="20%" colspan="2" ><strong>NIM</strong></td>
        <td align="left" colspan="2"><strong>:</strong> <?php echo $data_mhs->nim ?></td>
    </tr>
    <tr>
        <td align="left" colspan="2"><strong>Program Studi</strong></td>
        <td align="left" colspan="2"><strong>:</strong> <?php echo get_data('prodi','id_prodi',$data_mhs->id_prodi,'jenjang') ?> - <?php echo get_data('prodi','id_prodi',$data_mhs->id_prodi,'prodi') ?></td>
		        <td align="left" colspan="2"><strong>Periode</strong></td>
        <td align="left" colspan="2"><strong>:</strong> <?php echo get_data('tahun_akademik','kode_tahun',$kode_semester,'keterangan') ?></td>
		    </tr>
		<tr>
				<td align="left" colspan="2"><strong>Semester</strong></td>
				<td align="left" colspan="2"><strong>:</strong>
											<?php echo get_semester($nim,$kode_semester) ?>									</td>
		</tr>
</table>
<br>
<table class="table table-bordereds" width="80%" border="1|0" style="border-collapse: collapse;" align="center">
	<tr>
		<th rowspan="2" style="vertical-align:middle;">No</th>
		<th rowspan="2" style="vertical-align:middle;">Kode MK</th>
		<th rowspan="2" style="vertical-align:middle;">Nama MK</th>
		<th rowspan="2" style="vertical-align:middle;">Dosen Pengajar</th>
		<th rowspan="2" style="vertical-align:middle;">SKS</th>
		<th rowspan="2" style="vertical-align:middle;">Kelas</th>
		<th colspan="3" style="text-align: center;">Jadwal Perkuliahan</th>
	</tr>
	<tr>
        <th style="vertical-align:middle;">Ruang</th>
        <th style="vertical-align:middle;">Hari</th>
        <th style="vertical-align:middle;">Waktu</th>
    </tr>
    <?php 
    $no = 1;
    $sks_total = 0;
    $this->db->where('nim', $nim);
    $this->db->where('kode_semester', $kode_semester);
    foreach ($this->db->get('krs')->result() as $rw): ?>
    	
		<tr>
			<td align="center"><?php echo $no ?></td>
			<td align="center"><?php echo $rw->kode_mk ?></td>
			<td align="left"><?php echo $rw->nama_mk ?></td>
			<td align="left"><?php echo $rw->nama_dosen ?></td>
			<td align="center"><?php echo $rw->sks; $sks_total = $sks_total+$rw->sks ?></td>
			<td align="center"><?php echo $rw->kelas ?></td>
			        <td align="center"><?php echo $ruang = ($rw->id_jadwal !='') ? get_data('jadwal_kuliah','id_jadwal',$rw->id_jadwal,'ruang') : '' ; ?></td>
	        <td align="center"><?php echo $ruang = ($rw->id_jadwal !='') ? get_data('jadwal_kuliah','id_jadwal',$rw->id_jadwal,'hari') : '' ; ?></td>
	        <td align="center"><?php echo $ruang = ($rw->id_jadwal !='') ? get_data('jadwal_kuliah','id_jadwal',$rw->id_jadwal,'jam_mulai').' - '.get_data('jadwal_kuliah','id_jadwal',$rw->id_jadwal,'jam_selesai') : '' ; ?></td>
		</tr>
	<?php $no++; endforeach ?>
		
		<tr>
		<td colspan="4" align="right"><strong>Jumlah</strong></td>
		<td align="center"><?php echo $sks_total ?></td>
		<td colspan="4"></td>
	</tr>
</table>
<br />
<table class="table-sign" align="right">
	<tr>
		<td width="35%" align="center" colspan="3"></td>
		<td width="10%"></td>
		<td width="10%"></td>
		<td width="10%"></td>
		<td align="center" width="35%" colspan="2"><?php echo get_data('setting','id_setting','1','alamat') ?>, <?php echo date('d-m-Y') ?> </td>
	</tr>
	<tr>
		<td align="center" colspan="3">Mahasiswa</td>
		<td></td>
		<td></td>
		<td></td>
		<td align="center" colspan="2">Pembimbing Akademik</td>
	</tr>
	<!-- <tr>
		<td align="center" colspan="3">Penasehat Akademik</td>
		<td></td>
		<td></td>
		<td></td>
		<td align="center" colspan="2">BAAK</td>
	</tr> -->
	<tr>
		<td align="center" colspan="3"></td>
		<td></td>
		<td></td>
		<td></td>
		<!-- <td align="center"> - </td> -->
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td align="center"></td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td align="center"></td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td align="center"></td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td>&nbsp;</td>

		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" style="border-bottom: 1px solid #000" colspan="3">
			<strong><?php echo $data_mhs->nama ?></strong>
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td align="center" style="border-bottom: 1px solid #000" colspan="2">
			<strong><?php echo get_data('dosen','id_dosen',$data_mhs->dosen_pa,'nama') ?></strong>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="3"><?php echo $data_mhs->nim ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="center" colspan="2"><?php echo get_data('dosen','id_dosen',$data_mhs->dosen_pa,'nidn') ?></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td align="center" colspan="3"><?php echo get_data('tanda_tangan','id_tanda_tangan',1,'judul_atas') ?></td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td align="center" style="border-bottom: 1px solid #000" colspan="3">
			<strong><?php echo get_data('tanda_tangan','id_tanda_tangan',1,'nama') ?></strong>
		</td>
		<td align="center" colspan="2"></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td align="center" colspan="3"><?php echo get_data('tanda_tangan','id_tanda_tangan',1,'bawah_nama') ?></td>
		<td align="center" colspan="2"></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
</body>
</html>
