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
                            <option value="">--Pilih Kelas --</option>
                            <?php 
                            $sql = "SELECT kelas FROM krs WHERE kelas is not null GROUP BY kelas";
                            foreach ($this->db->query($sql)->result() as $rw): ?>
                                <option value="<?php echo $rw->kelas ?>"><?php echo $rw->kelas ?></option>
                            <?php endforeach ?>
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

    ?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> [ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>MK</b> : <?php echo get_data('master_matakuliah','kode_mk',$kode_mk,'nama_mk') ?>, <b>Kelas</b> : <?php echo $kls = ($kelas !='') ? $kelas : 'Semua Kelas' ; ?> ]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                <br><br>

                <div class="table-scrollable">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nim</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">MK</th>
                                <th colspan="4" style="text-align: center;">NILAI</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Angka</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Huruf</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Indeks</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Pilihan</th>
                            </tr>
                            <tr>
                                <th>Absen (10%)</th>
                                <th>Latihan (20%)</th>
                                <th>UTS (30%)</th>
                                <th>UAS (40%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if ($kelas !='') {
                                $this->db->where('kelas', $kelas);
                            }
                            $this->db->where('id_dosen', $this->session->userdata('keterangan'));
                            $this->db->where('kode_semester', $kode_semester);
                            $this->db->where('id_prodi', $id_prodi);
                            $this->db->where('kode_mk', $kode_mk);
                            foreach ($this->db->get('krs')->result() as $rw): ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $rw->nim ?></td>
                                <td><?php echo get_data('mahasiswa','nim',$rw->nim,'nama') ?></td>
                                <td><?php echo $rw->nama_mk ?></td>
                                <td>
                                    <form action="krs/simpan_nilai_mahasiswa/<?php echo $rw->id_krs.'?'.param_get() ?>" method="POST">
                                    <input type="number" name="kehadiran" value="<?php echo $rw->kehadiran ?>" required>
                                </td>
                                <td>
                                    <input type="number" name="latihan" value="<?php echo $rw->latihan ?>" required>
                                </td>
                                <td>
                                    <input type="number" name="uts" value="<?php echo $rw->uts ?>" required>
                                </td>
                                <td>
                                    <input type="number" name="uas" value="<?php echo $rw->uas ?>" required>
                                </td>
                                <td><?php echo $rw->angka ?></td>
                                <td><?php echo $rw->huruf ?></td>
                                <td><?php echo $rw->indeks ?></td>
                                <td>
                                    <?php if ($rw->kehadiran != ''): ?>
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>
                                    <?php endif ?>
                                    </form>
                                </td>
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#id_prodi").change(function() {
            var id_prodi = $(this).val();
            $.ajax({url: "kelas_ajar/get_select_mk/"+id_prodi, success: function(result){
                    $("#kode_mk").html(result);
                  console.log("success");
                }});
            
        });

    });
</script>