
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
            <label for="varchar">Nama * <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nidn <?php echo form_error('nidn') ?></label>
            <input type="text" class="form-control" name="nidn" id="nidn" placeholder="Nidn" value="<?php echo $nidn; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nip <?php echo form_error('nip') ?></label>
            <input type="text" class="form-control" name="nip" id="nip" placeholder="Nip" value="<?php echo $nip; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">No Pegawai * <?php echo form_error('no_pegawai') ?></label>
            <input type="text" class="form-control" name="no_pegawai" id="no_pegawai" placeholder="No Pegawai dari kampus" value="<?php echo $no_pegawai; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Jenis Kelamin * <?php echo form_error('jenis_kelamin') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="jenis_kelamin" value="L" <?php echo $retVal = ($jenis_kelamin =='L' or $jenis_kelamin=='') ? 'checked' : '' ; ?> >
                    <span class="text">Laki-laki</span>
                </label>
                <label>
                    <input type="radio" name="jenis_kelamin" value="P" <?php echo $retVal = ($jenis_kelamin=='P') ? 'checked' : '' ; ?> >
                    <span class="text">Perempuan</span>
                </label>
            </div>
        </div>
	    <div class="form-group">
            <label for="int">Agama * <?php echo form_error('agama') ?></label>
            <select name="agama" id="agama" style="width:100%;">
                <option value="">--Pilih Agama --</option>
                <?php 
                foreach ($this->db->get('agama')->result() as $rw): 
                    $checked = ($agama == $rw->id_agama) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_agama ?>" <?php echo $checked ?>><?php echo  $rw->id_agama.' - '. $rw->nm_agama ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="date">Tanggal Lahir <?php echo form_error('tanggal_lahir') ?></label>
            <div class="input-group">
                <input class="form-control date-picker" id="tanggal_lahir" type="text" name="tanggal_lahir" value="<?php echo $tanggal_lahir ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
	    <div class="form-group">
            <label for="int">Status * <?php echo form_error('status') ?></label>
            <select name="status" id="status" style="width:100%;">
                <option value="">--Pilih Status --</option>
                <?php 
                foreach ($this->db->get('status_keaktifan_pegawai')->result() as $rw): 
                    $checked = ($status == $rw->id_stat_aktif) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_stat_aktif ?>" <?php echo $checked ?>><?php echo  $rw->id_stat_aktif.' - '. $rw->nm_stat_aktif ?></option>
                <?php endforeach ?>
            </select>
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
	    <div class="form-group">
            <label for="int">Jabatan <?php echo form_error('id_jabatan') ?></label>
            <select name="id_jabatan" id="id_jabatan" style="width:100%;">
                <option value="">--Pilih Jabatan --</option>
                <?php 
                foreach ($this->db->get('jabatan')->result() as $rw): 
                    $checked = ($id_jabatan == $rw->id_jabatan) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_jabatan ?>" <?php echo $checked ?>><?php echo $rw->jabatan ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <input type="hidden" name="id_dosen" value="<?php echo $id_dosen; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('dosen') ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>



   