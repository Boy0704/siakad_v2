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
                        <select name="nim" id="nim" style="width:100%;" required="">
                            <option value="">------------------Pilih Nim ----------------</option>
                            
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
    $nim = $this->input->get('nim');

    $this->db->where('nim', $nim);
    $this->db->group_by('kode_semester');
    $this->db->order_by('kode_semester','asc');
    $semester = $this->db->get('krs');

    ?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-left bordered-darkorange">
                <span class="widget-caption"><?php echo $judul_page ?> [ <b>Prodi</b> : <?php echo get_data('prodi','id_prodi',$id_prodi,'prodi') ?>, <b>NIM</b> : <?php echo $nim ?>, <b>Nama</b> : <?php echo get_data('mahasiswa','nim',$nim,'nama') ?> ]</span>
            </div>
            <div class="widget-body bordered-left bordered-warning">
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                <br>

                <div class="widget-body no-padding">
                    <div class="widget-main ">
                        <div class="panel-group accordion" id="accordion">

                        <?php foreach ($semester->result() as $rw): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $rw->kode_semester ?>">
                                            <?php echo "Kartu Rencana Studi ( ".get_data('tahun_akademik','kode_tahun',$rw->kode_semester,'keterangan')." )" ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="<?php echo $rw->kode_semester ?>" class="panel-collapse collapse">
                                    <div class="panel-body border-red">
                                        
                                        <?php 
                                        $dt['nim'] = $rw->nim;
                                        $dt['kode_semester'] = $rw->kode_semester;
                                        $this->load->view('krs/isi_krs', $dt);
                                         ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<?php endif ?>
<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#nim").select2();

        $("#id_prodi").change(function() {
            var id_prodi = $(this).val();
            $.ajax({url: "app/get_list_nim/"+id_prodi, 
                beforeSend: function(){
                    $(".loading-container").show();
                    $(".loader").show();
                },
                success: function(result){
                    $("#nim").html(result);
                  console.log("success");
                },
                complete:function(data){
                    $(".loading-container").hide();
                    $(".loader").hide();
                }
            });
            
        });

    });
</script>