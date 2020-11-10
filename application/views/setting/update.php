<?php 
$sett = $data->row();
 ?>
<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
            </div>
        <div class="widget-body">

        	<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
        		<div class="form-group">
                    <label for="nama_kampus" class="col-sm-2 control-label no-padding-right">Nama Kampus *</label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control" id="nama_kampus" name="nama_kampus" value="<?php echo $sett->nama_kampus ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="col-sm-2 control-label no-padding-right">Alamat Kampus *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="alamat" id="alamat" rows="5"><?php echo $sett->alamat ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="logo" class="col-sm-2 control-label no-padding-right">Logo *</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="logo">
                        <div>
                        	<?php if ($sett->logo!=''): ?>
                        		<img src="image/<?php echo $sett->logo ?>" style="width: 100px;">
                        	<?php endif ?>
                        </div>
                        <p style="color: red">*)max ukuran file 10MB</p>
                    </div>
                    <div class="form-group">
                    	<div class="col-sm-offset-2 col-sm-10">
                    		<button type="submit" class="btn btn-primary">Update</button>
                    	</div>
                    </div>
                </div>
        	</form>

        </div>

    </div>
</div>