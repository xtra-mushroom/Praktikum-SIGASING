<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Lokasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=lokasiread">Lokasi</a></li>
                    <li class="breadcrumb-item">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Lokasi</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group col-6">
                    <label for="nama_lokasi">Nama Lokasi</label>
                    <input type="text" class="form-control form-control-sm" name="nama_lokasi" id="nama_lokasi">
                </div>
                <div class="form-group col-6">
                    <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
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
<?php
if(isset($_POST['button_create'])){
    // print_r($_POST);

    $database = new Database();
    $db = $database->getConnection();

    $validateSQL = "SELECT * FROM lokasi WHERE nama_lokasi = ?";
    $result = $db->prepare($validateSQL);
    $result->bindParam(1, $_POST['nama_lokasi']);
    $result->execute();
    if($result->rowCount() > 0){
    ?>
        <div class="alert alert-danger alert-dismissable col-3">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i>Gagal</h5>
            Nama lokasi sudah terdaftar
        </div>
    <?php
    }else{
        $insertSQL = "INSERT INTO lokasi SET nama_lokasi = ?";
        $result = $db->prepare($insertSQL);
        $result->bindParam(1, $_POST['nama_lokasi']);
        if($result->execute()){
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil simpan lokasi baru";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal simpan lokasi baru";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
    }
    
}
?>
<?php include_once "partials/scripts.php" ?>