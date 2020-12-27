<?php 
$data_mhs = $this->db->get_where('mahasiswa', array('nim'=>$nim))->row();
 ?>

<div class="row">
	<div class="col-lg-6 col-sm-6 col-xs-12">
	    <div class="well with-header">
	        <div class="header bordered-magenta">Ayah</div>

	        <div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">NIK Ayah</label>
			    <div class="col-sm-10">
			        <input type="text"  class="form-control" id="nik_ayah" name="nik_ayah" value="<?php echo $data_mhs->nik_ayah ?>">
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Nama</label>
			    <div class="col-sm-10">
			        <input type="text"  class="form-control" id="nama_ayah" name="nama_ayah" value="<?php echo $data_mhs->nama_ayah ?>">
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Tanggal Lahir</label>
			    <div class="col-sm-10">
			        <input type="text"  class="form-control" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" value="<?php echo $data_mhs->tanggal_lahir_ayah ?>">
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Pendidikan</label>
			    <div class="col-sm-10">
			        <select name="pendidikan_ayah" id="pendidikan_ayah" style="width:100%;">
			            <option value="">--Pilih Pendidikan --</option>
			            <?php 
			            foreach ($this->db->get('jenjang_pendidikan')->result() as $rw): 
			                $checked = ($data_mhs->pendidikan_ayah == $rw->id_jenj_didik) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_jenj_didik ?>" <?php echo $checked ?>><?php echo $rw->id_jenj_didik.' - '. $rw->nm_jenj_didik ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Pekerjaan</label>
			    <div class="col-sm-10">
			        <select name="pekerjaan_ayah" id="pekerjaan_ayah" style="width:100%;">
			            <option value="">--Pilih Pekerjaan --</option>
			            <?php 
			            foreach ($this->db->get('pekerjaan')->result() as $rw): 
			                $checked = ($data_mhs->pekerjaan_ayah == $rw->id_pekerjaan) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_pekerjaan ?>" <?php echo $checked ?>><?php echo $rw->id_pekerjaan.' - '. $rw->nm_pekerjaan ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Penghasilan</label>
			    <div class="col-sm-10">
			        <select name="penghasilan_ayah" id="penghasilan_ayah" style="width:100%;">
			            <option value="">--Pilih Penghasilan --</option>
			            <?php 
			            foreach ($this->db->get('penghasilan')->result() as $rw): 
			                $checked = ($data_mhs->penghasilan_ayah == $rw->id_penghasilan) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_penghasilan ?>" <?php echo $checked ?>><?php echo $rw->id_penghasilan.' - '. $rw->nm_penghasilan ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

	    </div>
	</div>

	<div class="col-lg-6 col-sm-6 col-xs-12">
	    <div class="well with-header">
	        <div class="header bordered-magenta">Ibu</div>

	        <div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">NIK Ibu</label>
			    <div class="col-sm-10">
			        <input type="text"  class="form-control" id="nik_ibu" name="nik_ibu" value="<?php echo $data_mhs->nik_ibu ?>">
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Nama *</label>
			    <div class="col-sm-10">
			        <input type="text"  class="form-control" id="nama_ibu" name="nama_ibu" value="<?php echo $data_mhs->nama_ibu ?>" required>
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Tanggal Lahir</label>
			    <div class="col-sm-10">
			        <input type="text"  class="form-control" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" value="<?php echo $data_mhs->tanggal_lahir_ibu ?>">
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Pendidikan</label>
			    <div class="col-sm-10">
			        <select name="pendidikan_ibu" id="pendidikan_ibu" style="width:100%;">
			            <option value="">--Pilih Pendidikan --</option>
			            <?php 
			            foreach ($this->db->get('jenjang_pendidikan')->result() as $rw): 
			                $checked = ($data_mhs->pendidikan_ibu == $rw->id_jenj_didik) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_jenj_didik ?>" <?php echo $checked ?>><?php echo $rw->id_jenj_didik.' - '. $rw->nm_jenj_didik ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Pekerjaan</label>
			    <div class="col-sm-10">
			        <select name="pekerjaan_ibu" id="pekerjaan_ibu" style="width:100%;">
			            <option value="">--Pilih Pekerjaan --</option>
			            <?php 
			            foreach ($this->db->get('pekerjaan')->result() as $rw): 
			                $checked = ($data_mhs->pekerjaan_ibu == $rw->id_pekerjaan) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_pekerjaan ?>" <?php echo $checked ?>><?php echo $rw->id_pekerjaan.' - '. $rw->nm_pekerjaan ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Penghasilan</label>
			    <div class="col-sm-10">
			        <select name="penghasilan_ibu" id="penghasilan_ibu" style="width:100%;">
			            <option value="">--Pilih Penghasilan --</option>
			            <?php 
			            foreach ($this->db->get('penghasilan')->result() as $rw): 
			                $checked = ($data_mhs->penghasilan_ibu == $rw->id_penghasilan) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_penghasilan ?>" <?php echo $checked ?>><?php echo $rw->id_penghasilan.' - '. $rw->nm_penghasilan ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

	    </div>
	</div>
</div>