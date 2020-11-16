<?php 
if ($this->session->userdata('level') == '') {
    redirect('login','refresh');
}
 ?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title><?php echo get_data('setting','id_setting','1','nama_kampus').' - '.$judul_page ?></title>
    <base href="<?php echo base_url() ?>">

    <meta name="description" content="data tables" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="image/<?php echo get_data('setting','id_setting','1','logo') ?>" type="image/x-icon">

    <!--Basic Styles-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="#" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/weather-icons.min.css" rel="stylesheet" />

    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">

    <!--Beyond styles-->
    <link id="beyond-link" href="assets/css/beyond.min.css" rel="stylesheet" />
    <link href="assets/css/demo.min.css" rel="stylesheet" />
    <link href="assets/css/typicons.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="#" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .loader_img{
          height: 100px;
          width: 100px;
          position: absolute;
          left: 50%;
          top: 45%;
          transform: translate(-50%, -50%);
        }
    </style>

    <!--Page Related styles-->
    <link href="assets/css/dataTables.bootstrap.css" rel="stylesheet" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="assets/js/skins.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
</head>
<!-- /Head -->
<!-- Body -->
<body>
    <!-- Loading Container -->
    <div class="loading-container">
        <img class="loader_img" src="image/<?php echo get_data('setting','id_setting','1','logo') ?>" alt="<?php echo get_data('setting','id_setting','1','nama_kampus') ?>" style="width: 50px; height: 50px;"/>
        <div class="loader"></div>
    </div>
    <!--  /Loading Container -->
    <!-- Navbar -->
    <?php $this->load->view('page/navbar.php'); ?>
    <!-- /Navbar -->
    <!-- Main Container -->
    <div class="main-container container-fluid">
        <!-- Page Container -->
        <div class="page-container">
            <!-- Page Sidebar -->
            <?php $this->load->view('page/sidebar'); ?>
            <!-- /Page Sidebar -->
            
            <!-- Page Content -->
            <div class="page-content">
                <!-- Page Breadcrumb -->
                <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="">Home</a>
                        </li>
                        <li>
                            <?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1))) ?>
                        </li>
                        <li class="active"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(2))) ?></li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <span>Semester Aktif :</span>
                        <h1>
                            <?php 
                            if (tahun_akademik_aktif('id_tahun_akademik') != '') {
                                echo tahun_akademik_aktif('keterangan').' - ('.tahun_akademik_aktif('kode_tahun').')';
                            } else {
                                echo "Tidak ada Tahun Akademik yang aktif (Segera aktifkan salah satu tahun akademik )";
                             
                            }
                            ?>
                        </h1>
                    </div>
                    <!--Header Buttons-->
                    <div class="header-buttons">
                        <a class="sidebar-toggler" href="#">
                            <i class="fa fa-arrows-h"></i>
                        </a>
                        <a class="refresh" id="refresh-toggler" href="<?php echo current_url(); ?>">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </a>
                        <a class="fullscreen" id="fullscreen-toggler" href="#">
                            <i class="glyphicon glyphicon-fullscreen"></i>
                        </a>
                    </div>
                    <!--Header Buttons End-->
                </div>
                <!-- /Page Header -->
                <!-- Page Body -->
                <div class="page-body">
                    
                    <?php $this->load->view($konten); ?>
                    
                </div>
                <!-- /Page Body -->
            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Page Container -->
        <!-- Main Container -->

    </div>

    <!--Basic Scripts-->
    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slimscroll/jquery.slimscroll.min.js"></script>

    <!--Beyond Scripts-->
    <script src="assets/js/beyond.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        <?php echo $this->session->userdata('notif') ?>        
    </script>

    <!--Page Related Scripts-->
    <script src="assets/js/datatable/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatable/ZeroClipboard.js"></script>
    <script src="assets/js/datatable/dataTables.tableTools.min.js"></script>
    <script src="assets/js/datatable/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/datatable/datatables-init.js"></script>
    <script>
        InitiateSearchableDataTable.init();
    </script>
    <!--Bootstrap Date Picker-->
    <script src="assets/js/datetime/bootstrap-datepicker.js"></script>
    <script src="assets/js/jquery.idle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.date-picker').datepicker();
        });
    </script>

    <script type="text/javascript">
        $(document).idle({
            onIdle: function(){
                //alert('I\'m idle');
                $.ajax({url: "app/set_online_user/0", success: function(result){
                  console.log("success");
                }});
            },
            onActive: function(){
                //alert('Hey, I\'m back!');
                $.ajax({url: "app/set_online_user/1", success: function(result){
                  console.log("success");
                }});
            },
            idle: 60000
        });

        $(document).ready(function() {

            //set submenu aktif
            $("ul.submenu > li > a").click(function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: 'app/set_aktif_submenu',
                    type: 'POST',
                    dataType: 'html',
                    data: {id: id},
                })
                .done(function() {
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
                
            });

            //clear submenu aktif
            $("ul.nav > li > a").click(function() {
                $.ajax({url: "app/set_clear_submenu", success: function(result){
                  console.log("success");
                }});
                
            });


        });
    </script>
    
</body>
</html>
