<?php
require_once __DIR__ . '/../config/database.php';

class Dashboard {
  private $pdo;

  public function __construct(){
    $db = new Database();
    $this->pdo = $db->connect();
  }

  // Top produits sortis (OUT)
  public function topOutProducts($limit = 5){
    $stmt = $this->pdo->prepare("
      SELECT p.id, p.name, p.sku, SUM(m.qty) AS total_out
      FROM movements m
      JOIN products p ON p.id = m.product_id
      WHERE m.type = 'OUT'
      GROUP BY p.id, p.name, p.sku
      ORDER BY total_out DESC
      LIMIT ?
    ");
    $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function latestMovements($limit = 5){
  $stmt = $this->pdo->prepare("
    SELECT m.created_at, m.type, m.qty, p.name, p.sku
    FROM movements m
    JOIN products p ON p.id = m.product_id
    ORDER BY m.id DESC
    LIMIT ?
  ");
  $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function movementsByMonth($limit = 6){
  $stmt = $this->pdo->prepare("
    SELECT DATE_FORMAT(created_at, '%Y-%m') AS mois,
           SUM(CASE WHEN type='IN'  THEN qty ELSE 0 END) AS total_in,
           SUM(CASE WHEN type='OUT' THEN qty ELSE 0 END) AS total_out
    FROM movements
    GROUP BY mois
    ORDER BY mois DESC
    LIMIT ?
  ");
  $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return array_reverse($rows);
}


}
