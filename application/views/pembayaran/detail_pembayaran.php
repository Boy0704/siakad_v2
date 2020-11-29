<?php 
$head = $this->db->get_where('pembayaran', array('id_pembayaran'=>$this->uri->segment(3)))->row();
$id_prodi = get_data('mahasiswa','nim',$head->nim,'id_prodi');
 ?>

<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-lightred">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>
            <div class="widget-body">
            	<center>
            		<h3>Detail Pembayaran</h3>
            	</center>
            	<table class="table table-bordered">
            		<tr>
            			<td>Nim</td>
            			<td><?php echo $head->nim ?></td>
            			<td>Tanggal Bayar</td>
            			<td><?php echo $head->tanggal_bayar ?></td>
            		</tr>
            		<tr>
            			<td>Nama</td>
            			<td><?php echo get_data('mahasiswa','nim',$head->nim,'nama') ?></td>
            			<td>Periode</td>
            			<td><?php echo $head->kode_semester ?></td>
            		</tr>
            		<tr>
            			<td>Prodi</td>
            			<td><?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?></td>
            			<td colspan="2"></td>
            		</tr>
            	</table>
            	<br>
                <table class="table table-hover table-striped table-bordered">
                    <thead class="bordered-blueberry">
                        <tr>
                            <th width="50">No.</th>
                            <th>Nama Biaya</th>
                            <th>Nilai</th>
                            <th>Potongan</th>
                            <th width="100">Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php 
					$no = 1;
					$total = 0;
					$this->db->where('id_pembayaran', $this->uri->segment(3));
					foreach ($this->db->get('pembayaran_detail')->result() as $rw): ?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo get_data('biaya','id_biaya',$rw->id_biaya,'nama_biaya') ?></td>
							<td><?php echo number_format($rw->nilai) ?></td>
							<td><?php echo number_format(hitung_potogan($head->nim,$rw->id_biaya,$rw->nilai,$rw->qty)) ?></td>
							<td><?php echo $rw->qty ?></td>
							<td><?php echo number_format($rw->subtotal); $total = $total + $rw->subtotal ?></td>
						</tr>
					<?php $no++; endforeach ?>
					<tr>
						<td colspan="5"><b>Total</b></td>
						<td><h3><b><?php echo number_format($total) ?></b></h3></td>
					</tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>