
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
                <?php echo anchor(site_url('master_menu_level/create'),'<i class="fa fa-plus"></i> Tambah Data', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('master_menu_level/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('master_menu_level'); ?>" class="btn btn-default">Reset</a>
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
		<th>Nama Menu</th>
		<th>Icon</th>
		<th>Link</th>
		<th>Status</th>
		<th>Parent</th>
		<th>Urutan</th>
		<th>Level</th>
		<th>Aktif</th>
		<th>Action</th>
                </tr>
            </thead>
            <tbody><?php
            foreach ($master_menu_level_data as $master_menu_level)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $master_menu_level->nama_menu ?></td>
			<td><?php echo $master_menu_level->icon ?></td>
			<td><?php echo $master_menu_level->link ?></td>
			<td><?php echo $master_menu_level->status ?></td>
			<td><?php echo get_data('master_menu_level','id_menu',$master_menu_level->parent,'nama_menu') ?></td>
			<td><?php echo $master_menu_level->urutan ?></td>
			<td><?php echo get_data('level','id_level',$master_menu_level->level,'level') ?></td>
			<td><?php echo $master_menu_level->aktif ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('master_menu_level/update/'.$master_menu_level->id_menu),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('master_menu_level/delete/'.$master_menu_level->id_menu),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    