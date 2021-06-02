<?php
$id = $_SESSION['user_id'];
$sql = "SELECT COUNT(post_id) as count FROM `user_posts` WHERE user_id = :id ";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($result);   

if (isset($_SESSION['user_id'])) {
    $count = "Count: ".$result['count'];
}