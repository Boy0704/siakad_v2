<?php 
$mhs = $data_mhs->row();
$data['nim'] = $mhs->nim;
 ?>
<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-lightred">
                <span class="widget-caption"><?php echo $judul_page ?></span>
            </div>
            <div class="widget-body">
                <div id="horizontal-form">
                    <form class="form-horizontal" action="mahasiswa/update_action/<?php echo $mhs->id_mahasiswa ?>?id_prodi=<?php echo $this->input->get('id_prodi') ?>&id_tahun_angkatan=<?php echo $this->input->get('id_tahun_angkatan') ?>" method="POST" role="form">
                        <div class="form-group">
                            <label for="Nama" class="col-sm-2 control-label no-padding-right">NIM *</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="nim" name="nim" placeholder="contoh: 1920126" value="<?php echo $mhs->nim ?>" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama" class="col-sm-2 control-label no-padding-right">Nama *</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="nama" name="nama" placeholder="contoh: Ilham Saputra" value="<?php echo $mhs->nama ?>" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin" class="col-sm-2 control-label no-padding-right">Jenis Kelamin *</label>
                            <div class="col-sm-10">
                                <div class="radio">
					                <label>
					                    <input type="radio" name="jenis_kelamin" value="L" <?php 
                                        $jenis_kelamin = $mhs->jenis_kelamin;
                                        echo $retVal = ($jenis_kelamin!='P' or $jenis_kelamin=='') ? 'checked' : '' ; ?> >
					                    <span class="text">Laki-laki</span>
					                </label>
					                <label>
					                    <input type="radio" name="jenis_kelamin" value="P" <?php 
                                        $jenis_kelamin = $mhs->jenis_kelamin;
                                        echo $retVal = ($jenis_kelamin=='P') ? 'checked' : '' ; ?> >
					                    <span class="text">Perempuan</span>
					                </label>
					            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tahun_angkatan" class="col-sm-2 control-label no-padding-right">Tahun Angkatan *</label>
                            <div class="col-sm-10">
                                <select name="id_tahun_angkatan" id="id_tahun_angkatan" style="width:100%;" required="">
					                <option value="">--Pilih Tahun Angkatan --</option>
					                <?php 
					                foreach ($this->db->get('tahun_angkatan')->result() as $rw): 
                                        $id_tahun_angkatan = $mhs->id_tahun_angkatan;
					                    $checked = ($id_tahun_angkatan == $rw->id_tahun_angkatan) ? 'selected' : '' ;
					                    ?>
					                    <option value="<?php echo $rw->id_tahun_angkatan ?>" <?php echo $checked ?>><?php echo $rw->tahun_angkatan ?></option>
					                <?php endforeach ?>
					            </select>
                            </div>
                        </div>


						<div class="form-group">
                            <label for="prodi" class="col-sm-2 control-label no-padding-right">Prodi *</label>
                            <div class="col-sm-10">
                                <select name="id_prodi" id="id_prodi" style="width:100%;">
					                <option value="">--Pilih Prodi --</option>
					                <?php 
                                    if ($this->session->userdata('level') == '2') {
                                        $id_prodi = get_data('users','id_user',$this->session->userdata('id_user'),'id_prodi');
                                        $this->db->where('id_prodi', $id_prodi);
                                    }
					                $this->db->where('aktif', 'y');
					                foreach ($this->db->get('prodi')->result() as $rw): 
                                        $id_prodi = $mhs->id_prodi;
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
                                        $jalur_pendaftaran = $mhs->jalur_pendaftaran;
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
                                        $jenis_pendaftaran = $mhs->jenis_pendaftaran;
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
                                    <input class="form-control date-picker" id="tanggal_masuk_kuliah" type="text" name="tanggal_masuk_kuliah" value="<?php echo $mhs->tanggal_masuk_kuliah ?>" data-date-format="yyyy-mm-dd" autocomplete="off" required>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="tahun_angkatan" class="col-sm-2 control-label no-padding-right">Mulai Semester *</label>
                            <div class="col-sm-10">
                                <select name="mulai_semester" id="mulai_semester" style="width:100%;" required="">
                                    <option value="">--Pilih Mulai Semester --</option>
                                    <?php 
                                    $this->db->order_by('kode_tahun', 'desc');
                                    foreach ($this->db->get('tahun_akademik')->result() as $rw): 
                                        $checked = ($mhs->mulai_semester == $rw->kode_tahun) ? 'selected' : '' ;
                                        ?>
                                        <option value="<?php echo $rw->kode_tahun ?>" <?php echo $checked ?>><?php echo $rw->kode_tahun ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">Tahun Belaku Tagihan *</label>
                            <div class="col-sm-10">
                                <select name="tahun_tagihan" id="tahun_tagihan" style="width:100%;" required="">
                                    <option value="">--Pilih Tahun --</option>
                                    <?php 
                                    foreach ($this->db->get('tahun_angkatan')->result() as $rw): 
                                        $tahun_tagihan = $mhs->tahun_tagihan;
                                        $checked = ($tahun_tagihan == $rw->tahun_angkatan) ? 'selected' : '' ;
                                        ?>
                                        <option value="<?php echo $rw->tahun_angkatan ?>" <?php echo $checked ?>><?php echo $rw->tahun_angkatan ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">Kelas Perkuliahan *</label>
                            <div class="col-sm-10">
                                <select name="id_kelas" id="id_kelas" style="width:100%;" required="">
                                    <option value="">--Pilih Kelas --</option>
                                    <?php 
                                    foreach ($this->db->get('kelas')->result() as $rw): 
                                        $selected = ($mhs->id_kelas == $rw->id_kelas) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $rw->id_kelas ?>" <?php echo $selected ?>><?php echo $rw->kelas.' - '. $rw->jenis_kelas ?></option>
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
                                        $dosen_pa = $mhs->dosen_pa;
                                        $checked = ($dosen_pa == $rw->id_dosen) ? 'selected' : '' ;
                                        ?>
                                        <option value="<?php echo $rw->id_dosen ?>" <?php echo $checked ?>><?php echo $rw->nidn.' - '. $rw->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="widget-main ">
                            <div class="tabbable">
                                <ul class="nav nav-tabs tabs-flat" id="myTab11">
                                    <li class="active">
                                        <a data-toggle="tab" href="#alamat">
                                            Alamat
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#orantua">
                                            Orang Tua
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#wali">
                                            Wali
                                        </a>
                                    </li>
                                    <?php if ($this->session->userdata('level') != '5'): ?>
                                        <li>
                                            <a data-toggle="tab" href="#akm">
                                                Akm Mahasiswa
                                            </a>
                                        </li>
                                    <?php endif ?>
                                </ul>
                                <div class="tab-content tabs-flat">
                                    <div id="alamat" class="tab-pane in active">
                                        <?php $this->load->view('mahasiswa/tab_alamat', $data); ?>
                                    </div>

                                    <div id="orantua" class="tab-pane">
                                        <?php $this->load->view('mahasiswa/tab_orang_tua', $data); ?>
                                    </div>

                                    <div id="wali" class="tab-pane">
                                        <?php $this->load->view('mahasiswa/tab_wali', $data); ?>
                                    </div>

                                    <div id="akm" class="tab-pane">
                                        <?php $this->load->view('mahasiswa/tab_akm', $data); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
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
        $("#kecamatan").select2();
    });
</script>