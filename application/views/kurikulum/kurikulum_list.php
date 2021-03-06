
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-yellow">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
                <div class="widget-buttons">
                    <a href="#" data-toggle="maximize">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="#" data-toggle="dispose">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
            <br>
            <div class="row">
            <div class="col-md-4">
                <?php echo anchor(site_url('kurikulum/create'),'<i class="fa fa-plus"></i> Tambah Data', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('kurikulum/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('kurikulum'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="table-scrollable">
        <table class="table table-bordered table-hover table-striped" style="margin-bottom: 10px">
            <thead class="bordered-darkorange">
                <tr role="row">
                    <th>No</th>
		<th>Kode Kurikulum</th>
		<th>Kurikulum</th>
		<th>Mulai Berlaku</th>
		<th>Sks Wajib</th>
		<th>Sks Pilihan</th>
		<th>Total Sks</th>
		<th>Prodi</th>
		<th>Action</th>
                </tr>
            </thead>
            <tbody><?php
            foreach ($kurikulum_data as $kurikulum)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $kurikulum->kode_kurikulum ?></td>
			<td><?php echo $kurikulum->kurikulum ?></td>
			<td><?php echo $kurikulum->mulai_berlaku ?></td>
			<td><?php echo $kurikulum->sks_wajib ?></td>
			<td><?php echo $kurikulum->sks_pilihan ?></td>
			<td><?php echo $kurikulum->total_sks ?></td>
			<td><?php echo get_data('prodi','id_prodi',$kurikulum->id_prodi,'prodi') ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('kurikulum/update/'.$kurikulum->id_kurikulum),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('kurikulum/delete/'.$kurikulum->id_kurikulum),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
    