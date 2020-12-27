<?php 
$data_mhs = $this->db->get_where('mahasiswa', array('nim'=>$nim))->row();
 ?>

<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
	    <div class="well with-header">
	        <div class="header bordered-magenta">Aktivitas Kuliah Mahasiswa</div>

	        <!-- <div class="table-scrollable"> -->
	        <table class="table table-hover table-striped table-bordered">
                <thead class="bordered-blueberry">
                    <tr>
                        <th width="50">No.</th>
                        <th>Nim</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Angkatan</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>IPS</th>
                        <th>IPK</th>
                        <th>SKS Semester</th>
                        <th>SKS Total</th>
                    </tr>
                </thead>
                <tbody>
				<?php 
				$tahun_akademik_aktif = tahun_akademik_aktif('kode_tahun');
				$no = 1;
			    $semester = $this->db->query("SELECT kode_tahun FROM tahun_akademik WHERE kode_tahun BETWEEN '$data_mhs->mulai_semester' AND '$tahun_akademik_aktif' ORDER BY kode_tahun ASC");
				foreach ($semester->result() as $rw): 
					$akm = $this->db->get_where('akm_mahasiswa',array('nim'=>$data_mhs->nim,'kode_semester'=>$rw->kode_tahun));
					if ($akm->num_rows() > 0) {
						$akm = $akm->row();
					} else {
						$akm = 0;
					}
					$id_select = $data_mhs->id_mahasiswa.'_'.$rw->kode_tahun;
					?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $nim ?></td>
						<td><?php echo get_data('mahasiswa','nim',$nim,'nama') ?></td>
						<td><?php $id_prodi = get_data('mahasiswa','nim',$nim,'id_prodi'); echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?></td>
						<td><?php $id_tahun_angkatan = get_data('mahasiswa','nim',$nim,'id_tahun_angkatan'); echo get_data('tahun_angkatan','id_tahun_angkatan',$id_tahun_angkatan,'tahun_angkatan') ?></td>
						<td><?php echo get_data('tahun_akademik','kode_tahun',$rw->kode_tahun,'keterangan') ?></td>
						<td>
							
                            <div class="input-group">
							    <select id="<?php echo $id_select ?>" onchange="editAkm('<?php echo $data_mhs->id_mahasiswa ?>','<?php echo $rw->kode_tahun ?>')" class="form-control">
                                	<option value="">--Not Set--</option>
                                	<?php foreach ($this->db->get('status_mhs')->result() as $st):
                                		$stat_mhs = ($akm != 0) ? $akm->id_stat_mhs : '';
                                		$select = ($stat_mhs == $st->id_status_mhs) ? 'selected' : '';
                                	 ?>
                                		<option value="<?php echo $st->id_status_mhs ?>" <?php echo $select ?>><?php echo $st->status_mhs ?></option>
                                	<?php endforeach ?>
                                </select>
							    <div class="input-group-btn">
							      
							    </div>
							  </div>
						</td>
						<td><?php echo number_format(ips($nim,$rw->kode_tahun),2) ?></td>
						<td><?php echo number_format(ipk($nim,$rw->kode_tahun),2) ?></td>
						<td style="text-align: center;"><?php echo sks_semester($nim,$rw->kode_tahun) ?></td>
						<td style="text-align: center;"><?php echo sks_total($nim,$rw->kode_tahun) ?></td>
					</tr>
				<?php $no++; endforeach ?>
                </tbody>
            </table>
			<!-- </div> -->

	    </div>
	</div>
</div>
<script type="text/javascript">
	function editAkm(id_mhs,kode_tahun) {
		var stat_mhs = $("#"+id_mhs+"_"+kode_tahun).val();
		$.ajax({
			url: "mahasiswa/update_akm/"+id_mhs+"/"+kode_tahun,
			type: 'POST',
			dataType: 'JSON',
			data: {stat_mhs: stat_mhs},
            beforeSend: function(){
                $(".loading-container").show();
                $(".loader").show();
            },
            success: function(result){
            	console.log("success");
            	if (result.status_code == 1) {
            		alert("AKM berhasil di update");
            	} else {
            		alert("AKM gagal di update");
            	}
            },
            complete:function(data){
                $(".loading-container").hide();
                $(".loader").hide();
            }
        });
	}
</script>