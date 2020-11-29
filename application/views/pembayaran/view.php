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


<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> [ <b>Prodi</b> : <?php echo (isset($_GET['id_prodi']) && $_GET['id_prodi'] != '') ? get_data('prodi','id_prodi',$_GET['id_prodi'],'prodi') : 'Semua Prodi' ?>, <b>Tahun Angkatan</b> : <?php echo (isset($_GET['id_tahun_angkatan']) && $_GET['id_tahun_angkatan'] != '') ? get_data('tahun_angkatan','id_tahun_angkatan',$_GET['id_tahun_angkatan'],'tahun_angkatan') : 'Semua Tahun' ?>]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                <br>

                <p>
                    <a href="pembayaran/create" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Pembayaran</a>
                </p>

                <div class="table-scrollable">
                    <table class="table table-bordered table-hover table-striped" id="searchable">
                        <thead class="bordered-darkorange">
                            <tr role="row">
                                <th>No</th>
                                <th>Nim</th>
                                <th>Nama</th>
                                <th>Prodi</th>
                                <th>Tgl Bayar</th>
                                <th>Periode</th>
                                <th>Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        $this->db->select('b.nim,b.nama,b.id_prodi,a.*');
                        $this->db->from('pembayaran a');
                        $this->db->join('mahasiswa b', 'a.nim = b.nim', 'inner');
                        if ($_GET) {
                            $this->db->where('b.id_prodi', $this->input->get('id_prodi'));
                            $this->db->where('b.id_tahun_angkatan', $this->input->get('id_tahun_angkatan'));
                        }
                        foreach ($this->db->get()->result() as $rw):
                         ?>
                
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $rw->nim ?></td>
                                <td><?php echo $rw->nama ?></td>
                                <td><?php echo get_data('prodi','id_prodi',$rw->id_prodi,'prodi') ?></td>
                                <td><?php echo $rw->tanggal_bayar ?></td>
                                <td><?php echo $rw->kode_semester ?></td>
                                <td>
                                    <a href="pembayaran/detail/<?php echo $rw->id_pembayaran ?>" class="label label-info">Detail</a>
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




<script src="assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        

    });
</script>
