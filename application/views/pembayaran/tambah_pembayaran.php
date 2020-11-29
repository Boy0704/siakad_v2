<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-lightred">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>
            <div class="widget-body">
                <div id="horizontal-form">
                    <form class="form-horizontal" action="" method="POST" role="form">
                        <div class="form-group">
                            <label for="Nama" class="col-sm-1 control-label no-padding-right">NIM *</label>
                            <div class="col-sm-10">
                                <select name="nim" id="nim" style="width:100%;" required="">
					                <option value="">--Pilih Mahasiswa --</option>
					                <?php 
					                $selected = '';
					                $this->db->where('status_mhs', '1');
					                foreach ($this->db->get('mahasiswa')->result() as $rw): 
					                	if ($_GET) {
					                		$selected = ($_GET['nim'] == $rw->nim) ? 'selected' : '';
					                	}
					                    ?>
					                    <option value="<?php echo $rw->nim ?>" <?php echo $selected ?>><?php echo $rw->nim.' - '.$rw->nama ?></option>
					                <?php endforeach ?>
					            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="periode" class="col-sm-1 control-label no-padding-right">Periode *</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="periode" name="periode" value="<?php echo tahun_akademik_aktif('kode_tahun') ?>" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                        	<div class="col-xs-12 col-md-12" style="margin-bottom: 10px;">
                        		<button class="btn btn-primary" id="btnBiaya"><i class="fa fa-plus"></i> Pilih Biaya</button>
                        		<a class="btn btn-danger" href="pembayaran/delete_detail_all<?php echo ($_GET) ? 
                        		'?'.param_get() : '' ?>"><i class="fa fa-trash"></i> Delete All</a>
                        	</div>
                        	<div class="col-xs-12 col-md-12">
	                            <div class="well with-header">
	                                <div class="header bg-warning">
	                                    Detail Pembayaran
	                                </div>
	                                <table class="table table-bordered table-hover">
	                                    <thead>
	                                        <tr>
	                                            <th width="50">#</th>
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
	                                    $total= 0;
	                                    $no = 1;
	                                    foreach ($this->cart->contents() as $rw): ?>
	                                    	
	                                    	<tr>
	                                    		<td>
	                                    			<a href="pembayaran/delete_detail/<?php echo $rw['rowid'].'?'.param_get() ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
	                                    		</td>
	                                            <td><?php echo $no ?></td>
	                                            <td><?php echo get_data('biaya','id_biaya',$rw['name'],'nama_biaya') ?></td>
	                                            <td><?php echo number_format($rw['price']) ?></td>
	                                            <td><?php 
		                                            $nim = $_GET['nim'];
		                                            $id_biaya = $rw['name'];
		                                            $biaya = $rw['price'];
		                                            $qty = $rw['qty'];

		                                            $t_pot = hitung_potogan($nim,$id_biaya,$biaya,$qty);

		                                            echo number_format($t_pot);
	                                             ?></td>
	                                            <td>
	                                            	<form action="pembayaran/update_detail/<?php echo $rw['rowid'].'?'.param_get() ?>" method="post">
	                                            	<div class="input-group">
                                                        <input type="text" name="qty" class="form-control" value="<?php echo $rw['qty'] ?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default shiny" type="submit"><i class="fa fa-plus"></i></button>
                                                        </span>
                                                    </div>
                                                    </form>
                                                </td>
	                                            <td><?php $subt = ($rw['qty'] * $rw['price']) - $t_pot; echo number_format($subt); $total = $total + $subt; ?></td>
	                                        </tr>

	                                    <?php $no++; endforeach ?>
	                                    <tr>
	                                    	<td colspan="6"><b>Total</b></td>
	                                    	<td><h3><b><?php echo number_format($total) ?></b></h3></td>
	                                    </tr>
	                                       
	                                    </tbody>
	                                </table>
	                            </div>

                        	</div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="registrasikan" value="1" >
                                            <span class="text"> Registrasikan Mahasiswa di Semester ini.</span>
                                        
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php if ($_GET): ?>
                                    <a href="pembayaran/simpan_pembayaran?<?php echo param_get() ?>" class="btn btn-primary" id="simpanPembayaran"><i class="fa fa-save"></i> Simpan</a>
                                <?php endif ?>
                                <a href="pembayaran" class="btn btn-default">Cancel</a>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalBiaya" style="display:none;">
    <div class="row">
        <div class="col-md-12">
        	<form action="pembayaran/aksi_pilih_biaya" method="POST" id="formBiaya">
            <div style="height: 400px; overflow-y: scroll;">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Biaya</th>
                        <th>Nilai</th>
                        <th>Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                
                <?php 
                $no = 1;
                if ($_GET) {
                    $id_prodi = get_data('mahasiswa','nim',$_GET['nim'],'id_prodi');
                    $this->db->where('id_prodi', $id_prodi);
                    $this->db->or_where('id_prodi', 0);
                }
                $this->db->where('tahun_berlaku', get_data('tahun_angkatan','aktif','y','tahun_angkatan'));
                foreach ($this->db->get('biaya_pembayaran')->result() as $rw): 
                	$checked = '';
                	foreach ($this->cart->contents() as $items) {
                		if ($items['id'] == $rw->id_nilai_biaya) {
                			$checked = 'checked';
                		} 
                	}
                	?>
                	
                	<tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo get_data('biaya','id_biaya',$rw->id_biaya,'nama_biaya') ?></td>
                        <td><?php echo number_format($rw->nilai) ?></td>
                        <td>
                        	<div class="checkbox">
                                <label>
                                	<input type="checkbox" name="ceklis[]" value="<?php echo $rw->id_nilai_biaya ?>" <?php echo $checked ?>>
                                        <span class="text"> </span>
                                    
                                </label>
                            </div>
                        </td>
                    </tr>

                <?php $no++; endforeach ?>
                </tbody>
            </table>
            </div>
            <hr>
            <button class="btn btn-primary btn-block">Pilih</button>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/select2/select2.js"></script>
<script src="assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#nim").select2();
        <?php 
        if (!empty($this->cart->contents())) {
        	?>
        	$("#nim").change(function() {
        		var nim = $("#nim").val();
        		window.location='<?php echo base_url() ?>/pembayaran/delete_detail_all?nim='+nim;
        	});
        	<?php
        } else {
            ?>
            $("#nim").change(function() {
                var nim = $("#nim").val();
                window.location='<?php echo base_url() ?>/pembayaran/create?nim='+nim;
            });
            <?php
        }


         ?>

        $("#btnBiaya").on('click', function (a) {
        	a.preventDefault();
            var nim = $("#nim").val();
        	var periode = $("#periode").val();
        	if (nim == '') {
        		alert('silahkan pilih mahasiswa dahulu');
        	} else {
                $("#formBiaya").attr('action', 'pembayaran/aksi_pilih_biaya?nim='+nim+'&periode='+periode);
	            bootbox.dialog({
	                message: $("#modalBiaya").html(),
	                title: "Pilih Biaya",
	                className: "modal-darkorange",
	            });
        	}
        	
        });

    });
</script>