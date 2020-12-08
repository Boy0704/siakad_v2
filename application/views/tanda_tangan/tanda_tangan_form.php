
<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
            </div>
        <div class="widget-body">
        <div>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Jenis Cetak <?php echo form_error('jenis_cetak') ?></label>
            <select name="jenis_cetak" class="form-control">
                <option value="">--Pilih Tanda Tangan--</option>
                <option value="krs" <?php echo ($jenis_cetak == 'krs') ?'selected' : '' ?>>CETAK KRS</option>
                <option value="khs" <?php echo ($jenis_cetak == 'khs') ?'selected' : '' ?>>CETAK KHS</option>
                <option value="kum" <?php echo ($jenis_cetak == 'kum') ?'selected' : '' ?>>CETAK KUM</option>
                <option value="rhs" <?php echo ($jenis_cetak == 'rhs') ?'selected' : '' ?>>CETAK RHS</option>
                <option value="slip_pembayaran" <?php echo ($jenis_cetak == 'slip_pembayaran') ?'selected' : '' ?>>CETAK SLIP PEMBAYARAN </option>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Judul Atas <?php echo form_error('judul_atas') ?></label>
            <input type="text" class="form-control" name="judul_atas" id="judul_atas" placeholder="Judul Atas" value="<?php echo $judul_atas; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Bawah Nama <?php echo form_error('bawah_nama') ?></label>
            <input type="text" class="form-control" name="bawah_nama" id="bawah_nama" placeholder="Bawah Nama" value="<?php echo $bawah_nama; ?>" />
        </div>
	    <input type="hidden" name="id_tanda_tangan" value="<?php echo $id_tanda_tangan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tanda_tangan') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   