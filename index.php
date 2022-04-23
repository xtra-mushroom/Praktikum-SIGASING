<?php
session_start();

if(isset($_SESSION['login'])){
    header("Location: home.php");
    exit;
}

$conn = mysqli_connect("localhost", "lava", "linolee", "praktikum_presensi_penggajian");

if(isset($_POST['login'])){
    $uname = $_POST['username'];
    $pw = md5($_POST['password']);
    $latestLogin = date("Y-m-d H:i:s");

    $result = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$uname'");

    if(mysqli_num_rows($result) > 0){
        $row =  mysqli_fetch_assoc($result);

        if($pw == $row['password']){
            $_SESSION['login'] = true;
            $_SESSION['peran'] = $row['peran'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];

            if($row['peran'] == "ADMIN"){
                $update = mysqli_query($conn, "UPDATE pengguna SET login_terakhir = '$latestLogin' WHERE username = '$uname'");
                header("Location: home.php");
                var_dump($update);
            }elseif($row['peran'] == "USER"){
                $update = mysqli_query($conn, "UPDATE pengguna SET login_terakhir = '$latestLogin' WHERE username = '$uname'");
                header("Location: pages/404.php");
            }
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login SIGASING</title>

  <?php require_once ("partials/head.php"); ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>SIGASING</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masukkan Username dan Password Anda</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">Log In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once ("partials/head.php"); ?>
</body>
</html>
