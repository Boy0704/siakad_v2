
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
            <label for="varchar">Kode Tahun * <?php echo form_error('kode_tahun') ?></label>
            <input type="text" class="form-control" name="kode_tahun" id="kode_tahun" placeholder="Contoh: 20202" value="<?php echo $kode_tahun; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Keterangan * <?php echo form_error('keterangan') ?></label>
            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Contoh: 2019/2020 Genap" value="<?php echo $keterangan; ?>" />
        </div>
        <div class="form-group">
            <label for="date">Mulai Aktif * <?php echo form_error('mulai_aktif') ?></label>
            <div class="input-group">
                <input class="form-control date-picker" id="mulai_aktif" type="text" name="mulai_aktif" value="<?php echo $mulai_aktif ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
	    <div class="form-group">
            <label for="date">Batas Registrasi * <?php echo form_error('batas_registrasi') ?></label>
            <div class="input-group">
                <input class="form-control date-picker" id="batas_registrasi" type="text" name="batas_registrasi" value="<?php echo $batas_registrasi ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
	    <div class="form-group">
            <label for="date">Batas Krs * <?php echo form_error('batas_krs') ?></label>
            <div class="input-group">
                <input class="form-control date-picker" id="batas_krs" type="text" name="batas_krs" value="<?php echo $batas_krs ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
	    <!-- <div class="form-group">
            <label for="enum">Aktif <?php echo form_error('aktif') ?></label>
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
        </div> -->
	    <input type="hidden" name="id_tahun_akademik" value="<?php echo $id_tahun_akademik; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tahun_akademik') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   