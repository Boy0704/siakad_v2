<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption">Filter</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <form class="form-inline" action="" method="get" role="form">
                    <div class="form-group">
                        <select name="tahun_angkatan" id="tahun_angkatan" style="width:100%;" required="">
			                <option value="">--Pilih Tahun --</option>
			                <?php 
                            $this->db->order_by('tahun_angkatan', 'desc');
			                foreach ($this->db->get('tahun_angkatan')->result() as $rw): 
                                $selected = '';
                                if ($_GET) {
                                    $selected = ($_GET['tahun_angkatan'] == $rw->tahun_angkatan) ? 'selected' : '';
                                }
			                    ?>
			                    <option value="<?php echo $rw->tahun_angkatan ?>" <?php echo $selected ?>><?php echo $rw->tahun_angkatan?></option>
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

    $tahun_angkatan = $this->input->get('tahun_angkatan');
    $this->db->where('tahun_berlaku', $tahun_angkatan);
    $data_setup = $this->db->get('biaya_pembayaran');
    ?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> [ <b>Periode Tahun</b> : <?php echo $this->input->get('tahun_angkatan') ?> ]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                <br>

                <?php if ($data_setup->num_rows() == 0): ?>
                     <a onclick="javasciprt: return confirm('Yakin akan Setup Biaya Pembayaran di periode tahun ini ?')" href="setup_pembayaran/setup/<?php echo $tahun_angkatan ?>" class="btn btn-info"><i class="fa fa-cogs"></i> Setup Biaya</a>
                <?php else: ?>

                    <a onclick="javasciprt: return confirm('Yakin akan Hapus Massal Biaya Pembayaran di periode tahun ini ?')" href="setup_pembayaran/hapus_massal/<?php echo $tahun_angkatan.'?'.param_get() ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus Massal</a>
                
                <?php endif ?>

                <br><br>

                <div class="table-scrollable">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Deskripsi</th>
                                <th>QTY</th>
                                <th>Jumlah</th>
                                <th>Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        
                        foreach ($data_setup->result() as $rw): ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo get_data('biaya','id_biaya',$rw->id_biaya,'nama_biaya') ?></td>
                                <td><?php 
                                $id_jenis_biaya = get_data('biaya','id_biaya',$rw->id_biaya,'id_jenis_biaya');
                                echo get_data('jenis_biaya','id_jenis_biaya',$id_jenis_biaya,'jenis_biaya')
                                 ?></td>
                                <td>
                                    <form action="setup_pembayaran/update_biaya/<?php echo $rw->id_nilai_biaya.'?'.param_get() ?>" method="post">
                                    <input type="number" name="nilai" class="form-control nilai" value="<?php echo $rw->nilai ?>">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
                                    </form>

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
<script type="text/javascript" src="assets/js/jquery.number.min.js"></script>
<script type="text/javascript">


    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }

      rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
      return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }


    $(document).ready(function() {

        $('.nilai').number(true,0);

        $("#id_prodi").change(function() {
            var id_prodi = $(this).val();
            $.ajax({url: "app/get_select_semester/"+id_prodi, success: function(result){
                    $("#semester").html(result);
                  console.log("success");
                }});
            
        });

    });
</script>