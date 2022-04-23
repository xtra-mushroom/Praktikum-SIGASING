<?php
if(isset($_POST['button_create'])){
    $database = new Database();
    $db = $database->getConnection();

    $validateSQL = "SELECT * FROM karyawan WHERE nik = ?";
    $result = $db->prepare($validateSQL);
    $result->bindParam(1, $_POST['nik']);
    $result->execute();
    if($result->rowCount() > 0){
        ?>
        <div class="alert alert-danger alert-dismissible col-3">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i>Gagal</h5>
            NIK sudah terdaftar
        </div>
        <?php
    }else{
        $validateSql = "SELECT * FROM pengguna WHERE username = ?";
        $result = $db->prepare($validateSQL);
        $result->bindParam(1, $_POST['username']);
        $result->execute();
        if($result->rowCount() > 0) {
            ?>
            <div class="alert alert-danger alert-dismissible col-3">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                Username sudah terdaftar
            </div>
            <?php
        }elseif($_POST['password'] != $_POST['password_ulang']){
            ?>
                <div class="alert alert-danger alert-dismissible col-3">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    Password tidak sama
                </div>
            <?php
        }else{
            $md5Password = md5($_POST['password']);

            $insertSql = "INSERT INTO pengguna VALUES (null, ?, ?, ?, null)";
            $result = $db->prepare($insertSql);
            $result->bindParam(1, $_POST['username']);
            $result->bindParam(2, $md5Password);
            $result->bindParam(3, $_POST['peran']);

            if($result->execute()){
                $pengguna_id = $db->lastInsertId();

                $insertKaryawanSql = "INSERT INTO karyawan VALUES (NULL, ?, ?, ?, ?, ?, ?)";
                $result = $db->prepare($insertKaryawanSql);
                $result->bindParam(1, $_POST['nik']);
                $result->bindParam(2, $_POST['nama_lengkap']);
                $result->bindParam(3, $_POST['handphone']);
                $result->bindParam(4, $_POST['email']);
                $result->bindParam(5, $_POST['tanggal_masuk']);
                $result->bindParam(6, $pengguna_id);
                if($result->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil simpan karyawan baru";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal simpan karyawan baru";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
            }
        }
    }}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
                    <li class="breadcrumb-item">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Karyawan</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group col-6">
                    <label for="nik">Nomor Induk Karyawan</label>
                    <input type="text" class="form-control form-control-sm" name="nik" id="nik">
                </div>
                <div class="form-group col-6">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control form-control-sm" name="nama_lengkap" id="nama_lengkap">
                </div>
                <div class="form-group col-6">
                    <label for="handphone">Handphone</label>
                    <input type="text" class="form-control form-control-sm" name="handphone" id="handphone">
                </div>
                <div class="form-group col-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control form-control-sm" name="email" id="email">
                </div>
                <div class="form-group col-6">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" class="form-control form-control-sm" name="tanggal_masuk" id="tanggal_masuk">
                </div>
                <div class="form-group col-6">
                    <label for="username">Username</label>
                    <input type="text" class="form-control form-control-sm" name="username" id="username">
                </div>
                <div class="form-group col-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control form-control-sm" name="password" id="password">
                </div>
                <div class="form-group col-6">
                    <label for="password_ulang">Password (Ulangi)</label>
                    <input type="password" class="form-control form-control-sm" name="password_ulang" id="password_ulang">
                </div>
                <div class="form-group col-6">
                    <label for="peran">Peran</label>
                    <select class="form-control form-control-sm" name="peran" id="peran">
                        <option value="">-- Pilih Peran --</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="USER">USER</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
                        <i class="fa fa-times"></i> Batal
                    </a>
                    <button type="submit" name="button_create" class="btn btn-success btn-sm float-right mr-2">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include_once "partials/scripts.php"; ?>