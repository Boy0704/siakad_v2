
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
            <label for="varchar">Nama Biaya * <?php echo form_error('nama_biaya') ?></label>
            <input type="text" class="form-control" name="nama_biaya" id="nama_biaya" placeholder="Nama Biaya" value="<?php echo $nama_biaya; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Jenis Biaya *  <?php echo form_error('id_jenis_biaya') ?></label>
            <select name="id_jenis_biaya" id="id_jenis_biaya" style="width:100%;">
                <option value="">--Pilih Jenis Biaya --</option>
                <?php 
                foreach ($this->db->get('jenis_biaya')->result() as $rw): 
                    $checked = ($id_jenis_biaya == $rw->id_jenis_biaya) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_jenis_biaya ?>" <?php echo $checked ?>><?php echo $rw->jenis_biaya ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <input type="hidden" name="id_biaya" value="<?php echo $id_biaya; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('biaya') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   