<?php 
$id_prodi = $this->input->get('id_prodi');
$id_prodi = decode($id_prodi);
 ?>
<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> - <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?></span>
            </div>
            <div class="widget-body bordered-left bordered-warning">

            	<a href="krs/krs_mahasiswa" class="btn btn-primary"><i class="fa fa-backward"></i> Kembali ke KRS</a>

            	<br><br>
            	<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
            	<br>

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
		                    			<?php 
		                    			$this->db->where('id_jadwal', $br->id_jadwal);
		                    			$this->db->where('id_mk', $br->id_mk);
		                    			$this->db->where('nim', $this->session->userdata('username'));
		                    			$cek_krs = $this->db->get('krs');
		                    			if ($cek_krs->num_rows() > 0): ?>
		                    				<a href="krs/aksi_ambil_krs/<?php echo $br->id_jadwal ?>/batal?id_prodi=<?php echo encode($id_prodi) ?>" class="label label-warning">Batalkan</a>
		                    			<?php else: ?>
		                    				<a onclick="javasciprt: return confirm('Yakin ambil matakuliah ini ?')" href="krs/aksi_ambil_krs/<?php echo $br->id_jadwal ?>/ambil?id_prodi=<?php echo encode($id_prodi) ?>" class="label label-info">Ambil</a>
		                    			<?php endif ?>
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