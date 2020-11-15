<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page ?></span>

                <!-- <div class="widget-buttons">
                    <a href="#" data-toggle="maximize">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="#" data-toggle="dispose">
                        <i class="fa fa-times"></i>
                    </a>
                </div> -->
            </div>

            <div class="widget-body no-padding">
                <div class="widget-main ">
                    <div class="panel-group accordion" id="accordion">

                    <?php foreach ($semester->result() as $rw): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $rw->kode_semester ?>">
                                        <?php echo "Kartu Hasil Studi ( ".get_data('tahun_akademik','kode_tahun',$rw->kode_semester,'keterangan')." )" ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="<?php echo $rw->kode_semester ?>" class="panel-collapse collapse">
                                <div class="panel-body border-red">
                                    
                                    <?php 
                                    $dt['nim'] = $this->session->userdata('username');
                                    $dt['kode_semester'] = $rw->kode_semester;
                                    $this->load->view('krs/isi_khs', $dt);
                                     ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>