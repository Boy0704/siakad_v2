
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
            <label for="varchar">Nama Menu <?php echo form_error('nama_menu') ?></label>
            <input type="text" class="form-control" name="nama_menu" id="nama_menu" placeholder="Nama Menu" value="<?php echo $nama_menu; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Icon <?php echo form_error('icon') ?></label>
            <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" value="<?php echo $icon; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Link <?php echo form_error('link') ?></label>
            <input type="text" class="form-control" name="link" id="link" placeholder="Link" value="<?php echo $link; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Status <?php echo form_error('status') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="status" value="menu" <?php echo $retVal = ($status!='submenu' or $status=='') ? 'checked' : '' ; ?> >
                    <span class="text">Menu</span>
                </label>
                <label>
                    <input type="radio" name="status" value="submenu" <?php echo $retVal = ($status=='submenu') ? 'checked' : '' ; ?> >
                    <span class="text">Submenu</span>
                </label>
            </div>
        </div>
	    <div class="form-group">
            <label for="int">Parent <?php echo form_error('parent') ?></label>
            <select name="parent" class="form-control" id="parent">
                <option value="">--Pilih Menu Parent--</option>
                <?php 
                $this->db->where('status', 'menu');
                $this->db->where('link', '#');
                foreach ($this->db->get('master_menu')->result() as $rw): 
                    $checked = ($parent == $rw->id_menu) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_menu ?>" <?php echo $checked ?>><?php echo $rw->nama_menu ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <input type="hidden" name="id_menu" value="<?php echo $id_menu; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('master_menu') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>
   
<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#parent").select2();
    });
</script>