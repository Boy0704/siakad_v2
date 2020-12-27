<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption">Filter</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <form class="form-inline" action="" method="get" role="form">
                    <div class="form-group">
                        <select name="id_prodi" id="id_prodi" style="width:100%;" required="">
			                <option value="">--Pilih Prodi --</option>
			                <?php 
			                $this->db->where('aktif', 'y');
			                foreach ($this->db->get('prodi')->result() as $rw): 
			                    ?>
			                    <option value="<?php echo $rw->id_prodi ?>"><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
			                <?php endforeach ?>
			            </select>
                    </div>

                    <div class="form-group">
                        <select name="id_tahun_angkatan" id="id_tahun_angkatan" style="width:100%;" required="">
                            <option value="">--Pilih Angkatan --</option>
                            <?php 
                            $this->db->order_by('tahun_angkatan', 'desc');
                            foreach ($this->db->get('tahun_angkatan')->result() as $rw): 
                                ?>
                                <option value="<?php echo $rw->id_tahun_angkatan ?>"><?php echo $rw->tahun_angkatan ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">FILTER</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($_GET): 

    $id_prodi = $this->input->get('id_prodi');
    $id_tahun_angkatan = $this->input->get('id_tahun_angkatan');
    $id_tahun_akademik = tahun_akademik_aktif('id_tahun_akademik');
    $kode_semester = tahun_akademik_aktif('kode_tahun');

    ?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> [ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>Tahun Angkatan</b> : <?php echo get_data('tahun_angkatan','id_tahun_angkatan',$id_tahun_angkatan,'tahun_angkatan') ?>]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                <br>

                <div class="table-scrollable">
                    <table class="table table-bordered table-hover table-striped" id="searchable">
                        <thead class="bordered-darkorange">
                            <tr role="row">
                                <th>No</th>
                                <th>Nim</th>
                                <th>Nama</th>
                                <th>Angakatan</th>
                                <th>Prodi</th>
                                <th>Periode</th>
                                <th>Tgl Registrasi</th>
                                <th>Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        $this->db->where('id_prodi', $id_prodi);
                        $this->db->where('id_tahun_angkatan', $id_tahun_angkatan);
                        foreach ($this->db->get('mahasiswa')->result() as $rw):
                            $semester = get_semester($rw->nim)
                         ?>
                
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $rw->nim ?></td>
                                <td><?php echo $rw->nama ?></td>
                                <td><?php echo get_data('tahun_angkatan','id_tahun_angkatan',$rw->id_tahun_angkatan,'tahun_angkatan') ?></td>
                                <td><?php echo get_data('prodi','id_prodi',$rw->id_prodi,'prodi') ?></td>
                                <td>
                                    <?php echo $retVal = (data_registarasi($rw->nim,$kode_semester,TRUE) =='1') ? data_registarasi($rw->nim,$kode_semester)->kode_semester : '' ; ?>
                                </td>
                                <td>
                                    <?php echo $retVal = (data_registarasi($rw->nim,$kode_semester,TRUE) =='1') ? data_registarasi($rw->nim,$kode_semester)->tanggal_registrasi : '' ; ?>
                                </td>
                                <td>
                                    <?php 
                                    $this->db->where('nim', $rw->nim);
                                    $this->db->where('id_tahun_akademik', $id_tahun_akademik);
                                    $this->db->where('kode_semester', $kode_semester);
                                    $cek = $this->db->get('registrasi');
                                    if ($cek->num_rows() > 0): ?>
                                        <a onclick="javasciprt: return confirm('Yakin akan batalkan registrasi mahasiswa ini ?')" href="registrasi/aksi_registrasi/batal_registrasi?id_mahasiswa=<?php echo $rw->id_mahasiswa ?>&id_tahun_akademik=<?php echo $id_tahun_akademik ?>&id_prodi=<?php echo $id_prodi ?>&id_tahun_angkatan=<?php echo $id_tahun_angkatan ?>" class="label label-danger">Batal Registrasi</a>
                                    <?php else: ?>
                                        <a onclick="javasciprt: return confirm('Yakin akan registarasikan mahasiswa ini ?')" href="registrasi/aksi_registrasi/registrasi?id_mahasiswa=<?php echo $rw->id_mahasiswa ?>&id_tahun_akademik=<?php echo $id_tahun_akademik ?>&kode_semester=<?php echo $kode_semester ?>&semester=<?php echo $semester ?>&id_prodi=<?php echo $id_prodi ?>&id_tahun_angkatan=<?php echo $id_tahun_angkatan ?>" class="label label-success">Registrasi</a>
                                    <?php endif ?>
                                    
                                </td>
                                
                                
                            </tr>

                        <?php $no++; endforeach ?>
                            
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>


<?php endif ?>




<script src="assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        

    });
</script>
