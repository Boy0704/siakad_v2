
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
                <?php echo anchor(site_url('jadwal_kuliah/create'),'<i class="fa fa-plus"></i> Tambah Data', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('jadwal_kuliah/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('jadwal_kuliah'); ?>" class="btn btn-default">Reset</a>
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
		<th>Id Tahun Akademik</th>
		<th>Id Mk</th>
		<th>Id Dosen</th>
		<th>Kelas</th>
		<th>Ruang</th>
		<th>Hari</th>
		<th>Jam Mulai</th>
		<th>Jam Selesai</th>
		<th>Id Prodi</th>
		<th>Semester</th>
		<th>Kapasitas</th>
		<th>Terisi</th>
		<th>Action</th>
                </tr>
            </thead>
            <tbody><?php
            foreach ($jadwal_kuliah_data as $jadwal_kuliah)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $jadwal_kuliah->id_tahun_akademik ?></td>
			<td><?php echo $jadwal_kuliah->id_mk ?></td>
			<td><?php echo $jadwal_kuliah->id_dosen ?></td>
			<td><?php echo $jadwal_kuliah->kelas ?></td>
			<td><?php echo $jadwal_kuliah->ruang ?></td>
			<td><?php echo $jadwal_kuliah->hari ?></td>
			<td><?php echo $jadwal_kuliah->jam_mulai ?></td>
			<td><?php echo $jadwal_kuliah->jam_selesai ?></td>
			<td><?php echo $jadwal_kuliah->id_prodi ?></td>
			<td><?php echo $jadwal_kuliah->semester ?></td>
			<td><?php echo $jadwal_kuliah->kapasitas ?></td>
			<td><?php echo $jadwal_kuliah->terisi ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('jadwal_kuliah/update/'.$jadwal_kuliah->id_jadwal),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('jadwal_kuliah/delete/'.$jadwal_kuliah->id_jadwal),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    