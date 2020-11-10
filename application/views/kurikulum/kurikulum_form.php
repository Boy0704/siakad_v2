
<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
            </div>
        <div class="widget-body">
        <div>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Kode Kurikulum * <?php echo form_error('kode_kurikulum') ?></label>
            <input type="text" class="form-control" name="kode_kurikulum" id="kode_kurikulum" placeholder="Contoh: KR2019" value="<?php echo $kode_kurikulum; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Kurikulum * <?php echo form_error('kurikulum') ?></label>
            <input type="text" class="form-control" name="kurikulum" id="kurikulum" placeholder="Contoh: Kurikulum 2019 Ganjil" value="<?php echo $kurikulum; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Mulai Berlaku * <?php echo form_error('mulai_berlaku') ?></label>
            <select name="mulai_berlaku" id="mulai_berlaku" style="width:100%;">
                <option value="">--Pilih Tahun Akademik --</option>
                <?php 
                foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                    $checked = ($mulai_berlaku == $rw->kode_tahun) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->kode_tahun ?>" <?php echo $checked ?>><?php echo $rw->kode_tahun.' - '. $rw->keterangan ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Sks Wajib * <?php echo form_error('sks_wajib') ?></label>
            <input type="text" class="form-control" name="sks_wajib" id="sks_wajib" placeholder="Sks Wajib" value="<?php echo $sks_wajib; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Sks Pilihan * <?php echo form_error('sks_pilihan') ?></label>
            <input type="text" class="form-control" name="sks_pilihan" id="sks_pilihan" placeholder="Sks Pilihan" value="<?php echo $sks_pilihan; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Total Sks * <?php echo form_error('total_sks') ?></label>
            <input type="text" class="form-control" name="total_sks" id="total_sks" placeholder="Total Sks" value="<?php echo $total_sks; ?>" readonly/>
        </div>
	    <div class="form-group">
            <label for="int">Prodi * <?php echo form_error('id_prodi') ?></label>
            <select name="id_prodi" id="id_prodi" style="width:100%;">
                <option value="">--Pilih Prodi --</option>
                <?php 
                $this->db->where('aktif', 'y');
                foreach ($this->db->get('prodi')->result() as $rw): 
                    $checked = ($id_prodi == $rw->id_prodi) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_prodi ?>" <?php echo $checked ?>><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <input type="hidden" name="id_kurikulum" value="<?php echo $id_kurikulum; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('kurikulum') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#sks_wajib").keyup(function() {
            var sks_wajib = $("#sks_wajib").val();
            var sks_pilihan = $("#sks_pilihan").val();
            var hasil = parseInt(sks_wajib) + parseInt(sks_pilihan);
            $("#total_sks").val(parseInt(hasil));
        });

        $("#sks_pilihan").keyup(function() {
            var sks_wajib = $("#sks_wajib").val();
            var sks_pilihan = $("#sks_pilihan").val();
            var hasil = parseInt(sks_wajib) + parseInt(sks_pilihan);
            $("#total_sks").val(parseInt(hasil));
        });
    });
</script>
   