
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
            <label for="varchar">Kode Prodi * <?php echo form_error('kode_prodi') ?></label>
            <input type="text" class="form-control" name="kode_prodi" id="kode_prodi" placeholder="Kode Prodi" value="<?php echo $kode_prodi; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Prodi * <?php echo form_error('prodi') ?></label>
            <input type="text" class="form-control" name="prodi" id="prodi" placeholder="Prodi" value="<?php echo $prodi; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Sks Lulus <?php echo form_error('sks_lulus') ?></label>
            <input type="text" class="form-control" name="sks_lulus" id="sks_lulus" placeholder="Sks Lulus" value="<?php echo $sks_lulus; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Ketua Prodi * <?php echo form_error('ketua_prodi') ?></label>
            <select name="ketua_prodi" id="ketua_prodi" style="width:100%;">
                <option value="">--Pilih Ketua Prodi --</option>
                <?php 
                $this->db->where('status', 1);
                foreach ($this->db->get('dosen')->result() as $rw): 
                    $checked = ($ketua_prodi == $rw->id_dosen) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_dosen ?>" <?php echo $checked ?>><?php echo $rw->nama ?></option>
                <?php endforeach ?>
            </select>
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
	    <input type="hidden" name="id_prodi" value="<?php echo $id_prodi; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('prodi') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   