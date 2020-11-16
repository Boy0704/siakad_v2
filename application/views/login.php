<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title><?php echo get_data('setting','id_setting','1','nama_kampus').' - '.$judul_page ?></title>
    <base href="<?php echo base_url() ?>">

    <meta name="description" content="login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="image/<?php echo get_data('setting','id_setting','1','logo') ?>" type="image/x-icon">

    <!--Basic Styles-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="#" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />

    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">

    <!--Beyond styles-->
    <link id="beyond-link" href="assets/css/beyond.min.css" rel="stylesheet" />
    <link href="assets/css/demo.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="#" rel="stylesheet" type="text/css" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="assets/js/skins.min.js"></script>
</head>
<!--Head Ends-->
<!--Body-->
<body>
    <div class="login-container animated fadeInDown">
        <div class="loginbox bg-white">
            <!-- <div style="margin-top: 10px;">
                <center>
                    <img class="loader_img" src="image/<?php echo get_data('setting','id_setting','1','logo') ?>" alt="<?php echo get_data('setting','id_setting','1','nama_kampus') ?>" style="width: 100px; height: 100px;"/>
                </center>
            </div> -->
            <div class="logobox">
                <img class="loader_img" src="image/<?php echo get_data('setting','id_setting','1','logo') ?>" alt="<?php echo get_data('setting','id_setting','1','nama_kampus') ?>" style="width: 100px; height: 100px;"/>
            </div>
            <div class="loginbox-title"><?php echo get_data('setting','id_setting','1','nama_kampus') ?></div>
            <div class="loginbox-social">
                <div class="social-title ">Silahkan Login menggunakan Username dan Password kamu.</div>
                
            </div>
            <form action="login/auth" method="POST">
                <div class="loginbox-textbox">
                    <input type="text" name="username" class="form-control" placeholder="Username" autofocus="" />
                </div>
                <div class="loginbox-textbox">
                    <input type="password" name="password" class="form-control" placeholder="Password" />
                </div>
                
                <div class="loginbox-submit">
                    <input type="submit" class="btn btn-primary btn-block" value="Login">
                </div>
            </form>
            
        </div>
        
    </div>

    <!--Basic Scripts-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slimscroll/jquery.slimscroll.min.js"></script>

    <!--Beyond Scripts-->
    <script src="assets/js/beyond.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript"><?php echo $this->session->userdata('message') ?></script>

    
</body>
<!--Body Ends-->

<!-- Mirrored from beyondadmin-v1.6.1.s3-website-us-east-1.amazonaws.com/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 31 Oct 2020 06:34:41 GMT -->
</html>
