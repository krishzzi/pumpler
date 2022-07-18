<!--Sidebar-->
<aside class="main-sidebar sidebar-dark-primary elevation-4 overflow-hidden">

    <a href="../../index3.html" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar ">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>


        <nav class="mt-2 ">
            <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">



                <?php
				$this->load->helper('navigation');
                echo '<li class="nav-header">MANAGEMENT SECTION</li>';
//                $helper = new \App\Helpers\NavigationHelper();
                $sidebarMenu = getSidebar();
                    foreach ($sidebarMenu as $key => $menu)
                    {
                        if(isset($menu['child']) && !empty($menu['child']) && is_array($menu['child']))
                        {
                            // Main Menu
                            echo sprintf('
                                <li class="nav-item">
                                    <a href="%s" class="nav-link">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            %s
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                ',route_to($menu['url']),$menu['label']);

                            // Child Menu
                            foreach ($menu['child'] as $child)
                            {
                                echo sprintf('
                                <li class="nav-item">
                                    <a href="%s" class="nav-link">
                                        <i class="nav-icon %s"></i>
                                        <p>
                                            %s
                                        </p>
                                    </a>
                                </li>
                            ',route_to($child['url']),$child['icon'],$child['label']);
                            }
                            // Main Menu
                            echo "
                                    </ul>
                                </li>
                            ";
                        }else{
                            // Main Menu
                            echo sprintf('
                                <li class="nav-item">
                                    <a href="%s" class="nav-link">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            %s
                                              <span class="right badge badge-%s">%s</span>
                                        </p>
                                    </a>
                                </li>
                            ',route_to($menu['url']),$menu['label'],trim($menu['badgeColor'] ?? ''),$menu['badge']??'');
                        }
                    }
                ?>

                <li class="nav-header">APPLICATION SECTION</li>

                <li class="nav-item">
                    <a href="<?php echo route_to('admin.users')??'' ?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=site_url('admin/settings')?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Settings</p>
                    </a>
                </li>

            </ul>
        </nav>


x

    </div>

</aside>
