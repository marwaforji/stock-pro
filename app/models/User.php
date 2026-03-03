<?php
require_once __DIR__ . '/../config/database.php';

class User {

  private $pdo;

  public function __construct(){
    $db = new Database();
    $this->pdo = $db->connect();
  }

  public function findByEmail($email){
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
