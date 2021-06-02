<?php

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}
require_once '../BlogPost/dbconnect.php';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM `posts` WHERE post_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            header('location: user_post_edit.php');
        }
    }
?>