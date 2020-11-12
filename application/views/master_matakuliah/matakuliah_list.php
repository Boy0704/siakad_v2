
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
                <?php echo anchor(site_url('matakuliah/create'),'<i class="fa fa-plus"></i> Tambah Data', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('matakuliah/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('matakuliah'); ?>" class="btn btn-default">Reset</a>
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
		<th>Kode Mk</th>
		<th>Nama Mk</th>
		<th>Jenis Mk</th>
		<th>Sks Tm</th>
		<th>Sks Prak</th>
		<th>Sks Prak La</th>
		<th>Sks Total</th>
		<th>Metode Pembelajaran</th>
		<th>Tgl Mulai Efektif</th>
		<th>Tgl Akhir Efektif</th>
		<th>Semester</th>
		<th>Id Prodi</th>
		<th>Id Kurikulum</th>
		<th>Action</th>
                </tr>
            </thead>
            <tbody><?php
            foreach ($matakuliah_data as $matakuliah)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $matakuliah->kode_mk ?></td>
			<td><?php echo $matakuliah->nama_mk ?></td>
			<td><?php echo $matakuliah->jenis_mk ?></td>
			<td><?php echo $matakuliah->sks_tm ?></td>
			<td><?php echo $matakuliah->sks_prak ?></td>
			<td><?php echo $matakuliah->sks_prak_la ?></td>
			<td><?php echo $matakuliah->sks_total ?></td>
			<td><?php echo $matakuliah->metode_pembelajaran ?></td>
			<td><?php echo $matakuliah->tgl_mulai_efektif ?></td>
			<td><?php echo $matakuliah->tgl_akhir_efektif ?></td>
			<td><?php echo $matakuliah->semester ?></td>
			<td><?php echo $matakuliah->id_prodi ?></td>
			<td><?php echo $matakuliah->id_kurikulum ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('matakuliah/update/'.$matakuliah->id_mk),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('matakuliah/delete/'.$matakuliah->id_mk),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    