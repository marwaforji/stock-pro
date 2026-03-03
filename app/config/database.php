<?php
class Database {
  private $host = "localhost";
  private $db   = "gestion_stock_pro";
  private $user = "root";
  private $pass = "";
  public $pdo;

  public function connect(){
    try{
      $this->pdo = new PDO(
        "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
        $this->user,
        $this->pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );
      return $this->pdo;
    } catch(PDOException $e){
      die("DB Error: " . $e->getMessage());
    }
  }
}
