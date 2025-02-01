<?php
class Database{
  private $servername = "localhost";
  private $username = "root";
  private $password = "";
  private $dbname = "attendance_db";
  private $port = 3307; 
  public $conn = null;

  public function __construct(){
    try {
      // Establishing connection with PDO
      $this->conn = new PDO(
        "mysql:host={$this->servername};port={$this->port};dbname={$this->dbname}", 
        $this->username, 
        $this->password
      );
      // Set the PDO error mode to exception
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //echo "Connected successfully";
    } catch(PDOException $e) {
      // Outputting detailed connection failure message
      echo "Connection failed: " . $e->getMessage();
    }
  }
}

// Testing the database connection
$db = new Database();
?>
