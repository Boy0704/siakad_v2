<?php 
$uri2 = $this->uri->segment(2);
 ?>
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
            <label for="int">Matakuliah * <?php echo form_error('id_mk') ?></label>
            <select name="id_mk" id="id_mk" style="width:100%;">
                <option value="">--Pilih Matakuliah --</option>
                <?php 
                if ($this->input->get('semester') != '') {
                    $this->db->where('semester', $this->input->get('semester'));
                }
                $this->db->where('id_prodi', $this->input->get('id_prodi'));
                $this->db->where('id_kurikulum', $this->input->get('id_kurikulum'));
                $this->db->order_by('semester', 'asc');
                foreach ($this->db->get('matakuliah')->result() as $rw): 
                    $checked = ($id_mk == $rw->id_mk) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_mk ?>" <?php echo $checked ?>><?php echo $rw->kode_mk.' - '. $rw->nama_mk.' - semester '.$rw->semester ?></option>
                <?php endforeach ?>
            </select>
            <?php if ($id_mk != ''): ?>
                <input type="hidden" id="sks" value="<?php echo get_data('matakuliah','id_mk',$id_mk,'sks_tm') ?>">
            <?php else: ?>
                <input type="hidden" id="sks">
            <?php endif ?>
        </div>
	    <div class="form-group">
            <label for="int">Dosen Pengajar * <?php echo form_error('id_dosen') ?></label>
            <select name="id_dosen" id="id_dosen" style="width:100%;">
                <option value="">--Pilih Dosen --</option>
                <?php 
                $this->db->where('status', '1');
                foreach ($this->db->get('dosen')->result() as $rw): 
                    $checked = ($id_dosen == $rw->id_dosen) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_dosen ?>" <?php echo $checked ?>><?php echo $rw->nidn.' - '. $rw->nama ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Kelas * <?php echo form_error('kelas') ?></label>
            <select name="kelas" id="kelas" style="width:100%;">
                <option value="">--Pilih Kelas --</option>
                <?php 
                foreach ($this->db->get('kelas')->result() as $rw): 
                    $checked = ($kelas == $rw->kelas) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->kelas ?>" <?php echo $checked ?>><?php echo $rw->kelas ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Ruang <?php echo form_error('ruang') ?></label>
            <select name="ruang" id="ruang" style="width:100%;">
                <option value="">--Pilih Ruang --</option>
                <?php 
                foreach ($this->db->get('ruang')->result() as $rw): 
                    $checked = ($ruang == $rw->ruang) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->ruang ?>" <?php echo $checked ?>><?php echo $rw->ruang ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Hari <?php echo form_error('hari') ?></label>
            <select name="hari" id="hari" style="width:100%;">
                <option value="">--Pilih Hari --</option>
                <?php 
                foreach ($this->db->get('hari')->result() as $rw): 
                    $checked = ($hari == $rw->hari) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->hari ?>" <?php echo $checked ?>><?php echo $rw->hari ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="time">Jam Mulai <?php echo form_error('jam_mulai') ?></label>
            <input type="text" class="form-control" name="jam_mulai" data-mask="99:99" id="jam_mulai" placeholder="00:00" value="<?php echo $jam_mulai; ?>" />
        </div>
	    <div class="form-group">
            <label for="time">Jam Selesai <?php echo form_error('jam_selesai') ?></label>
            <input type="text" class="form-control" name="jam_selesai" id="jam_selesai" data-mask="99:99" placeholder="00:00" value="<?php echo $jam_selesai; ?>"/>
        </div>
	    <div class="form-group">
            <label for="int">Prodi * <?php echo form_error('id_prodi') ?></label>
            <select name="id_prodi" id="id_prodi" style="width:100%;">
                <option value="">--Pilih Prodi --</option>
                <?php 
                if ($uri2 == 'create') {
                    $id_prodi = $this->input->get('id_prodi');
                }
                if ($this->session->userdata('level') == '2') {
                    $id_prodi = get_data('users','id_user',$this->session->userdata('id_user'),'id_prodi');
                    $this->db->where('id_prodi', $id_prodi);
                }
                $this->db->where('aktif', 'y');
                foreach ($this->db->get('prodi')->result() as $rw): 
                    $checked = ($id_prodi == $rw->id_prodi) ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $rw->id_prodi ?>" <?php echo $checked ?>><?php echo $rw->kode_prodi.' - '. $rw->prodi ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Semester * <?php echo form_error('semester') ?></label>
            <?php 
            if ($uri2 == 'create') {
                $semester = $this->input->get('semester');
            }
             ?>
            <select name="semester" id="semester" style="width:100%;" readonly>
                <option value="">--Pilih Semester --</option>
                <?php 
                for ($i=1; $i <= 8 ; $i++) { 
                    $checked = ($semester == $i) ? 'selected' : '' ;
                 ?>
                    <option value="<?php echo $i ?>" <?php echo $checked ?>><?php echo $i ?></option>
                <?php } ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Kapasitas <?php echo form_error('kapasitas') ?></label>
            <input type="text" class="form-control" name="kapasitas" id="kapasitas" placeholder="Kapasitas" value="<?php echo $kapasitas; ?>" />
        </div>
	    <input type="hidden" name="id_jadwal" value="<?php echo $id_jadwal; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('jadwal_kuliah?id_prodi='.$this->input->get('id_prodi').'&semester='.$this->input->get('semester')) ?>" class="btn btn-default">Cancel</a>
	</form>
                                    </div>
                                </div>
                                </div>

<script src="assets/js/inputmask/jasny-bootstrap.min.js"></script>
<script src="assets/js/select2/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#id_mk").select2();
        $("#id_dosen").select2();

        $("#id_mk").change(function() {
            var id_mk = $(this).val();
            $.ajax({url: "app/get_sks_mk/"+id_mk,
                'dataType': 'json',
                success: function(a){
                    $("#sks").val(a.sks);
                    $("#semester").val(a.semester);
                console.log("success");
            }});
        });

        $("#jam_mulai").keyup(function() {
            var n = $(this).val();
            var sks = $("#sks").val();
            $.ajax({url: "app/get_jam_selesai_kuliah/"+n+"/"+sks, success: function(result){
                $("#jam_selesai").val(result);
              console.log("success");
            }});
        });

        $("#kelas").change(function() {
            var n = $(this).val();
            $.ajax({url: "app/get_kapasitas_kelas?kelas="+n, success: function(result){
                $("#kapasitas").val(result);
              console.log("success");
            }});
        });

    });
</script>