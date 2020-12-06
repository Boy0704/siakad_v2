<div id="horizontal-form">
    <form class="form-horizontal" action="api_feeder/kurikulum" method="POST" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">Kurikulum</label>
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
                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></button>
            </div>
        </div>

    </form>
</div>

<hr>

<div id="horizontal-form">
    <form class="form-horizontal" action="api_feeder/matakuliah_kurikulum" method="POST" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">Matakuliah Kurikulum</label>
            <div class="col-sm-4">
                <select name="id_sms" id="id_sms" style="width:100%;" required="">
                    <option value="">--Pilih Prodi --</option>
                    <?php 
                    foreach ($this->db->get('feeder_sms')->result() as $rw): 
                        ?>
                        <option value="<?php echo $rw->id_sms ?>"><?php echo $rw->kode_prodi.' - '. $rw->nm_lemb ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-sm-4">
                <select name="id_kurikulum_sp" id="id_kurikulum_sp" style="width:100%;" required="">
                    <option value="">--Pilih Kurikulum --</option>
                    
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></button>
            </div>
        </div>

    </form>
</div>

<hr>

<div id="horizontal-form">
    <form class="form-horizontal" action="api_feeder/kelas_kuliah" method="POST" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">Kelas Kuliah</label>
            <div class="col-sm-4">
                <select name="id_sms" id="id_sms" style="width:100%;" required="">
                    <option value="">--Pilih Prodi --</option>
                    <?php 
                    foreach ($this->db->get('feeder_sms')->result() as $rw): 
                        ?>
                        <option value="<?php echo $rw->id_sms ?>"><?php echo $rw->kode_prodi.' - '. $rw->nm_lemb ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-sm-4">
                <select name="id_kurikulum_sp" id="id_kurikulum_sp" style="width:100%;" required="">
                    <option value="">--Pilih Semester --</option>
                    
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></button>
            </div>
        </div>

    </form>
</div>

<hr>

<div id="horizontal-form">
    <form class="form-horizontal" action="api_feeder/dosen_ajar" method="POST" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">Dosen Ajar</label>
            <div class="col-sm-4">
                <select name="id_sms" id="id_sms" style="width:100%;" required="">
                    <option value="">--Pilih Prodi --</option>
                    <?php 
                    foreach ($this->db->get('feeder_sms')->result() as $rw): 
                        ?>
                        <option value="<?php echo $rw->id_sms ?>"><?php echo $rw->kode_prodi.' - '. $rw->nm_lemb ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-sm-4">
                <select name="id_kurikulum_sp" id="id_kurikulum_sp" style="width:100%;" required="">
                    <option value="">--Pilih Semester --</option>
                    
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></button>
            </div>
        </div>

    </form>
</div>

<hr>

<div id="horizontal-form">
    <form class="form-horizontal" action="api_feeder/nilai_mahasiswa" method="POST" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">KRS dan KHS Mahasiswa</label>
            <div class="col-sm-4">
                <select name="id_sms" id="id_sms" style="width:100%;" required="">
                    <option value="">--Pilih Prodi --</option>
                    <?php 
                    foreach ($this->db->get('feeder_sms')->result() as $rw): 
                        ?>
                        <option value="<?php echo $rw->id_sms ?>"><?php echo $rw->kode_prodi.' - '. $rw->nm_lemb ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-sm-4">
                <select name="id_kurikulum_sp" id="id_kurikulum_sp" style="width:100%;" required="">
                    <option value="">--Pilih Semester --</option>
                    
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></button>
            </div>
        </div>

    </form>
</div>

<hr>

<div id="horizontal-form">
    <form class="form-horizontal" action="api_feeder/akm_mahasiswa" method="POST" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left">Aktivitas Kuliah Mahasiswa</label>
            <div class="col-sm-4">
                <select name="id_sms" id="id_sms" style="width:100%;" required="">
                    <option value="">--Pilih Prodi --</option>
                    <?php 
                    foreach ($this->db->get('feeder_sms')->result() as $rw): 
                        ?>
                        <option value="<?php echo $rw->id_sms ?>"><?php echo $rw->kode_prodi.' - '. $rw->nm_lemb ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-sm-4">
                <select name="id_kurikulum_sp" id="id_kurikulum_sp" style="width:100%;" required="">
                    <option value="">--Pilih Semester --</option>
                    
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></button>
            </div>
        </div>

    </form>
</div>