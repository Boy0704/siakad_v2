
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
                <?php echo anchor(site_url('skala_nilai/create'),'<i class="fa fa-plus"></i> Tambah Data', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('skala_nilai/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('skala_nilai'); ?>" class="btn btn-default">Reset</a>
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
		<th>Nilai Huruf</th>
		<th>Nilai Indeks</th>
		<th>Min</th>
		<th>Max</th>
		<th>Tgl Mulai Efektif</th>
		<th>Tgl Akhir Efektif</th>
		<th>Prodi</th>
		<th>Action</th>
                </tr>
            </thead>
            <tbody><?php
            foreach ($skala_nilai_data as $skala_nilai)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $skala_nilai->nilai_huruf ?></td>
			<td><?php echo $skala_nilai->nilai_indeks ?></td>
			<td><?php echo $skala_nilai->min ?></td>
			<td><?php echo $skala_nilai->max ?></td>
			<td><?php echo $skala_nilai->tgl_mulai_efektif ?></td>
			<td><?php echo $skala_nilai->tgl_akhir_efektif ?></td>
			<td><?php echo get_data('prodi','id_prodi',$skala_nilai->id_prodi,'prodi') ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('skala_nilai/update/'.$skala_nilai->id_skala),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('skala_nilai/delete/'.$skala_nilai->id_skala),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    