<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> </span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
            	<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
            	<br>

            	<?php 
            	$data_mhs = $this->db->get_where('mahasiswa',array('nim'=>$this->session->userdata('username')))->row();

            	 ?>

            	<?php if (!setuju_dosen_pa($data_mhs->nim)): ?>

            		<a href="krs/ambil_krs?id_prodi=<?php echo encode($data_mhs->id_prodi) ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Pilih matakuliah</a>

            	<?php endif ?>
                
                
                
                <br><br>
                <div class="table-scrollable">
                <table align="center" class="table table-bordered">
				    <tr>
				        <td align="center" colspan="8" style="font-size: 16px;">
				        	<strong><u>KARTU RENCANA STUDI (KRS)</u></strong>
				        </td>
				    </tr>
				    <tr>
				    	<td colspan="8">&nbsp</td>
				    </tr>
				    <tr>
				        <td align="left" width="20%" colspan="2" ><strong>Nama Mahasiswa</strong></td>
				        <td align="left" width="30%" colspan="2"><strong>:</strong> <?php echo $data_mhs->nama ?></td>
				        <td align="left" width="20%" colspan="2" ><strong>NIM</strong></td>
				        <td align="left" colspan="2"><strong>:</strong> <?php echo $data_mhs->nim ?></td>
				    </tr>
				    <tr>
				        <td align="left" colspan="2"><strong>Program Studi</strong></td>
				        <td align="left" colspan="2"><strong>:</strong> <?php echo get_data('prodi','id_prodi',$data_mhs->id_prodi,'jenjang') ?> - <?php echo get_data('prodi','id_prodi',$data_mhs->id_prodi,'prodi') ?></td>
						        <td align="left" colspan="2"><strong>Periode</strong></td>
				        <td align="left" colspan="2"><strong>:</strong> <?php echo tahun_akademik_aktif('keterangan') ?></td>
						    </tr>
						<tr>
								<td align="left" colspan="2"><strong>Semester</strong></td>
								<td align="left" colspan="2"><strong>:</strong> <?php echo $data_mhs->semester_aktif ?></td>

								<td align="left" colspan="2"><strong>Disetujui Dosen PA</strong></td>
								<td align="left" colspan="2"><strong>:</strong> <?php 
								if (pengajuan_krs($data_mhs->nim)) {
									echo $retVal = (setuju_dosen_pa($data_mhs->nim)) ? '<span class="label label-success">disetejui</span>' : '<span class="label label-warning">belum disetejui</span>' ; 
								} else {
									echo '<span class="label label-warning">belum diajukan, silahkan ajuka terlebih dahulu</span>';
								}
								
								?></td>
						</tr>

				</table>
				<br><br>

                
	                <table class="table table-bordered table-hover table-striped">
	                    <thead>
	                        <tr role="row">
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">No.</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode MK</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama MK</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Dosen Pengajar</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">SKS</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kelas</th>
	                            <th colspan="3" style="text-align: center;">Jadwal Perkuliahan</th>
	                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Pilihan</th>
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
	                    $nim = $this->session->userdata('username');
	                    $id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');
	                    $kode_semester = tahun_akademik_aktif('kode_tahun');
	                    	$this->db->where('kode_semester', $kode_semester);
	                    	$this->db->where('nim', $nim);
	                    	$this->db->where('id_tahun_akademik', $id_tahun_akademik);
	                    	foreach ($this->db->get('krs')->result() as $br): ?>
	                    		<tr>
	                    			<td><?php echo $no; ?></td>
		                    		<td><?php echo get_data('matakuliah','id_mk',$br->id_mk,'kode_mk') ?></td>
		                    		<td><?php echo get_data('matakuliah','id_mk',$br->id_mk,'nama_mk') ?></td>
		                    		<td><?php echo get_data('dosen','id_dosen',$br->id_dosen,'nama') ?></td>
		                    		<td><?php $sks = get_data('matakuliah','id_mk',$br->id_mk,'sks_total');
		                    			echo $sks;
		                    			$sks_total = $sks_total + $sks;
		                    		 ?></td>
		                    		<td><?php echo get_data('jadwal_kuliah','id_jadwal',$br->id_jadwal,'kelas') ?></td>
		                    		<td><?php echo get_data('jadwal_kuliah','id_jadwal',$br->id_jadwal,'ruang') ?></td>
		                    		<td><?php echo get_data('jadwal_kuliah','id_jadwal',$br->id_jadwal,'hari') ?></td>
		                    		<td><?php echo get_data('jadwal_kuliah','id_jadwal',$br->id_jadwal,'jam_mulai').' - '.get_data('jadwal_kuliah','id_jadwal',$br->id_jadwal,'jam_selesai')  ?></td>
		                    		<td>
		                    			<?php if (setuju_dosen_pa($data_mhs->nim)): ?>
		                    			<span class="label label-success">Tidak bisa dihapus</span>
		                    			<?php else: ?>
		                    			<a onclick="javasciprt: return confirm('Yakin hapus matakuliah di KRS ini ?')" href="krs/aksi_ambil_krs/<?php echo $br->id_jadwal ?>/batal?id_prodi=<?php echo encode($data_mhs->id_prodi) ?>" class="label label-danger">Hapus</a>
		                    			<?php endif ?>
		                            	
		                    		</td>
		                    	</tr>
	                    	<?php $no++; endforeach ?>
	                    	<tr>
	                    		<td colspan="4"><b>Total SKS</b></td>
	                    		<td colspan="7"><?php echo $sks_total ?></td>
	                    	</tr>
	                        
	                    </tbody>
	                </table>
            	</div>

            	<div class="row" style="margin-top: 10px;">
            		<div class="col-md-2">
            			<?php if (pengajuan_krs($nim)): ?>
            				<span class="label label-success">Krs ini sudah diajukan ke dosen pembimbing</span>
            			<?php else: ?>
            				<a onclick="javasciprt: return confirm('Yakin akan ajukan krs ini ke dosen pembimbing ?')" href="krs/ajukan_krs?nim=<?php echo $data_mhs->nim ?>&id_prodi=<?php echo $data_mhs->id_prodi ?>&kode_semester=<?php echo tahun_akademik_aktif('kode_tahun') ?>&id_dosen=<?php echo $data_mhs->dosen_pa ?>" class="btn btn-info">Ajukan ke dosen pembimbing</a>
            			<?php endif ?>
            		</div>
            		<div class="col-md-8"></div>
            		<div class="col-md-2">
            			<?php if (setuju_dosen_pa($data_mhs->nim)): ?>
            				<a href="cetak/cetak_krs/<?php echo $nim ?>/<?php echo tahun_akademik_aktif('kode_tahun') ?>" class="btn btn-info"><i class="fa fa-print"></i> Cetak KRS</a>
            			<?php endif ?>
            		</div>
            	</div>

            </div>
        </div>
    </div>
</div>