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

	?>

<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption">Master Matakuliah [ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>Semester</b> : <?php echo $smst = ($semester !='') ? $semester : 'Semua Semester' ; ?> ]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <a href="master_matakuliah/create?id_prodi=<?php echo $id_prodi ?>&semester=<?php echo $semester ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Matakuliah</a>

                <button class="btn btn-darkorange" id="btnImport">Import Data</button>
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
	                            <th>Prodi</th>
	                            <th>Pilihan</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php 
	                    if ($semester !='') {
	                    	$this->db->where('semester', $semester);
	                    }
	                    $this->db->where('id_prodi', $id_prodi);
	                    $this->db->order_by('semester', 'asc');
	                    foreach ($this->db->get('master_matakuliah')->result() as $rw): ?>
	            
	                        <tr>
	                            <td><?php echo $rw->kode_mk ?></td>
	                            <td><?php echo $rw->nama_mk ?></td>
	                            <td><?php echo get_data('jenis_mk','jenis_mk',$rw->jenis_mk,'jenis') ?></td>
	                            <td><?php echo $rw->sks_total ?></td>
	                            <td><?php echo $rw->metode_pembelajaran ?></td>
	                            <td><?php echo $rw->tgl_mulai_efektif ?></td>
	                            <td><?php echo $rw->tgl_akhir_efektif ?></td>
	                            <td><?php echo $rw->semester ?></td>
	                            <td><?php echo get_data('prodi','id_prodi',$rw->id_prodi,'prodi') ?></td>
	                            <td>
	                            	<a href="master_matakuliah/update/<?php echo $rw->id_mk ?>" class="label label-info">Ubah</a>
	                            	|
	                            	<a onclick="javasciprt: return confirm('Are You Sure ?')" href="master_matakuliah/delete/<?php echo $rw->id_mk ?>" class="label label-danger">Hapus</a>
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

<div id="modalImport" style="display:none;">
        <div class="row">
        	<form action="Import/import_mk?id_prodi=<?php echo $id_prodi ?>" method="post" enctype="multipart/form-data">
            <div class="col-md-12">
            	<div class="form-group">
            		<a href="files/template/import_mk.xlsx" class="label label-success">Download Template</a>
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


		$("#btnImport").on('click', function () {
            bootbox.dialog({
                message: $("#modalImport").html(),
                title: "Form Import",
                className: "modal-darkorange",
                // buttons: {
                //     success: {
                //         label: "Send",
                //         className: "btn-blue",
                //         callback: function () { }
                //     },
                //     "Save as Draft": {
                //         className: "btn-danger",
                //         callback: function () { }
                //     }
                // }
            });
        });

	});
</script>