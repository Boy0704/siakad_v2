<?php 
$data_mhs = $this->db->get('mahasiswa', array('nim'=>$nim))->row();
 ?>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Kewarganegaraan *</label>
    <div class="col-sm-2">
        <input type="text"  class="form-control" id="kewarganegaraan" name="kewarganegaraan" placeholder="contoh: Ilham Saputra" value="ID" readonly="">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">NIK *</label>
    <div class="col-sm-5">
        <input type="text"  class="form-control" id="nik" name="nik" value="<?php echo $data_mhs->nik ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">NISN </label>
    <div class="col-sm-5">
        <input type="text"  class="form-control" id="nisn" name="nisn" value="<?php echo $data_mhs->nisn ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">NPWP</label>
    <div class="col-sm-5">
        <input type="text"  class="form-control" id="npwp" name="npwp" value="<?php echo $data_mhs->npwp ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Jalan</label>
    <div class="col-sm-5">
        <input type="text"  class="form-control" id="jalan" name="jalan" value="<?php echo $data_mhs->jalan ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Dusun</label>
    <div class="col-sm-4">
        <input type="text"  class="form-control" id="dusun" name="dusun" value="<?php echo $data_mhs->dusun ?>">
    </div>

    <label class="col-sm-1 control-label no-padding-right">RT</label>
    <div class="col-sm-1">
        <input type="text"  class="form-control" id="rt" name="rt" value="<?php echo $data_mhs->rt ?>">
    </div>

    <label class="col-sm-1 control-label no-padding-right">RW</label>
    <div class="col-sm-1">
        <input type="text"  class="form-control" id="rw" name="rw" value="<?php echo $data_mhs->rw ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Kelurahan *</label>
    <div class="col-sm-5">
        <input type="text"  class="form-control" id="kelurahan" name="kelurahan" value="<?php echo $data_mhs->kelurahan ?>" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Kecamatan *</label>
    <div class="col-sm-5">
        <select name="kecamatan" id="kecamatan" style="width:100%;" >
            <option value="">--Pilih Kecamatan --</option>
            <?php 
            foreach ($this->db->get('data_wilayah')->result() as $rw): 
                $checked = ($data_mhs->kecamatan == $rw->id_wil) ? 'selected' : '' ;
                ?>
                <option value="<?php echo $rw->id_wil ?>" <?php echo $checked ?>><?php echo $rw->id_wil.' - '. $rw->nm_wil ?></option>
            <?php endforeach ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Jenis Tinggal</label>
    <div class="col-sm-5">
        <select name="jenis_tinggal" id="jenis_tinggal" style="width:100%;">
            <option value="">--Pilih Jenis Tinggal --</option>
            <?php 
            foreach ($this->db->get('jenis_tinggal')->result() as $rw): 
                $checked = ($data_mhs->jenis_tinggal == $rw->id_jns_tinggal) ? 'selected' : '' ;
                ?>
                <option value="<?php echo $rw->id_jns_tinggal ?>" <?php echo $checked ?>><?php echo $rw->id_jns_tinggal.' - '. $rw->nm_jns_tinggal ?></option>
            <?php endforeach ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Alat Transportasi</label>
    <div class="col-sm-5">
        <select name="alat_transportasi" id="alat_transportasi" style="width:100%;" >
            <option value="">--Pilih Alat Transportasi --</option>
            <?php 
            foreach ($this->db->get('data_transportasi')->result() as $rw): 
                $checked = ($data_mhs->alat_transportasi == $rw->id_alat_transport) ? 'selected' : '' ;
                ?>
                <option value="<?php echo $rw->id_alat_transport ?>" <?php echo $checked ?>><?php echo $rw->id_alat_transport.' - '. $rw->nm_alat_transport ?></option>
            <?php endforeach ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Telepon</label>
    <div class="col-sm-4">
        <input type="text"  class="form-control" id="telp_rumah" name="telp_rumah" value="<?php echo $data_mhs->telp_rumah ?>">
    </div>

    <label class="col-sm-1 control-label no-padding-right">HP</label>
    <div class="col-sm-4">
        <input type="text"  class="form-control" id="no_hp" name="no_hp" value="<?php echo $data_mhs->no_hp ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Email</label>
    <div class="col-sm-5">
        <input type="text"  class="form-control" id="email" name="email" value="<?php echo $data_mhs->email ?>">
    </div>

    
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Penerima KPS *</label>
    <div class="col-sm-2">
        <div class="radio">
            <label>
                <input type="radio" name="terima_kps" value="0" <?php 
                echo $retVal = ($data_mhs->terima_kps=='0') ? 'checked' : '' ; ?> >
                <span class="text">Tidak</span>
            </label>
            <label>
                <input type="radio" name="terima_kps" value="1" <?php 
                echo $retVal = ($data_mhs->terima_kps=='1') ? 'checked' : '' ; ?> >
                <span class="text">Ya</span>
            </label>
        </div>
    </div>
	<label class="col-sm-1 control-label no-padding-right">No KPS</label>
	<div class="col-sm-4">
        <input type="text"  class="form-control" id="no_kps" name="no_kps" value="<?php echo $data_mhs->no_kps ?>">
    </div>
</div>
