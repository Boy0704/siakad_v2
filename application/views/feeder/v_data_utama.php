<div id="horizontal-form">
    <form class="form-horizontal" action="api_feeder/mahasiswa" method="POST" role="form">
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
                <select name="id_tahun_angkatan" id="id_tahun_angkatan" style="width:100%;" required="">
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
                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></button>
            </div>
        </div>

    </form>
</div>