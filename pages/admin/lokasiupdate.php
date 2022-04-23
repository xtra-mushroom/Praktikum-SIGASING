<?php
if(isset($_GET['id'])){
    $database = new DAtabase();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM lokasi WHERE id = ?";
    $result = $db->prepare($findSql);
    $result ->bindParam(1, $_GET['id']);
    $result->execute();

    $row = $result->fetch();
    if(isset($row['id'])){
        if(isset($_POST['button_update'])){
            $database = new Database();
            $db = $database->getConnection();

            $validateSQL = "SELECT * FROM lokasi WHERE nama_lokasi = ? AND id != ?";
            $result = $db->prepare($validateSQL);
            $result->bindParam(1, $_POST['nama_lokasi']);
            $result->bindParam(2, $_POST['id']);
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
                $updateSQL = "UPDATE lokasi SET nama_lokasi = ? WHERE id = ?";
                $result = $db->prepare($updateSQL);
                $result->bindParam(1, $_POST['nama_lokasi']);
                $result->bindParam(2, $_POST['id']);
                if($result->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil ubah data lokasi";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal ubah data lokasi";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
            }
        }
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Ubah Data Lokasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=lokasiread">Lokasi</a></li>
                    <li class="breadcrumb-item">Ubah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ubah Lokasi</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group col-6">
                    <label for="nama_lokasi">Nama Lokasi</label>
                    <input type="hidden" class="form-control form-control-sm" name="id" id="id" value="<?= $row['id'] ?>">
                    <input type="text" class="form-control form-control-sm" name="nama_lokasi" id="nama_lokasi" value="<?= $row['nama_lokasi'] ?>">
                </div>
                <div class="form-group col-6">
                    <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                        <i class="fa fa-times"></i> Batal
                    </a>
                    <button type="submit" name="button_update" class="btn btn-success btn-sm float-right mr-2">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php
    } else {
        echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
}
?>