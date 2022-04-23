<?php
session_start();
if($_SESSION['peran'] == "USER"){
    header("Location: index.php");
    exit;
}
if(!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once ("partials/head.php");
require_once ("database/database.php");
 ?>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php 
        require_once ("partials/nav.php");
        require_once ("partials/sidebar.php");
        ?>
        <div class="content-wrapper">
            <?php require_once ("routes.php") ?>
        </div>
        <?php 
        require_once ("partials/control.php");
        require_once ("partials/footer.php");
        ?>
    </div>
</body>
</html>