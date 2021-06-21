<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link<?= ($act[0] == 'dashboard') ? ' active' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <?php if (session()->get('level') == "Admin") { ?>
            <li class="nav-item">
                <a href="<?= base_url('users') ?>" class="nav-link<?= ($act[0] == 'users') ? ' active' : ''; ?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Admin</p>
                </a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a href="<?= base_url('product') ?>" class="nav-link<?= ($act[0] == 'product') ? ' active' : ''; ?>">
                <i class="nav-icon fas fa-box"></i>
                <p>Produk</p>
            </a>
        </li>
        <li class="nav-item<?= ($act[0] == 'sales') ? ' menu-open' : ''; ?>">
            <a href="#" class="nav-link<?= ($act[0] == 'sales') ? ' active' : ''; ?>">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>
                    Penjualan
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('cart') ?>" class="nav-link<?= ($act[1] == 'add_sales') ? ' active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tambah</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('sales') ?>" class="nav-link<?= ($act[1] == 'data_sales') ? ' active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data</p>
                    </a>
                </li>
            </ul>
        </li>
        <?php if (session()->get('level') == "Admin") { ?>
            <li class="nav-item">
                <a href="<?= base_url('report') ?>" class="nav-link<?= ($act[0] == 'report') ? ' active' : ''; ?>">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>Laporan</p>
                </a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a href="<?= base_url('logout') ?>" class="nav-link">
                <i class="nav-icon fas fa-power-off"></i>
                <p>Log Out</p>
            </a>
        </li>
    </ul>
</nav>