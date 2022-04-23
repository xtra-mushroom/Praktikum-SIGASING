<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Bagian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                    <li class="breadcrumb-item">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Bagian</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group col-6">
                    <label for="nama_bagian">Nama Bagian</label>
                    <input type="text" class="form-control form-control-sm" name="nama_bagian" id="nama_bagian">
                </div>
                <div class="form-group col-6">
                    <label for="kepala_bagian">Kepala Bagian</label>
                    <select name="kepala_bagian" id="kepala_bagian" class="form-control">
                        <option value="">-- Pilih Kepala Bagian --</option>
                        <?php
                        $database = new Database();
                        $db = $database->getConnection();

                        $selectSQL = "SELECT * FROM karyawan";
                        $result_karyawan = $db->prepare($selectSQL);
                        $result_karyawan->execute();

                        while($row_karyawan = $result_karyawan->fetch(PDO::FETCH_ASSOC)){
                            echo "<option value=\"" . $row_karyawan["id"] . "\">" . $row_karyawan["nama_lengkap"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="lokasi_bagian">Lokasi Bagian</label>
                    <select name="lokasi_bagian" id="lokasi_bagian" class="form-control">
                        <option value="">-- Pilih Lokasi Bagian --</option>
                        <?php
                        $database = new Database();
                        $db = $database->getConnection();

                        $selectSQL = "SELECT * FROM lokasi";
                        $result_lokasi = $db->prepare($selectSQL);
                        $result_lokasi->execute();

                        while($row_lokasi = $result_lokasi->fetch(PDO::FETCH_ASSOC)){
                            echo "<option value=\"" . $row_lokasi["id"] . "\">" . $row_lokasi["nama_lokasi"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-6">
                    <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
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

    $validateSQL = "SELECT bagian.*, karyawan.nama_lengkap as nama_kepala_bagian, lokasi.nama_lokasi FROM bagian LEFT JOIN karyawan ON bagian.karyawan_id = karyawan.id LEFT JOIN lokasi ON bagian.lokasi_id = lokasi.id WHERE nama_bagian = ?";
    $result = $db->prepare($validateSQL);
    $result->bindParam(1, $_POST['nama_bagian']);
    $result->execute();
    if($result->rowCount() > 0){
    ?>
        <div class="alert alert-danger alert-dismissable col-3">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i>Gagal</h5>
            Nama bagian sudah terdaftar
        </div>
    <?php
    }else{
        $namaBagian = $_POST['nama_bagian'];
        $kepalaBagian = $_POST['kepala_bagian'];
        $lokasiBagian = $_POST['lokasi_bagian'];

        $insertSQL = "INSERT INTO bagian SET nama_bagian = '$namaBagian', karyawan_id = $kepalaBagian, lokasi_id = $lokasiBagian";
        $result = $db->prepare($insertSQL);
        $result->bindParam(1, $_POST['nama_bagian']);
        $result->bindParam(2, $_POST['kepala_bagian']);
        $result->bindParam(3, $_POST['lokasi_bagian']);
        if($result->execute()){
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil simpan bagian baru";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal simpan bagian baru";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }   
}
?>
<?php include_once "partials/scripts.php"; ?>