
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
            <label for="varchar">Kode Kelas <?php echo form_error('kode_kelas') ?></label>
            <input type="text" class="form-control" name="kode_kelas" id="kode_kelas" placeholder="Ex: TI A" value="<?php echo $kode_kelas; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Kelas <?php echo form_error('kelas') ?></label>
            <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas" value="<?php echo $kelas; ?>" />
        </div>
        <!-- <div class="form-group">
            <label for="varchar">Jenis Kelas <?php echo form_error('jenis_kelas') ?></label>
            <select name="jenis_kelas" class="form-control">
                <option value="">--Pilih Jenis Kelas--</option>
                <option value="pagi" <?php echo ($jenis_kelas == 'pagi') ?'selected' : '' ?>>Pagi</option>
                <option value="sore" <?php echo ($jenis_kelas == 'sore') ?'selected' : '' ?>>Sore</option>
                <option value="delik" <?php echo ($jenis_kelas == 'delik') ?'selected' : '' ?>>Delik</option>
                <option value="pilihan" <?php echo ($jenis_kelas == 'pilihan') ?'selected' : '' ?>>Pilihan</option>
            </select>
        </div> -->
	    <div class="form-group">
            <label for="int">Kapasitas <?php echo form_error('kapasitas') ?></label>
            <input type="text" class="form-control" name="kapasitas" id="kapasitas" placeholder="Kapasitas" value="<?php echo $kapasitas; ?>" />
        </div>
	    <input type="hidden" name="id_kelas" value="<?php echo $id_kelas; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('kelas') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   