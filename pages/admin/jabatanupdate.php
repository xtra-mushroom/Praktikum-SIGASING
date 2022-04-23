<?php
if(isset($_GET['id'])){
    $database = new DAtabase();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM jabatan WHERE id = ?";
    $result = $db->prepare($findSql);
    $result ->bindParam(1, $_GET['id']);
    $result->execute();

    $row = $result->fetch();
    if(isset($row['id'])){
        if(isset($_POST['button_update'])){
            $database = new Database();
            $db = $database->getConnection();

            $validateSQL = "SELECT * FROM jabatan WHERE nama_jabatan = ? AND id != ?";
            $result = $db->prepare($validateSQL);
            $result->bindParam(1, $_POST['nama_jabatan']);
            $result->bindParam(2, $_POST['id']);
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
                $id = $_POST['id'];

                $updateSQL = "UPDATE jabatan SET nama_jabatan = '$namaJabatan', gapok_jabatan = $gapokJabatan, tunjangan_jabatan = $tunjanganJabatan, uang_makan_perhari = $uang_makan WHERE id = $id";
                $result = $db->prepare($updateSQL);
                $result->bindParam(1, $_POST['nama_jabatan']);
                $result->bindParam(2, $_POST['id']);
                $result->bindParam(3, $_POST['gapok_jabatan']);
                $result->bindParam(4, $_POST['tunjangan_jabatan']);
                $result->bindParam(5, $_POST['uang_makan_perhari']);
                if($result->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil ubah data jabatan";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal ubah data jabatan";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
            }
        }
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Ubah Data Jabatan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=jabatanread">Jabatan</a></li>
                    <li class="breadcrumb-item">Ubah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ubah Jabatan</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group col-6">
                    <label for="nama_jabatan">Nama Jabatan</label>
                    <input type="hidden" class="form-control form-control-sm" name="id" id="id" value="<?= $row['id'] ?>">
                    <input type="text" class="form-control form-control-sm" name="nama_jabatan" id="nama_jabatan" value="<?= $row['nama_jabatan'] ?>">
                </div>
                <div class="form-group col-6">
                    <label for="gapok_jabatan">Gaji Pokok</label>
                    <input type="text" class="form-control form-control-sm" name="gapok_jabatan" id="gapok_jabatan" value="<?= $row['gapok_jabatan'] ?>" onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <div class="form-group col-6">
                    <label for="tunjangan_jabatan">Tunjangan</label>
                    <input type="text" class="form-control form-control-sm" name="tunjangan_jabatan" id="tunjangan_jabatan" value="<?= $row['tunjangan_jabatan'] ?>" onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <div class="form-group col-6">
                    <label for="uang_makan_perhari">Uang Makan Perhari</label>
                    <input type="text" class="form-control form-control-sm" name="uang_makan_perhari" id="uang_makan_perhari" value="<?= $row['uang_makan_perhari'] ?>" onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <div class="form-group col-6">
                    <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right">
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
        echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
}
?>