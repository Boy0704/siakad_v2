<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bg-themeprimary">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>

            <div class="widget-body">
                <div class="widget-main ">
                    <div class="tabbable">
                        <ul class="nav nav-tabs tabs-flat" id="myTab11">
                            <li class="active">
                                <a data-toggle="tab" href="#uts">
                                    Ujian UTS
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#uas">
                                    Ujian UAS
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tabs-flat">
                            <div id="uts" class="tab-pane in active">
                                <?php $this->load->view('absensi/ujian_uts'); ?>
                            </div>

                            <div id="uas" class="tab-pane">
                                <?php $this->load->view('absensi/ujian_uas'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>