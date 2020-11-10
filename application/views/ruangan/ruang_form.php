
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
            <label for="varchar">Ruang * <?php echo form_error('ruang') ?></label>
            <input type="text" class="form-control" name="ruang" id="ruang" placeholder="contoh: Ruang D.1" value="<?php echo $ruang; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Kapasitas * <?php echo form_error('kapasitas') ?></label>
            <input type="text" class="form-control" name="kapasitas" id="kapasitas" placeholder="contoh: 40" value="<?php echo $kapasitas; ?>" />
        </div>
        <input type="hidden" name="id_ruang" value="<?php echo $id_ruang; ?>" /> 
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
        <a href="<?php echo site_url('ruangan') ?>" class="btn btn-default">Cancel</a>
    </form>
                                    </div>
                                </div>
                                </div>
   