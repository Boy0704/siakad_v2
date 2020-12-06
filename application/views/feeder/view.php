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
                            <?php 
                            $tab_aktif = ($_GET && $_GET['active']!='') ? $_GET['active'] : '';
                             ?>
                            <li class="<?php echo ($tab_aktif == '') ? 'active' : '' ?>">
                                <a data-toggle="tab" href="#set_koneksi" aria-expanded="true">
                                    Setting Koneksi
                                </a>
                            </li>
                            <li class="<?php echo ($tab_aktif == 'data_utama') ? 'active' : '' ?>">
                                <a data-toggle="tab" href="#data_utama" aria-expanded="false">
                                    Data Utama
                                </a>
                            </li>
                            <li class="<?php echo ($tab_aktif == 'perkuliahan') ? 'active' : '' ?>">
                                <a data-toggle="tab" href="#perkuliahan" aria-expanded="false">
                                    Perkuliahan
                                </a>
                            </li>
                            <li class="<?php echo ($tab_aktif == 'pelengkap') ? 'active' : '' ?>">
                                <a data-toggle="tab" href="#pelengkap" aria-expanded="false">
                                    Pelengkap
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tabs-flat">
                            <div style="margin-bottom: 10px;">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                            <div id="set_koneksi" class="tab-pane <?php echo ($tab_aktif == '') ? 'active' : '' ?>">
                                <?php $this->load->view('feeder/v_koneksi'); ?>
                            </div>

                            <div id="data_utama" class="tab-pane <?php echo ($tab_aktif == 'data_utama') ? 'active' : '' ?>">
                               <?php $this->load->view('feeder/v_data_utama'); ?>
                            </div>
                            <div id="perkuliahan" class="tab-pane <?php echo ($tab_aktif == 'perkuliahan') ? 'active' : '' ?>">
                               <?php $this->load->view('feeder/v_perkuliahan'); ?>
                            </div>
                            <div id="pelengkap" class="tab-pane <?php echo ($tab_aktif == 'pelengkap') ? 'active' : '' ?>">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalLog" style="display:none;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>No.</td>
                <td>Code Error</td>
                <td>Deskripsi Error</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($this->db->get('feeder_log_error')->result() as $rw): ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $rw->error_code ?></td>
                <td><?php echo $rw->error_desc ?></td>
            </tr>
            <?php $no++; endforeach ?>
        </tbody>
    </table>
</div>

<div id="modalLogMahasiswa" style="display:none;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>No.</td>
                <td>Nim</td>
                <td>Nama</td>
                <td>Code Error</td>
                <td>Deskripsi Error</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($this->db->get('feeder_log_error_mahasiswa')->result() as $rw): ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $rw->nim ?></td>
                <td><?php echo get_data('mahasiswa','nim',$rw->nim,'nama') ?></td>
                <td><?php echo $rw->error_code ?></td>
                <td><?php echo $rw->error_desc ?></td>
            </tr>
            <?php $no++; endforeach ?>
        </tbody>
    </table>
</div>

<script src="assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#lihatLog").on('click', function () {
            bootbox.dialog({
                message: $("#modalLog").html(),
                title: "Log Error",
                className: "modal-darkorange",
            });
        });

        $("#lihatLogMahasiswa").on('click', function () {
            bootbox.dialog({
                message: $("#modalLogMahasiswa").html(),
                title: "Log Error",
                className: "modal-darkorange",
            });
        });

    });
</script>