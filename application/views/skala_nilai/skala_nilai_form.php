
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
            <label for="varchar">Nilai Huruf * <?php echo form_error('nilai_huruf') ?></label>
            <input type="text" class="form-control" name="nilai_huruf" id="nilai_huruf" placeholder="contoh: B+" value="<?php echo $nilai_huruf; ?>" />
        </div>
	    <div class="form-group">
            <label for="float">Nilai Indeks * <?php echo form_error('nilai_indeks') ?></label>
            <input type="text" class="form-control" name="nilai_indeks" id="nilai_indeks" placeholder="contoh: 2" value="<?php echo $nilai_indeks; ?>" />
        </div>
	    <div class="form-group">
            <label for="float">Min * <?php echo form_error('min') ?></label>
            <input type="text" class="form-control" name="min" id="min" placeholder="contoh: 69.50" value="<?php echo $min; ?>" />
        </div>
	    <div class="form-group">
            <label for="float">Max * <?php echo form_error('max') ?></label>
            <input type="text" class="form-control" name="max" id="max" placeholder="contoh: 74.50" value="<?php echo $max; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Tgl Mulai Efektif <?php echo form_error('tgl_mulai_efektif') ?></label>
            <div class="input-group">
                <input class="form-control date-picker" id="tgl_mulai_efektif" type="text" name="tgl_mulai_efektif" value="<?php echo $tgl_mulai_efektif ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
	    <div class="form-group">
            <label for="date">Tgl Akhir Efektif <?php echo form_error('tgl_akhir_efektif') ?></label>
            <div class="input-group">
                <input class="form-control date-picker" id="tgl_akhir_efektif" type="text" name="tgl_akhir_efektif" value="<?php echo $tgl_akhir_efektif ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
	    <div class="form-group">
            <label for="int">Prodi * <?php echo form_error('id_prodi') ?></label>
            <select name="id_prodi" id="id_prodi" style="width:100%;">
                <option value="">--Pilih Prodi --</option>
                <?php 
                $this->db->where('aktif', 'y');
                foreach ($this->db->get('prodi')->result() as $rw): 
                    $checked = ($id_prodi == $rw->id_prodi) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_prodi ?>" <?php echo $checked ?>><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <input type="hidden" name="id_skala" value="<?php echo $id_skala; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('skala_nilai') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   