<?php 
$data_mhs = $this->db->get_where('mahasiswa',array('nim'=>$this->session->userdata('username')))->row();

$jenis_ujian = 'uts';
 ?>

<?php if ($abs_uts == 't'): ?>

	<?php echo alert_notif('Tidak ada Ujian UTS yang aktif di periode ini !','danger') ?>

<?php else: ?>

<div style="margin-bottom: 10px;">
    <a href="cetak/cetak_kum/<?php echo $data_mhs->nim ?>/<?php echo tahun_akademik_aktif('kode_tahun') ?>/<?php echo $jenis_ujian ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Cetak KUM UTS</a>
</div>

<div class="table-scrollable">
<table align="center" class="table table-bordered">
    <tr>
        <td align="center" colspan="8" style="font-size: 16px;">
        	<strong><u>KARTU ABSEN UJIAN UTS</u></strong>
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
				<td align="left" colspan="8"><strong>:</strong> <?php echo get_semester($data_mhs->nim,tahun_akademik_aktif('kode_tahun')) ?></td>

				
		</tr>

</table>
<br><br>


    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr role="row">
                <th>No.</th>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>Kelas</th>
                <th>SKS</th>
                <th>Tgl Absen</th>
                <th>Pilihan</th>
            </tr>
            
        </thead>
        <tbody>
        <?php 
        $no=1;
        $sks_total = 0;
        $nim = $this->session->userdata('username');
        $id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');
        $kode_semester = tahun_akademik_aktif('kode_tahun');
        	$this->db->select('a.*,b.uts_mhs,b.date_uts_mhs');
        	$this->db->from('krs a');
        	$this->db->join('absen b', 'a.id_krs = b.id_krs', 'inner');
        	$this->db->where('a.kode_semester', $kode_semester);
        	$this->db->where('a.nim', $nim);
        	foreach ($this->db->get()->result() as $br): ?>
        		<tr>
        			<td><?php echo $no; ?></td>
            		<td><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'kode_mk') : $br->kode_mk ?></td>
            		<td><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'nama_mk') : $br->nama_mk ?></td>
            		<td><?php echo ($br->id_jadwal != '') ? get_data('jadwal_kuliah','id_jadwal',$br->id_jadwal,'kelas') : $br->kelas ?></td>
            		<td><?php $sks = ($br->id_mk !='') ? get_data('matakuliah','id_mk',$br->id_mk,'sks_total') : $br->sks ;
            			echo $sks;
            			$sks_total = $sks_total + $sks;
            		 ?></td>
            		<td>
            			<?php echo $br->date_uts_mhs ?>
            		</td>

            		<td>
            			<?php if ($br->uts_mhs != ''): ?>
            				<span class="label label-success">Sdh Absen</span>
            			<?php else: ?>
            				<a onclick="javasciprt: return confirm('Yakin akan isi absen ujian uts ?')" href="absensi/hadir_ujian/<?php echo $jenis_ujian ?>?nim=<?php echo $br->nim ?>&id_krs=<?php echo $br->id_krs ?>" class="label label-info">Hadir</a>
            			<?php endif ?>
                    	
            		</td>
            	</tr>
        	<?php $no++; endforeach ?>
        	<tr>
        		<td colspan="4"><b>Total SKS</b></td>
        		<td colspan="3"><?php echo $sks_total ?></td>
        	</tr>
            
        </tbody>
    </table>
</div>


<?php endif ?>
