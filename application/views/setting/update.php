<?php 
$sett = $data->row();
 ?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="well bordered-top bordered-darkorange">
            <h5 class="label label-success">Setting Absen Ujian</h5>
            <p>
                
                Fitur ini untuk membuka akses absensi ujian UTS/UAS. <br>
                Silah Klik Tombol dibawah ini :

            </p>
            <hr class="wide">

            <?php if ($sett->absen_uts == 't'): ?>
                <a onclick="javasciprt: return confirm('Apakah kamu yakin membuka akses Absen UTS Mahasiswa ?')" href="app/akses_absen_ujian/uts/y" class="btn btn-info">Open UTS</a>
            <?php else: ?>
                <a onclick="javasciprt: return confirm('Apakah kamu yakin tutup akses Absen UTS Mahasiswa ?')" href="app/akses_absen_ujian/uts/t" class="btn btn-danger">Tutup UTS</a>
            <?php endif ?>

            <?php if ($sett->absen_uas == 't'): ?>
                <a onclick="javasciprt: return confirm('Apakah kamu yakin membuka akses Absen UAS Mahasiswa ?')" href="app/akses_absen_ujian/uas/y" class="btn btn-info">Open UAS</a>
            <?php else: ?>
                <a onclick="javasciprt: return confirm('Apakah kamu yakin tutup akses Absen UAS Mahasiswa ?')" href="app/akses_absen_ujian/uas/t" class="btn btn-danger">Tutup UAS</a>
            <?php endif ?>

            
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="well bordered-top bordered-darkorange">
            <h5 class="label label-warning">Hapus Semua Data di Tabel SIAKAD</h5>
            <p>
                Hati-hati menggunakan fitur ini. <br>
                Fitur ini hanya digunakan jika anda telah melakukan testing dan ingin menghapus semua data testing anda. <br>

            </p>
            <hr class="wide">
            <a onclick="javasciprt: return confirm('Apakah kamu yakin akan menghapus semua tabel di siakad ini, jika iya maka semua data akan terhapus permananen ?')" href="app/#clear_tabel" class="btn btn-danger">Clear Semua Tabel</a>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
            </div>
        <div class="widget-body">

        	<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
        		<div class="form-group">
                    <label for="nama_kampus" class="col-sm-2 control-label no-padding-right">Nama Kampus *</label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control" id="nama_kampus" name="nama_kampus" value="<?php echo $sett->nama_kampus ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="col-sm-2 control-label no-padding-right">Alamat Kampus *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="alamat" id="alamat" rows="5"><?php echo $sett->alamat ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat" class="col-sm-2 control-label no-padding-right">Kop Kampus *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control textarea_editor" name="kop" id="kop" rows="5"><?php echo $sett->kop ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="logo" class="col-sm-2 control-label no-padding-right">Logo *</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="logo">
                        <div>
                        	<?php if ($sett->logo!=''): ?>
                                <input type="hidden" name="logo_old" value="<?php echo $sett->logo ?>">
                        		<img src="image/<?php echo $sett->logo ?>" style="width: 100px;">
                        	<?php endif ?>
                        </div>
                        <p style="color: red">*)max ukuran file 10MB</p>
                    </div>
                    <div class="form-group">
                    	<div class="col-sm-offset-2 col-sm-10">
                    		<button type="submit" class="btn btn-primary">Update</button>
                            
                    	</div>
                    </div>
                </div>
        	</form>

        </div>

    </div>
</div>
</div>



<script type="text/javascript" src="assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: ".textarea_editor",
        height: "500",
        plugins: [
             "advlist autolink link image lists charmap print preview hr anchor pagebreak fullscreen",
             "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
             "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
       ],
       toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
       toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
       image_advtab: true ,
       
       external_filemanager_path:"assets/filemanager/",
       filemanager_title:"Responsive Filemanager" ,
       external_plugins: { "filemanager" : "<?php echo base_url() ?>assets/filemanager/plugin.min.js"}
   });

</script>