<?php 
$uri2 = $this->uri->segment(2);
 ?>
<div class="row">
	<div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-lightred">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>
            <div class="widget-body">
                <div id="horizontal-form">
                    <form class="form-horizontal" action="mahasiswa/create_action?id_prodi=<?php echo $this->input->get('id_prodi') ?>&id_tahun_angkatan=<?php echo $this->input->get('id_tahun_angkatan') ?>" method="POST" role="form">
                        <div class="form-group">
                            <label for="Nama" class="col-sm-2 control-label no-padding-right">NIM *</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="nim" name="nim" placeholder="contoh: 1920126" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama" class="col-sm-2 control-label no-padding-right">Nama *</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="nama" name="nama" placeholder="contoh: Ilham Saputra" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin" class="col-sm-2 control-label no-padding-right">Jenis Kelamin *</label>
                            <div class="col-sm-10">
                                <div class="radio">
					                <label>
					                    <input type="radio" name="jenis_kelamin" value="L" <?php echo $retVal = ($jenis_kelamin!='L' or $jenis_kelamin=='') ? 'checked' : '' ; ?> >
					                    <span class="text">Laki-laki</span>
					                </label>
					                <label>
					                    <input type="radio" name="jenis_kelamin" value="P" <?php echo $retVal = ($jenis_kelamin=='P') ? 'checked' : '' ; ?> >
					                    <span class="text">Perempuan</span>
					                </label>
					            </div>
                            </div>
                        </div>
                        <?php 
			            if ($uri2 == 'create') {
			                $id_tahun_angkatan = $this->input->get('id_tahun_angkatan');
			            }
			             ?>
                        <div class="form-group">
                            <label for="tahun_angkatan" class="col-sm-2 control-label no-padding-right">Tahun Angkatan *</label>
                            <div class="col-sm-10">
                                <select name="id_tahun_angkatan" id="id_tahun_angkatan" style="width:100%;" required="">
					                <option value="">--Pilih Tahun Angkatan --</option>
					                <?php 
					                foreach ($this->db->get('tahun_angkatan')->result() as $rw): 
					                    $checked = ($id_tahun_angkatan == $rw->id_tahun_angkatan) ? 'selected' : '' ;
					                    ?>
					                    <option value="<?php echo $rw->id_tahun_angkatan ?>" <?php echo $checked ?>><?php echo $rw->tahun_angkatan ?></option>
					                <?php endforeach ?>
					            </select>
                            </div>
                        </div>

                        <?php 
			            if ($uri2 == 'create') {
			                $id_prodi = $this->input->get('id_prodi');
			            }
			             ?>

						<div class="form-group">
                            <label for="prodi" class="col-sm-2 control-label no-padding-right">Prodi *</label>
                            <div class="col-sm-10">
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
                        </div>

                        <div class="form-group">
                            <label for="jalur_pendaftaran" class="col-sm-2 control-label no-padding-right">Jalur Pendaftaran</label>
                            <div class="col-sm-10">
                                <select name="jalur_pendaftaran" id="jalur_pendaftaran" style="width:100%;">
					                <option value="">--Pilih Jalur Pendaftaran --</option>
					                <?php 
					                foreach ($this->db->get('jalur_masuk')->result() as $rw): 
					                    $checked = ($jalur_pendaftaran == $rw->id) ? 'selected' : '' ;
					                    ?>
					                    <option value="<?php echo $rw->id ?>" <?php echo $checked ?>><?php echo $rw->id.' - '. $rw->jalur ?></option>
					                <?php endforeach ?>
					            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_pendaftaran" class="col-sm-2 control-label no-padding-right">Jenis Pendaftaran *</label>
                            <div class="col-sm-10">
                                <select name="jenis_pendaftaran" id="jenis_pendaftaran" style="width:100%;" required="">
                                    <option value="">--Pilih Jenis Pendaftaran --</option>
                                    <?php 
                                    foreach ($this->db->get('jenis_pendaftaran')->result() as $rw): 
                                        $checked = ($jenis_pendaftaran == $rw->id_jns_daftar) ? 'selected' : '' ;
                                        ?>
                                        <option value="<?php echo $rw->id_jns_daftar ?>" <?php echo $checked ?>><?php echo $rw->id_jns_daftar.' - '. $rw->nm_jns_daftar ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama" class="col-sm-2 control-label no-padding-right">Tgl Masuk Kuliah *</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control date-picker" id="tanggal_masuk_kuliah" type="text" name="tanggal_masuk_kuliah" data-date-format="yyyy-mm-dd" autocomplete="off">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <?php 
                        if ($uri2 == 'create') {
                            $kode_tahun = tahun_akademik_aktif('kode_tahun');
                        }
                         ?>
                        <div class="form-group">
                            <label for="tahun_angkatan" class="col-sm-2 control-label no-padding-right">Mulai Semester *</label>
                            <div class="col-sm-10">
                                <select name="mulai_semester" id="mulai_semester" style="width:100%;" required="">
                                    <option value="">--Pilih Mulai Semester --</option>
                                    <?php 
                                    $this->db->order_by('kode_tahun', 'desc');
                                    foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                                        $checked = ($kode_tahun == $rw->kode_tahun) ? 'selected' : '' ;
                                        ?>
                                        <option value="<?php echo $rw->kode_tahun ?>" <?php echo $checked ?>><?php echo $rw->kode_tahun ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_pendaftaran" class="col-sm-2 control-label no-padding-right">Dosen PA *</label>
                            <div class="col-sm-10">
                                <select name="dosen_pa" id="dosen_pa" style="width:100%;" required="">
                                    <option value="">--Pilih Dosen Pembimbing Akademik --</option>
                                    <?php 
                                    foreach ($this->db->get('dosen')->result() as $rw): 
                                        $checked = ($dosen_pa == $rw->id_dosen) ? 'selected' : '' ;
                                        ?>
                                        <option value="<?php echo $rw->id_dosen ?>" <?php echo $checked ?>><?php echo $rw->nidn.' - '. $rw->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="mahasiswa?id_prodi=<?php echo $this->input->get('id_prodi') ?>&id_tahun_angkatan=<?php echo $this->input->get('id_tahun_angkatan') ?>" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#dosen_pa").select2();
    });
</script>