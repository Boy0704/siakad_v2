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
                                <!-- <th style="text-align: center;">Tampilkan <br> di Mahasiswa</th> -->
                                <th>Prodi</th>
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
                                <!-- <td style="text-align: center;">
                                    <div class="checkbox">
                                        <label>
                                            <?php if ($rw->tampilkan == 't'): ?>
                                                <input type="checkbox" onclick="ceklis('<?php echo $rw->id_nilai_biaya ?>')" id="<?php echo 'id_'.$rw->id_nilai_biaya ?>">
                                                <span class="text" id="<?php echo 'txt_'.$rw->id_nilai_biaya ?>"> Tidak</span>
                                            <?php else: ?>
                                                <input type="checkbox" onclick="ceklis('<?php echo $rw->id_nilai_biaya ?>')" id="<?php echo 'id_'.$rw->id_nilai_biaya ?>" checked >
                                                <span class="text" id="<?php echo 'txt_'.$rw->id_nilai_biaya ?>"> Ya</span>
                                            <?php endif ?>
                                        </label>
                                    </div>
                                </td> -->
                                <td><?php echo ($rw->id_prodi == 0) ? 'Semua Prodi' : get_data('prodi','id_prodi',$rw->id_prodi,'prodi') ?></td>
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


    function ceklis(id) {
        if ($("#id_"+id).is(':checked')) {
            // alert('y '+id);    
            $.ajax({url: "setup_pembayaran/set_tampilkan/"+id+"/y", 
                beforeSend: function(){
                    $(".loading-container").show();
                    $(".loader").show();
                },
                success: function(response){
                    $("#txt_"+id).text(response);
                },
                complete:function(data){
                    $(".loading-container").hide();
                    $(".loader").hide();
                }
            });
        } else {
            // alert('t '+id);
            $.ajax({url: "setup_pembayaran/set_tampilkan/"+id+"/t", 
                beforeSend: function(){
                    $(".loading-container").show();
                    $(".loader").show();
                },
                success: function(response){
                    $("#txt_"+id).text(response);
                },
                complete:function(data){
                    $(".loading-container").hide();
                    $(".loader").hide();
                }
            });
        }
    }

    $(document).ready(function() {

        $('.nilai').number(true,0);

        $("#tampilkan").click(function() {
            
        });

        $("#id_prodi").change(function() {
            var id_prodi = $(this).val();
            $.ajax({url: "app/get_select_semester/"+id_prodi, success: function(result){
                    $("#semester").html(result);
                  console.log("success");
                }});
            
        });

    });
</script>