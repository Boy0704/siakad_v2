<?php 
$uri2 = $this->uri->segment(2);
 ?>
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
            <label for="varchar">Kode Mk * <?php echo form_error('kode_mk') ?></label>
            <input type="text" class="form-control" name="kode_mk" id="kode_mk" placeholder="Kode Mk" value="<?php echo $kode_mk; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Mk * <?php echo form_error('nama_mk') ?></label>
            <input type="text" class="form-control" name="nama_mk" id="nama_mk" placeholder="Nama Mk" value="<?php echo $nama_mk; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Jenis Mk * <?php echo form_error('jenis_mk') ?></label>
            <select name="jenis_mk" id="jenis_mk" style="width:100%;">
                <option value="">--Pilih Jenis MK --</option>
                <?php 
                foreach ($this->db->get('jenis_mk')->result() as $rw): 
                    $checked = ($jenis_mk == $rw->jenis_mk) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->jenis_mk ?>" <?php echo $checked ?>><?php echo $rw->jenis_mk.' - '. $rw->jenis ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Sks Tatap Muka * <?php echo form_error('sks_tm') ?></label>
            <input type="text" class="form-control" name="sks_tm" id="sks_tm" placeholder="Sks Tm" value="<?php echo $sks_tm; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Sks Praktek *  <?php echo form_error('sks_prak') ?></label>
            <input type="text" class="form-control" name="sks_prak" id="sks_prak" placeholder="Sks Prak" value="<?php echo $sks_prak; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Sks Praktek Lapangan * <?php echo form_error('sks_prak_la') ?></label>
            <input type="text" class="form-control" name="sks_prak_la" id="sks_prak_la" placeholder="Sks Prak La" value="<?php echo $sks_prak_la; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Sks Simulasi * <?php echo form_error('sks_simulasi') ?></label>
            <input type="text" class="form-control" name="sks_simulasi" id="sks_simulasi" placeholder="Sks Simulasi" value="<?php echo $sks_simulasi; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Sks Total * <?php echo form_error('sks_total') ?></label>
            <input type="text" class="form-control" name="sks_total" id="sks_total" placeholder="Sks Total" value="<?php echo $sks_total; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Metode Pembelajaran <?php echo form_error('metode_pembelajaran') ?></label>
            <input type="text" class="form-control" name="metode_pembelajaran" id="metode_pembelajaran" placeholder="Metode Pembelajaran" value="<?php echo $metode_pembelajaran; ?>" />
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
            <label for="int">Semester * <?php echo form_error('semester') ?></label>
            <?php 
            if ($uri2 == 'create') {
                $semester = $this->input->get('semester');
            }
             ?>
            <select name="semester" id="semester" style="width:100%;">
                <?php 
                for ($i=1; $i <= 8 ; $i++) { 
                    $checked = ($semester == $i) ? 'selected' : '' ;
                 ?>
                    <option value="<?php echo $i ?>" <?php echo $checked ?>><?php echo $i ?></option>
                <?php } ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Prodi * <?php echo form_error('id_prodi') ?></label>
            <select name="id_prodi" id="id_prodi" style="width:100%;">
                <option value="">--Pilih Prodi --</option>
                <?php 
                if ($uri2 == 'create') {
                    $id_prodi = $this->input->get('id_prodi');
                }
                $this->db->where('aktif', 'y');
                foreach ($this->db->get('prodi')->result() as $rw): 
                    $checked = ($id_prodi == $rw->id_prodi) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_prodi ?>" <?php echo $checked ?>><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Kurikulum * <?php echo form_error('id_kurikulum') ?></label>
            <select name="id_kurikulum" id="id_kurikulum" style="width:100%;">
                <option value="">--Pilih Kurikulum --</option>
                <?php 
                if ($uri2 == 'create') {
                    $id_kurikulum = $this->input->get('id_kurikulum');
                }
                foreach ($this->db->get('kurikulum')->result() as $rw): 
                    $checked = ($id_kurikulum == $rw->id_kurikulum) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_kurikulum ?>" <?php echo $checked ?>><?php echo $rw->kode_kurikulum.' - '. $rw->kurikulum ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <input type="hidden" name="id_mk" value="<?php echo $id_mk; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('matakuliah') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   