
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
            <label for="varchar">Nim *<?php echo form_error('nim') ?></label>
            <!-- <input type="text" class="form-control" name="nim" id="nim" placeholder="Nim" value="<?php echo $nim; ?>" /> -->
            <select name="nim" id="nim" style="width:100%;" >
                <option value="">--Pilih Mahasiswa --</option>
                <?php 
                $this->db->select('nim,nama');
                $this->db->where('status_mhs', 1);
                foreach ($this->db->get('mahasiswa')->result() as $rw): 
                    $checked = ($nim == $rw->nim) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->nim ?>" <?php echo $checked ?>><?php echo $rw->nim.' - '.$rw->nama ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Biaya *<?php echo form_error('id_biaya') ?></label>
            <select name="id_biaya" id="id_biaya" style="width:100%;" >
                <option value="">--Pilih Biaya --</option>
                <?php 
                foreach ($this->db->get('biaya')->result() as $rw): 
                    $checked = ($id_biaya == $rw->id_biaya) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_biaya ?>" <?php echo $checked ?>><?php echo $rw->nama_biaya ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Jumlah * <?php echo form_error('jumlah') ?></label>
            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php echo $jumlah; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Jenis Potongan * <?php echo form_error('jenis_potongan') ?></label>
            <select name="jenis_potongan" id="jenis_potongan" style="width:100%;" >
                <option value="">--Jenis Potongan --</option>
                <option value="angka" <?php echo ($jenis_potongan == 'angka') ? 'selected' : '' ?>>Angka</option>
                <option value="persen" <?php echo ($jenis_potongan == 'persen') ? 'selected' : '' ?>>Persen</option>
            </select>
        </div>
	    <div class="form-group">
            <label for="enum">Berlaku * <?php echo form_error('berlaku') ?></label>
            <select name="berlaku" id="berlaku" style="width:100%;" >
                <option value="">-- Berlaku --</option>
                <option value="1" <?php echo ($berlaku == '1') ? 'selected' : '' ?>>Sampai Tamat</option>
                <option value="2" <?php echo ($berlaku == '2') ? 'selected' : '' ?>>Sampai Batas Tanggal Tertentu</option>
            </select>
        </div>
	    <div class="form-group" id="bts_tgl" <?php echo ($berlaku == '1') ? 'style="display: none;"' : '' ?>>
            <label for="date">Batas Tanggal </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <input class="form-control date-picker" id="batas_tanggal" type="text" name="batas_tanggal" data-date-format="yyyy-mm-dd" value="<?php echo $batas_tanggal ?>" autocomplete="off">
                
            </div>
        </div>
	    <input type="hidden" name="id_potongan" value="<?php echo $id_potongan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('potongan_biaya') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>

<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#id_biaya").select2();
        $("#nim").select2();

    $("#berlaku").change(function() {
        var n = $(this).val();
        if (n == '2') {
            $("#bts_tgl").show();
        }
    });

    });
</script>
   