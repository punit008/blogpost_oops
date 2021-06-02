<?php
require_once '../BlogPost/dbconnect.php';

echo $_SESSION['user_id'];

if (isset($_SESSION['user_id'])) {
    echo "Session Exist";
} else {
    echo "Session Does not exit";
}


$sql = "SELECT * FROM `posts` ";
$stmt = $conn->prepare($sql);
$stmt->execute();
// $result = $stmt->fetch(PDO::FETCH_ASSOC);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($orders);

// $result = $stmt->fetch(PDO::FETCH_ASSOC);
foreach( $orders as $value) {
    echo $value['title'] . "<br/>";
}

// $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
// foreach((new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
//   echo $v;
// }

?>