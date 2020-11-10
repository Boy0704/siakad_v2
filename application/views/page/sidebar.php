<div class="page-sidebar" id="sidebar">
    <!-- Page Sidebar Header-->
    <div class="sidebar-header-wrapper">
        <form>
            <input type="text" name="menu" class="searchinput" autocomplete="off" />
            <i class="searchicon fa fa-search"></i>
            <div class="searchhelper">Cari menu </div>
        </form>
        
    </div>
    <!-- /Page Sidebar Header -->
    <!-- Sidebar Menu -->
    <ul class="nav sidebar-menu">

        <?php if (isset($_GET['menu'])): ?>

            <?php 
            $this->db->where('level', $this->session->userdata('level'));
            $this->db->like('nama_menu', $this->input->get('menu'), 'BOTH');
            $cari_menu = $this->db->get('master_menu_level');
            if ($cari_menu->num_rows() > 0): ?>

                <?php foreach ($cari_menu->result() as $menu): ?>
                    
                    <li>
                        <a href="<?php echo $menu->link ?>">
                            <i class="menu-icon <?php echo $menu->icon ?>"></i>
                            <span class="menu-text"> <?php echo $menu->nama_menu ?> </span>
                        </a>
                    </li>

                <?php endforeach ?>

            <?php else: ?>
                
                <li>
                    <a href="#">
                        <i class="menu-icon fa fa-search"></i>
                        <span class="menu-text"> menu tidak ada, kembali </span>
                    </a>
                </li>

            <?php endif ?>
            

        <?php else: ?>

        <?php 
        # cek menu parent
        $this->db->where('level', $this->session->userdata('level'));
        $this->db->where('status', 'menu');
        $this->db->order_by('urutan', 'asc');
        $menu = $this->db->get('master_menu_level');
        foreach ($menu->result() as $mn): ?>
            <?php 
            $this->db->where('parent', $mn->id_menu);
            $cek_submn = $this->db->get('master_menu_level');
            if ($cek_submn->num_rows() > 0): 

                if ($this->session->userdata('submn_parent') == $mn->id_menu) {
                    $active = "class=\"active open\"";
                } else {
                    $active = "";
                }

                ?>

                <!-- menu dengan submenu -->
                <li <?php echo $active ?>>
                    <a href="<?php echo $mn->link ?>" class="menu-dropdown">
                        <i class="menu-icon <?php echo $mn->icon ?>"></i>
                        <span class="menu-text"> <?php echo $mn->nama_menu ?> </span>

                        <i class="menu-expand"></i>
                    </a>

                    <ul class="submenu">

                        <?php foreach ($cek_submn->result() as $submn): 
                            $submenu_aktif = ( strpos(current_url(), $submn->link)  ) ? 'class="active"' : '' ;
                            ?>
                            
                            <li <?php echo $submenu_aktif ?>>
                                <a href="<?php echo $submn->link ?>" data-id="<?php echo $submn->parent ?>">
                                    <span class="menu-text"><?php echo $submn->nama_menu ?></span>
                                </a>
                            </li>

                        <?php endforeach ?>
                       
                    </ul>
                </li>

            <?php else: 
                $menu_aktif2 = ( strpos(current_url(), $mn->link) ) ? 'class="active"' : '' ;
                ?>
                <!-- menu tanpa submenu -->
                <li <?php echo $menu_aktif2 ?>>
                    <a href="<?php echo $mn->link ?>">
                        <i class="menu-icon <?php echo $mn->icon ?>"></i>
                        <span class="menu-text"> <?php echo $mn->nama_menu ?> </span>
                    </a>
                </li>
                
            <?php endif ?>
            
        <?php endforeach ?>

        <?php endif ?>
    </ul>
    <!-- /Sidebar Menu -->
</div>