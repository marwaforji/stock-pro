<?php
require_once __DIR__ . '/../config/database.php';

class Category {
  private $pdo;

  public function __construct(){
    $db = new Database();
    $this->pdo = $db->connect();
  }

  public function all(){
    $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function find($id){
    $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function create($name){
    $stmt = $this->pdo->prepare("INSERT INTO categories(name) VALUES (?)");
    return $stmt->execute([$name]);
  }

  public function update($id, $name){
    $stmt = $this->pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
    return $stmt->execute([$name, $id]);
  }

  public function delete($id){
    $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
    return $stmt->execute([$id]);
  }
}
