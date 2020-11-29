<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption">Filter</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <form class="form-inline" action="" method="get" role="form">
                    <div class="form-group">
                        <select name="id_prodi" id="id_prodi" style="width:100%;" required="">
                            <option value="">--Pilih Prodi --</option>
                            <?php 
                            $this->db->where('aktif', 'y');
                            foreach ($this->db->get('prodi')->result() as $rw): 
                                ?>
                                <option value="<?php echo $rw->id_prodi ?>"><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="kode_mk" id="kode_mk" style="width:100%;" required="">
                            <option value="">--Pilih MK --</option>
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="kelas" id="kelas" style="width:100%;">
                            <option value="">--Semua Kelas --</option>
                            
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">FILTER</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($_GET):
    
    $id_prodi = $this->input->get('id_prodi');
    $kode_mk = $this->input->get('kode_mk');
    $kelas = $this->input->get('kelas');
    $kode_semester = tahun_akademik_aktif('kode_tahun');
    $id_dosen = $this->session->userdata('keterangan');

    ?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> [ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>MK</b> : <?php echo get_data('master_matakuliah','kode_mk',$kode_mk,'nama_mk') ?>, <b>Kelas</b> : <?php echo $kls = ($kelas !='') ? $kelas : 'Semua Kelas' ; ?> ]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                <br>
                
                <?php 
                $this->db->where('kode_mk', $kode_mk);
                $this->db->where('kode_semester', $kode_semester);
                $this->db->where('id_prodi', $id_prodi);
                $this->db->where('kelas', $kelas);
                $this->db->where('id_dosen', $id_dosen);
                $this->db->where('tanggal', date('Y-m-d'));
                $abs_dosen = $this->db->get('absen_dosen');
                if ($abs_dosen->num_rows() > 0) {
                    $abs_dosen = $abs_dosen->row();
                } else {
                    $abs_dosen = null;
                } 

                 ?>
                <form action="kelas_ajar/simpan_kehadiran?<?php echo param_get() ?>" method="POST">
                <table class="table table-bordered table-hover">
                    <input type="hidden" name="kode_mk" value="<?php echo $kode_mk ?>">
                    <input type="hidden" name="kode_semester" value="<?php echo $kode_semester ?>">
                    <input type="hidden" name="id_prodi" value="<?php echo $id_prodi ?>">
                    <input type="hidden" name="kelas" value="<?php echo $kelas ?>">
                    <input type="hidden" name="id_dosen" value="<?php echo $id_dosen ?>">
                    <input type="hidden" name="nama_dosen" value="<?php echo $this->session->userdata('nama') ?>">
                    <input type="hidden" name="date_absen" value="<?php echo get_waktu() ?>">
                    <tr>
                        <td>Tanggal</td>
                        <td><input type="text" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly></td>
                    </tr>
                    <tr>
                        <td>Dosen</td>
                        <td><?php echo $this->session->userdata('nama'); ?></td>
                    </tr>
                    <tr>
                        <td>Petemuan Ke</td>
                        <td><input type="number" class="form-control" name="pertemuan" value="<?php echo ($abs_dosen != null) ? $abs_dosen->pertemuan : '' ?>"></td>
                    </tr>
                    <tr>
                        <td>Pembahasan</td>
                        <td>
                            <textarea class="form-control" name="pembahasan"><?php echo ($abs_dosen != null) ? $abs_dosen->pembahasan : '' ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button></td>
                    </tr>
                </table>
                </form>

                <hr>

                <?php if ($abs_dosen!=null): ?>
                <div id="pesanAlert" style="display: none; margin-bottom: 10px;"></div>
                
                <div class="table-scrollable">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="20">No</th>
                                <th>Nim</th>
                                <th>Nama</th>
                                <th width="50">Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if ($kelas !='') {
                                $this->db->where('kelas', $kelas);
                            }
                            $this->db->select('a.id_krs,a.nim,b.kehadiran');
                            $this->db->from('krs a');
                            $this->db->join('absen_mahasiswa b', 'a.id_krs =b.id_krs', 'left');
                            $this->db->where('a.id_dosen', $id_dosen);
                            $this->db->where('a.kode_semester', $kode_semester);
                            $this->db->where('a.id_prodi', $id_prodi);
                            $this->db->where('a.kode_mk', $kode_mk);
                            foreach ($this->db->get()->result() as $rw): ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $rw->nim ?></td>
                                <td><?php echo get_data('mahasiswa','nim',$rw->nim,'nama') ?></td>
                                <td>
                                    <select name="kehadiran" onchange="absen_mhs('<?php echo $rw->id_krs ?>','<?php echo $rw->nim ?>')" id="kehadiran_<?php echo $rw->id_krs ?>">
                                        <option value="">--Pilih--</option>
                                        <option value="h" <?php echo ($rw->kehadiran == 'h') ? 'selected' : '' ?>>Hadir</option>
                                        <option value="a" <?php echo ($rw->kehadiran == 'a') ? 'selected' : '' ?>>Alfa</option>
                                        <option value="i" <?php echo ($rw->kehadiran == 'i') ? 'selected' : '' ?>>Izin</option>
                                        <option value="s" <?php echo ($rw->kehadiran == 's') ? 'selected' : '' ?>>Sakit</option>
                                    </select>
                                </td>
                            </tr>
                            <?php $no++; endforeach ?>
                            
                        </tbody>
                    </table>
                </div>

                <?php endif ?>


            </div>
        </div>
    </div>
</div>



<?php endif ?>

<script type="text/javascript">

    function absen_mhs(id_krs,nim) {
        var val = $("#kehadiran_"+id_krs).val();
        $.ajax({url: "kelas_ajar/absen_mhs", 
            type: 'POST',
            dataType: 'html',
            data: {id_krs: id_krs, nim: nim, kehadiran: val,id_absen_dosen: '<?php echo ($abs_dosen != null) ? $abs_dosen->id_absen_dosen : ''  ?>'},
            beforeSend: function(){
                $(".loading-container").show();
                $(".loader").show();
            },
            success: function(result){
                console.log("success");
                $("#pesanAlert").show();
                $("#pesanAlert").html(result);
                // window.location='<?php echo base_url() ?>kelas_ajar/absensi_mahasiswa?<?php echo param_get() ?>';
            },
            complete:function(data){
                $(".loading-container").hide();
                $(".loader").hide();
            }
        });
    }


    $(document).ready(function() {
        $("#id_prodi").change(function() {
            var id_prodi = $(this).val();
            $.ajax({url: "kelas_ajar/get_select_mk/"+id_prodi, 
                beforeSend: function(){
                    $(".loading-container").show();
                    $(".loader").show();
                },
                success: function(result){
                    $("#kode_mk").html(result);
                  console.log("success");
                },
                complete:function(data){
                    $(".loading-container").hide();
                    $(".loader").hide();
                }
            });
            
        });

        $("#kode_mk").change(function() {
            var kode_mk = $(this).val();
            var id_prodi = $("#id_prodi").val();
            $.ajax({url: "kelas_ajar/get_select_kelas/"+id_prodi+"/"+kode_mk, 
                beforeSend: function(){
                    $(".loading-container").show();
                    $(".loader").show();
                },
                success: function(result){
                    $("#kelas").html(result);
                  console.log("success");
                },
                complete:function(data){
                    $(".loading-container").hide();
                    $(".loader").hide();
                }
            });
            
        });

    });
</script>