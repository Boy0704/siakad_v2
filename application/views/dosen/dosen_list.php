
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
                <?php echo anchor(site_url('dosen/create'),'<i class="fa fa-plus"></i> Tambah Data', 'class="btn btn-primary"'); ?>

                <button class="btn btn-darkorange" id="btnImport">Import Data</button>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('dosen/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('dosen'); ?>" class="btn btn-default">Reset</a>
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
		<th>Nama</th>
		<th>Nidn</th>
		<th>Nip</th>
		<th>No Pegawai</th>
		<th>JK</th>
		<th>Agama</th>
		<th>Tanggal Lahir</th>
        <th>Status</th>
		<th>Prodi</th>
		<th>Jabatan</th>
		<th>Action</th>
                </tr>
            </thead>
            <tbody><?php
            foreach ($dosen_data as $dosen)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $dosen->nama ?></td>
			<td><?php echo $dosen->nidn ?></td>
			<td><?php echo $dosen->nip ?></td>
			<td><?php echo $dosen->no_pegawai ?></td>
			<td><?php echo $dosen->jenis_kelamin ?></td>
			<td><?php echo get_data('agama','id_agama',$dosen->agama,'nm_agama') ?></td>
			<td><?php echo $dosen->tanggal_lahir ?></td>
            <td><?php echo get_data('status_keaktifan_pegawai','id_stat_aktif',$dosen->status,'nm_stat_aktif') ?></td>
			<td><?php echo get_data('prodi','id_prodi',$dosen->id_prodi,'prodi') ?></td>
			<td><?php echo get_data('jabatan','id_jabatan',$dosen->id_jabatan,'jabatan') ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('dosen/update/'.$dosen->id_dosen),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('dosen/delete/'.$dosen->id_dosen),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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

<div id="modalImport" style="display:none;">
    <div class="row">
        <form action="Import/import_dosen" method="post" enctype="multipart/form-data">
        <div class="col-md-12">
            <div class="form-group">
                <a href="files/template/import_dosen.xlsx" class="label label-success">Download Template</a>
            </div>
            <div class="form-group">
                <select name="id_prodi" id="id_prodi" style="width:100%;" required="">
                    <option value="">--Pilih Prodi --</option>
                    <?php 
                    $this->db->where('aktif', 'y');
                    foreach ($this->db->get('prodi')->result() as $rw): 
                        ?>
                        <option value="<?php echo $rw->id_prodi ?>"><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" name="file_excel" required="">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script src="assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#btnImport").on('click', function () {
            bootbox.dialog({
                message: $("#modalImport").html(),
                title: "Form Import",
                className: "modal-darkorange",
            });
        });
    });
</script>

    