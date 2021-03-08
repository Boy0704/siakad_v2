<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
            </div>
        <div class="widget-body">
        <div>
        <form action="krs/tambah_krs?<?php echo param_get() ?>" method="post">
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
            <select name="id_jadwal" id="id_jadwal" style="width:100%;" required="">
                <option value="">--Pilih Matakuliah yang ada di jadwal --</option>
                <?php 
                $id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');
                $this->db->where('id_prodi', $this->input->get('id_prodi'));
                $this->db->where('id_tahun_akademik', $id_tahun_akademik);
                foreach ($this->db->get('jadwal_kuliah')->result() as $rw): 
                    ?>
                    <option value="<?php echo $rw->id_jadwal ?>"><?php echo get_data('matakuliah','id_mk',$rw->id_mk,'kode_mk').' - '. get_data('matakuliah','id_mk',$rw->id_mk,'nama_mk').' - semester '.$rw->semester ?></option>
                <?php endforeach ?>
            </select>
            
        </div>
	    
	    <button type="submit" class="btn btn-primary">Simpan</button> 
	    <a href="krs?<?php echo param_get() ?>" class="btn btn-default">Cancel</a>
	</form>
    </div>
</div>
</div>
<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#id_jadwal").select2();
    });
</script>