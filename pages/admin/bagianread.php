<?php require_once ("partials/cssdatatables.php"); ?>
<div class="content-header">
    <div class="container-fluid">
        <?php 
        if(isset($_SESSION['hasil'])){
            if($_SESSION['hasil']) {
        ?>
            <div class="alert alert-success alert-dismissable col-3">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h5><i class="icon fas fa-check"></i>Berhasil</h5>
                <?php echo $_SESSION['pesan'] ?>
            </div>
            <?php 
            } else {
            ?>
            <div class="alert alert-danger alert-dismissable col-3">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                <?php echo $_SESSION['pesan'] ?>
            </div>
        <?php
            }
            unset($_SESSION['pesan']);
            unset($_SESSION['hasil']);
        }
        ?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bagian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item">Bagian</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Bagian</h3>
            <a href="?page=bagiancreate" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus-circle"></i>
                Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-bordered table-hover">
                <thead align="center">
                    <tr>
                        <th>No</th>
                        <th>Nama Bagian</th>
                        <th>Nama Kepala Bagian</th>
                        <th>Nama Lokasi Bagian</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tfoot align="center">
                    <tr>
                        <th>No</th>
                        <th>Nama Bagian</th>
                        <th>Nama Kepala Bagian</th>
                        <th>Nama Lokasi Bagian</th>
                        <th>Opsi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    function rupiah($angka){	
                        $rupiah = "Rp. " . number_format($angka,2,',','.');
                        return $rupiah;
                    }
                    
                    $database = new Database();
                    $db = $database->getConnection();

                    $sqlBagian = "SELECT bagian.*, karyawan.nama_lengkap as nama_kepala_bagian, lokasi.nama_lokasi FROM bagian LEFT JOIN karyawan ON bagian.karyawan_id = karyawan.id LEFT JOIN lokasi ON bagian.lokasi_id = lokasi.id";
                    
                    $resultBagian = $db->prepare($sqlBagian);
                    $resultBagian->execute();

                    $no = 1;
                    while ($row = $resultBagian->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                    <tr>
                        <td align="center"><?php echo $no++ ?></td>
                        <td><?php echo $row['nama_bagian'] ?></td>
                        <td align="right"><?php echo $row['nama_kepala_bagian'] ?></td>
                        <td align="right"><?php echo $row['nama_lokasi'] ?></td>
                        <td  align="center">
                            <a href="?page=bagianupdate&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-sm mr-1">
                                <i class="fa fa-edit"></i> Ubah
                            </a>
                            <a href="?page=bagiandelete&id=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm" onClick="javascript : return confirm('Konfirmasi data akan dihapus?');">
                                <i class="fa fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once ("partials/scripts.php");
require_once ("partials/scriptsdatatables.php");
?>
<script>
    $(function() {
        $('#myTable').DataTable()
    });
</script>