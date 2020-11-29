<div class="row">
	<div class="col-md-12">
		<div class="alert alert-success">
			<h2>Selamat datang, <?php echo $this->session->userdata('nama'); ?></h2>
		</div>
		
	</div>

</div>

<?php if ($this->session->userdata('level') == '1' || $this->session->userdata('level') == '2' || $this->session->userdata('level') == '3' ): ?>
	

<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
	    <div class="widget">
	        <div class="widget-header ">
	            <span class="widget-caption">Grafik Data Mahasiswa</span>
	            <div class="widget-buttons">
	                <a href="#" data-toggle="maximize">
	                    <i class="fa fa-expand"></i>
	                </a>
	                <a href="#" data-toggle="collapse">
	                    <i class="fa fa-minus"></i>
	                </a>
	                <a href="#" data-toggle="dispose">
	                    <i class="fa fa-times"></i>
	                </a>
	            </div>
	        </div>
	        <div class="widget-body">
	        	
                <div id="line-chart-2" class="chart chart-lg"></div>
            </div>
	    </div>
	</div>
</div>


<!--Page Related Scripts-->
    <script src="assets/js/charts/morris/raphael-2.0.2.min.js"></script>
    <script src="assets/js/charts/morris/morris.js"></script>
    <script src="assets/js/charts/morris/morris-init.js"></script>

    <script type="text/javascript">
        $(window).bind("load", function () {

            /*Sets Themed Colors Based on Themes*/
            themeprimary = getThemeColorFromCss('themeprimary');
            themesecondary = getThemeColorFromCss('themesecondary');
            themethirdcolor = getThemeColorFromCss('themethirdcolor');
            themefourthcolor = getThemeColorFromCss('themefourthcolor');
            themefifthcolor = getThemeColorFromCss('themefifthcolor');

            var InitiateLineChart2 = function () {
			    return {
			        init: function () {
			            Morris.Line({
			                element: 'line-chart-2',
			                data: [
			                <?php 
			                $this->db->select('b.tahun_angkatan,b.id_tahun_angkatan');
				        	$this->db->from('mahasiswa a');
				        	$this->db->join('tahun_angkatan b', 'a.id_tahun_angkatan = b.id_tahun_angkatan', 'join');
				        	$this->db->group_by('a.id_tahun_angkatan');
				        	foreach ($this->db->get()->result() as $th) {
			                 ?>
			                  { y: '<?php echo $th->tahun_angkatan ?>', 
			                  	a: <?php echo $this->db->get_where('mahasiswa', array('id_tahun_angkatan'=>$th->id_tahun_angkatan,'id_prodi'=>'2'))->num_rows(); ?>, 
			                  	b: <?php echo $this->db->get_where('mahasiswa', array('id_tahun_angkatan'=>$th->id_tahun_angkatan,'id_prodi'=>'1'))->num_rows(); ?> },
			                <?php } ?>
			                ],
			                xkey: 'y',
			                ykeys: ['a', 'b'],
			                labels: ['Teknik Informatika','Sistem Informasi'],
			                lineColors: [themeprimary, themethirdcolor]
			            });

			        }
			    };
			}();
            
            InitiateLineChart2.init();
            
        });
    </script>

<?php endif ?>

<?php if ($this->session->userdata('level') == '5'): ?>
	
<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
	    <div class="widget">
	        <div class="widget-header ">
	            <span class="widget-caption">Aktivitas Perkuliahan Mahasiswa</span>
	            <div class="widget-buttons">
	                <a href="#" data-toggle="maximize">
	                    <i class="fa fa-expand"></i>
	                </a>
	                <a href="#" data-toggle="collapse">
	                    <i class="fa fa-minus"></i>
	                </a>
	                <a href="#" data-toggle="dispose">
	                    <i class="fa fa-times"></i>
	                </a>
	            </div>
	        </div>
	        <div class="widget-body">
	        	<div class="table-scrollable">
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

						$nim = $this->session->userdata('username');

						$no = 1;
						$this->db->where('nim', $nim);
					    $this->db->group_by('kode_semester');
					    $this->db->order_by('kode_semester','asc');
					    $semester = $this->db->get('krs');
						foreach ($semester->result() as $rw): ?>
							<tr>
								<td><?php echo $no ?></td>
								<td><?php echo $nim ?></td>
								<td><?php echo get_data('mahasiswa','nim',$nim,'nama') ?></td>
								<td><?php $id_prodi = get_data('mahasiswa','nim',$nim,'id_prodi'); echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?></td>
								<td><?php $id_tahun_angkatan = get_data('mahasiswa','nim',$nim,'id_tahun_angkatan'); echo get_data('tahun_angkatan','id_tahun_angkatan',$id_tahun_angkatan,'tahun_angkatan') ?></td>
								<td><?php echo get_data('tahun_akademik','kode_tahun',$rw->kode_semester,'keterangan') ?></td>
								<td><?php echo 'Aktif' ?></td>
								<td><?php echo number_format(ips($nim,$rw->kode_semester),2) ?></td>
								<td><?php echo number_format(ipk($nim,$rw->kode_semester),2) ?></td>
								<td style="text-align: center;"><?php echo sks_semester($nim,$rw->kode_semester) ?></td>
								<td style="text-align: center;"><?php echo sks_total($nim,$rw->kode_semester) ?></td>
							</tr>
						<?php $no++; endforeach ?>
	                    </tbody>
	                </table>
	        	</div>
            </div>
	    </div>
	</div>
</div>


<?php endif ?>

