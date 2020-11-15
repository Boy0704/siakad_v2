

<html>

<head>
	<title>Kartu Ujian Mahasiswa <?php echo $jenis_ujian ?></title>
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
				<p class="navbar-brand">Kartu Ujian Mahasiswa <?php echo strtoupper($jenis_ujian) ?></p>
				<button type="button" class="btn btn-primary btn-flat navbar-btn navbar-right" onclick="window.print(); return false;"><i class="fa fa-print"></i> Cetak</button>
			</div>
		</nav>
				<table width="70%" align="center" class="kop kop-width">
			<tr>
				<td class="side"></td>
				<td class="img" rowspan="3">
											<img src="http://stmikmpb.gofeedercloud.com/uploads/063101/logoPT.png" alt="logo" class="logo-default" height="80">
									</td>
				<td colspan="2" class="nama_pt">
					<!-- STMIK MUHAMMADIYAH PAGUYANGAN BREBES -->
					STMIK MUHAMMADIYAH PAGUYANGAN BREBES				</td>
				<td class="side"></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2" class="info_pt">
					<!-- Alamat : Jalan Raya Paguyangan KM.01 Paguyangan -->
					Alamat : Jalan Raya Paguyangan KM.01 Paguyangan				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2" class="info_pt">
					<!-- Kodepos : 52276, Telepon : 02894403691 -->
					Kodepos : 52276, 					Telepon : 02894403691				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td colspan="2" style="border-bottom:1px solid black; padding-bottom: 8px;" class="info_pt">
					<!-- Website : stmikmpb.ac.id, Email : cs@stmikmpb.ac.id, Faximile : 02894403691 -->
					Website : stmikmpb.ac.id | 					Email : cs@stmikmpb.ac.id | 					Faximile : 02894403691				</td>
				<td></td>
			</tr>
		</table>
	<br />
<style type="text/css">
	.border-foto {
		width: 113px;
		height: 151px;
		border: 1px solid #000;
	}

	.foto-mhs {
		width: 113px;
		height: 151px;
	}

	@media screen {
		.table-bordereds {
			border-collapse: collapse;
			width: 70%;
		}

		.table-bordereds td,
		.table-bordereds th {
			border: 1px solid #000 !important;
		}

		.table-sign {
			width: 70%;
		}

		.table-sign td {
			width: 20%;
		}

		.foto {
			width: 80% !important;
		}

		.table-name {
			width: 70%;
		}
	}

	@media print {
		@page {
			size: A4 portrait landscape;
		}

		.foto {
			width: 80% !important;
		}

		.table-bordereds {
			border-collapse: collapse;
			width: 100%;
		}

		.table-bordereds td,
		.table-bordereds th {
			border: 1px solid #000 !important;
		}

		.table-sign {
			width: 100%;
		}

		.table-sign td {
			width: 30%;
		}

		.table-name {
			width: 100%;
		}
	}
</style>
<?php 
$this->db->where('nim', $nim);
$data_mhs = $this->db->get('mahasiswa')->row();

$this->db->where('nim', $nim);
$this->db->where('kode_semester', $kode_semester);
$data_krs = $this->db->get('krs');

 ?>
				<table align="center" class="table-name">
			<tr>
				<td align="center" colspan="4" style="font-size: 16px;">
					<strong><u>KARTU UJIAN MAHASISWA <?php echo strtoupper($jenis_ujian) ?></u></strong>
				</td>
			</tr>
			<tr>
				<td>&nbsp</td>
			</tr>
			<tr>
				<td align="left" width="15%"><strong>NIM</strong></td>
				<td align="left" width="30%"><strong>:</strong> <?php echo $data_mhs->nim ?></td>

									<td align="left"><strong>Periode</strong></td>
					<td align="left"><strong>:</strong> <?php echo get_data('tahun_akademik','kode_tahun',$kode_semester,'keterangan') ?></td>
							</tr>
			<tr>
				<td align="left" width="25%"><strong>Nama Mahasiswa</strong></td>
				<td align="left" width="45%"><strong>:</strong> <?php echo $data_mhs->nama ?></td>
				<!-- <td align="left" ><strong>Nomor Ujian</strong></td>
			<td align="left" ><strong>:</strong></td> -->
				<td align="left"><strong>Jumlah MK diujiankan</strong></td>
				<td align="left"><strong>:</strong> <?php echo $data_krs->num_rows() ?> Mata Kuliah</td>
			</tr>
		</table>
		<br>
		<table class="table table-bordereds" border="1|0" align="center">
			<tr>
				<th rowspan="2" style="vertical-align:middle;" width="5%">No</th>
				<th rowspan="2" style="vertical-align:middle;" width="15%">Kode MK</th>
				<th rowspan="2" style="vertical-align:middle;">Nama Mata Kuliah</th>
				<th rowspan="2" style="vertical-align:middle;">SKS</th>
				<th rowspan="2" style="vertical-align:middle;">Nama Kelas</th>
				<th rowspan="2" style="vertical-align:middle;">Tanda Tangan Pengawas</th>
				<th rowspan="2" style="vertical-align:middle;">Hari dan Tanggal</th>
				<th rowspan="2" style="vertical-align:middle;" width="10%">Jam</th>
			</tr>
			<tr>
			</tr>
			<?php 
			$no = 1;
			$sks_total = 0;
			foreach ($data_krs->result() as $br): ?>
				
			
				<tr>
					<td align="center"><?php echo $no; ?></td>
					<td align="center"><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'kode_mk') : $br->kode_mk ?></td>
					<td align="left"><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'nama_mk') : $br->nama_mk ?></td>
					<td align="center"><?php $sks = ($br->id_mk !='') ? get_data('matakuliah','id_mk',$br->id_mk,'sks_total') : $br->sks ;
            			echo $sks;
            			$sks_total = $sks_total + $sks;
            		 ?></td>
					<td align="center"><?php echo ($br->id_jadwal != '') ? get_data('jadwal_kuliah','id_jadwal',$br->id_jadwal,'kelas') : $br->kelas ?></td>
					<td align="center"></td>
					<td align="center"></td>
					<td align="center"></td>
				</tr>
			<?php $no++; endforeach ?>
				
			<tr>
				<td colspan="3" align="center"><strong>Total</strong></td>

				<td align="center"><strong><?php echo $sks_total ?></strong></td>
				<td colspan="4"></td>
			</tr>
		</table>
		<br />
				<table class="table-sign" align="center">
			<tr style="height:20px;">
				<td align="center" colspan="1"></td>
				<td colspan="1" align="right" rowspan="8" class="foto">
											<div class="border-foto">
							<p style="text-align: center; padding-top: 10%;">Foto 3x4</p>
						</div>
									</td>
			</tr>
			<tr style="height:20px;">
				<td align="center" colspan="1"><?php echo get_data('setting','id_setting','1','alamat') ?>, <?php echo date('d-m-Y') ?>  </td>
				<td colspan="1" align="right">

				</td>
			</tr>
			<tr style="height:20px;">
				<td align="center" colspan="1">BAAK</td>
				<td colspan="1"></td>
			</tr>
			<tr style="height:20px;">
				<td colspan="1">&nbsp;</td>
				<td colspan="1"></td>
			</tr>
			<tr style="height:20px;">
				<td colspan="1">&nbsp;</td>
				<td colspan="1"></td>
			</tr>
			<tr style="height:20px;">
				<td colspan="1">&nbsp;</td>
				<td colspan="1"></td>
			</tr>
			<tr style="height:20px;">
				<td colspan="1">&nbsp;</td>
				<td colspan="1"></td>
			</tr>
			<tr>
				<td align="center" style="border-bottom: 1px solid #000" colspan="1">
										<strong>Nama BAAK</strong>
					<!--_______-->
				</td>
				<td colspan="1"></td>
			</tr>
			<tr>
				<td align="center" colspan="1">No Pegawai</td>
				<td colspan="1"></td>
			</tr>

		</table>
	
</body>

</html>
<div></div>