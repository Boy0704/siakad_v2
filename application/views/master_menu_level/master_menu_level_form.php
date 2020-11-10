
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
            <select id="pilih_nama_menu" style="width:100%;">
                <option value="">--Pilih Dari Master Menu --</option>
                <?php 
                foreach ($this->db->get('master_menu')->result() as $rw): 
                    $checked = ($parent == $rw->id_menu) ? 'checked' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_menu ?>" <?php echo $checked ?>><?php echo $rw->nama_menu.' ['.$rw->status.']' ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Menu <?php echo form_error('nama_menu') ?></label>
            <input type="text" class="form-control" name="nama_menu" id="nama_menu" placeholder="Nama Menu" value="<?php echo $nama_menu; ?>" readonly/>
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
            <select name="parent" id="parent" style="width:100%;">
                <option value="">--Pilih Menu Parent--</option>
                <?php 
                $this->db->where('status', 'menu');
                $this->db->where('link', '#');
                foreach ($this->db->get('master_menu_level')->result() as $rw): 
                    $checked = ($parent == $rw->id_menu) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_menu ?>" <?php echo $checked ?>><?php echo $rw->nama_menu ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Urutan <?php echo form_error('urutan') ?></label>
            <input type="text" class="form-control" name="urutan" id="urutan" placeholder="Urutan" value="<?php echo $urutan; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Level <?php echo form_error('level') ?></label>
            <select name="level" id="level" style="width:100%;">
                <option value="">--Pilih level--</option>
                <?php 
                foreach ($this->db->get('level')->result() as $rw): 
                    $checked = ($_GET['level'] == $rw->id_level OR $level == $rw->id_level) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_level ?>" <?php echo $checked ?>><?php echo $rw->level ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
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
        </div>
	    <input type="hidden" name="id_menu" value="<?php echo $id_menu; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('master_menu_level') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>

<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#pilih_nama_menu").select2();
        $("#level").select2();
        $("#parent").select2();

        $("#pilih_nama_menu").change(function() {
            var id_menu = $(this).val();
            $.ajax({
                url: 'app/get_master_menu',
                type: 'POST',
                dataType: 'JSON',
                data: {id_menu: id_menu},
            })
            .done(function(a) {
                console.log("success");
                $("#nama_menu").val(a.nama_menu);
                $("#icon").val(a.icon);
                $("#link").val(a.link);
                $('[name="status"][value="'+a.status+'"]').prop('checked', true);
                // $("#parent").val(a.parent).change();
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            
        });
    });
</script>
   