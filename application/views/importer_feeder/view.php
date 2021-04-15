<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bg-themeprimary">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>

            <div class="widget-body">
                <div class="widget-main ">
                    
                    <div id="horizontal-form">
                        <form class="form-horizontal" action="importer_feeder/data_mahasiswa" method="GET" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-left">Data Mahasiswa</label>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">
                                    <select name="angkatan" id="angkatan" style="width:100%;" required="">
                                        <option value="">--Pilih Angkatan --</option>
                                        <?php 
                                        $this->db->order_by('tahun_angkatan', 'desc');
                                        foreach ($this->db->get('tahun_angkatan')->result() as $rw): 
                                            ?>
                                            <option value="<?php echo $rw->id_tahun_angkatan ?>" ><?php echo $rw->tahun_angkatan ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <hr>

                    <div id="horizontal-form">
                        <form class="form-horizontal" action="importer_feeder/data_akm" method="GET" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-left">Data AKM</label>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">
                                    <select name="periode" id="periode" style="width:100%;" required="">
                                        <option value="">--Pilih Periode --</option>
                                        <?php 
                                        $this->db->order_by('kode_tahun', 'desc');
                                        foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                                            ?>
                                            <option value="<?php echo $rw->kode_tahun ?>" ><?php echo $rw->kode_tahun.' - '. $rw->keterangan ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <hr>

                    <div id="horizontal-form">
                        <form class="form-horizontal" action="importer_feeder/matkul_kurikulum" method="GET" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-left">Matakuliah Kurikulum</label>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">
                                    <select name="id_kurikulum" id="id_kurikulum" style="width:100%;" required="">
                                        <option value="">--Pilih Kurikulum --</option>
                                        <?php 
                                        foreach ($this->db->get('kurikulum')->result() as $rw): 
                                            ?>
                                            <option value="<?php echo $rw->id_kurikulum ?>" ><?php echo $rw->kurikulum ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <hr>

                    <div id="horizontal-form">
                        <form class="form-horizontal" action="importer_feeder/data_kelas" method="GET" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-left">Data Kelas</label>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">
                                    <select name="periode" id="periode" style="width:100%;" required="">
                                        <option value="">--Pilih Periode --</option>
                                        <?php 
                                        $this->db->order_by('kode_tahun', 'desc');
                                        foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                                            ?>
                                            <option value="<?php echo $rw->kode_tahun ?>" ><?php echo $rw->kode_tahun.' - '. $rw->keterangan ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <hr>

                    <div id="horizontal-form">
                        <form class="form-horizontal" action="importer_feeder/dosen_ajar" method="GET" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-left">Dosen Ajar</label>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">
                                    <select name="periode" id="periode" style="width:100%;" required="">
                                        <option value="">--Pilih Periode --</option>
                                        <?php 
                                        $this->db->order_by('kode_tahun', 'desc');
                                        foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                                            ?>
                                            <option value="<?php echo $rw->kode_tahun ?>" ><?php echo $rw->kode_tahun.' - '. $rw->keterangan ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <hr>

                    <div id="horizontal-form">
                        <form class="form-horizontal" action="importer_feeder/data_krs" method="GET" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-left">Data KRS</label>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">
                                    <select name="periode" id="periode" style="width:100%;" required="">
                                        <option value="">--Pilih Periode --</option>
                                        <?php 
                                        $this->db->order_by('kode_tahun', 'desc');
                                        foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                                            ?>
                                            <option value="<?php echo $rw->kode_tahun ?>" ><?php echo $rw->kode_tahun.' - '. $rw->keterangan ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <hr>

                    <div id="horizontal-form">
                        <form class="form-horizontal" action="importer_feeder/data_khs" method="GET" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-left">Data KHS</label>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">
                                    <select name="periode" id="periode" style="width:100%;" required="">
                                        <option value="">--Pilih Periode --</option>
                                        <?php 
                                        $this->db->order_by('kode_tahun', 'desc');
                                        foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                                            ?>
                                            <option value="<?php echo $rw->kode_tahun ?>" ><?php echo $rw->kode_tahun.' - '. $rw->keterangan ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <hr>
                
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#id_kurikulum").select2();
    });
</script>

