

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
											<img src="http://stmikmpb.gofeedercloud.com/uploads/063101/logoPT.png" alt="logo" class="logo-default" height="80">
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
        <td align="left" width="30%" colspan="2"><strong>:</strong> Rini Afrisa</td>
        <td align="left" width="20%" colspan="2" ><strong>NIM</strong></td>
        <td align="left" colspan="2"><strong>:</strong> 18.01.0.0034</td>
    </tr>
    <tr>
        <td align="left" colspan="2"><strong>Program Studi</strong></td>
        <td align="left" colspan="2"><strong>:</strong> S1 - Teknik Informatika</td>
		        <td align="left" colspan="2"><strong>Periode</strong></td>
        <td align="left" colspan="2"><strong>:</strong> 2020/2021 Ganjil</td>
		    </tr>
		<tr>
				<td align="left" colspan="2"><strong>Semester</strong></td>
				<td align="left" colspan="2"><strong>:</strong>
											5									</td>
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
		<tr>
		<td align="center">1</td>
		<td align="center">TI31008</td>
		<td align="left">Tata Tulis Karya Ilmiah</td>
		<td align="left"> ELA KRISTI PERMATASARI</td>
		<td align="center">2</td>
		<td align="center">TI B</td>
		        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">
        	-        	<!-- - -->
        </td>
	</tr>
		<tr>
		<td align="center">2</td>
		<td align="center">TI31010</td>
		<td align="left">Proses Bisnis & Pemodelan Sistem</td>
		<td align="left"> SUGIARTO</td>
		<td align="center">3</td>
		<td align="center">TI B</td>
		        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">
        	-        	<!-- - -->
        </td>
	</tr>
		<tr>
		<td align="center">3</td>
		<td align="center">TI31025</td>
		<td align="left">Rekayasa Perangkat Lunak</td>
		<td align="left"> UMAR GHONI</td>
		<td align="center">3</td>
		<td align="center">TI B</td>
		        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">
        	-        	<!-- - -->
        </td>
	</tr>
		<tr>
		<td align="center">4</td>
		<td align="center">TI31039</td>
		<td align="left">Pemrograman Dekstop</td>
		<td align="left"> FAUZAN ISHLAKHUDDIN</td>
		<td align="center">3</td>
		<td align="center">TI B</td>
		        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">
        	-        	<!-- - -->
        </td>
	</tr>
		<tr>
		<td align="center">5</td>
		<td align="center">TI31040</td>
		<td align="left">Pemrograman Web Dinamis</td>
		<td align="left"> MAMUR SETIANAMA</td>
		<td align="center">3</td>
		<td align="center">TI B</td>
		        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">
        	-        	<!-- - -->
        </td>
	</tr>
		<tr>
		<td align="center">6</td>
		<td align="center">TI31041</td>
		<td align="left">Sistem Pendukung Keputusan</td>
		<td align="left"> IIF ALFIATUL MUKAROMAH</td>
		<td align="center">3</td>
		<td align="center">TI B</td>
		        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">
        	-        	<!-- - -->
        </td>
	</tr>
		<tr>
		<td align="center">7</td>
		<td align="center">TI32028</td>
		<td align="left">Metodologoi Penelitian</td>
		<td align="left"> IIF ALFIATUL MUKAROMAH</td>
		<td align="center">2</td>
		<td align="center">TI B</td>
		        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">
        	-        	<!-- - -->
        </td>
	</tr>
		<tr>
		<td align="center">8</td>
		<td align="center">TI32152</td>
		<td align="left">Kriptografi</td>
		<td align="left"> IIF ALFIATUL MUKAROMAH</td>
		<td align="center">3</td>
		<td align="center">TI</td>
		        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">
        	-        	<!-- - -->
        </td>
	</tr>
		<tr>
		<td colspan="4" align="right"><strong>Jumlah</strong></td>
		<td align="center">22</td>
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
		<td align="center" width="35%" colspan="2">Paguyangan, 11 November 2020 </td>
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
			<strong>Rini Afrisa</strong>
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td align="center" style="border-bottom: 1px solid #000" colspan="2">
			<strong>
							</strong>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="3">18.01.0.0034</td>
		<td></td>
		<td></td>
		<td></td>
		<td align="center" colspan="2">
					</td>
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
		<td align="center" colspan="3">BAAK</td>
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
			<strong>Utami Juwita,S.Pd</strong>
		</td>
		<td align="center" colspan="2"></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td align="center" colspan="3">1294310</td>
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
