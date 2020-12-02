
<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
            </div>
        <div class="widget-body">
        <div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	    <div class="form-group">
            <label for="varchar">Nama * <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Username * <?php echo form_error('username') ?></label>
            <?php
            $readonly = '';
            if ($level == '4' or $level == '5') {
                $readonly = 'readonly';
            }
             ?>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" <?php echo $readonly ?>/>
        </div>
	    <div class="form-group">
            <label for="varchar">Password * <?php echo form_error('password') ?></label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Password"  />
            <input type="hidden" class="form-control" name="password_old" id="password" placeholder="Password" value="<?php echo $password; ?>" />
            <div>
                <?php if ($password != ''): ?>
                    <span>*) kosongkan password jika tidak dirubah</span>
                <?php endif ?>
            </div>
        </div>
	    
	    <div class="form-group">
            <label for="varchar">Foto * <?php echo form_error('foto') ?></label>
            <input type="file" class="form-control" name="foto" id="foto" placeholder="Foto" value="<?php echo $foto; ?>" required/>

            <div>
                <?php if ($foto != ''): ?>
                    <input type="hidden" name="foto_old" value="<?php echo $foto ?>">
                    <b>*) Foto Sebelumnya : </b><br>
                    <img src="image/user/<?php echo $foto ?>" style="width: 100px;">
                <?php endif ?>
            </div>
        </div>
        <div class="form-group">
            <label for="int">Level * <?php echo form_error('level') ?></label>
            <select name="level" id="level" style="width:100%;">
                <option value="">--Pilih Level --</option>
                <?php 
                foreach ($this->db->get('level')->result() as $rw): 
                    $checked = ($level == $rw->id_level) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_level ?>" <?php echo $checked ?>><?php echo $rw->level ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group" id="s_prodi" style="display: none;">
            <label for="int">Prodi * </label>
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
	    
	    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('users') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>


<script type="text/javascript">
    $(document).ready(function() {
        $("#level").change(function() {
            var level = $(this).val();
            if (level == '2') {
                $("#s_prodi").show();
            }
        });

    });
</script>
   