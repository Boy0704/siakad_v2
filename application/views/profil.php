<?php 
$prof = $data->row();
 ?>
<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-lightred">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>
            <div class="widget-body">
            	<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
            		<div class="form-group">
	                    <label for="foto" class="col-sm-2 control-label no-padding-right">Foto Profil *</label>
	                    <div class="col-sm-10">
	                        <input type="file" class="form-control" name="foto">
	                        <div style="margin-top: 10px;">
	                        	<?php if ($prof->foto!=''): ?>
	                                <input type="hidden" name="foto_old" value="<?php echo $prof->foto ?>">
	                        		<img src="image/user/<?php echo $prof->foto ?>" style="width: 100px;">
	                        	<?php endif ?>
	                        </div>
	                        <p style="color: red">*)max ukuran file 1MB</p>
	                    </div>
	                    
	                </div>
            		<div class="form-group">
	                    <label class="col-sm-2 control-label no-padding-right">Password Sebelumnya </label>
	                    <div class="col-sm-10">
	                        <input type="password"  class="form-control" id="password_lama" name="password_lama" placeholder="Masukkan Password Lama">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-2 control-label no-padding-right">Password Baru </label>
	                    <div class="col-sm-10">
	                        <input type="password"  class="form-control" id="password_baru" name="password_baru" placeholder="Masukkan Password Baru">
	                    </div>
	                </div>

	                <div class="form-group">
                    	<div class="col-sm-offset-2 col-sm-10">
                    		<button type="submit" class="btn btn-primary">Update</button>
                            
                    	</div>
                    </div>

            	</form>
            </div>
        </div>
    </div>
</div>