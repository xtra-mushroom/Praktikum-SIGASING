<?php
if(isset($_GET['id'])){
    $database = new DAtabase();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM bagian WHERE id = ?";
    $result = $db->prepare($findSql);
    $result ->bindParam(1, $_GET['id']);
    $result->execute();

    $row = $result->fetch();
    if(isset($row['id'])){
        if(isset($_POST['button_update'])){
            $database = new Database();
            $db = $database->getConnection();

            $validateSQL = "SELECT * FROM bagian WHERE nama_bagian = ? AND id != ?";
            $result = $db->prepare($validateSQL);
            $result->bindParam(1, $_POST['nama_bagian']);
            $result->bindParam(2, $_POST['id']);
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
                $id = $_POST['id'];

                $updateSQL = "UPDATE bagian SET nama_bagian = '$namaBagian', karyawan_id = $kepalaBagian, lokasi_id = $lokasiBagian WHERE id = $id";
                $result = $db->prepare($updateSQL);
                $result->bindParam(1, $_POST['nama_bagian']);
                $result->bindParam(2, $_POST['id']);
                $result->bindParam(3, $_POST['kepala_bagian']);
                $result->bindParam(4, $_POST['lokasi_bagian']);
                if($result->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil ubah data bagian";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal ubah data bagian";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
            }
        }
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Ubah Data Bagian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                    <li class="breadcrumb-item">Ubah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ubah Bagian</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group col-6">
                    <label for="nama_bagian">Nama Bagian</label>
                    <input type="hidden" class="form-control form-control-sm" name="id" id="id" value="<?= $row['id'] ?>">
                    <input type="text" class="form-control form-control-sm" name="nama_bagian" id="nama_bagian" value="<?= $row['nama_bagian'] ?>">
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
                            $selected = $row_karyawan['id'] == $row['karyawan_id'] ? " selected " : "";
                            echo "<option value=\"" . $row_karyawan["id"] . "\" " . $selected . ">" . $row_karyawan["nama_lengkap"] . "</option>";
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
                            $selected = $row_lokasi['id'] == $row['lokasi_id'] ? " selected " : "";
                            echo "<option value=\"" . $row_lokasi["id"] . "\" " . $selected . ">" . $row_lokasi["nama_lokasi"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-6">
                    <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
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
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
}
?>