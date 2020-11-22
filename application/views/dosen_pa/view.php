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
			                	$selected = ($_GET['id_prodi'] == $rw->id_prodi) ? 'selected' : '' ;
			                    ?>
			                    <option value="<?php echo $rw->id_prodi ?>" <?php echo $selected ?>><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
			                <?php endforeach ?>
			            </select>
                    </div>

                    <div class="form-group">
                    	<select name="kode_tahun" id="kode_tahun" style="width:100%;" required="">
			                <option value="">--Pilih Periode --</option>
			                <?php 
			                $this->db->order_by('kode_tahun', 'desc');
			                foreach ($this->db->get('tahun_akademik')->result() as $rw): 
			                	$selected = ($_GET['kode_tahun'] == $rw->kode_tahun OR tahun_akademik_aktif('kode_tahun') == $rw->kode_tahun) ? 'selected' : '' ;
			                    ?>
			                    <option value="<?php echo $rw->kode_tahun ?>" <?php echo $selected ?>><?php echo $rw->keterangan ?></option>
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
$kode_tahun = $this->input->get('kode_tahun');
$id_tahun_angkatan = $this->input->get('id_tahun_angkatan');

	?>
	
<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"> <?php echo $judul_page ?>[ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>Periode</b> : <?php echo get_data('tahun_akademik','kode_tahun',$kode_tahun,'keterangan') ?>, <b>Tahun Angkatan</b> : <?php echo $tha = ($id_tahun_angkatan !='') ? get_data('tahun_angkatan','id_tahun_angkatan',$id_tahun_angkatan,'tahun_angkatan') : 'Semua Tahun Angkatan' ; ?>]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>

                <br>

                <div class="table-scrollable">
	                <table class="table table-bordered table-hover table-striped" id="searchable">
	                    <thead class="bordered-darkorange">
	                        <tr role="row">
	                            <th>Nim</th>
	                            <th>Nama</th>
	                            <th>Kode Semester</th>
	                            <th>Prodi</th>
	                            <th>Pilihan</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php 
	                    
	                    $this->db->where('kode_semester', $kode_tahun);
	                    $this->db->where('id_prodi', $id_prodi);
	                    $this->db->where('id_dosen', $this->session->userdata('keterangan'));
	                    foreach ($this->db->get('temp_krs_pa')->result() as $rw): ?>
	            
	                        <tr>
	                            <td><?php echo $rw->nim ?></td>
	                            <td><?php echo get_data('mahasiswa','nim',$rw->nim,'nama') ?></td>
	                            <td><?php echo $rw->kode_semester ?></td>
	                            <td><?php echo get_data('prodi','id_prodi',$rw->id_prodi,'prodi') ?></td>
	                            <td>
	                            	<a href="dosen_pa/detail_krs?nim=<?php echo $rw->nim ?>&kode_semester=<?php echo $rw->kode_semester ?>" class="label label-default" target="_blank">detail krs</a>
	                            	<?php if ($rw->di_setujui == 't'): ?>
	                            		<a onclick="javasciprt: return confirm('Yakin akan setujui KRS mahasiswa ini ?')" href="dosen_pa/setujui?nim=<?php echo $rw->nim ?>&kode_semester=<?php echo $rw->kode_semester ?>&id_prodi=<?php echo $id_prodi ?>" class="label label-info">Setujui</a>
	                            	<?php else: ?>
	                            		<a onclick="javasciprt: return confirm('Yakin akan batalkan KRS mahasiswa ini ?')" href="dosen_pa/batalkan?nim=<?php echo $rw->nim ?>&kode_semester=<?php echo $rw->kode_semester ?>&id_prodi=<?php echo $id_prodi ?>" class="label label-success">Batalkan</a>
	                            	<?php endif ?>
	                            	
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
