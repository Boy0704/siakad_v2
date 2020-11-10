<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption">Filter</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <form class="form-inline" action="" method="get" role="form">
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
                    	<select name="id_tahun_angkatan" id="id_tahun_angkatan" style="width:100%;">
			                <option value="">--Pilih Tahun Angkatan --</option>
			                <?php 
			                foreach ($this->db->get('tahun_angkatan')->result() as $rw): 
			                    ?>
			                    <option value="<?php echo $rw->id_tahun_angkatan ?>"><?php echo $rw->tahun_angkatan ?></option>
			                <?php endforeach ?>
			            </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">FILTER</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($_GET): 

$id_prodi = $this->input->get('id_prodi');
$id_tahun_angkatan = $this->input->get('id_tahun_angkatan');

	?>
	
<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption">Daftar Mahasiswa [ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>Tahun Angkatan</b> : <?php echo $tha = ($id_tahun_angkatan !='') ? get_data('tahun_angkatan','id_tahun_angkatan',$id_tahun_angkatan,'tahun_angkatan') : 'Semua Tahun Angkatan' ; ?>]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <a href="mahasiswa/create?id_prodi=<?php echo $id_prodi ?>&id_tahun_angkatan=<?php echo $id_tahun_angkatan ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Mahasiswa</a>
                <br>
                
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>

                <br>




                <div class="table-scrollable">
	                <table class="table table-bordered table-hover table-striped" id="searchable">
	                    <thead class="bordered-darkorange">
	                        <tr role="row">
	                            <th>Nim</th>
	                            <th>Nama</th>
	                            <th>Jenis Kelamin</th>
	                            <th>Prodi</th>
	                            <th>Pilihan</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php 
	                    if ($id_tahun_angkatan !='') {
	                    	$this->db->where('id_tahun_angkatan', $id_tahun_angkatan);
	                    }
	                    $this->db->where('id_prodi', $id_prodi);
	                    foreach ($this->db->get('mahasiswa')->result() as $rw): ?>
	            
	                        <tr>
	                            <td><?php echo $rw->nim ?></td>
	                            <td><?php echo $rw->nama ?></td>
	                            <td><?php echo $rw->jenis_kelamin ?></td>
	                            <td><?php echo get_data('prodi','id_prodi',$rw->id_prodi,'prodi') ?></td>
	                            <td>
	                            	<a href="mahasiswa/update/<?php echo $rw->id_mahasiswa ?>" class="label label-info">Ubah</a>
	                            	|
	                            	<a onclick="javasciprt: return confirm('Are You Sure ?')" href="mahasiswa/delete/<?php echo $rw->id_mahasiswa ?>" class="label label-danger">Hapus</a>
	                            </td>
	                            
	                            
	                        </tr>

	                    <?php endforeach ?>
	                        
	                    </tbody>
	                </table>
            	</div>


            </div>
        </div>
    </div>
</div>


<?php endif ?>
