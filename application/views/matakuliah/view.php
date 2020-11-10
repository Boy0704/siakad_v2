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
                    	<select name="id_kurikulum" id="id_kurikulum" style="width:100%;">
			                <option value="">--Pilih Kurikulum --</option>
			                
			            </select>
                    </div>

                    <div class="form-group">
                    	<select name="semester" id="semester" style="width:100%;">
			                <option value="">--Pilih Semester --</option>
			                <?php 
			                for ($i=1; $i <= 8 ; $i++) { 
			                 ?>
			                 <option value="<?php echo $i ?>"><?php echo $i ?></option>
			               	<?php } ?>
			                
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
	$id_kurikulum = $this->input->get('id_kurikulum');
	$semester = $this->input->get('semester');

	?>

<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption">Daftar Matakuliah [ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>Kurikulum</b> : <?php echo $kr = ($id_kurikulum !='') ? get_data('kurikulum','id_kurikulum',$id_kurikulum,'kurikulum') : 'Semua Kurikulum' ; ?>, <b>Semester</b> : <?php echo $smst = ($semester !='') ? $semester : 'Semua Semester' ; ?> ]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <a href="matakuliah/create?id_prodi=<?php echo $id_prodi ?>&id_kurikulum=<?php echo $id_kurikulum ?>&semester=<?php echo $semester ?>" class="btn btn-primary"><i class="fa fa-plus">Tambah Matakuliah</i></a>
                <br><br>

                <div class="table-scrollable">
	                <table class="table table-bordered table-hover table-striped" id="searchable">
	                    <thead class="bordered-darkorange">
	                        <tr role="row">
	                            <th>Kode MK</th>
	                            <th>Nama MK</th>
	                            <th>Jenis MK</th>
	                            <th>SKS</th>
	                            <th>Metode Pembelajaran</th>
	                            <th>Tgl Mulai Efektif</th>
	                            <th>Tgl Akhir Efektif</th>
	                            <th>Semester</th>
	                            <th>Kurikulum</th>
	                            <th>Prodi</th>
	                            <th>Pilihan</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php 
	                    if ($id_kurikulum != '') {
	                    	$this->db->where('id_kurikulum', $id_kurikulum);
	                    }
	                    if ($semester !='') {
	                    	$this->db->where('semester', $semester);
	                    }
	                    $this->db->where('id_prodi', $id_prodi);
	                    foreach ($this->db->get('matakuliah')->result() as $rw): ?>
	            
	                        <tr>
	                            <td><?php echo $rw->kode_mk ?></td>
	                            <td><?php echo $rw->nama_mk ?></td>
	                            <td><?php echo get_data('jenis_mk','jenis_mk',$rw->jenis_mk,'jenis') ?></td>
	                            <td><?php echo $rw->sks_total ?></td>
	                            <td><?php echo $rw->metode_pembelajaran ?></td>
	                            <td><?php echo $rw->tgl_mulai_efektif ?></td>
	                            <td><?php echo $rw->tgl_akhir_efektif ?></td>
	                            <td><?php echo $rw->semester ?></td>
	                            <td><?php echo get_data('kurikulum','id_kurikulum',$rw->id_kurikulum,'kurikulum') ?></td>
	                            <td><?php echo get_data('prodi','id_prodi',$rw->id_prodi,'prodi') ?></td>
	                            <td>
	                            	<a href="matakuliah/update/<?php echo $rw->id_mk ?>" class="label label-info">Ubah</a>
	                            	|
	                            	<a onclick="javasciprt: return confirm('Are You Sure ?')" href="matakuliah/delete/<?php echo $rw->id_mk ?>" class="label label-danger">Hapus</a>
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





<script type="text/javascript">
	$(document).ready(function() {
		$("#id_prodi").change(function() {
			var id_prodi = $(this).val();
			$.ajax({
				url: 'app/filter_kurikulum_prodi/'+id_prodi,
				type: 'GET',
				dataType: 'html',
			})
			.done(function(a) {
				console.log("success");
				$("#id_kurikulum").html(a);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		});
	});
</script>