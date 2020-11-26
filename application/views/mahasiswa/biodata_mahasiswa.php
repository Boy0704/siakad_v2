<?php 
$mhs = $data_mhs->row();
$data['nim'] = $mhs->nim;
 ?>
<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-lightred">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>
            <div class="widget-body">
                <div id="horizontal-form">
                    <form class="form-horizontal" action="mahasiswa/update_biodata_mahasiswa" method="POST" role="form">
                        <div class="form-group">
                            <label for="Nama" class="col-sm-2 control-label no-padding-right">NIM *</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="nim" value="<?php echo $mhs->nim ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama" class="col-sm-2 control-label no-padding-right">Nama *</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="nama" name="nama" placeholder="contoh: Ilham Saputra" value="<?php echo $mhs->nama ?>" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin" class="col-sm-2 control-label no-padding-right">Jenis Kelamin *</label>
                            <div class="col-sm-10">
                                <div class="radio">
					                <label>
					                    <input type="radio" name="jenis_kelamin" value="L" <?php 
                                        $jenis_kelamin = $mhs->jenis_kelamin;
                                        echo $retVal = ($jenis_kelamin!='P' or $jenis_kelamin=='') ? 'checked' : '' ; ?> >
					                    <span class="text">Laki-laki</span>
					                </label>
					                <label>
					                    <input type="radio" name="jenis_kelamin" value="P" <?php 
                                        $jenis_kelamin = $mhs->jenis_kelamin;
                                        echo $retVal = ($jenis_kelamin=='P') ? 'checked' : '' ; ?> >
					                    <span class="text">Perempuan</span>
					                </label>
					            </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">Tempat Lahir *</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="contoh: Jakarta" value="<?php echo $mhs->tempat_lahir ?>" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">Tanggal Lahir *</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control date-picker" id="tanggal_lahir" type="text" name="tanggal_lahir" data-date-format="yyyy-mm-dd" value="<?php echo $mhs->tanggal_lahir ?>" autocomplete="off">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tahun_angkatan" class="col-sm-2 control-label no-padding-right">Tahun Angkatan *</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo get_data('tahun_angkatan','id_tahun_angkatan',$mhs->id_tahun_angkatan,'tahun_angkatan') ?>" readonly="">
                            </div>
                        </div>


						<div class="form-group">
                            <label for="prodi" class="col-sm-2 control-label no-padding-right">Prodi *</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo get_data('prodi','id_prodi',$mhs->id_prodi,'prodi') ?>" readonly="">
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <label for="jenis_pendaftaran" class="col-sm-2 control-label no-padding-right">Dosen PA *</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo get_data('dosen','id_dosen',$mhs->dosen_pa,'nama') ?>" readonly="">
                            </div>
                        </div>

                        <div class="widget-main ">
                            <div class="tabbable">
                                <ul class="nav nav-tabs tabs-flat" id="myTab11">
                                    <li class="active">
                                        <a data-toggle="tab" href="#alamat">
                                            Alamat
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#orantua">
                                            Orang Tua
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#wali">
                                            Wali
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content tabs-flat">
                                    <div id="alamat" class="tab-pane in active">
                                        <?php $this->load->view('mahasiswa/tab_alamat', $data); ?>
                                    </div>

                                    <div id="orantua" class="tab-pane">
                                        <?php $this->load->view('mahasiswa/tab_orang_tua', $data); ?>
                                    </div>

                                    <div id="wali" class="tab-pane">
                                        <?php $this->load->view('mahasiswa/tab_wali', $data); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#kecamatan").select2();
    });
</script>