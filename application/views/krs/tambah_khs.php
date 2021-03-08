<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
            </div>
        <div class="widget-body">
        <div>
        <form action="krs/tambah_khs?<?php echo param_get() ?>" method="post">
        <div class="form-group">
            <label for="int">Nim </label>
            <input type="text" class="form-control" name="nim" id="nim" value="<?php echo $this->input->get('nim') ?>" readonly />
        </div>

        <div class="form-group">
            <label for="int">Nama </label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo get_data('mahasiswa','nim',$this->input->get('nim'),'nama') ?>" readonly />
        </div>
	    <div class="form-group">
            <label for="int">Matakuliah *</label>
            <select name="id_mk" id="id_mk" style="width:100%;" required="">
                <option value="">--Pilih Matakuliah yang ada di master matakuliah --</option>
                <?php 
                $this->db->where('id_prodi', $this->input->get('id_prodi'));
                foreach ($this->db->get('master_matakuliah')->result() as $rw): 
                    ?>
                    <option value="<?php echo $rw->id_mk ?>"><?php echo $rw->kode_mk.' - '. $rw->nama_mk .' - Semester'.$rw->semester ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group">
            <label>Periode *</label>
            <select name="periode" id="periode" style="width:100%;" required="">
                <option value="">--Pilih Periode --</option>
                <?php 
                $this->db->order_by('kode_tahun', 'desc');
                foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                    ?>
                    <option value="<?php echo $rw->kode_tahun ?>"><?php echo $rw->kode_tahun.' - '.$rw->keterangan ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group">
            <label>Nilai *</label>
            <input type="number" class="form-control" name="nilai" id="nilai" value="" required="" />
        </div>
	    
	    <button type="submit" class="btn btn-primary">Simpan</button> 
	    <a href="krs/khs?<?php echo param_get() ?>" class="btn btn-default">Cancel</a>
	</form>
    </div>
</div>
</div>
<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#id_mk").select2();
    });
</script>