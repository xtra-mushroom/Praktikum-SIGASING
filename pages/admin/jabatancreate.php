<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Jabatan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=lokasiread">Jabatan</a></li>
                    <li class="breadcrumb-item">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Jabatan</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group col-6">
                    <label for="nama_jabatan">Nama Jabatan</label>
                    <input type="text" class="form-control form-control-sm" name="nama_jabatan" id="nama_jabatan">
                </div>
                <div class="form-group col-6">
                    <label for="gapok_jabatan">Gaji Pokok</label>
                    <input type="text" class="form-control form-control-sm" name="gapok_jabatan" id="gapok_jabatan" onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <div class="form-group col-6">
                    <label for="tunjangan_jabatan">Tunjangan</label>
                    <input type="text" class="form-control form-control-sm" name="tunjangan_jabatan" id="tunjangan_jabatan" onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <div class="form-group col-6">
                    <label for="uang_makan_perhari">Uang Makan Perhari</label>
                    <input type="text" class="form-control form-control-sm" name="uang_makan_perhari" id="uang_makan_perhari" onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <div class="form-group col-6">
                    <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right">
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

    $validateSQL = "SELECT * FROM jabatan WHERE nama_jabatan = ?";
    $result = $db->prepare($validateSQL);
    $result->bindParam(1, $_POST['nama_jabatan']);
    $result->execute();
    if($result->rowCount() > 0){
    ?>
        <div class="alert alert-danger alert-dismissable col-3">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i>Gagal</h5>
            Nama jabatan sudah terdaftar
        </div>
    <?php
    }else{
        $namaJabatan = $_POST['nama_jabatan'];
        $gapokJabatan = $_POST['gapok_jabatan'];
        $tunjanganJabatan = $_POST['tunjangan_jabatan'];
        $uang_makan = $_POST['uang_makan_perhari'];

        $insertSQL = "INSERT INTO jabatan SET nama_jabatan = '$namaJabatan', gapok_jabatan = $gapokJabatan, tunjangan_jabatan = $tunjanganJabatan, uang_makan_perhari = $uang_makan";
        $result = $db->prepare($insertSQL);
        $result->bindParam(1, $_POST['nama_jabatan']);
        $result->bindParam(2, $_POST['gapok_jabatan']);
        $result->bindParam(3, $_POST['tunjangan_jabatan']);
        $result->bindParam(4, $_POST['uang_makan_perhari']);
        if($result->execute()){
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil simpan jabatan baru";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal simpan jabatan baru";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
    }   
}
?>
<?php include_once "partials/scripts.php"; ?>