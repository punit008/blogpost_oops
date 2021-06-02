<?php

class Database{
    private $servername = "localhost";
    private $username = "root";
    private $password = "Vardaam@123";
    private $database = "blog_oops";
    public $conn;

    public function getConnection() {
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->database}",$this->username, $this->password);
            echo "Connection Successful";
        } catch (PDOException $e) {
            echo "Connection Failed ". $e->getMessage();
        }

    }
}

$object = new Database();
$object->getConnection();

?>