<html>

<head>
	<title>Cetak SLIP</title>
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
			padding-left: 10px;
		}

		.info_pt {
			vertical-align: middle;
			padding-left: 10px;
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
				/*text-align: center !important;*/
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

<?php 
$id_pembayaran = $this->uri->segment(3);
$head = $this->db->get_where('pembayaran', array('id_pembayaran'=>$id_pembayaran))->row();
$id_prodi = get_data('mahasiswa','nim',$head->nim,'id_prodi');
$total = $this->db->query("SELECT SUM(subtotal) as total FROM pembayaran_detail WHERE id_pembayaran='$id_pembayaran'")->row()->total;
 ?>

<nav class="navbar navbar-default">
	<div class="container">
		<p class="navbar-brand">Cetak Slip Pembayaran</p>
		<button type="button" class="btn btn-primary btn-flat navbar-btn navbar-right" onclick="window.print(); return false;"><i class="fa fa-print"></i> Cetak</button>
	</div>
</nav>
				
	<table cellspacing="0" border="0" align="center">
		<colgroup span="5" width="86"></colgroup>
		<colgroup width="139"></colgroup>
		<tr>
			<td height="40" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><font color="#000000">NO: <?php echo no_urut_slip() ?>/P/<?php echo date('m') ?>/<?php echo date('Y') ?></font></td>
		</tr>
		<tr>
			<td rowspan=3 height="64" align="left" valign=bottom><font color="#000000"><img src="image/<?php echo get_data('setting','id_setting','1','logo') ?>" width=57 height=56 hspace=14 vspace=5>
			</font></td>
			<td colspan=5 align="left"><font color="#000000">Stmik Muhammadiyah Paguyungan Brebes (STMIKMPB)</font></td>
			</tr>
		<tr>
			<td colspan=5 align="left"><font color="#000000">Jl. Raya Paguyuban, Desa Paguyungan, Kec. Paguyungan Brebes</font></td>
			</tr>
		<tr>
			<td colspan=5 align="left"><font color="#000000">Web : www.stmikmpb.ac.id</font></td>
			</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
		</tr>
		<tr>
			<td colspan=2 height="21" align="left" valign=bottom><font color="#000000">Telah terima dari </font></td>
			<td style="border-bottom: 1px solid #000000" align="left" colspan="5"><font color="#000000">: <?php echo $head->nim.' - '.get_data('mahasiswa','nim',$head->nim,'nama') ?></font></td>
		</tr>
		<tr>
			<td colspan=2 height="21" align="left" valign=bottom><font color="#000000">Sejumlah </font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom colspan="5"><font color="#000000">: <?php echo ucwords(terbilang($total)) ?></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom colspan="2"><font color="#000000">Untuk Pembayaran</font></td>
			<?php 
			$this->db->where('id_pembayaran', $id_pembayaran);
			foreach ($this->db->get('pembayaran_detail', 1, 0)->result() as $rw): ?>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom colspan="5"><font color="#000000">: <?php echo get_data('biaya','id_biaya',$rw->id_biaya,'nama_biaya') ?></font></td>
			<?php endforeach ?>
			
		</tr>
		<?php 
		$this->db->where('id_pembayaran', $id_pembayaran);
		foreach ($this->db->get('pembayaran_detail', 20, 1)->result() as $rw): ?>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom colspan="5"><font color="#000000"> &nbsp&nbsp<?php echo get_data('biaya','id_biaya',$rw->id_biaya,'nama_biaya') ?></font></td>
		</tr>
		<?php endforeach ?>

		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
		</tr>

		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="21" align="center" valign=bottom><font color="#000000" style="font-weight: bold;">Rp. <?php echo number_format($total,0,"",".").";-" ?></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000">Paguyangan, <?php echo date('d-m-Y') ?></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><?php echo get_data('tanda_tangan','id_tanda_tangan',4,'judul_atas') ?></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font color="#000000"><?php echo get_data('tanda_tangan','id_tanda_tangan',4,'nama') ?></font></td>
		</tr>
		<tr>
			<td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><br></font></td>
			<td align="left" valign=bottom><font color="#000000"><?php echo get_data('tanda_tangan','id_tanda_tangan',4,'bawah_nama') ?></font></td>
		</tr>
	</table>

</body>
</html>