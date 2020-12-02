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
			                if ($this->session->userdata('level') == '2') {
                                $id_prodi = get_data('users','id_user',$this->session->userdata('id_user'),'id_prodi');
                                $this->db->where('id_prodi', $id_prodi);
                            }
			                $this->db->where('aktif', 'y');
			                foreach ($this->db->get('prodi')->result() as $rw): 
			                    ?>
			                    <option value="<?php echo $rw->id_prodi ?>"><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
			                <?php endforeach ?>
			            </select>
                    </div>

                    <div class="form-group">
                    	<select name="semester" id="semester" style="width:100%;">
			                <option value="">--Pilih Semester --</option>
			                
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
	$semester = $this->input->get('semester');

	$this->db->where('mulai_berlaku', tahun_akademik_aktif('kode_tahun'));
	$id_kurikulum = $this->db->get('kurikulum')->row()->id_kurikulum;

	?>

<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> [ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>Semester</b> : <?php echo $smst = ($semester !='') ? $semester : 'Semua Semester' ; ?> ]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
            	<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
            	<br><br>

                <a href="jadwal_kuliah/create?id_prodi=<?php echo $id_prodi ?>&semester=<?php echo $semester ?>&id_kurikulum=<?php echo $id_kurikulum ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Jadwal</a>

                <a onclick="javasciprt: return confirm('Yakin akan ambil jadwal kuliah dari kurikulum ?')" href="app/set_jadwal_from_kr?id_prodi=<?php echo $id_prodi ?>" class="btn btn-info"><i class="fa fa-sync"></i> Ambil dari Kurikulum berlaku</a>
                
                
                <br><br>

                <div class="table-scrollable">
	                <table class="table table-bordered table-hover table-striped">
	                    <thead>
	                        <tr role="row">
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode MK</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama MK</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Dosen Pengajar</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">SKS</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kelas</th>
	                            <th colspan="3" style="text-align: center;">Jadwal Perkuliahan</th>
	                            <th colspan="2" style="text-align: center;">Kuota</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Pilihan</th>
	                        </tr>
	                        <tr>
	                        	<th>Ruang</th>
	                        	<th>Hari</th>
	                        	<th>Waktu</th>
	                        	<th>Kapasitas</th>
	                        	<th>Terisi</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php 
	                    if (jenis_semester_aktif() == 'ganjil') {
	                    	$jenis = '1';
	                    } else {
	                    	$jenis = '0';
	                    }
	                    $where = "";
	                    if ($semester !='') {
	                    	$where = "and semester=$semester";
	                    }
	                    $id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');

	                    $smt = $this->db->query("
	                    	SELECT semester from jadwal_kuliah 
	                    	where id_prodi='$id_prodi' 
	                    	and id_tahun_akademik='$id_tahun_akademik' 
	                    	and semester%2='$jenis' $where 
	                    	group by semester ");
	                    foreach ($smt->result() as $rw): ?>

	                    	<tr class="success">
	                    		<td colspan="11">Semester <?php echo $rw->semester ?></td>
	                    	</tr>
	                    	<?php 
	                    	$this->db->where('semester', $rw->semester);
	                    	$this->db->where('id_prodi', $id_prodi);
	                    	$this->db->where('id_tahun_akademik', $id_tahun_akademik);
	                    	foreach ($this->db->get('jadwal_kuliah')->result() as $br): ?>
	                    		<tr>
		                    		<td><?php echo get_data('matakuliah','id_mk',$br->id_mk,'kode_mk') ?></td>
		                    		<td><?php echo get_data('matakuliah','id_mk',$br->id_mk,'nama_mk') ?></td>
		                    		<td><?php echo get_data('dosen','id_dosen',$br->id_dosen,'nama') ?></td>
		                    		<td><?php echo get_data('matakuliah','id_mk',$br->id_mk,'sks_total') ?></td>
		                    		<td><?php echo $br->kelas ?></td>
		                    		<td><?php echo $br->ruang ?></td>
		                    		<td><?php echo $br->hari ?></td>
		                    		<td><?php echo $br->jam_mulai.' - '.$br->jam_selesai ?></td>
		                    		<td><?php echo $br->kapasitas ?></td>
		                    		<td><?php echo $br->terisi ?></td>
		                    		<td>
		                    			<a href="jadwal_kuliah/update/<?php echo $br->id_jadwal ?>?id_prodi=<?php echo $id_prodi ?>&semester=<?php echo $semester ?>&id_kurikulum=<?php echo $id_kurikulum ?>" class="label label-info">Ubah</a>
		                            	|
		                            	<a onclick="javasciprt: return confirm('Yakin hapus jadwal ini ?')" href="jadwal_kuliah/delete/<?php echo $br->id_jadwal ?>" class="label label-danger">Hapus</a>
		                    		</td>
		                    	</tr>
	                    	<?php endforeach ?>

	                    <?php endforeach ?>
	                        
	                    </tbody>
	                </table>
            	</div>


            </div>
        </div>
    </div>
</div>



<?php endif ?>




<script src="assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#id_prodi").change(function() {
			var id_prodi = $(this).val();
			$.ajax({url: "app/get_select_semester/"+id_prodi, success: function(result){
					$("#semester").html(result);
                  console.log("success");
                }});
			
		});

	});
</script>