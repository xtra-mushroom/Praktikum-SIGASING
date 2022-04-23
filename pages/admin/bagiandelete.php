<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->getConnection();

    $deleteSql = "DELETE FROM bagian WHERE id = ?";
    $result = $db->prepare($deleteSql);
    $result->bindParam(1, $_GET['id']);
    if($result->execute()){
        $_SESSION['hasil'] = true;
    } else {
        $_SESSION['hasil'] = false;
    }
}
echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
?>