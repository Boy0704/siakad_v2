

<html>

<head>
	<title>Cetak Laporan Transkip Nilai Mahasiswa</title>
	<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
	<link href="http://stmikmpb.gofeedercloud.com/application/assets/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="http://stmikmpb.gofeedercloud.com/application/assets/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
				<p class="navbar-brand">Cetak Laporan Transkip Nilai Mahasiswa</p>
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
			margin-right: 15%;
			width: 70%;
		}

		.table-set {
			margin-left: 15%;
			width: 70%;
		}

		.table-set td,
		th {
			padding: 5px;
			font-weight: bold;
		}

		.table-name {
			width: 70%;
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
			margin-right: 0%;
			width: 100%;
		}

		.table-set {
			margin-left: 0%;
			width: 100%;
		}

		.table-set td,
		th {
			padding: 5px;
			font-weight: bold;
		}

		.table-name {
			width: 100%;
		}

	}
</style>

<?php
$nim = $this->uri->segment(3);

if ($this->session->userdata('level') == 5) {
	$nim = $this->session->userdata('username');
}
$id_prodi = get_data('mahasiswa','nim',$nim,'id_prodi');

?>

<table align="center" class="table-name">
	<tr>
		<td align="center" colspan="8" style="font-size: 16px;">
			<strong>TRANSKIP NILAI MAHASISWA</strong>
		</td>
	</tr>
	<tr>
		<td colspan="8">&nbsp</td>
	</tr>
	<tr>
		<td align="left" width="20%" colspan="2"><strong>Nama Mahasiswa</strong></td>
		<td align="left" width="30%" colspan="2"><strong>:</strong> <?php echo get_data('mahasiswa','nim',$nim,'nama') ?></td>
		<td align="left" width="20%" colspan="2"><strong>NIM</strong></td>
		<td align="left" colspan="2"><strong>:</strong> <?php echo $nim ?></td>
	</tr>
	<tr>
		<td align="left" colspan="2"><strong>Program Studi</strong></td>
		<td align="left" colspan="2"><strong>:</strong> <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?></td>

	</tr>
</table>
<br>
	
	<?php
	$this->db->where('nim', $nim);
    $this->db->group_by('kode_semester');
    $this->db->order_by('kode_semester','asc');
    $semester = $this->db->get('krs');
	 foreach ($semester->result() as $smt): ?>
		
	

		<table class="table table-bordereds" align="center">
			<tr>
				<td height="20px" colspan="8" style="vertical-align:middle" align="center"><strong>Periode :</strong> <?php echo get_data('tahun_akademik','kode_tahun',$smt->kode_semester,'keterangan') ?></td>
			</tr>
			<tr>
				<th rowspan="2" width="5%" style="vertical-align:middle">No</th>
				<th rowspan="2" width="13%" style="vertical-align:middle">Kode Mata Kuliah</th>
				<th rowspan="2" style="vertical-align:middle">Nama Mata Kuliah</th>
				<th rowspan="2" width="5%" style="vertical-align:middle">SKS</th>
				<th colspan="3" width="15%">Nilai</th>
				<th rowspan="2" width="10%" style="vertical-align:middle">SKS * Indeks</th>
			</tr>
			<tr>
				<th>Angka</th>
				<th>Huruf</th>
				<th>Indeks</th>
			</tr>

				<?php 
				$no=1;
		        $sks_total = 0;
		        $total_s_in = 0;
		        $ips = 0;
	        	$this->db->where('kode_semester', $smt->kode_semester);
	        	$this->db->where('nim', $nim);
				foreach ($this->db->get('krs')->result() as $br): ?>
					
				
			
					<tr>
						<td align="right"><?php echo $no ?></td>
						<td align="center"><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'kode_mk') : $br->kode_mk ?></td>
						<td align="left"><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'nama_mk') : $br->nama_mk ?></td>
						<td align="right"><?php $sks = ($br->id_mk !='') ?get_data('matakuliah','id_mk',$br->id_mk,'sks_total') : $br->sks;
            			echo $sks;
            			$sks_total = $sks_total + $sks; ?></td>
						<td align="right"><?php echo $br->angka ?></td>
						<td align="right"><?php echo $br->huruf ?>  </td>
						<td align="right"><?php echo $br->indeks ?></td>
						<td style="text-align:right">
							<?php 
		            		$jml = $br->sks*$br->indeks; 
		            		echo $jml;
		            		$total_s_in = $total_s_in + $jml;
		            		?>
						</td>
					</tr>

				<?php $no++; endforeach ?>
				
					
									<tr>
					<td colspan="3" align="right"><strong>Jumlah</strong></td>
					<td style="text-align:right"><?php echo $sks_total ?></td>
					<td colspan="3"></td>
					<td style="text-align:right">
						<?php 
		        		echo $total_s_in;
		        		$ips = $total_s_in/$sks_total;
		        		 ?>
					</td>
				</tr>
				<tr>
					<td colspan="7" align="right"><strong>IPS ( Indeks Prestasi Semester )</strong></td>
					<th style="text-align:right">
						<?php echo number_format($ips,2) ?>
					</th>
				</tr>

		</table>

		<?php  endforeach ?>
							
				<table class="table-set">
	<tr>
		<td width="30%" colspan="2">Total SKS Diambil</td>
		<td width="15%">: &emsp; <?php echo sks_total($nim,$smt->kode_semester) ?> SKS</td>
		<td colspan="5"></td>
	</tr>
	<tr>
		<td width="30%" colspan="2">IPK ( Indeks Prestasi Kumulatif )</td>
		<td width="15%">: &emsp; <?php echo number_format(ipk($nim,$smt->kode_semester),2) ?></td>
		<td colspan="5"></td>
	</tr>
</table>
<br />
<br />
<table class="table-sign" align="right">
	<tr>
		<td colspan="4"></td>
		<td align="center" width="30%" colspan="4"><?php echo get_data('setting','id_setting','1','alamat') ?>, <?php echo date('d-m-Y') ?> </td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td align="center" colspan="4"></td>
	</tr>
	<tr>
		<!-- <td align="center"> - </td> -->
		<td colspan="4"></td>
		<td colspan="4"></td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td align="center" style="border-bottom: 1px solid #000" colspan="4">
			<strong></strong>
		</td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td align="center" colspan="4"></td>
	</tr>
</table>

</body>

</html>