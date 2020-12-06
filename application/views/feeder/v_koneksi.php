<?php 
$this->db->where('id_config', 1);
$set = $this->db->get('feeder_config')->row();
 ?>
<div id="horizontal-form">
    <form class="form-horizontal" action="" method="POST" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">Url Server *</label>
            <div class="col-sm-10">
                <input type="text"  class="form-control" id="url" name="url" placeholder="contoh: http://localhost:8082" value="<?php echo $set->url ?>" required="">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">Username *</label>
            <div class="col-sm-10">
                <input type="text"  class="form-control" id="username" name="username" value="<?php echo $set->username ?>" placeholder="" required="">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">Password *</label>
            <div class="col-sm-10">
                <input type="password"  class="form-control" id="password" name="password" value="<?php echo $set->password ?>" placeholder="" required="">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                <a href="api_feeder/tes_konek" class="btn btn-info"><i class="fa fa-cloud-download"></i>Tes Koneksi</a>
            </div>
        </div>

    </form>
</div>