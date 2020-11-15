<?php 
$data_mhs = $this->db->get_where('mahasiswa',array('nim'=>$nim))->row();

 ?>
<div style="margin-bottom: 10px;">
    <a href="cetak/cetak_khs/<?php echo $data_mhs->nim ?>/<?php echo $kode_semester ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Cetak KHS</a>
</div>

<div class="table-scrollable">
<table align="center" class="table table-bordered">
    <tr>
        <td align="center" colspan="8" style="font-size: 16px;">
        	<strong><u>KARTU HASIL STUDI</u></strong>
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
        <td align="left" colspan="2"><strong>:</strong> <?php echo get_data('tahun_akademik','kode_tahun',$kode_semester,'keterangan') ?></td>
		    </tr>
		<tr>
				<td align="left" colspan="2"><strong>Semester</strong></td>
				<td align="left" colspan="2"><strong>:</strong> <?php echo get_semester($data_mhs->nim,$kode_semester) ?></td>
				<td colspan="2"></td>
				<td colspan="2"></td>
				
		</tr>

</table>
<br><br>


    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr role="row">
                <th rowspan="2" style="text-align: center; vertical-align: middle;">No.</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode MK</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama MK</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">SKS</th>
                
                <th colspan="3" style="text-align: center;">Nilai</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; ">SKS * Indeks</th>
            </tr>
            <tr>
            	<th>Angka</th>
            	<th>Huruf</th>
            	<th>Indeks</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $no=1;
        $sks_total = 0;
        $total_s_in = 0;
        $ips = 0;
        	$this->db->where('kode_semester', $kode_semester);
        	$this->db->where('nim', $nim);
        	foreach ($this->db->get('krs')->result() as $br): ?>
        		<tr>
        			<td><?php echo $no; ?></td>
            		<td><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'kode_mk') : $br->kode_mk ?></td>
            		<td><?php echo ($br->id_mk != '') ? get_data('matakuliah','id_mk',$br->id_mk,'nama_mk') : $br->nama_mk ?></td>
            		<td><?php $sks = ($br->id_mk !='') ?get_data('matakuliah','id_mk',$br->id_mk,'sks_total') : $br->sks;
            			echo $sks;
            			$sks_total = $sks_total + $sks;
            		 ?></td>
            		<td><?php echo $br->angka ?></td>
            		<td><?php echo $br->huruf ?></td>
            		<td><?php echo $br->indeks ?></td>
            		<td style="text-align: right;"><?php 
            		$jml = $br->sks*$br->indeks; 
            		echo $jml;
            		$total_s_in = $total_s_in + $jml;
            		?></td>
            		
            	</tr>
        	<?php $no++; endforeach ?>
        	<tr>
        		<td colspan="3"><b>Total SKS</b></td>
        		<td colspan="1"><?php echo $sks_total ?></td>
        		<td colspan="3"></td>
        		<td style="text-align: right;"><?php 
        		echo $total_s_in;
        		$ips = $total_s_in/$sks_total;
        		 ?></td>
        	</tr>
        	<tr>
        		<td colspan="7" style="text-align: right;"><b>IPS ( Indeks Prestasi Semester )</b></td>
        		<td style="text-align: right;"><b><?php echo number_format($ips,2) ?></b></td>
        	</tr>
        	<tr>
        		<td colspan="7" style="text-align: right;"><b>IPK ( Indeks Prestasi Kumulatif )</b></td>
        		<td style="text-align: right;"><b><?php echo number_format(ipk($nim,$kode_semester),2) ?></b></td>
        	</tr>
            
        </tbody>
    </table>
</div>