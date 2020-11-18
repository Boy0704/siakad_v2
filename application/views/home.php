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
			                  { y: '<?php echo $th->tahun_angkatan ?>', a: <?php echo $this->db->get_where('mahasiswa', array('id_tahun_angkatan'=>$th->id_tahun_angkatan,'id_prodi'=>'2'))->num_rows(); ?>, b: <?php echo $this->db->get_where('mahasiswa', array('id_tahun_angkatan'=>$th->id_tahun_angkatan,'id_prodi'=>'1'))->num_rows(); ?> },
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
