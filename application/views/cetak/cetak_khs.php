

<html>

<head>
	<title>Cetak Laporan KHS Mahasiswa</title>
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
				<p class="navbar-brand">Cetak Laporan KHS Mahasiswa</p>
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
	<br />
<style type="text/css">
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
			width: 20%;
			margin-right: 15%;
		}

		.table-name {
			width: 70%;
		}

		.batas {
			width: 70%;
			margin: auto;
			font-style: italic;
			font-size: 14px;
		}
	}

	@media print {
		@page {
			size: A4 portrait landscape;
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
			width: 35%;
			margin-right: 0%;
		}

		.table-name {
			width: 100%;
		}

		.batas {
			width: 100%;
			margin: auto;
			font-style: italic;
			font-size: 12px;
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
			<td align="center" colspan="8" style="font-size: 16px;">
				<strong>KARTU HASIL STUDI (KHS)</strong>
			</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp</td>
		</tr>
		<tr>
			<td align="left" width="20%" colspan="2"><strong>Nama Mahasiswa</strong></td>
			<td align="left" width="30%" colspan="2"><strong>:</strong> <?php echo $data_mhs->nama ?></td>
			<td align="left" width="20%" colspan="2"><strong>NIM</strong></td>
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
			<td align="left" colspan="2"><strong>:</strong> <?php echo get_semester($nim,$kode_semester) ?></td>
		</tr>
	</table>

	<br>

	
		<table class="table table-bordereds" border="1|0" align="center">
			<thead>
				<tr class="info">
					<th rowspan="2" style="vertical-align:middle;">No.</th>
					<th rowspan="2" style="vertical-align:middle;">Kode Mata Kuliah</th>
					<th rowspan="2" style="vertical-align:middle;">Nama Mata Kuliah</th>
					<th rowspan="2" style="vertical-align:middle;">SKS</th>
					<th colspan="3" style="text-align: center;">Nilai</th>
					<th rowspan="2" style="vertical-align:middle; text-align: center;">SKS * Indeks</th>
				</tr>
				<tr class="info">
					<th style="vertical-align:middle; text-align: center;">Angka</th>
					<th style="vertical-align:middle; text-align: center;">Huruf</th>
					<th style="vertical-align:middle; text-align: center;">Indeks</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				$sks_total = 0;
		        $total_s_in = 0;
		        $ips = 0;
				foreach ($data_krs->result() as $br): ?>
					
					<tr>
						<td align="right"><?php echo $no; ?></td>
						<td align="center"><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'kode_mk') : $br->kode_mk ?></td>
						<td align="left"><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'nama_mk') : $br->nama_mk ?></td>
						<td align="right"><?php $sks = ($br->id_mk !='') ?get_data('matakuliah','id_mk',$br->id_mk,'sks_total') : $br->sks;
            			echo $sks;
            			$sks_total = $sks_total + $sks;
            		 ?></td>
						<td align="right"><?php echo $br->angka ?></td>
						<td align="center"><?php echo $br->huruf ?></td>
						<td align="right"><?php echo $br->indeks ?></td>
						<td style="text-align:right"><?php 
            		$jml = $br->sks*$br->indeks; 
            		echo $jml;
            		$total_s_in = $total_s_in + $jml;
            		?></td>
					</tr>

				<?php $no++; endforeach ?>
							
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" align="right"><strong>Total SKS</strong></td>
						<td style="text-align:right"><strong><?php echo $sks_total ?></strong></td>
						<td colspan="3"></td>
						<td style="text-align:right"><?php 
		        		echo $total_s_in;
		        		$ips = $total_s_in/$sks_total;
        		 ?></td>
					</tr>
					<tr>
						<td colspan="7" align="right"><strong>IPS ( Indeks Prestasi Semester )</strong></td>
						<th style="text-align:right"><?php echo number_format($ips,2) ?></th>
					</tr>
					<tr>
						<td colspan="7" align="right"><strong>IPK ( Indeks Prestasi Kumulatif )</strong></td>
						<th style="text-align:right"><?php echo number_format(ipk($nim,$kode_semester),2) ?></th>
					</tr>
				</tfoot>

			
		</table>

		<!-- <div class="batas">Batas SKS yang bisa diambil di semester berikutnya adalah <b>24 SKS</b></div> -->
		<br />

		<table class="table-sign" width="35%" align="right">
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td align="center"><?php echo get_data('setting','id_setting','1','alamat') ?>, <?php echo date('d-m-Y') ?> </td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td align="center"><?php echo get_data('tanda_tangan','id_tanda_tangan',2,'judul_atas') ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<!-- <td align="center"> - </td> -->
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td align="center" style="border-bottom: 1px solid #000">
					<strong><?php echo get_data('tanda_tangan','id_tanda_tangan',2,'nama') ?></strong>
				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td align="center"><?php echo get_data('tanda_tangan','id_tanda_tangan',2,'bawah_nama') ?></td>
				<td></td>
			</tr>
		</table>

	</body>

</html>