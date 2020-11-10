
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
            <label for="year">Tahun Angkatan * <?php echo form_error('tahun_angkatan') ?></label>
            <input type="text" class="form-control" name="tahun_angkatan" id="tahun_angkatan" placeholder="contoh: 2019" value="<?php echo $tahun_angkatan; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Aktif * <?php echo form_error('aktif') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="aktif" value="y" <?php echo $retVal = ($aktif!='t' or $aktif=='') ? 'checked' : '' ; ?> >
                    <span class="text">Ya</span>
                </label>
                <label>
                    <input type="radio" name="aktif" value="t" <?php echo $retVal = ($aktif=='t') ? 'checked' : '' ; ?> >
                    <span class="text">Tidak</span>
                </label>
            </div>
        </div>
	    <input type="hidden" name="id_tahun_angkatan" value="<?php echo $id_tahun_angkatan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tahun_angkatan') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   