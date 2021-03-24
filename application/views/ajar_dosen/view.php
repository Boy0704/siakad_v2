<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> </span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
           		<table class="table table-bordered table-hover table-striped">
	                    <thead>
	                        <tr role="row">
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">No.</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode MK</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama MK</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Dosen Pengajar</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">SKS</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Prodi</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kelas</th>
	                            <th colspan="3" style="text-align: center;">Jadwal Perkuliahan</th>
	                        </tr>
	                        <tr>
	                        	<th>Ruang</th>
	                        	<th>Hari</th>
	                        	<th>Waktu</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php 
	                    $no=1;
	                    $sks_total = 0;
	                    $id_dosen = $this->session->userdata('keterangan');
	                    $id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');
	                    	$this->db->where('id_tahun_akademik', $id_tahun_akademik);
	                    	$this->db->where('id_dosen', $id_dosen);
	                    	foreach ($this->db->get('jadwal_kuliah')->result() as $br): ?>
	                    		<tr>
	                    			<td><?php echo $no; ?></td>
		                    		<td><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'kode_mk') : $br->kode_mk ?></td>
		                    		<td><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'nama_mk') : $br->nama_mk ?></td>
		                    		<td><?php echo ($br->id_mk !='') ? get_data('dosen','id_dosen',$br->id_dosen,'nama') : $br->nama_dosen ?></td>
		                    		<td><?php $sks = ($br->id_mk !='') ?get_data('matakuliah','id_mk',$br->id_mk,'sks_total') : $br->sks;
		                    			echo $sks;
		                    			$sks_total = $sks_total + $sks;
		                    		 ?></td>
		                    		<td><?php echo get_data('prodi','id_prodi',$br->id_prodi,'prodi') ?></td>
		                    		<td><?php echo $br->kelas ?></td>
		                    		<td><?php echo $br->ruang ?></td>
		                    		<td><?php echo $br->hari ?></td>
		                    		<td><?php echo $br->jam_mulai.' - '.$br->jam_selesai  ?></td>
		                    		
		                    	</tr>
	                    	<?php $no++; endforeach ?>
	                    	<tr>
	                    		<td colspan="4"><b>Total SKS</b></td>
	                    		<td colspan="7"><?php echo $sks_total ?></td>
	                    	</tr>
	                        
	                    </tbody>
	                </table>
           	</div>
        </div>
    </div>
</div>