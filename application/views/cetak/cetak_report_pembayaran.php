<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <form action="" method="get" role="form">
                    
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                    	<div class="input-group">
                            <input class="form-control date-picker" id="tgl1" type="text" name="tgl1" data-date-format="yyyy-mm-dd" autocomplete="off">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <div class="input-group">
                            <input class="form-control date-picker" id="tgl2" type="text" name="tgl2" data-date-format="yyyy-mm-dd" autocomplete="off">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
                </form>
            </div>
        </div>
    </div>
</div>