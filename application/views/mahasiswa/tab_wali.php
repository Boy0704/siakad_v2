<?php 
$data_mhs = $this->db->get_where('mahasiswa', array('nim'=>$nim))->row();
 ?>

<div class="row">
	<div class="col-lg-6 col-sm-6 col-xs-12">
	    <div class="well with-header">
	        <div class="header bordered-magenta">Wali</div>

	        

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Nama</label>
			    <div class="col-sm-10">
			        <input type="text"  class="form-control" id="nama_wali" name="nama_wali" value="<?php echo $data_mhs->nama_wali ?>">
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Tanggal Lahir</label>
			    <div class="col-sm-10">
			        <input type="text"  class="form-control" id="tanggal_lahir_wali" name="tanggal_lahir_wali" value="<?php echo $data_mhs->tanggal_lahir_wali ?>">
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Pendidikan</label>
			    <div class="col-sm-10">
			        <select name="pendidikan_wali" id="pendidikan_wali" style="width:100%;">
			            <option value="">--Pilih Pendidikan --</option>
			            <?php 
			            foreach ($this->db->get('jenjang_pendidikan')->result() as $rw): 
			                $checked = ($data_mhs->pendidikan_wali == $rw->id_jenj_didik) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_jenj_didik ?>" <?php echo $checked ?>><?php echo $rw->id_jenj_didik.' - '. $rw->nm_jenj_didik ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Pekerjaan</label>
			    <div class="col-sm-10">
			        <select name="pekerjaan_wali" id="pekerjaan_wali" style="width:100%;">
			            <option value="">--Pilih Pekerjaan --</option>
			            <?php 
			            foreach ($this->db->get('pekerjaan')->result() as $rw): 
			                $checked = ($data_mhs->pekerjaan_wali == $rw->id_pekerjaan) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_pekerjaan ?>" <?php echo $checked ?>><?php echo $rw->id_pekerjaan.' - '. $rw->nm_pekerjaan ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-2 control-label no-padding-right">Penghasilan</label>
			    <div class="col-sm-10">
			        <select name="penghasilan_wali" id="penghasilan_wali" style="width:100%;">
			            <option value="">--Pilih Penghasilan --</option>
			            <?php 
			            foreach ($this->db->get('penghasilan')->result() as $rw): 
			                $checked = ($data_mhs->penghasilan_wali == $rw->id_penghasilan) ? 'selected' : '' ;
			                ?>
			                <option value="<?php echo $rw->id_penghasilan ?>" <?php echo $checked ?>><?php echo $rw->id_penghasilan.' - '. $rw->nm_penghasilan ?></option>
			            <?php endforeach ?>
			        </select>
			    </div>
			</div>

	    </div>
	</div>
</div>