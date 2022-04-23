<?php 
    $getP = $_GET['page'];

    if ($getP == "home") {
        $activeHome = "active";
    } elseif ($getP == "lokasicreate" OR $getP == "lokasiread" OR $getP == "lokasiupdate") {
        $open = "menu-open";
        $activeLokasi = "active";
    } elseif ($getP == "jabatanread" OR $getP == "jabatancreate" OR $getP == "jabatanupdate") {
        $open = "menu-open";
        $activeJabatan = "active";
    } elseif ($getP == "bagianread" OR $getP == "bagiancreate" OR $getP == "bagianupdate") {
        $open = "menu-open";
        $activeBagian = "active";
    } elseif ($getP == "karyawanread" OR $getP == "karyawancreate" OR $getP == "karyawanupdate") {
        $open = "menu-open";
        $activeKaryawan = "active";
    }
?>

<aside class="main-sidebar sidebar-dark-secondary elevation-4" style="background-color:#383434">
    <a href="#" class="brand-link">
        <img src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">SIGASING</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../assets/dist/img/avatar3.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="?page=home" class="nav-link <?php echo $activeHome ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item <?php echo $open ?>">
                    <a href="#" class="nav-link <?php echo $activeLokasi ?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Master Data
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=lokasiread" class="nav-link <?php echo $activeLokasi ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lokasi</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=jabatanread" class="nav-link <?php echo $activeJabatan ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jabatan</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=bagianread" class="nav-link <?php echo $activeBagian ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bagian</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=karyawanread" class="nav-link <?php echo $activeKaryawan ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Karyawan</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>