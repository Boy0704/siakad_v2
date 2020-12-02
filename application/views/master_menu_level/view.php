<div class="row">
	<div class="col-md-12">
		<div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Pilih Level</span>

                <div class="widget-buttons">
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="#" data-toggle="dispose">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <form action="">
                	<div class="form-group">
                		<div class="row">
                			<div class="col-md-3">
                				<select name="level" class="form-control">
                					<option value="">--pilih level--</option>
                					<?php 
                					$selected = '';
                					foreach ($this->db->get('level')->result() as $rw): 
                						if (isset($_GET['level'])) {
                							$selected = ($_GET['level'] == $rw->id_level) ? 'selected':'';
                						}
                					?>
                						<option value="<?php echo $rw->id_level ?>" <?php echo $selected ?>><?php echo $rw->level ?></option>
                					<?php endforeach ?>
                				</select>
                			</div>
                			<div class="col-md-3">
                				<button type="submit" class="btn btn-primary">Pilih</button>
                				<?php if ($_GET): ?>
                					<a href="master_menu_level" class="btn btn-info">Reset</a>
                				<?php endif ?>
                			</div>
                		</div>
                	</div>
                </form>
            </div>
        </div>
	</div>
</div>

<?php if (isset($_GET['level'])): ?>
	


<div class="row">

	<div class="col-md-4">
		<div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Menu Level <a href="master_menu_level/create?level=<?php echo $_GET['level'] ?>" class="label label-primary">Tambah Manual</a></span>

                <div class="widget-buttons">
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="#" data-toggle="dispose">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                
                <div class="dd" id="menu_level">
				    <ol class="dd-list">
				    	<?php 
				    	//cek jika tidak ada menu apapun di level ini
				    	$this->db->where('level', $this->input->get('level'));
				    	$cek_menu_level = $this->db->get('master_menu_level');

				    	if ($cek_menu_level->num_rows() == 0) {
				    		?>
				    		<div class="dd-empty"></div>
				    		<?php
				    	} else {

				    		# cek menu parent
					        $this->db->where('level', $this->input->get('level'));
					        $this->db->where('status', 'menu');
					        $this->db->order_by('urutan', 'asc');
					        $menu = $this->db->get('master_menu_level');
					        foreach ($menu->result() as $mn): ?>
					            <?php 
					            $this->db->where('parent', $mn->id_menu);
					            $cek_submn = $this->db->get('master_menu_level');
					            if ($cek_submn->num_rows() > 0): ?>

					                <!-- menu dengan submenu -->
					                <li class="dd-item" data-nama="<?php echo $mn->nama_menu ?>" data-id="<?php echo $mn->id_menu ?>">
							            <div class="dd-handle"><i class="menu-icon <?php echo $mn->icon ?>"></i> <?php echo $mn->nama_menu ?></div>
							            <ol class="dd-list">
							            	<?php foreach ($cek_submn->result() as $submn): ?>
	                            
					                            <li class="dd-item" data-nama="<?php echo $submn->nama_menu ?>" data-id="<?php echo $submn->id_menu ?>">
								                    <div class="dd-handle"><?php echo $submn->nama_menu ?> </div>
								                </li>

					                        <?php endforeach ?>
							               
							                
							            </ol>
							        </li>

					            <?php else: ?>
					                <!-- menu tanpa submenu -->
					                <li class="dd-item" data-nama="<?php echo $mn->nama_menu ?>" data-id="<?php echo $mn->id_menu ?>">
							            <div class="dd-handle"><i class="menu-icon <?php echo $mn->icon ?>"></i> <?php echo $mn->nama_menu ?> </div>
							        </li>
					                
					                
					            <?php endif ?>
					            
					        <?php endforeach ?>

					    	<?php } ?>
				        
				    </ol>
				</div>
				<!-- <hr> -->
				<div style="margin-top: 20px;">
					<button class="btn btn-primary" id="simpan_menu">Simpan</button>
				</div>

				<input type="hidden" id="output_menu_level" >
				<input type="hidden" id="output_menu_master" >
				<input type="hidden" id="output_menu_dihapus" >

            </div>
        </div>
	</div>

	<div class="col-md-4">
		<div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Tong Sampah </span>

                <div class="widget-buttons">
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="#" data-toggle="dispose">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
            	<div class="alert alert-danger">
            		Silahkan buang menu yang menu tidak terpakai disini !
            	</div>
            	<div class="dd" id="tong_sampah">
            		<div class="dd-empty">
            			
            		</div>
            	</div>
            </div>
        </div>
	</div>

	<div class="col-md-4">
		<div class="widget">
            <div class="widget-header">
                <span class="widget-caption">Menu Master</span>

                <div class="widget-buttons">
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="#" data-toggle="dispose">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
            	<div class="alert alert-info">
            		Silahkan ambil menu disini !
            	</div>
            	<div style="height: 400px; overflow-y: scroll;">
                <div class="dd" id="menu_master">
				    <ol class="dd-list">
				    	<?php 
				        # cek menu parent
				        $this->db->where('status', 'menu');
				        $this->db->order_by('urutan', 'asc');
				        $menu = $this->db->get('master_menu');
				        foreach ($menu->result() as $mn): ?>
				            <?php 
				            $this->db->where('parent', $mn->id_menu);
				            $cek_submn = $this->db->get('master_menu');
				            if ($cek_submn->num_rows() > 0): ?>

				                <!-- menu dengan submenu -->
				                <li class="dd-item" data-nama="<?php echo $mn->nama_menu ?>" data-id="<?php echo $mn->id_menu ?>">
						            <div class="dd-handle"><i class="menu-icon <?php echo $mn->icon ?>"></i> <?php echo $mn->nama_menu ?></div>
						            <ol class="dd-list">
						            	<?php foreach ($cek_submn->result() as $submn): ?>
                            
				                            <li class="dd-item" data-nama="<?php echo $submn->nama_menu ?>" data-id="<?php echo $submn->id_menu ?>">
							                    <div class="dd-handle"><?php echo $submn->nama_menu ?></div>
							                </li>

				                        <?php endforeach ?>
						               
						                
						            </ol>
						        </li>

				            <?php else: ?>
				                <!-- menu tanpa submenu -->
				                <li class="dd-item" data-nama="<?php echo $mn->nama_menu ?>" data-id="<?php echo $mn->id_menu ?>">
						            <div class="dd-handle"><i class="menu-icon <?php echo $mn->icon ?>"></i> <?php echo $mn->nama_menu ?></div>
						        </li>
				                
				                
				            <?php endif ?>
				            
				        <?php endforeach ?>

				        
				    </ol>
				</div>
				</div>
            </div>
        </div>
	</div>

</div>



<script src="assets/js/nestable/jquery.nestable.min.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
    	var updateOutput = function(e)
	    {
	        var list   = e.length ? e : $(e.target),
	            output = list.data('output');
	        if (window.JSON) {
	            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
	        } else {
	            output.val('JSON browser support required for this demo.');
	        }
	    };

	    // activate Nestable for list 1
	    $('#menu_level').nestable({
	        group: 1
	    })
	    .on('change', updateOutput);

	    $("#tong_sampah").nestable({
	    	group: 1
	    })
	    .on('change', updateOutput);

	    // activate Nestable for list 2
	    $('#menu_master').nestable({
	        group: 1
	    })
	    .on('change', updateOutput);

	    // output initial serialised data
	    updateOutput($('#menu_level').data('output', $('#output_menu_level')));
	    updateOutput($('#menu_master').data('output', $('#output_menu_master')));
	    updateOutput($('#tong_sampah').data('output', $('#output_menu_dihapus')));

        $("#simpan_menu").click(function() {
        	var data = $("#output_menu_level").val();
        	var data_dihapus = $("#output_menu_dihapus").val();
        	$.ajax({
        		url: 'app/simpan_menu_level',
        		type: 'POST',
        		dataType: 'html',
        		data: {data: data, data_dihapus:data_dihapus, id_level:'<?php echo $this->input->get('level') ?>'},
        	})
        	.done(function(hsl) {
        		console.log("success");
        		alert(hsl);
        	})
        	.fail(function() {
        		console.log("error");
        	})
        	.always(function() {
        		console.log("complete");
        	});
        	
        });


    });
</script>

<?php endif ?>