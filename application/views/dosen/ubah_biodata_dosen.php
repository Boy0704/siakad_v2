<?php 
$dosen = $data_dosen->row();
 ?>
<div class="row">
    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption"><?php echo $judul_page; ?></span>
            </div>
        <div class="widget-body">
        <div>
        <form action="" method="post">
	    <div class="form-group">
            <label for="varchar">Nama * </label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $dosen->nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nidn </label>
            <input type="text" class="form-control" name="nidn" id="nidn" placeholder="Nidn" value="<?php echo $dosen->nidn; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nip </label>
            <input type="text" class="form-control" name="nip" id="nip" placeholder="Nip" value="<?php echo $dosen->nip; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">No Pegawai * </label>
            <input type="text" class="form-control" name="no_pegawai" id="no_pegawai" placeholder="No Pegawai dari kampus" value="<?php echo $dosen->no_pegawai; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Jenis Kelamin * </label>
            <div class="radio">
                <label>
                    <input type="radio" name="jenis_kelamin" value="L" <?php echo $retVal = ($dosen->jenis_kelamin =='L' or $dosen->jenis_kelamin=='') ? 'checked' : '' ; ?> >
                    <span class="text">Laki-laki</span>
                </label>
                <label>
                    <input type="radio" name="jenis_kelamin" value="P" <?php echo $retVal = ($dosen->jenis_kelamin=='P') ? 'checked' : '' ; ?> >
                    <span class="text">Perempuan</span>
                </label>
            </div>
        </div>
	    <div class="form-group">
            <label for="int">Agama * </label>
            <select name="agama" id="agama" style="width:100%;">
                <option value="">--Pilih Agama --</option>
                <?php 
                foreach ($this->db->get('agama')->result() as $rw): 
                    $checked = ($dosen->agama == $rw->id_agama) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_agama ?>" <?php echo $checked ?>><?php echo  $rw->id_agama.' - '. $rw->nm_agama ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label for="varchar">Tempat Lahir </label>
            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?php echo $dosen->tempat_lahir; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Tanggal Lahir </label>
            <div class="input-group">
                <input class="form-control date-picker" id="tanggal_lahir" type="text" name="tanggal_lahir" value="<?php echo $dosen->tanggal_lahir ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
	    
        <div class="form-group">
            <label for="int">Prodi </label>
            <input type="text" class="form-control" value="<?php echo get_data('prodi','id_prodi',$dosen->id_prodi,'prodi') ?>" readonly>
        </div>
	    <div class="form-group">
            <label for="int">Jabatan </label>
            <input type="text" class="form-control" value="<?php echo get_data('jabatan','id_jabatan',$dosen->id_jabatan,'jabatan') ?>" readonly>
        </div>
	    <button type="submit" class="btn btn-primary">Update</button> 
	</form>
    </div>
</div>
</div>



   